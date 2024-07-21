<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $conn = new PDO("mysql:host=localhost;dbname=applicant-records;max_allowed_packet=67108864", "root", "");
    $conn->setAttribute(PDO::ATTR_TIMEOUT, 300); // 5 minutes
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstname = trim(htmlspecialchars($_POST['firstname']));
        $middlename = trim(htmlspecialchars($_POST['middlename']));
        $lastname = trim(htmlspecialchars($_POST['lastname']));
        
        // Check if the applicant already exists
        $sql = "SELECT COUNT(*) FROM applicantrecord WHERE firstname = :firstname AND middlename = :middlename AND lastname = :lastname";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':middlename', $middlename);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        
        if ($count > 0) {
            echo "<script>alert('An applicant with the same name already exists.'); window.history.back();</script>";
            exit();
        }
        
        $conn->beginTransaction();
        
        // Applicant record insertion
        $sex = trim(htmlspecialchars($_POST['sex']));
        $province = trim(htmlspecialchars($_POST['province']));
        $exam_venue = trim(htmlspecialchars($_POST['exam_venue']));
        $date_of_examination = trim(htmlspecialchars($_POST['date_of_examination']));
        $date_of_notification = trim(htmlspecialchars($_POST['date_of_notification']));
        $proctor = trim(htmlspecialchars($_POST['proctor']));
        $status = trim(htmlspecialchars($_POST['status']));
        $contact_number = trim(htmlspecialchars($_POST['contact_number']));
        $email_address = trim(htmlspecialchars($_POST['email_address']));

        if (isset($_FILES['applicant_form']) && $_FILES['applicant_form']['error'] == UPLOAD_ERR_OK) {
            if ($_FILES['applicant_form']['size'] > 100000000) { // 10MB limit
                throw new Exception("File is too large. Maximum size is 10MB.");
            }
            $applicant_form = file_get_contents($_FILES['applicant_form']['tmp_name']);
        } else {
            $applicant_form = null;
        }

        $sql = "INSERT INTO applicantrecord (firstname, middlename, lastname, sex, province, exam_venue, date_of_examination, date_of_notification, proctor, status, applicant_form, contact_number, email_address)
                VALUES (:firstname, :middlename, :lastname, :sex, :province, :exam_venue, :date_of_examination, :date_of_notification, :proctor, :status, :applicant_form, :contact_number, :email_address)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':middlename', $middlename);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':sex', $sex);
        $stmt->bindParam(':province', $province);
        $stmt->bindParam(':exam_venue', $exam_venue);
        $stmt->bindParam(':date_of_examination', $date_of_examination);
        $stmt->bindParam(':date_of_notification', $date_of_notification);
        $stmt->bindParam(':proctor', $proctor);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':applicant_form', $applicant_form, PDO::PARAM_LOB);
        $stmt->bindParam(':contact_number', $contact_number);
        $stmt->bindParam(':email_address', $email_address);
        
        if (!$stmt->execute()) {
            throw new Exception("Failed to insert applicant record: " . implode(", ", $stmt->errorInfo()));
        }

        $last_applicant_ID = $conn->lastInsertId();
        
        // Applicant score insertion
        $applicant_score_part1 = trim(htmlspecialchars($_POST['exam1Score']));
        $applicant_score_part2 = trim(htmlspecialchars($_POST['exam2Score']));
        $applicant_score_part3 = trim(htmlspecialchars($_POST['exam3Score']));
        $sum = $applicant_score_part1 + $applicant_score_part2 + $applicant_score_part3;

        $sql = "INSERT INTO applicantscore (applicantID, applicant_score_part1, applicant_score_part2, applicant_score_part3, total_score)
                VALUES (:applicant_ID, :applicant_score_part1, :applicant_score_part2, :applicant_score_part3, :total_score)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':applicant_ID', $last_applicant_ID);
        $stmt->bindParam(':applicant_score_part1', $applicant_score_part1);
        $stmt->bindParam(':applicant_score_part2', $applicant_score_part2);
        $stmt->bindParam(':applicant_score_part3', $applicant_score_part3);
        $stmt->bindParam(':total_score', $sum);
        
        if (!$stmt->execute()) {
            throw new Exception("Failed to insert applicant score: " . implode(", ", $stmt->errorInfo()));
        }
        
        $conn->commit();
        $addapplicant = $firstname.' '.$middlename.' '.$lastname;
        include('addrecord.php');

        header("Location: table-records.php");
        exit();
    }
} catch(Exception $e) {
    if (isset($conn)) {
        $conn->rollBack();
    }
    error_log("Error: " . $e->getMessage());
    echo "An error occurred. Please try again later.";
}
?>
