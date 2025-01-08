<?php
/*
When an invoice is created with a notify_url, invoice notification data will be sent to this URL via a POST request when the customer makes a payment to the invoice address.

Content Type: multipart/form-data
Accessing Data:
- Use $_POST to directly access data sent via POST.
- Use $_REQUEST to access data from $_POST, $_GET, and $_COOKIE (if applicable).

NOTE : Do not use file_get_contents("php://input"); method to access data. This method only works for JSON data.
*/

if (isset($_POST['invoice_id'])) {
    $invoice_id = $_POST['invoice_id'];
} else if (isset($_REQUEST['invoice_id'])) {
    $invoice_id = $_REQUEST['invoice_id'];
} else {
    echo "No Invoice Data Received";
    exit;
}

/*
* Now verify this invoice_id with the getInvoice method.
*/

include_once './vendor/autoload.php';

use CoinRemitter\CoinRemitter;

$wallet = new CoinRemitter('WALLET_API_KEY', 'WALLET_PASSWORD');
$invoice = $wallet->getInvoice(['invoice_id' => $invoice_id]);
print_r($invoice);

// Write your business logic here