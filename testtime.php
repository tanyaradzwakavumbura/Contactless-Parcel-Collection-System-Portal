<?php
date_default_timezone_set('Your/Timezone'); // Set your timezone

// Get the current timestamp
$current_timestamp = time();

// Get the timestamp for the target time today
$target_timestamp = strtotime('12:25');

// If the target time is earlier than the current time, assume it's for the next day
if ($target_timestamp < $current_timestamp) {
    $target_timestamp = strtotime('12:25 +1 day');
}

// Calculate the difference in seconds
$diff_seconds = $target_timestamp - $current_timestamp;

// Convert seconds to minutes
$total_minutes = floor($diff_seconds / 60);

echo "Total minutes between now and 12:25 is: $total_minutes minutes.";
?>
