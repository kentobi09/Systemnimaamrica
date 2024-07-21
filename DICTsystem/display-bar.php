<?php

require_once "first-connection.php";
if (isset($_POST["clear_filter"])) {
    $start_date = null;
    $end_date = null;
} else {
    $start_date = isset($_POST["start_date"]) ? $_POST["start_date"] : null;
    $end_date = isset($_POST["end_date"]) ? $_POST["end_date"] : null;
}
try {
    $pdo = new PDO("mysql:host=localhost;dbname=applicant-records", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Date condition variables
    $date_condition_record = "";
    $date_condition_handson = "";
    if ($start_date && $end_date) {
        $date_condition_record =
            " AND ar.date_of_examination BETWEEN :start_date AND :end_date";
        $date_condition_handson =
            " AND ar.date_of_examination BETWEEN :start_date AND :end_date";
    }

    // Query for diagnostic exam (applicantrecord table)
    $diagnostic_query =
        "SELECT province, COUNT(*) as passer_count
                         FROM applicantrecord ar
                         WHERE status = 'Passed'" .
        $date_condition_record .
        "
                         GROUP BY province
                         ORDER BY passer_count DESC
                         LIMIT 5";
    $diagnostic_stmt = $pdo->prepare($diagnostic_query);
    if ($start_date && $end_date) {
        $diagnostic_stmt->bindParam(":start_date", $start_date);
        $diagnostic_stmt->bindParam(":end_date", $end_date);
    }
    $diagnostic_stmt->execute();
    $diagnostic_result = $diagnostic_stmt->fetchAll(PDO::FETCH_ASSOC);

    // Query for handson exam (joining applicantrecord and applicanthandson tables)
    $handson_query =
        "SELECT ar.province, COUNT(*) as passer_count
                      FROM applicantrecord ar
                      JOIN applicanthandson ah ON ar.applicantID = ah.applicantID
                      WHERE ah.handson_status = 'Passed'" .
        $date_condition_handson .
        "
                      GROUP BY ar.province
                      ORDER BY passer_count DESC
                      LIMIT 5";
    $handson_stmt = $pdo->prepare($handson_query);
    if ($start_date && $end_date) {
        $handson_stmt->bindParam(":start_date", $start_date);
        $handson_stmt->bindParam(":end_date", $end_date);
    }
    $handson_stmt->execute();
    $handson_result = $handson_stmt->fetchAll(PDO::FETCH_ASSOC);

    $json_data = json_encode([
        "diagnostic" => $diagnostic_result,
        "handson" => $handson_result,
    ]);
} catch (PDOException $e) {
    $json_data = json_encode(["error" => $e->getMessage()]);
}
