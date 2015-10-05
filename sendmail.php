<?php
// Open file with last order id
$versionFile = fopen("orders/id", "r+") or die("Unable to open file!");
$orderId = intval(fread($versionFile, filesize("orders/id")));
rewind($versionFile);
fwrite($versionFile, $orderId + 1);
fclose($versionFile);

// Prepare email information
$from = $_GET["from"];
$cc = "devishna@gmail.com";
$to = "alexey.s.kolonitsky@gmail.com";
$subject = "Froggy Order #" . $orderId;
$message = $_GET["data"];

writeUTF8File("orders/order" . $orderId, $message);

// Send information about order to manager 
// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: ' . $from . "\r\n";
$headers .= 'Cc: ' . $cc . "\r\n";
mail($from, $subject, $message, $headers);

// Send cover letter to customer
echo "<orderId>" . $orderId . "</orderId>";

// Write UTF8 File
function writeUTF8File($filename,$content) { 
        $f=fopen($filename,"w") or die("Unable to open file!"); 
        # Now UTF-8 - Add byte order mark 
        fwrite($f, pack("CCC",0xef,0xbb,0xbf)); 
        fwrite($f,$content); 
        fclose($f); 
} 
?>