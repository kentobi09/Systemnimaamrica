<?php session_start()
?>
<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=applicant-records", "root", "");
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Array of personnel data


    // Default values for password_hash and current_session
    $default_password_hash = password_hash("default_password", PASSWORD_DEFAULT); // Change "default_password" as needed
    $default_current_session = "default_session"; // Change this as needed

    // Prepare SQL and bind parameters
    $stmt = $conn->prepare("INSERT INTO adminaccount (username, admin_password) VALUES (:name, :password_hash)");

    // Insert each personnel

        $hashedPassword = password_hash("rugbyenjoyer", PASSWORD_DEFAULT);
        $name = "Rica";
        $password_hash = $hashedPassword;


        // Bind parameters and execute
        $stmt->bindParam(':password_hash', $password_hash);
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        echo "Plain Password: $plainPassword<br>";
        echo "Hashed Password: $hashedPassword <br>";


    echo "Records inserted successfully";
}
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$conn = null;
?>





<?php
echo "<br>";
print_r($_SESSION);
?>