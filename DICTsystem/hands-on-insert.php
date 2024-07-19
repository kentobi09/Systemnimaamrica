<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $conn = new PDO("mysql:host=localhost;dbname=applicant-records;max_allowed_packet=67108864", "root", "");
    $conn->setAttribute(PDO::ATTR_TIMEOUT, 300); // 5 minutes
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $applicant_id = trim(htmlspecialchars($_POST['add-ID']));
        $handson_score = trim(htmlspecialchars($_POST['add-handsonscore']));
        
        $conn->beginTransaction();
        
        // Determine if the input is an ID or a name
        if (is_numeric($applicant_id)) {
            // Check if ID exists
            $sql = "SELECT applicantID FROM applicantrecord WHERE applicantID = :applicantID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':applicantID', $applicant_id, PDO::PARAM_INT);
        } else {
            // Check if name exists
            $sql = "SELECT applicantID FROM applicantrecord WHERE CONCAT_WS(' ', firstname, middlename, lastname) = :applicantName";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':applicantName', $applicant_id);
        }
        
        $stmt->execute();
        $applicantRecord = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$applicantRecord) {
            // No record found, alert and exit
            echo "<script>alert('No record found for this applicant.'); window.history.back();</script>";
            $conn->rollBack();
            exit();
        }

        $applicantID = $applicantRecord['applicantID'];

        // Check if applicant already has a record in applicanthandson
        $sql = "SELECT COUNT(*) FROM applicanthandson WHERE applicantID = :applicantID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':applicantID', $applicantID, PDO::PARAM_INT);
        $stmt->execute();
        $recordCount = $stmt->fetchColumn();

        if ($recordCount > 0) {
            // Record exists, show an alert
            echo "<script>alert('An entry for this applicant already exists in the records.'); window.history.back();</script>";
            $conn->rollBack();
            exit();
        }

        // Update applicant score
        $sql = "UPDATE applicantscore 
                SET handson_score = :handson_score 
                WHERE applicantID = :applicant_ID";
    
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':handson_score', $handson_score, PDO::PARAM_STR);
        $stmt->bindParam(':applicant_ID', $applicantID, PDO::PARAM_INT);
        
        if (!$stmt->execute()) {
            throw new Exception("Failed to update handson score: " . implode(", ", $stmt->errorInfo()));
        }

        // Insert new record into applicanthandson
        $exam_venue = $_POST['handson-exam_venue'];
        $date_of_examination = $_POST['handson-date_of_examination'];
        $date_of_notification = $_POST['handson-date_of_notification'];
        $proctor = $_POST['handson-proctorName'];
        $handson_status = $_POST['handson-status'];

        $sql = "INSERT INTO applicanthandson (applicantID, exam_venue, date_of_examination, date_of_notification, proctor, handson_status) 
                VALUES (:applicantID, :exam_venue, :date_of_examination, :date_of_notification, :proctor, :handson_status)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':applicantID', $applicantID);
        $stmt->bindParam(':exam_venue', $exam_venue);
        $stmt->bindParam(':date_of_examination', $date_of_examination);
        $stmt->bindParam(':date_of_notification', $date_of_notification);
        $stmt->bindParam(':proctor', $proctor);
        $stmt->bindParam(':handson_status', $handson_status);

        if (!$stmt->execute()) {
            throw new Exception("Failed to insert handson record: " . implode(", ", $stmt->errorInfo()));
        }

        $conn->commit();
        header("Location: table-records.php");
        exit();
    }
} catch (Exception $e) {
    if (isset($conn)) {
        $conn->rollBack();
    }
    echo "<script>alert('An error occurred: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
}
?>
    