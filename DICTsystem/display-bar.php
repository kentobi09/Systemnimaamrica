<?php
require_once 'first-connection.php';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=applicant-records", 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT province, COUNT(*) as passer_count 
              FROM applicantrecord 
              WHERE status = 'Passed'
              GROUP BY province 
              ORDER BY passer_count DESC 
              LIMIT 5";

    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

   
    $json_data = json_encode($result);

} catch(PDOException $e) {
    
    $json_data = json_encode(["error" => $e->getMessage()]);
}