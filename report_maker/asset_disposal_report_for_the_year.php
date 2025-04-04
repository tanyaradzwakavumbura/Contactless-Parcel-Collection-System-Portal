<?php
require('fpdf.php');
require('../includes/db.php');

// Create a new PDF document
$pdf = new FPDF();
$pdf->AddPage();

// Set the font and text color
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetTextColor(0, 0, 0);

// Add the logo and header name
$imageWidth = 50; // Adjust this value based on the actual width of your image
$pdf->SetX(($pdf->GetPageWidth() - $imageWidth) / 2);
$pdf->Image('../images/login.png', null, null, $imageWidth);

$pdf->Ln(10);

// Center the text
$text = 'Asset Disposal Report For ' . date('Y');
$pdf->SetX(0); // Move the current position to the left edge of the page
$pdf->SetFont('Arial', 'B', 14); // Set the font and size according to your requirements
$textWidth = $pdf->GetStringWidth($text);
$pdf->SetX(($pdf->GetPageWidth() - $textWidth) / 5);
$pdf->Cell(0, 10, $text, 0, 1, 'C');

$pdf->Ln(10);

// Retrieve the asset details from the database
// Modify this section according to your database structure and retrieval logic

$find_assets = $connect->prepare("SELECT * FROM disposal_requests WHERE status=? AND YEAR(date) =?");
$the_year = date("Y");
$submitted = "disposed";
$find_assets->execute([$submitted, $the_year]);

// Add content to the report
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Disposed Asset Details:', 0, 1);

$pdf->SetFont('Arial', '', 10);

while ($row = $find_assets->fetch(PDO::FETCH_ASSOC)) {
    $asset_code = $row["asset"];
    $disposal_reason = $row["reason"];
    $disposal_current_condition = $row["current_condition"];
    $disposal_approval = $row["approval"];
    $disposal_finance_approval = $row["finance_approval"];
    $disposal_finance_comment = $row["finance_comment"];
    $disposal_date = $row["date"];
    $disposal_id = $row["id"];

    // Retrieve asset details
    $find_asset_details = $connect->prepare("SELECT * FROM assets WHERE code=?");
    $find_asset_details->execute([$asset_code]);
    $asset_row = $find_asset_details->fetch(PDO::FETCH_ASSOC);
    $asset_name = $asset_row["description"];
    $asset_serial = $asset_row["serial"];
    $asset_category = $asset_row["category"];
    $asset_date_registered = $asset_row["date"];
    $asset_department_code = $asset_row["department"];

    // Retrieve category details
    $find_category_details = $connect->prepare("SELECT * FROM categories WHERE identifier=?");
    $find_category_details->execute([$asset_category]);
    $category_row = $find_category_details->fetch(PDO::FETCH_ASSOC);
    $asset_category_name = $category_row["name"];

    // Retrieve department details
    $find_asset_department = $connect->prepare("SELECT * FROM departments WHERE dep_code=?");
    $find_asset_department->execute([$asset_department_code]);
    $department_row = $find_asset_department->fetch(PDO::FETCH_ASSOC);
    $department_name = $department_row["name"];
    $department_hod = $department_row["hod"];

    // Retrieve requester details
    $find_the_requester = $connect->prepare("SELECT * FROM users WHERE username=?");
    $find_the_requester->execute([$disposal_approval]);
    $requester_row = $find_the_requester->fetch(PDO::FETCH_ASSOC);
    $hod_name = $requester_row["name"];
    $hod_surname = $requester_row["surname"];
    $hod_fullname = $hod_name . " " . $hod_surname;

    // Retrieve approver details
    $find_the_approver = $connect->prepare("SELECT * FROM users WHERE username=?");
    $find_the_approver->execute([$disposal_finance_approval]);
    $approver_row = $find_the_approver->fetch(PDO::FETCH_ASSOC);
    $approver_name = $approver_row["name"];
    $approver_surname = $approver_row["surname"];
    $approver_fullname = $approver_name . " " . $approver_surname;

    // Retrieve disposal details
    $find_the_actual_disposal_details = $connect->prepare("SELECT * FROM disposal_details WHERE disposal_id=?");
    $find_the_actual_disposal_details->execute([$disposal_id]);
    $disposal_details_row = $find_the_actual_disposal_details->fetch(PDO::FETCH_ASSOC);
    $the_disposal_type = $disposal_details_row["disposal_type"];
    $the_disposal_price = $disposal_details_row["price"];
    $the_disposal_company = $disposal_details_row["company"];
    $the_disposal_date = $disposal_details_row["date"];

    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 8, 'Asset ID: ' . $asset_code, 0, 1);
    $pdf->SetFont('Arial', '', 10);

    $pdf->Cell(0, 8, 'Asset Name: ' . $asset_name, 0, 1);
    $pdf->Cell(0, 8, 'Asset Category: ' . $asset_category_name, 0, 1);
    $pdf->Cell(0, 8, 'Asset Serial Number: ' . $asset_serial, 0, 1);
    $pdf->Cell(0, 8, 'Date Registered: ' . $asset_date_registered, 0, 1);
    $pdf->Cell(0, 8, 'Department: ' . $department_name, 0, 1);
    $pdf->Cell(0, 8, 'Department HOD: ' . $department_hod, 0, 1);
    $pdf->Cell(0, 8, 'Date of Disposal: ' . $disposal_date, 0, 1);
    $pdf->Cell(0, 8, 'Reason for Disposal: ' . $disposal_reason, 0, 1);
    $pdf->Cell(0, 8, 'Current Condition at Disposal: ' . $disposal_current_condition, 0, 1);
    $pdf->Cell(0, 8, 'Submitted By: ' . $hod_fullname, 0, 1);
    $pdf->Cell(0, 8, 'Approved By: ' . $approver_fullname, 0, 1);
    $pdf->Cell(0, 8, 'Approval Reason: ' . $disposal_finance_comment, 0, 1);
    $pdf->Ln(1);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 8, 'Disposal Details:', 0, 1);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 8, 'Disposal Type: ' . $the_disposal_type, 0, 1);
    $pdf->Cell(0, 8, 'Disposal Company: ' . $the_disposal_company, 0, 1);
    $pdf->Cell(0, 8, 'Disposal Price: ' . $the_disposal_price, 0, 1);
    $pdf->Cell(0, 8, 'Date of Actual Disposal: ' . $the_disposal_date, 0, 1);
    $pdf->Ln(5);
}

$pdf->Ln(20);

// Output the PDF document
$filename = 'asset_disposal_report_' . date('Y-m-d_H-i-s') . '.pdf';
$pdf->Output('D', $filename);
?>
