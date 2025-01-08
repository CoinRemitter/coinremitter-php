<?php

/*
You will receive data on this URL if you have set this URL in setting of your wallet
Content Type: multipart/form-data
Accessing Data:
- Use $_POST to directly access data sent via POST.
- Use $_REQUEST to access data from $_POST, $_GET, and $_COOKIE (if applicable).

NOTE : Do not use file_get_contents("php://input"); method to access data. This method only works for JSON data.
*/


if (isset($_POST['id'])) {
    $id = $_POST['id'];
} else if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
} else {
    echo "No Transaction Data Received";
    exit;
}

/*
* Now verify this $id with the getTransaction method.
*/

include_once './vendor/autoload.php';

use CoinRemitter\CoinRemitter;

$wallet = new CoinRemitter('WALLET_API_KEY', 'WALLET_PASSWORD');
$transaction = $wallet->getTransaction(['id' => $id]);
print_r($transaction);


// Write your business logic here