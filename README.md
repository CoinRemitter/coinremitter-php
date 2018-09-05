# coinremitter-php
coinremitter sdk for php
## installation guide.
you can install coin remitter plugin using composer in your project using : 
```
composer require coinremitterphp/coinremitter-php
```
 
 ## Usage of library : 
 
 you have to include namespace of package wherever you want to use this library like,
 ```
 include_once './vendor/autoload.php';
 use CoinRemitter\CoinRemitter;
 ```
 after using name space you can access all the methods of library by creating object of class like ,
 ```
 $params = [
    'coin'=>'BTC',//coin for which you want to use this object.
    'api_key'=>'YOUR_API_KEY',//api key from coinremitter wallet
    'password'=>'PASSWORD' // password for selected wallet
 ];
 $obj = new CoinRemitter($params);
 ```
 

### Get Balance : 
you can get balance of your wallet using get_balance call.
```
$balance = $obj->get_balance();
```
this will return either success response or error response if something went wrong.like below is the success response : 
```
{
  "flag":1,
  "msg":'Get balance successfully !',
  'data':123
}
```

### Create New Wallet Address
You can get new wallet address using folowing method:
```
$address = $obj->get_new_address();
```
success response : 
```
{
   "flag":1,
   "msg":"New address created successfully !",
   "data":"MMtU5BzKcrew9BdTzru9QyT3YravQmzokh"
}

```
also you can assign lable to your address with passing parameter to get_new_address method like:
```
$address = $obj->get_new_address("my_label");
```
the response will remian same as above response.

### Validate wallet address
for validation wallet address use folowing method:
```
$validate = $obj->validate_address("your_Address_to_validate");
```
response : 
```
{
   "flag":1,
   "msg":"Success !",
   "data":1
}

```
if ```data``` in response is ```1``` then the given address is valid,otherwise it's a invalid address.

### withdraw amount 
to withdraw amount to specific  address following method will use : 

```
$withdraw = $obj->withdraw(['to_address'=>'YOUR_ADDRESS','amount'=>123]);
```
success response : 
```
{
   "flag":1,
   "msg":"Amount Successfully Withdraw !",
   "data":{
      "id":"5b5ff10a8ebb830edb4e2a22",
      "trx_id":"1147aca98ced7684907bd469e80cdf7482fe740a1aaf75c1e55f7a60f725ba28",
      "amount":"123",
      "transaction_fees":0.001,
      "processing_fees":0.00015,
      "to_address":"YOUR_ADDRESS",
      "wallet_name":"wallet_name",
      "coin_short_name":"BTC"
   }
}
```

### Get Transaction
get transaction detail using id received from ```withdraw amount``` response's ```id``` or from webhook's ```id``` field using following method :
```
$transaction = $obj->get_transaction('5b5ff10a8ebb830edb4e2a22');
```
success response : 
```
{
   "flag":1,
   "msg":"success",
   "data":{
      "id":"5b5ff10a8ebb830edb4e2a22",
      "txid":"1147aca98ced7684907bd469e80cdf7482fe740a1aaf75c1e55f7a60f725ba28",
      "type":"receive",
      "coin_short_name":"BTC",
      "wallet":"wallet_name",
      "address":"YOUR_ADDRESS",
      "amount":123,
      "confirmations":51022,
      "time":"2018-08-15 15:10:42"
   }
}
```
### Create Invoice
you can create invoice using following method : 
```
$param = [
    'amount'=>123,      //required.
    'notify_url'=>'https://notification.url', //required,url on which you wants to receive notification,
    'name'=>'',//optional,
    'currency'=>'usd',//optional,
    'expire_hours'=>'',//optional,
    'description'=>'',//optional.
];

$invoice  = $obj->create_invoice($param);
```

success response : 
```
{
   "flag":1,
   "msg":"success",
   "data":{
      "invoice_id":"BTC02",
      "url":"https://coinremitter.com/invoice/5b7650458ebb8306365624a2",
      "amount":123,
      "fees":0.0006,
      "pay_amount":0.0015,
      "paid_amount":0,
      "coin":"BTC",
      "wallet_id":"5b6983ae8ebb8315cb5b68a5",
      "address":"rger54654fgsd4h6u7dgsg",
      "merchant":"Merchant_NAME",
      "status":"Pending",
      "time":"2018-08-17 10:04:13"
   }
}

```

**for further reference please visit our [api documentation](https://coinremitter.com/docs)**
