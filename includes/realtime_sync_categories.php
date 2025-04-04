<?php

/*-----------------------------------------------------------------------------------------------------------------------------
                                           CURRENT DATE AND TIME CODE
----------------------------------------------------------------------------------------------------------------------------*/
// Use constants for values that won't change during script execution
define('CURRENT_DATETIME', date('Y-m-d H:i:s'));
define('CURRENT_DATE', date('Y-m-d'));
define('CURRENT_TIME', date('H:i'));
define('CURRENT_YEAR', date('Y'));

require_once('db.php');

try {
    // Connection String for Online Database
    $connect_online = new PDO(
        "mysql:host=$online_host;dbname=$online_dbname",
        $online_username,
        $online_password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Begin transaction
    $connect->beginTransaction();

    // 1. First get all records from online database
    $online_records = $connect_online->query("SELECT code, name, cost, minutes FROM categories")->fetchAll(PDO::FETCH_ASSOC);

    // 2. Get all records from offline database
    $offline_records = $connect->query("SELECT code, name, cost, minutes FROM categories")->fetchAll(PDO::FETCH_ASSOC);

    // Create associative arrays for easier comparison
    $offline_map = [];
    $online_map = [];
    
    foreach ($offline_records as $record) {
        $offline_map[$record['code']] = $record;
    }
    
    foreach ($online_records as $record) {
        $online_map[$record['code']] = $record;
    }

    // Prepare statements
    $insert_stmt = $connect->prepare("
        INSERT INTO categories (code, name, cost, minutes, date) 
        VALUES (:code, :name, :cost, :minutes, :date)
    ");

    $update_stmt = $connect->prepare("
        UPDATE categories 
        SET name = :name, cost = :cost, minutes = :minutes, date = :date
        WHERE code = :code
    ");

    $delete_stmt = $connect->prepare("
        DELETE FROM categories WHERE code = :code
    ");

    $insert_count = 0;
    $update_count = 0;
    $delete_count = 0;

    // Process each online record for inserts and updates
    foreach ($online_records as $online_record) {
        if (!isset($offline_map[$online_record['code']])) {
            // New record - Insert
            $insert_stmt->execute([
                'code' => $online_record['code'],
                'name' => $online_record['name'],
                'cost' => $online_record['cost'],
                'minutes' => $online_record['minutes'],
                'date' => CURRENT_DATE
            ]);
            $insert_count++;
        } else {
            // Existing record - Check if update needed
            $offline_record = $offline_map[$online_record['code']];
            
            if ($online_record['cost'] != $offline_record['cost'] ||
                $online_record['name'] != $offline_record['name'] ||
                $online_record['minutes'] != $offline_record['minutes']) {
                
                // Update needed
                $update_stmt->execute([
                    'code' => $online_record['code'],
                    'name' => $online_record['name'],
                    'cost' => $online_record['cost'],
                    'minutes' => $online_record['minutes'],
                    'date' => CURRENT_DATE
                ]);
                $update_count++;
            }
        }
    }

    // Process deletions - check for records in offline that don't exist in online
    foreach ($offline_map as $code => $offline_record) {
        if (!isset($online_map[$code])) {
            // Record exists offline but not online - Delete it
            $delete_stmt->execute(['code' => $code]);
            $delete_count++;
        }
    }

    // Commit all changes
    $connect->commit();
    echo "Synchronization completed successfully. Inserted: $insert_count, Updated: $update_count, Deleted: $delete_count records.";

} catch (PDOException $e) {
    if (isset($connect) && $connect->inTransaction()) {
        $connect->rollBack();
    }
    error_log("Error in realtime_sync.php: " . $e->getMessage());
    echo "An error occurred during synchronization: " . $e->getMessage();
}
?>