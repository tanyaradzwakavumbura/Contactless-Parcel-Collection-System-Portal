<?php
//Function to shorten the string to a certain amount
function limit_string($string, $limit) {
  if (strlen($string) > $limit) {
    $string = substr($string, 0, $limit) . "..."; // Add "..." to indicate that the string has been truncated
  }

  return $string; // Return the limited string
}

//Function to Format Date
function format_date($date) {
  $timestamp = strtotime($date);
  $formatted_date = date("F j, Y", $timestamp);

  return $formatted_date;
}

//Add Leading Zeros
function add_leading_zeros($number, $digits) {
  return sprintf('%0' . $digits . 'd', $number);
}


//Fucntion to Format Money
function format_money($amount) {
    return '$' . number_format($amount, 2, '.', ',');
}



/*----------------------------------------------------------------------------------------------------------------------------

                                            CALCULATE NUMBER OF YEARS CODE FUNCTION 
----------------------------------------------------------------------------------------------------------------------------*/
function calculateYears($startYear) {
    $currentYear = date('Y');
    $years = $currentYear - $startYear;

    return $years;
}
/*----------------------------------------------------------------------------------------------------------------------------

                                            GET THE YEAR FROM A NORMAL DATE CODE FUNCTION 
----------------------------------------------------------------------------------------------------------------------------*/
function getYearFromDate($dateString) {
    // Convert the date string to a Unix timestamp
    $timestamp = strtotime($dateString);

    // Extract the year from the timestamp
    $year = date('Y', $timestamp);

    return $year;
}
/*----------------------------------------------------------------------------------------------------------------------------

                                            CALCULATE THE MINUTES BETWEEN TWO TIMES CODE FUNCTION 
----------------------------------------------------------------------------------------------------------------------------*/
function calculateMinutesDifference($startTime, $endTime) {
    // Convert the time strings to DateTime objects
    $start = DateTime::createFromFormat('H:i', $startTime);
    $end = DateTime::createFromFormat('H:i', $endTime);

    // Check if the time objects are valid
    if ($start && $end) {
        // Calculate the difference between the two DateTime objects
        $interval = $start->diff($end);

        // Convert the difference to minutes
        $minutes = $interval->h * 60 + $interval->i;

        // Return the difference in minutes
        return $minutes;
    } else {
        // Return an error message if the input times are invalid
        return "Invalid time format. Please use HH:MM format.";
    }
}

/*----------------------------------------------------------------------------------------------------------------------------

                                            GENERATE LOCKER CODE FUNCTION 
----------------------------------------------------------------------------------------------------------------------------*/
function calculateLockerCode($connect)
{
    $the_locker_code = 1;

    try {
        // Find total count of lockers
        $find_lockers = $connect->prepare("SELECT COUNT(*) AS total_lockers FROM lockers");
        $find_lockers->execute();
        $count_lockers = $find_lockers->fetchColumn();

        // Calculate the locker code
        $the_locker_code = $count_lockers > 0 ? $count_lockers + 1 : 1;

        // Find the last locker
        $find_last_locker = $connect->prepare("SELECT id FROM lockers ORDER BY id DESC LIMIT 1");
        $find_last_locker->execute();
        $row = $find_last_locker->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $current_locker = $row["id"];
            $the_locker_code = $current_locker + 1;
        }
    } catch (PDOException $e) {
        // Handle any database errors
        echo "Error: " . $e->getMessage();
        // You may want to log the error or perform additional error handling here
    }

    // Pad the locker code with leading zeros
    $the_locker_code = str_pad($the_locker_code, 4, "0", STR_PAD_LEFT);

    return "LOCKER-" . $the_locker_code;
}

/*----------------------------------------------------------------------------------------------------------------------------

                                            GENERATE PARCEL CODE FUNCTION 
----------------------------------------------------------------------------------------------------------------------------*/
function calculateParcelCode($connect)
{
    $the_locker_code = 1;

    try {
        // Find total count of lockers
        $find_lockers = $connect->prepare("SELECT COUNT(*) AS total_lockers FROM parcels");
        $find_lockers->execute();
        $count_lockers = $find_lockers->fetchColumn();

        // Calculate the locker code
        $the_locker_code = $count_lockers > 0 ? $count_lockers + 1 : 1;

        // Find the last locker
        $find_last_locker = $connect->prepare("SELECT id FROM parcels ORDER BY id DESC LIMIT 1");
        $find_last_locker->execute();
        $row = $find_last_locker->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $current_locker = $row["id"];
            $the_locker_code = $current_locker + 1;
        }
    } catch (PDOException $e) {
        // Handle any database errors
        echo "Error: " . $e->getMessage();
        // You may want to log the error or perform additional error handling here
    }

    // Pad the locker code with leading zeros
    $the_locker_code = str_pad($the_locker_code, 4, "0", STR_PAD_LEFT);

    return "PARCEL-" . $the_locker_code;
}
/*----------------------------------------------------------------------------------------------------------------------------

                                            GENERATE MEMBER CODE FUNCTION 
----------------------------------------------------------------------------------------------------------------------------*/
function calculateMemberCode($connect)
{
    try {
        // Begin a transaction to ensure atomicity
        $connect->beginTransaction();

        // Find the last row in the table (the highest ID)
        $find_last_member = $connect->prepare("SELECT id FROM members ORDER BY id DESC LIMIT 1 FOR UPDATE");
        $find_last_member->execute();
        $row = $find_last_member->fetch(PDO::FETCH_ASSOC);

        // Calculate the new member code
        $new_id = $row ? $row["id"] + 1 : 1;

        // Commit the transaction
        $connect->commit();

        // Pad the member code with leading zeros
        $member_code = str_pad($new_id, 4, "0", STR_PAD_LEFT);

        return "MEM" . $member_code;
    } catch (PDOException $e) {
        // Roll back the transaction in case of error
        $connect->rollBack();
        echo "Error: " . $e->getMessage();
        // Handle or log the error as needed
    }

    return null; // Return null in case of an error
}

/*----------------------------------------------------------------------------------------------------------------------------

                                            GENERATE WEEKS IN A MONTH CODE FUNCTION 
----------------------------------------------------------------------------------------------------------------------------*/
function getWeeksInMonth($year, $month) {
    $weeks = [];
    $start_date = new DateTime("$year-$month-01"); // First day of the month
    $end_date = new DateTime($start_date->format('Y-m-t')); // Last day of the month
    
    while ($start_date <= $end_date) {
        $week_start = clone $start_date;
        $week_end = clone $start_date;
        $week_end->modify('Sunday this week'); // Get the end of the week (Sunday)

        // Ensure the week doesn't extend beyond the month
        if ($week_end > $end_date) {
            $week_end = clone $end_date;
        }

        // Store the start and end date of the week
        $weeks[] = [
            'start' => $week_start->format('Y-m-d'),
            'end' => $week_end->format('Y-m-d'),
        ];

        // Move to the next week (Monday after the current week's Sunday)
        $start_date = clone $week_end;
        $start_date->modify('+1 day');
    }

    return $weeks;
}

/*----------------------------------------------------------------------------------------------------------------------------

                                            GENERATE DEPARTMENT CODE FUNCTION 
----------------------------------------------------------------------------------------------------------------------------*/
function calculateDepartmentCode($connect)
{
    try {
        // Begin a transaction to ensure atomicity
        $connect->beginTransaction();

        // Find the last row in the table (the highest ID)
        $find_last_department = $connect->prepare("SELECT id FROM departments ORDER BY id DESC LIMIT 1 FOR UPDATE");
        $find_last_department->execute();
        $row = $find_last_department->fetch(PDO::FETCH_ASSOC);

        // Calculate the new department code
        $new_id = $row ? $row["id"] + 1 : 1;

        // Commit the transaction
        $connect->commit();

        // Pad the department code with leading zeros
        $department_code = str_pad($new_id, 4, "0", STR_PAD_LEFT);

        return "DEPT" . $department_code;
    } catch (PDOException $e) {
        // Roll back the transaction in case of error
        $connect->rollBack();
        echo "Error: " . $e->getMessage();
        // Handle or log the error as needed
    }

    return null; // Return null in case of an error
}


/*----------------------------------------------------------------------------------------------------------------------------

                                            GENERATE PROJECT CODE FUNCTION 
----------------------------------------------------------------------------------------------------------------------------*/
function calculateProjectCode($connect)
{
    try {
        // Begin a transaction to ensure atomicity
        $connect->beginTransaction();

        // Find the last row in the table (the highest ID)
        $find_last_project = $connect->prepare("SELECT id FROM projects ORDER BY id DESC LIMIT 1 FOR UPDATE");
        $find_last_project->execute();
        $row = $find_last_project->fetch(PDO::FETCH_ASSOC);

        // Calculate the new project code
        $new_id = $row ? $row["id"] + 1 : 1;

        // Commit the transaction
        $connect->commit();

        // Pad the project code with leading zeros
        $project_code = str_pad($new_id, 5, "0", STR_PAD_LEFT); // 5 digits for projects

        return "PROJ" . $project_code;
    } catch (PDOException $e) {
        // Roll back the transaction in case of error
        $connect->rollBack();
        echo "Error: " . $e->getMessage();
        // Handle or log the error as needed
    }

    return null; // Return null in case of an error
}

/*----------------------------------------------------------------------------------------------------------------------------

                                            GENERATE CELL MEETING CODE FUNCTION 
----------------------------------------------------------------------------------------------------------------------------*/
function calculateCellMeetingCode($connect)
{
    try {
        // Begin a transaction to ensure atomicity
        $connect->beginTransaction();

        // Find the last row in the table (the highest ID)
        $find_last_meeting = $connect->prepare("SELECT id FROM cell_meetings ORDER BY id DESC LIMIT 1 FOR UPDATE");
        $find_last_meeting->execute();
        $row = $find_last_meeting->fetch(PDO::FETCH_ASSOC);

        // Calculate the new meeting code
        $new_id = $row ? $row["id"] + 1 : 1;

        // Commit the transaction
        $connect->commit();

        // Pad the meeting code with leading zeros
        $meeting_code = str_pad($new_id, 4, "0", STR_PAD_LEFT);

        return "MEET" . $meeting_code;
    } catch (PDOException $e) {
        // Roll back the transaction in case of error
        $connect->rollBack();
        echo "Error: " . $e->getMessage();
        // Handle or log the error as needed
    }

    return null; // Return null in case of an error
}
/*----------------------------------------------------------------------------------------------------------------------------

                                            GENERATE CLASS CODE FUNCTION 
----------------------------------------------------------------------------------------------------------------------------*/
function calculateClassCode($connect)
{
    try {
        // Begin a transaction to ensure atomicity
        $connect->beginTransaction();

        // Find the last row in the table (the highest ID)
        $find_last_class = $connect->prepare("SELECT id FROM classes ORDER BY id DESC LIMIT 1 FOR UPDATE");
        $find_last_class->execute();
        $row = $find_last_class->fetch(PDO::FETCH_ASSOC);

        // Calculate the new class code
        $new_id = $row ? $row["id"] + 1 : 1;

        // Commit the transaction
        $connect->commit();

        // Pad the class code with leading zeros
        $class_code = str_pad($new_id, 4, "0", STR_PAD_LEFT);

        return "CLASS" . $class_code;
    } catch (PDOException $e) {
        // Roll back the transaction in case of error
        $connect->rollBack();
        echo "Error: " . $e->getMessage();
        // Handle or log the error as needed
    }

    return null; // Return null in case of an error
}
/*----------------------------------------------------------------------------------------------------------------------------

                                            GENERATE VEHICLE ENTRY CODE FUNCTION 
----------------------------------------------------------------------------------------------------------------------------*/
function calculateVehicleEntryCode($connect)
{
    $company_code = 1;

    try {
        // Find total count of companies
        $find_companies = $connect->prepare("SELECT COUNT(*) AS total_companies FROM vehicle_entry");
        $find_companies->execute();
        $count_companies = $find_companies->fetchColumn();

        // Calculate the company code
        $company_code = $count_companies > 0 ? $count_companies + 1 : 1;

        // Find the last company
        $find_last_company = $connect->prepare("SELECT id FROM vehicle_entry ORDER BY id DESC LIMIT 1");
        $find_last_company->execute();
        $row = $find_last_company->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $current_company = $row["id"];
            $company_code = $current_company + 1;
        }
    } catch (PDOException $e) {
        // Handle any database errors
        echo "Error: " . $e->getMessage();
        // You may want to log the error or perform additional error handling here
    }

    // Pad the company code with leading zeros
    $company_code = str_pad($company_code, 4, "0", STR_PAD_LEFT);

    return "ENTRY" . $company_code;
}

/*----------------------------------------------------------------------------------------------------------------------------

                                            SANITIZE INPUT DATA CODE FUNCTION 
----------------------------------------------------------------------------------------------------------------------------*/
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}
/*----------------------------------------------------------------------------------------------------------------------------

                                            GENERATE EMPLOYEE CODE FUNCTION 
----------------------------------------------------------------------------------------------------------------------------*/
function calculateEmployeeCode($connect)
{
    $company_code = 1;

    try {
        // Find total count of companies
        $find_companies = $connect->prepare("SELECT COUNT(*) AS total_companies FROM employees");
        $find_companies->execute();
        $count_companies = $find_companies->fetchColumn();

        // Calculate the company code
        $company_code = $count_companies > 0 ? $count_companies + 1 : 1;

        // Find the last company
        $find_last_company = $connect->prepare("SELECT id FROM employees ORDER BY id DESC LIMIT 1");
        $find_last_company->execute();
        $row = $find_last_company->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $current_company = $row["id"];
            $company_code = $current_company + 1;
        }
    } catch (PDOException $e) {
        // Handle any database errors
        echo "Error: " . $e->getMessage();
        // You may want to log the error or perform additional error handling here
    }

    // Pad the company code with leading zeros
    $company_code = str_pad($company_code, 4, "0", STR_PAD_LEFT);

    return "EMP" . $company_code;
}
/*----------------------------------------------------------------------------------------------------------------------------

                                            GENERATE REVIEWER CODE FUNCTION 
----------------------------------------------------------------------------------------------------------------------------*/
function calculateReviewerCode($connect)
{
    $company_code = 1;

    try {
        // Find total count of companies
        $find_companies = $connect->prepare("SELECT COUNT(*) AS total_companies FROM reviewers");
        $find_companies->execute();
        $count_companies = $find_companies->fetchColumn();

        // Calculate the company code
        $company_code = $count_companies > 0 ? $count_companies + 1 : 1;

        // Find the last company
        $find_last_company = $connect->prepare("SELECT id FROM reviewers ORDER BY id DESC LIMIT 1");
        $find_last_company->execute();
        $row = $find_last_company->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $current_company = $row["id"];
            $company_code = $current_company + 1;
        }
    } catch (PDOException $e) {
        // Handle any database errors
        echo "Error: " . $e->getMessage();
        // You may want to log the error or perform additional error handling here
    }

    // Pad the company code with leading zeros
    $company_code = str_pad($company_code, 4, "0", STR_PAD_LEFT);

    return "REV" . $company_code;
}

/*----------------------------------------------------------------------------------------------------------------------------

                                            GENERATE PERFORMANCE RATING CODE FUNCTION 
----------------------------------------------------------------------------------------------------------------------------*/
function calculateRatingCode($connect)
{
    $company_code = 1;

    try {
        // Find total count of companies
        $find_companies = $connect->prepare("SELECT COUNT(*) AS total_companies FROM ratings");
        $find_companies->execute();
        $count_companies = $find_companies->fetchColumn();

        // Calculate the company code
        $company_code = $count_companies > 0 ? $count_companies + 1 : 1;

        // Find the last company
        $find_last_company = $connect->prepare("SELECT id FROM ratings ORDER BY id DESC LIMIT 1");
        $find_last_company->execute();
        $row = $find_last_company->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $current_company = $row["id"];
            $company_code = $current_company + 1;
        }
    } catch (PDOException $e) {
        // Handle any database errors
        echo "Error: " . $e->getMessage();
        // You may want to log the error or perform additional error handling here
    }

    // Pad the company code with leading zeros
    $company_code = str_pad($company_code, 4, "0", STR_PAD_LEFT);

    return "RATE" . $company_code;
}

/*----------------------------------------------------------------------------------------------------------------------------

                                        CHECK RATING CODE AND COMMENT FUNCTION 
----------------------------------------------------------------------------------------------------------------------------*/
function checkRatingCommentColor($connect, $mark) {
    // Prepare SQL query
    $find_grading_query = $connect->prepare("SELECT * FROM ratings WHERE :mark BETWEEN lower AND upper_limit");

    // Bind parameter as integer or float
    $find_grading_query->bindParam(':mark', $mark, PDO::PARAM_INT); // Use PDO::PARAM_INT for integer, or PDO::PARAM_STR for string (if mark can be a string) 

    // Execute query
    $find_grading_query->execute();

    // Fetch the row
    $row = $find_grading_query->fetch(PDO::FETCH_ASSOC);

    // Check if a row was returned
    if ($row) {
        // Extract grade name and color
        $rating_name = $row["name"];
        $rating_description = $row["description"];

        // Return grade name
        return $rating_name;
    } else {
        // Return a default value or handle the case when no grade is found
        return "No rating";
    }
}
/*----------------------------------------------------------------------------------------------------------------------------

                                        CALCULATE MINUTES FOR BOOMGATE FUNCTION 
----------------------------------------------------------------------------------------------------------------------------*/
function calculateMinutesToTargetTime($target_time) {
    // Get the current timestamp
    $current_timestamp = time();

    // Get the timestamp for the target time today
    $target_timestamp = strtotime($target_time);

    // If the target time is earlier than the current time, assume it's for the next day
    if ($target_timestamp < $current_timestamp) {
        $target_timestamp = strtotime($target_time . ' +1 day');
    }

    // Calculate the difference in seconds
    $diff_seconds = $target_timestamp - $current_timestamp;

    // Convert seconds to minutes
    $total_minutes = floor($diff_seconds / 60);

    return $total_minutes;
}
?>