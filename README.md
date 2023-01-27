CoinRemitter plugin for PHP
===

Coinremitter is a [crypto payment processor](http://coinremitter.com). Accept Bitcoin, Tron, Binance (BEP20), BitcoinCash, Ethereum, Litecoin, Dogecoin, USDTERC20, USDTTRC20, Dash, Monero etc.

**What is the Crypto Payment Processor?**

The Crypto Payment Processor acts as a mediator between merchants and customers, allowing the merchant to receive payments in the form of cryptocurrency.


## Installation guide:
You can install the Coinremitter plugin using the composer in your project as shown below:
```
composer require coinremitterphp/coinremitter-php
```
 
## Usage of the library:
 
 You have to include the namespace of the package for using this library like this:
 ```
 include_once './vendor/autoload.php';
 use CoinRemitter\CoinRemitter;
 ```
 After using the namespace, you can access all the methods of the library by creating an object of a class like this:
 ```
 $params = [
    'coin'=>'BTC', //coin for which you want to use this object.
    'api_key'=>'YOUR_API_KEY_FROM_COINREMITTER_WALLET', //api key from coinremitter wallet
    'password'=>'YOUR_PASSWORD_FOR_WALLET' //password for selected wallet
 ];
 $obj = new CoinRemitter($params);
 ```
 

### Get Balance
You can get the balance of your wallet using the get_balance call.
```
$balance = $obj->get_balance();
```
This will return either a success response or an error response if something went wrong. Like below is the Success response:
```
{
   "flag":1,
   "msg":"Get balance successfully",
   "action":"get-balance",
   "data":{
      "balance":0.2457,
      "wallet_name":"my-wallet",
      "coin_name":"Bitcoin"
   }
}
```

### Create New Wallet Address
You can get a new wallet address using the following method:
```
$address = $obj->get_new_address();
```
Success response: 
```
{
   "flag":1,
   "msg":"New address created successfully .",
   "action":"get-new-address",
   "data":{
      "address":"MMtU5BzKcrewdTzru9QyT3YravQmzokh",
      "label":"",
      "qr_code":"https://coinremitter.com/qr/btc/image.png"
   }
}

```
Also, you can assign a label to your address with the passing parameter to the get_new_address method like this:
```
$param = [
    'label'=>'my-label'
];
$address = $obj->get_new_address($param);
```
The response will add the given label at the label key.
```
{
   "flag":1,
   "msg":"New address created successfully .",
   "action":"get-new-address",
   "data":{
      "address":"MMtU5BzKcrewdTzru9QyT3YravQmzokh",
      "label":"my-label",
      "qr_code":"https://coinremitter.com/qr/btc/image.png"
   }
}
```
### Validate the wallet address
For the validation of the wallet address, use the following method:
```
$param = [
    'address'=>'QdN2STEHi7omQwVMjb863SVP7cxm3Nkp'
];
$validate = $obj->validate_address($param);
```
Success response:  
```
{
   "flag":1,
   "msg":"Success !",
   "action":"validate-address",
   "data":{
      "valid":true
   }
}

```
If the ```valid``` in ```data``` response is ```1``` then the given address is valid,otherwise it's an invalid address.

### Withdraw amount 
To withdraw the amount to a specific address, the following method will be used:

```
$param = [
    'to_address'=>'QfZzaLPmAMbYSVRN9vb6A9k875LxbU',
    'amount'=>0.0001
];
$withdraw = $obj->withdraw($param);
```
Success response:
```
{
   "flag":1,
   "msg":"Amount Successfully Withdraw.",
   "action":"withdraw",
   "data":{
      "id":"5b5ff10a8ebb830edb4e2a22",
      "txid":"1147aca98ced7684907bd469e80f7482f40a1aaf75c1e55f7a60f725ba28",
      "explorer_url":"http://btc.com/exp/1147aca98ced7684907bd469e80f7482f40a1aaf75c1e55f7a60f725ba28",
      "amount":0.0001,
      "transaction_fees":"0.00002000",
      "processing_fees":"0.00460000",
      "total_amount":"0.00472",
      "to_address":"QfZzaLPmAMbYSVRN9vb6A9k875LxbU",
      "wallet_id":"5c42a0ab846fe75142cfb2",
      "wallet_name":"my-wallet",
      "coin_short_name":"BTC",
      "date":"2019-06-02 01:02:03"
   }
}
```
The dates received in the response are in the UTC format.

### Get transaction details
Retrieve transaction information using the ID received from the "withdraw amount" response's ID or from the "id" field in the webhook using the following method.

```
$param = [
    'id'=>'5fe6bfb464fcc062a210'
];
$transaction = $obj->get_transaction($param);
```
Success response: 
```
{
    "flag":1,
    "msg":"success",
    "action":"get-transaction",
    "data":{
        "id":"5fe6bfb464fcc062a210",
        "txid":"1147aca98ced7684907bd469e80cdf7482fe740a1aaf75c1e55f7a60f725ba28",
        "explorer_url":"http://btc.com/exp/1147aca98ced7684907bd469e80cdf7482fe740a1aaf75c1e55f7a60f725ba28",
        "type":"receive",
        "merchant_id":"5bc46fb28ebb8363d2657347",
        "coin_short_name":"BTC",
        "wallet_id":"5c42ea0ab846fe751421cfb2",
        "wallet_name":"wallet_name",
        "address":"QYTZkkKz7n1sMuphtxSPdau6BQthZfpnZC",
        "amount":0.0003,
        "confirmations":3,
        "date":"2018-08-15 15:10:42"
    }
}
```
If the response data object contains ```type``` is equal to ```send``` then the response will be given as shown below:
```
{
    "flag":1,
    "msg":"success",
    "action":"get-transaction",
    "data":{
        "id":"5b5ff10a8ebb830edb4e2a22",
        "txid":"1147aca98ced7684907bd469e80cdf7482fe740a1aaf75c1e55f7a60f725ba28",
        "explorer_url":"http://btc.com/exp/1147aca98ced7684907bd469e80cdf7482fe740a1aaf75c1e55f7a60f725ba28",
        "type":"send",
        "merchant_id":"5bc46fb28ebb8363d2657347",
        "coin_short_name":"BTC",
        "wallet_id":"5c42ea0ab846fe751421cfb2",
        "wallet_name":"wallet_name",
        "address":"QYTZkkKz7n1sMuphtxSPdau6BQthZfpnZC",
        "amount":0.0003,
        "confirmations":3,
        "date":"2018-08-15 15:10:42",
        "transaction_fees":0.001,
        "processing_fees":0.1,
        "total_amount":"2.10100000"
    }
}
```
The dates received in the response are in the UTC format.

### Get Transaction Details by Address
Get transaction details by the given address:
```
$param = [
    'address' => 'MLjDMFsob8gk9EX6tj8KUKSpmHM6qG2qFK',
];
$response = $obj->get_transaction_by_address($param);
```
Success response : 
```
{
   "flag":1,
   "msg":"success",
   "action":"get-transaction-by-address",
   "data":[
      {
         "id":"5b7650458ebb8306365624a2",
         "txid":"7a6ca109c7c651f9b70a7d4dc8fa77de322e420119c5d2470bce7f08ba0cd1d6",
         "explorer_url":"http://coin-explorer-url/exp/7a6ca109c7c651f9b70a7d4dc8fa7...",
         "merchant_id":"5bc46fb28ebb8363d2657347",
         "type":"receive",
         "coin_short_name":"BTC",
         "wallet_id":"5c42ea0ab846fe751421cfb2",
         "wallet_name":"my-wallet",
         "address":"MLjDMFsob8gk9EX6tj8KUKSpmHM6qG2qFK",
         "amount":"2",
         "confirmations":3,
         "date":"2018-08-17 10:04:13"
      },
      {
         "id":"23sdew232158ebb8306365624a2",
         "txid":"7a6ca109c7c651f9b70fdgfg44er34re7de322e420119c5d2470bce7f08ba0cd1d6",
         "explorer_url":"http://coin-explorer-url/exp/2322ereer344c7c651f9b70a7d4dc8fa7...",
         "merchant_id":"3434df4w28ebb8363d2657347",
         "type":"receive",
         "coin_short_name":"BTC",
         "wallet_id":"5c42ea0ab846fe751421cfb2",
         "wallet_name":"my-wallet",
         "address":"MLjDMFsob8gk9EX6tj8KUKSpmHM6qG2qFK",
         "amount":"1",
         "confirmations":2,
         "date":"2018-08-17 10:05:13"
      }
   ]
}
```
The dates received in the response are in the UTC format.

### Create Invoice
You can create an invoice using the following method:
```
$param = [
    'amount'=>'15', //required.
    'notify_url'=>'https://yourdomain.com/notify-url', //required,you will receive notification on this url,
    'name'=>'my-invoice',//optional,
    'currency'=>'USD',//optional,
    'expire_time'=>60,//in minutes,optional,
    'description'=>'My invoice description',//optional,
    'custom_data1'=>'',//optional
    'custom_data2'=>''//optional
];

$invoice  = $obj->create_invoice($param);
```

Success response : 
```
{
   "flag":1,
   "msg":"success",
   "action":"create-invoice",
   "data":{
      "id":"5de7ab46b846fe6aa15931b2",
      "invoice_id":"BTC122",
      "merchant_id":"5bc46fb28ebb8363d2657347",
      "url":"https://coinremitter.com/invoice/5de7ab46b846fe6aa15931b2",
      "total_amount":{
         "BTC":"0.00020390",
         "USD":"2.21979838",
      },
      "paid_amount":[
      ],
      "usd_amount":"2.21979838",
      "conversion_rate":{
         "USD_BTC":"0.00009186",
         "BTC_USD":"10886.83"
      },
      "base_currency":"USD",
      "coin":"BTC",
      "name":"random name",
      "description":"",
      "wallet_name":"my-wallet",
      "address":"QbrhNkto3732i36NYmZUNwCo4gvTJK3992",
      "status":"Pending",
      "status_code":0,
      "notify_url":"http://yourdomain.com/notify-url",
      "suceess_url":"http://yourdomain.com/success-url",
      "fail_url":"http://yourdomain.com/fail-url",
      "expire_on":"2019-12-04 18:39:10",
      "invoice_date":"2019-12-04 18:19:10",
      "custom_data1":"",
      "custom_data2":"",
      "last_updated_date":"2019-12-04 18:19:10"
   }
}
```
The dates received in the response are in the UTC format.

### Get Invoice
Get invoice details using invoice_id received using the following method:
```
$param = [
    'invoice_id'=>'BTC02'
];
$invoice = $obj->get_invoice($param);
```
Success response:
```
{
    "flag":1,
    "msg":"success",
    "action":"get-invoice",
    "data":{
        "id":"5b7650458ebb8306365624a2",
        "invoice_id":"BTC02",
        "merchant_id":"5bc46fb28ebb8363d2657347",
        "url":"https://coinremitter.com/invoice/5b7650458ebb8306365624a2",
        "total_amount":{
             "BTC":"0.00020390",
             "USD":"2.21979838",
        },
        "paid_amount": {
            "BTC": "0.00020000",
            "USD": "2.167729279"
        },
        "usd_amount":"2.21979838",
        "conversion_rate":{
             "USD_BTC":"0.00009186",
             "BTC_USD":"10886.83"
        },
        "base_currency": "USD",
        "coin":"BTC",
        "name":"random name",
        "description":"",
        "wallet_name":"my-wallet",
        "address":"QbrhNkto3732i36NYmZUNwCo4gvTJK3992",
        "payment_history":[
                {
                    "txid":"c4b853d4be7586798870a4aa766e3bb781eddb24aaafd81da8f66263017b872d",
                    "explorer_url":"http://btc.com/exp/c4b853d4be7586798870a4aa766e3bb781eddb24aaafd81da8f66263017b872d",
                    "amount":"0.0001",
                    "date":"2019-12-04 18:21:05",
                    "confirmation":781
                },
                {
                    "txid":"a2541253ab72d7cf29f2f9becb1e31320dd0ed418f761ab1973dc9e412a51c7f",
                    "explorer_url":"http://btc.com/exp/a2541253ab72d7cf29f2f9becb1e31320dd0ed418f761ab1973dc9e412a51c7f",
                    "amount":"0.0001",
                    "date":"2019-12-04 18:22:23",
                    "confirmation":778
                }
        ],
        "status":"Under Paid",
        "status_code":2,
        "wallet_id": "6347e0e9f4efc676380afde7",
        "suceess_url":"http://yourdomain.com/success-url",
        "fail_url":"http://yourdomain.com/fail-url",
        "notify_url":"http://yourdomain.com/notify-url",
        "expire_on":"2019-12-04 18:39:10",
        "invoice_date":"2019-12-04 18:19:10",
        "custom_data1": "",
        "custom_data2": "",
        "last_updated_date":"2019-12-04 18:22:23"
    }
}
```
The dates received in the response are in the UTC format.

### Get Crypto Rate
Get the current crypto rate in fiat currencies using the following method:
```
$param = [
    'fiat_symbol'=>'USD',
    'fiat_amount'=>'1'
];
$response = $obj->get_fiat_to_crypto_rate($param);
```
Success response: 
```
{
   "flag":1,
   "msg":"success",
   "action":"get-fiat-to-crypto-rate",
   "data":{
      "crypto_amount":"0.02123593",
      "crypto_symbol":"BTC",
      "crypto_currency":"Bitcoin",
      "fiat_amount":"1",
      "fiat_symbol":"USD"
   }
}
```

### Get Coin Rate
Get the coin rate using the following method:
```
$rate = $obj->get_coin_rate();
```
Success response:
```
{
   "flag":1,
   "msg":"success",
   "action":"get-coin-rate",
   "data":{
      "BTC":{
         "symbol":"BTC",
         "name":"Bitcoin",
         "price":10886.83
      },
      "LTC":{
         "symbol":"LTC",
         "name":"Litecoin",
         "price":47
      },
      "DOGE":{
         "symbol":"DOGE",
         "name":"DogeCoin",
         "price":235.26
      }
   }
}
```

**For further reference please visit our [api documentation](https://coinremitter.com/docs)**