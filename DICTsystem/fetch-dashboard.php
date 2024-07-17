<?php
include_once('first-connection.php');
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : null;
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : null;

try {
    $pdo = new PDO("mysql:host=localhost;dbname=applicant-records", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $base_query = "SELECT COUNT(*) as count FROM applicantrecord";
    $date_condition = "";
    if ($start_date && $end_date) {
        $date_condition = " WHERE date_applied BETWEEN :start_date AND :end_date";
    }
    


    function executeQuery($pdo, $query, $params = []) {
        $stmt = $pdo->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
$query_params = [];
if ($start_date && $end_date) {
    $query_params = [':start_date' => $start_date, ':end_date' => $end_date];
}

$total_query = $base_query . $date_condition;
$total_count = executeQuery($pdo, $total_query, $query_params);


$passed_query = $base_query . $date_condition . ($date_condition ? " AND" : " WHERE") . " status = 'passed'";
$passed_count = executeQuery($pdo, $passed_query, $query_params);


$failed_query = $base_query . $date_condition . ($date_condition ? " AND" : " WHERE") . " status = 'failed'";
$failed_count = executeQuery($pdo, $failed_query, $query_params);


$pending_query = $base_query . $date_condition . ($date_condition ? " AND" : " WHERE") . " status = 'pending'";
$pending_count = executeQuery($pdo, $pending_query, $query_params);


$passed_handson_query = $base_query . $date_condition . ($date_condition ? " AND" : " WHERE") . " handson_status = 'passed'";
$passed_handson_count = executeQuery($pdo, $passed_handson_query, $query_params);


$failed_handson_query = $base_query . $date_condition . ($date_condition ? " AND" : " WHERE") . " handson_status = 'failed'";
$failed_handson_count = executeQuery($pdo, $failed_handson_query, $query_params);


$pending_handson_query = $base_query . $date_condition . ($date_condition ? " AND" : " WHERE") . " handson_status = 'pending'";
$pending_handson_count = executeQuery($pdo, $pending_handson_query, $query_params);



} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
