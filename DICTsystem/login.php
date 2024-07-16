<?php
session_start();
// Check if session_conflict alert is set
if (isset($_GET['alert']) && $_GET['alert'] === 'session_conflict') {
    echo "<script>alert('Another admin is using this account. You have been logged out.');</script>";
    // Clear the alert after displaying
    unset($_GET['alert']);
}
try {
    $conn = new PDO("mysql:host=localhost;dbname=applicant-records", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

$error = "";
$name = "";
$password = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];
    $name = $_POST['name'];

    $stmt = $conn->prepare("SELECT adminID, admin_password, session_token FROM adminaccount WHERE username = :name");
    $stmt->bindParam(':name', $name);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && password_verify($password, $result['admin_password'])) {
        // Generate a new session token
        $session_token = bin2hex(random_bytes(32));

        // Store the session token in the session and update database
        $_SESSION['user_id'] = $result['adminID'];
        $_SESSION['session_token'] = $session_token;

        // Update session token in the database
        $stmt = $conn->prepare("UPDATE adminaccount SET session_token = :session_token WHERE adminID = :adminID");
        $stmt->bindParam(':session_token', $session_token);
        $stmt->bindParam(':adminID', $result['adminID']);
        $stmt->execute();

        // Clear the session conflict flag
        unset($_SESSION['session_conflict']);

        header("Location: table-records.php");
        exit();
    } else {
        $error = "Invalid name or password.";
        $name = "";
        $password = "";
    }
}

if (isset($_SESSION['user_id'])) {
    // Verify session token
    $stmt = $conn->prepare("SELECT session_token FROM adminaccount WHERE adminID = :adminID");
    $stmt->bindParam(':adminID', $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && $result['session_token'] === $_SESSION['session_token']) {
        // Check if session_conflict flag is set
        if (isset($_SESSION['session_conflict'])) {
            // Redirect to login page with alert message
            header("Location: login.php?alert=session_conflict");
            exit();
        }
        header("Location: table-records.php");
        exit();
    } else {
        // Invalid session token
        session_destroy();
        header("Location: login.php");
        exit();
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3&display=swap" rel="stylesheet">
    <title>Login to CRUD</title>
    <style>
        body {
            background-color: #f0f4f8;
            font-family: 'Source Sans 3', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            width: 100%;
            max-width: 1100px;
            min-height: fit-content;
        }

        .login-form {
            padding: 40px;
        }

        .login-title {
            color: #333;
            margin-bottom: 30px;
            font-size: 2.5rem;
        }

        .form-control {
            border-radius: 8px;
            font-size: 1.1rem;
            padding: 12px;
        }

        .btn-login {
            background-color: #3498db;
            border: none;
            width: 100%;
            font-size: 1.2rem;
            padding: 12px;
        }

        .login-image {
            max-width: 100%;
            height: auto;
            max-height: 500px;
        }

        .illustration-container {
            background-color: #f8f9fa;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .form-label {
            font-size: 1.1rem;
        }

        .form-check-label,
        .form-check-input {
            font-size: 1rem;
        }

        .input-group-text {
            font-size: 1.1rem;
        }

        @media (max-width: 767px) {
            .login-container {
                min-height: auto;
            }

            .illustration-container {
                order: -1;
                padding: 20px;
            }

            .login-image {
                max-height: 300px;
            }

            .login-form {
                padding: 20px;
            }

            .login-title {
                font-size: 2rem;
                text-align: center;
            }

            .form-control {
                font-size: 1rem;
                padding: 10px;
            }

            .btn-login {
                font-size: 1rem;
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="row g-0 h-100">
            <div class="col-md-6">
                <div class="illustration-container">
                    <img src="image/dictregion2.png" alt="Login illustration" class="login-image">
                </div>
            </div>
            <div class="col-md-6">
                <div class="login-form">
                    <h2 class="login-title">ICT Proficiency Certification Examination</h2>
                    <form method="POST" action="">
                        <?php if ($error): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                        <div class="mb-4">
                            <label for="form3Example3" class="form-label">Email</label>
                            <input type="text" name="name" id="form3Example3" class="form-control"
                                value="<?php echo htmlspecialchars($name); ?>">
                        </div>
                        <div class="mb-4">
                            <label for="form3Example4" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="form3Example4" class="form-control"
                                    value="<?php echo htmlspecialchars($password); ?>">
                                <span class="input-group-text">
                                    <i id="togglePassword" class="fa-solid fa-eye-slash"></i>
                                </span>
                            </div>
                        </div>

                        <button type="submit" id="loginButton" class="btn btn-primary btn-login mb-4"
                            disabled>Login</button>

                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/dc21b4aa01.js" crossorigin="anonymous"></script>

    <script>
        // Function to toggle password visibility
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('form3Example4');
            const togglePassword = document.getElementById('togglePassword');
            const loginButton = document.getElementById('loginButton');

            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle eye icon
                togglePassword.classList.toggle('fa-eye');
                togglePassword.classList.toggle('fa-eye-slash');
            });

            // Function to check if both fields are filled and enable/disable the login button
            function checkInputs() {
                const nameValue = document.getElementById('form3Example3').value.trim();
                const passwordValue = passwordInput.value.trim();

                if (nameValue !== '' && passwordValue !== '') {
                    loginButton.removeAttribute('disabled');
                } else {
                    loginButton.setAttribute('disabled', 'true');
                }
            }

            // Event listeners for input fields
            document.getElementById('form3Example3').addEventListener('input', checkInputs);
            passwordInput.addEventListener('input', checkInputs);

            // Clear input fields if error message is displayed
            <?php if ($error): ?>
                document.getElementById('form3Example3').value = '';
                document.getElementById('form3Example4').value = '';
            <?php endif; ?>
        });
    </script>

</body>

</html>