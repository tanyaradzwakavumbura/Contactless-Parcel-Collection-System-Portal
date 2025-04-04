<?php
require_once 'vendor/autoload.php';

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

// Generate 6 random strings and hash them
$hashes = array();
for ($i = 0; $i < 6; $i++) {
    $string = bin2hex(random_bytes(3)); // 6 characters
    $hash = hash('sha256', $string);
    $hashes[] = $hash;
}

// Generate QR codes and display them
echo '<div style="display: flex; flex-wrap: wrap;">';
foreach ($hashes as $hash) {
    // Generate QR code options
    $options = new QROptions([
        'version' => 5, 
        'outputType' => QRCode::OUTPUT_IMAGE_PNG,
        'eccLevel' => QRCode::ECC_L,
        'scale' => 4,
        'imageBase64' => false
    ]);

    $qrCode = new QRCode($options);

    // and dump the output
    $qr = $qrCode->render($hash);

    // Get QR code image as data URI
    $dataUri = 'data:image/png;base64,' . base64_encode($qr);

    // Display QR code
    echo '<div class="qr-container">';
    echo '<div class="qr-image"><img src="'.$dataUri.'" alt="'.$hash.'" /></div>';
    // echo '<div class="qr-data"><p>'.$hash.'</p></div>';
    echo '</div>';
}
echo '</div>';
?>

<style>
.qr-container {
  display: flex;
  align-items: center;
  padding: 10px;
  border: 2px solid #000;
  width: 400px;
  margin: 10px;
  /* height: 200px; */
}

.qr-image {
  width: 33%;
  padding-right: 10px;
}

.qr-data {
  width: 67%;
}
</style>
