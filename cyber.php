<?php
// ESC/POS commands to format the receipt
$initPrinter = "\x1B\x40"; // Initialize the printer
$centerAlign = "\x1B\x61\x01"; // Align text to center
$leftAlign = "\x1B\x61\x00"; // Align text to left
$boldOn = "\x1B\x45\x01"; // Enable bold
$boldOff = "\x1B\x45\x00"; // Disable bold
$lineFeed = "\x0A"; // Line feed (new line)
$cutPaper = "\x1D\x56\x00"; // Cut paper

// Receipt content
$date = date('Y-m-d H:i:s');
$storeName = "Store XYZ";
$receiptTitle = "Receipt";
$items = [
    ['Item 1', 10.00],
    ['Item 2', 5.50],
    ['Item 3', 2.00],
    ['Very Long Item Name That Might Overflow', 15.99], // Example of long item name
];
$total = 0;

// Generate receipt content
$receipt = $initPrinter; // Initialize printer
$receipt .= $centerAlign . $storeName . $lineFeed; // Store name
$receipt .= $centerAlign . $receiptTitle . $lineFeed; // Receipt title
$receipt .= $centerAlign . $date . $lineFeed; // Date
$receipt .= $leftAlign; // Align text to left
$receipt .= str_repeat("-", 40) . $lineFeed; // Separator line

// Item list (Fixed width for item name and price to avoid overflow)
foreach ($items as $item) {
    $itemName = substr($item[0], 0, 20); // Truncate item name to 20 characters
    $receipt .= sprintf("%-20s %10.2f\n", $itemName, $item[1]); // Item name and price
    $total += $item[1]; // Calculate total
}

// Total
$receipt .= str_repeat("-", 40) . $lineFeed; // Separator line
$receipt .= sprintf("%-20s %10.2f\n", "Total", $total); // Total price
$receipt .= $cutPaper; // Cut paper

// Define the file path to save the receipt
$file = 'receipt.txt';

// Write the receipt content to the text file
file_put_contents($file, $receipt);

echo "Receipt saved to receipt.txt!<br>";

// Now, automatically print the file using Notepad
// Define the command to print the receipt using Notepad
$command = 'notepad /p ' . $file;

// Execute the command
exec($command, $output, $status);

// Check the result
if ($status === 0) {
    echo "File sent to printer successfully!";
} else {
    echo "Error in sending the file to the printer.";
}
?>
