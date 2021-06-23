# coinremitter-php
Official PHP SDK for coinremitter cryptocurrency payment gateway
## installation guide.
you can install coinremitter plugin using composer in your project using : 
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
    'api_key'=>'$2y$10$A371Booxinhex/Q.1dAA8OopyKDPQnZ6hxOvRZMKjOR',//api key from coinremitter wallet
    'password'=>'123456' // password for selected wallet
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
Array
(
    [flag] => 1
    [msg] => Get balance successfully.
    [action] => get-balance
    [data] => Array
        (
            [balance] => 0.09094956
            [wallet_name] => my-wallet
            [coin_name] => Bitcoin
        )

)
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
    "action":"get-new-address",
    "data":{
        "address":"MMtU5BzKcrew9BdTzru9QyT3YravQmb",
        "label":""
        
    }
}

```
also you can assign lable to your address with passing parameter to get_new_address method like:
```
$param = [
    'label'=>'my-label'
];
$address = $obj->get_new_address($param);
```
the response will add given label at label key.
```
Array
(
    [flag] => 1
    [msg] => New address created successfully.
    [action] => get-new-address
    [data] => Array
        (
            [address] => QdN2STEHi7omQwVMjb863SVP7cxm3Nkp
            [label] => my-label
        )

)
```
### Validate wallet address
for validation wallet address use folowing method:
```
$param = [
    'address'=>'QdN2STEHi7omQwVMjb863SVP7cxm3Nkp'
];
$validate = $obj->validate_address($param);
```
success response :  
```
Array
(
    [flag] => 1
    [msg] => success
    [action] => validate-address
    [data] => Array
        (
            [valid] => 1
        )

)

```
if ```valid``` in ```data``` response is ```1``` then the given address is valid,otherwise it's a invalid address.

### Withdraw amount 
to withdraw amount to specific  address following method will use : 

```
$param = [
    'to_address'=>'QfZzaLPmAMbYSVRN9vb6A9k875LxbU',
    'amount'=>0.0001
];
$withdraw = $obj->withdraw($param);
```
success response : 
```
Array
(
    [flag] => 1
    [msg] => The amount is successfully withdraw.
    [action] => withdraw
    [data] => Array
        (
            [id] => 5fe6bfb464fcc062a210
            [txid] => ac4da11cfcbe5e0ba4d74d966636f230207afe37a3a7bd69e5a8cd1ce6da
            [explorer_url] => http://btc.com/exp/ac4da11cfcbe5e0ba4d74d966636f230207afe37a3a7bd69e5a8cd1ce6da
            [amount] => 0.00010000
            [transaction_fees] => 0.00000100
            [processing_fees] => 0.00000023
            [total_amount] => 0.00010123
            [to_address] => QfZzaLPmAMbYSVRN9vb6A9k875LxbU
            [wallet_id] => 5f228f1979c2f64b3621
            [wallet_name] => my-wallet
            [coin_short_name] => BTC
            [date] => 2020-12-26 10:14:36
        )

)

```

### Get Transaction
get transaction detail using id received from ```withdraw amount``` response's ```id``` or from webhook's ```id``` field using following method :
```
$param = [
    'id'=>'5fe6bfb464fcc062a210'
];
$transaction = $obj->get_transaction($param);
```
success response : 
```
Array
(
    [flag] => 1
    [msg] => success
    [action] => get-transaction
    [data] => Array
        (
            [id] => 5fe6bfcd667d5f63ab25
            [txid] => ac4da11cfcbe5e0ba4d74d966636f230207afe37a3a7bd69e5a8cd1ce6da
            [explorer_url] => http://btc.com/exp/ac4da11cfcbe5e0ba4d74d966636f230207afe37a3a7bd69e5a8cd1ce6da
            [type] => receive
            [merchant_id] => 5f21111bd59e410a8b77
            [coin_short_name] => BTC
            [wallet_id] => 5fa0fb7a4930866f035b
            [wallet_name] => my-btc-wallet
            [address] => QfZzaLPmAMbYSVRN9vb6A9k875LxbU
            [amount] => 0.00010000
            [confirmations] => 3
            [date] => 2020-12-26 10:15:01
        )

)
```
if reponse data object contains ```type``` is equal to ```send``` then response will be given as below
```
Array
(
    [flag] => 1
    [msg] => success
    [action] => get-transaction
    [data] => Array
        (
            [id] => 5fe6bfb464fcc062a210
            [txid] => ac4da11cfcbe5e0ba4d74d966636f230207afe37a3a7bd69e5a8cd1ce6da
            [explorer_url] => http://btc.com/exp/ac4da11cfcbe5e0ba4d74d966636f230207afe37a3a7bd69e5a8cd1ce6da
            [type] => send
            [merchant_id] => 5f21111bd59e410a8b77
            [coin_short_name] => BTC
            [wallet_id] => 5f228f1979c2f64b3621
            [wallet_name] => my-wallet
            [address] => QfZzaLPmAMbYSVRN9vb6A9k875LxbU
            [amount] => 0.00010000
            [confirmations] => 3
            [date] => 2020-12-26 10:14:36
            [transaction_fees] => 0.00000100
            [processing_fees] => 0.00000023
            [total_amount] => 0.00010123
        )

)
```
### Get Transaction by Address
get transactions details by given address.
```
$param = [
    'address' => 'MLjDMFsob8gk9EX6tj8KUKSpmHM6qG2qFK',
];
$response = $obj->get_transaction_by_address($param);
```
success response : 
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

### Create Invoice
you can create invoice using following method : 
```
$param = [
    'amount'=>'1',      //required.
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

success response : 
```
Array
(
    [flag] => 1
    [msg] => Invoice is successfully created.
    [action] => create-invoice
    [data] => Array
        (
            [id] => 5fe6c8201588b330da44
            [invoice_id] => BTC4105
            [merchant_id] => 5f21111bd59e410a8b77
            [url] => https://coinremitter.com/invoice/5fe6c8201588b330da44
            [total_amount] => Array
                (
                    [BTC] => 0.00009185
                    [USD] => 1.00000000
                )

            [paid_amount] => Array
                (
                )

            [usd_amount] => 1.00000000
            [conversion_rate] => Array
                (
                    [USD_BTC] => 0.00009185
                    [BTC_USD] => 10886.83
                )

            [base_currency] => USD
            [coin] => BTC
            [name] => my-invoice
            [description] => My invoice description
            [wallet_name] => my-wallet
            [address] => QeaQVb8HWJQEjfVWEJ1cD74HiswiXx
            [status] => Pending
            [status_code] => 0
            [suceess_url] => http://yourdomain.com/success-url
            [fail_url] => http://yourdomain.com/fail-url
            [notify_url] => http://yourdomain.com/notify-url
            [expire_on] => 2020-12-26 11:50:32
            [invoice_date] => 2020-12-26 10:50:32
            [custom_data1] => 
            [custom_data2] => 
            [last_updated_date] => 2020-12-26 10:50:32
        )

)

```

### Get Invoice
get invoice detail using invoice_id received using following method :
```
$param = [
    'invoice_id'=>'BTC4105'
];
$invoice = $obj->get_invoice($param);
```
success response : 
```
Array
(
    [flag] => 1
    [msg] => success
    [action] => get-invoice
    [data] => Array
        (
            [id] => 5fe6c8201588b330da44
            [invoice_id] => BTC4105
            [merchant_id] => 5f21111bd59e410a8b77
            [url] => https://coinremitter.com/invoice/5fe6c8201588b330da44
            [total_amount] => Array
                (
                    [BTC] => 0.00009185
                    [USD] => 1.00000000
                )

            [paid_amount] => Array
                (
                    [BTC] => 0.00009185
                    [USD] => 1.00000000
                )

            [usd_amount] => 1.00000000
            [conversion_rate] => Array
                (
                    [USD_BTC] => 0.00009185
                    [BTC_USD] => 10886.83
                )

            [base_currency] => USD
            [coin] => BTC
            [name] => my-invoice
            [description] => My invoice description
            [wallet_name] => my-wallet
            [address] => QeaQVb8HWJQEjfVWEJ1cD74HiswiXx
            [payment_history] => Array
                (
                    [0] => Array
                        (
                            [txid] => 658929265ae1254042f1fae71a95ce1265ceae13a14a398a7ce49cdb58f9
                            [explorer_url] => http://btc.com/exp/658929265ae1254042f1fae71a95ce1265ceae13a14a398a7ce49cdb58f9
                            [amount] => 0.00009185
                            [date] => 2020-12-26 11:01:01
                            [confirmation] => 3
                        )

                )

            [status] => Paid
            [status_code] => 1
            [wallet_id] => 5f228f1979c2f64b3621
            [suceess_url] => http://yourdomain.com/success-url
            [fail_url] => http://yourdomain.com/fail-url
            [notify_url] => http://yourdomain.com/notify-url
            [expire_on] => 2020-12-26 11:50:32
            [invoice_date] => 2020-12-26 10:50:32
            [custom_data1] => 
            [custom_data2] => 
            [last_updated_date] => 2020-12-26 11:01:01
        )

)
```

### Get Ctrypto Rate
get current crypto rate using using fiat currency: 
```
$param = [
    'fiat_symbol' => 'USD',
    'fiat_amount' => 1
];
$response = $obj->get_fiat_to_crypto_rate($param);
```
success response : 
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
get coin rate using following method :
```
$rate = $obj->get_coin_rate();
```
success response : 
```
Array
(
    [flag] => 1
    [msg] => success
    [action] => get-coin-rate
    [data] => Array
        (
            [BTC] => Array
                (
                    [symbol] => BTC
                    [name] => Bitcoin
                    [price] => 10886.83
                )

            [LTC] => Array
                (
                    [symbol] => LTC
                    [name] => Litecoin
                    [price] => 47
                )

            [BCH] => Array
                (
                    [symbol] => BCH
                    [name] => Bitcoin Cash
                    [price] => 235.26
                )

            [ETH] => Array
                (
                    [symbol] => ETH
                    [name] => Ethereum
                    [price] => 350.72
                )

            [DOGE] => Array
                (
                    [symbol] => DOGE
                    [name] => Dogecoin
                    [price] => 0.00260658
                )

            [XRP] => Array
                (
                    [symbol] => XRP
                    [name] => Ripple
                    [price] => 0.25012
                )

            [USDT] => Array
                (
                    [symbol] => USDT
                    [name] => Tether
                    [price] => 1
                )

            [DASH] => Array
                (
                    [symbol] => DASH
                    [name] => Dash
                    [price] => 66.67
                )

            [KOIN] => Array
                (
                    [symbol] => KOIN
                    [name] => KOIN
                    [price] => 1.0E-9
                )

            [TCN] => Array
                (
                    [symbol] => TCN
                    [name] => Test Coin
                    [price] => 47.09
                )

            [XMR] => Array
                (
                    [symbol] => XMR
                    [name] => Monero
                    [price] => 110.31
                )

            [USDTERC20] => Array
                (
                    [symbol] => USDTERC20
                    [name] => USDT ERC20
                    [price] => 1
                )

            [LINK] => Array
                (
                    [symbol] => LINK
                    [name] => ChainLink Token
                    [price] => 0
                )

        )

)
```

**for further reference please visit our [api documentation](https://coinremitter.com/docs)**
