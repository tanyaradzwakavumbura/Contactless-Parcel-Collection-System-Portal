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
    $online_records = $connect_online->query("
        SELECT id, username, password, name, phone, role, main_job, 
               last_login_date, creation_date, modification_date 
        FROM users")->fetchAll(PDO::FETCH_ASSOC);

    // 2. Get all records from offline database
    $offline_records = $connect->query("
        SELECT id, username, password, name, phone, role, main_job, 
               last_login_date, creation_date, modification_date 
        FROM users")->fetchAll(PDO::FETCH_ASSOC);

    // Create associative arrays for easier comparison
    $offline_map = [];
    $online_map = [];
    
    foreach ($offline_records as $record) {
        $offline_map[$record['id']] = $record;
    }
    
    foreach ($online_records as $record) {
        $online_map[$record['id']] = $record;
    }

    // Prepare statements
    $insert_stmt = $connect->prepare("
        INSERT INTO users (id, username, password, name, phone, role, main_job,
                         last_login_date, creation_date, modification_date) 
        VALUES (:id, :username, :password, :name, :phone, :role, :main_job,
                :last_login_date, :creation_date, :modification_date)
    ");

    $update_stmt = $connect->prepare("
        UPDATE users 
        SET username = :username, password = :password, name = :name,
            phone = :phone, role = :role, main_job = :main_job,
            last_login_date = :last_login_date, modification_date = :modification_date
        WHERE id = :id
    ");

    $delete_stmt = $connect->prepare("DELETE FROM users WHERE id = :code");

    $insert_count = 0;
    $update_count = 0;
    $delete_count = 0;

    // Process each online record for inserts and updates
    foreach ($online_records as $online_record) {
        if (!isset($offline_map[$online_record['id']])) {
            // New record - Insert
            $insert_stmt->execute([
                'id' => $online_record['id'],
                'username' => $online_record['username'],
                'password' => $online_record['password'],
                'name' => $online_record['name'],
                'phone' => $online_record['phone'],
                'role' => $online_record['role'],
                'main_job' => $online_record['main_job'],
                'last_login_date' => $online_record['last_login_date'],
                'creation_date' => $online_record['creation_date'],
                'modification_date' => $online_record['modification_date']
            ]);
            $insert_count++;
        } else {
            // Existing record - Check if update needed
            $offline_record = $offline_map[$online_record['id']];
            
            if ($online_record['username'] != $offline_record['username'] ||
                $online_record['password'] != $offline_record['password'] ||
                $online_record['name'] != $offline_record['name'] ||
                $online_record['phone'] != $offline_record['phone'] ||
                $online_record['role'] != $offline_record['role'] ||
                $online_record['main_job'] != $offline_record['main_job'] ||
                $online_record['last_login_date'] != $offline_record['last_login_date'] ||
                $online_record['modification_date'] != $offline_record['modification_date']) {
                
                // Update needed
                $update_stmt->execute([
                    'id' => $online_record['id'],
                    'username' => $online_record['username'],
                    'password' => $online_record['password'],
                    'name' => $online_record['name'],
                    'phone' => $online_record['phone'],
                    'role' => $online_record['role'],
                    'main_job' => $online_record['main_job'],
                    'last_login_date' => $online_record['last_login_date'],
                    'modification_date' => $online_record['modification_date']
                ]);
                $update_count++;
            }
        }
    }

    // Process deletions - check for records in offline that don't exist in online
    foreach ($offline_map as $id => $offline_record) {
        if (!isset($online_map[$id])) {
            // Record exists offline but not online - Delete it
            $delete_stmt->execute(['code' => $id]);
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