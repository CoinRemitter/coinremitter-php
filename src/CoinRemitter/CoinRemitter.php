<?php

namespace CoinRemitter;

class CoinRemitter
{
    /**
     * 
     * @var string endpoint of api
     */
    private $url = 'https://api.coinremitter.com/';

    /**
     * 
     * @var string of api version
     */
    private $version = 'v1';

    /**
     * 
     * @var string of plugin version
     */
    private $plugin_version = '1.0.0';

    /**
     * 
     * @var string of api key
     */
    private $api_key;

    /**
     * 
     * @var string of api password
     */
    private $password;

    /**
     * 
     * @param string $api_key - pass valid api_key of wallet
     * @param string $password - pass valid password of wallet
     */
    public function __construct($api_key = '', $password = '')
    {
        $this->api_key = $api_key;
        $this->password = $password;
    }

    /**
     * Return wallet api route base url.
     *
     * @return string wallet api route base url.
     */
    private function getWalletUrl(): string
    {
        return $this->url . $this->version . '/wallet/';
    }
    /**
     * Return invoice api route base url.
     *
     * @return string invoice api route base url.
     */
    private function getInvoiceUrl(): string
    {
        return $this->url . $this->version . '/invoice/';
    }

    /**
     * Return rate api route base url.
     *
     * @return string rate api route base url.
     */
    private function getRateUrl(): string
    {
        return $this->url . $this->version . '/rate/';
    }

    /**
     * Creates a new wallet address.
     *
     * @param array $param (optional) The parameters to send with the request. If empty, default parameters are used.
     *              - `label` - (optional) A label to assign to the new address.
     * 
     * @return array The response contain the newly created address or an error message.
     *             - `success` - (boolean) The status of the request. Either 'true' or 'false'.
     *             - `data` - (array) The data returned by the request. (if success is 'true')
     *                  - `wallet_id` - (string) Wallet id.
     *                  - `wallet_name` - (string) Wallet name.
     *                  - `coin` - (string) Coin full name. E.g. Bitcoin.
     *                  - `coin_symbol` - (string) Symbol of coin. E.g. BTC for Bitcoin.
     *                  - `coin_logo` - (string) Coin logo url.
     *                  - `blockchain_network_name` - (string) Blockchain network name.
     *                  - `contract_address` - (string) Contract address of token.
     *                  - `contract_address_url` - (string) Explorer url of contract address.
     *                  - `chain_id` - (string) Blockchain id for EVM coins.
     *                  - `address` - (string) It is address where Coins/Tokens is sent or received.
     *                  - `explorer_url` - (string) Third party explorer URL where the address can be cross-checked.
     *                  - `label` - (string) Label that is assigned to the newly created address.
     *                  - `qr_code` - (string) Image url of address QR code.
     *                  - `minimum_deposit_amount` - (string) Minimum deposite amount for coin.Below this amount transaction is not accepted.
     *                  - `remaining_address_limit` - (string) It indicates remaining address limit for the wallet. If the value is -1, means you have pro plan and you can create unlimited addresses from this wallet.
     *                  - `wrn_msg` - (string) This warning message should display to the user.
     *                  - `expire_on` - (string) Expiry date of address.
     *                  - `expire_on_timestamp` - (integer) Timestamp of expiry time.
     */
    public function createAddress($param)
    {
        $url = $this->getWalletUrl() . 'address/create';
        $res = $this->httpRequest($url, $param, 'createAddress');
        return $res;
    }

    /**
     * Validate address.
     *
     * @param array $param (optional) The parameters to send with the request. If empty, default parameters are used.
     *              - `address` - (required) The address to validate.
     * 
     * @return array The response contain the validation status of the address.
     *             - `success` - (boolean) The status of the request. Either 'true' or 'false'.
     *             - `data` - (array) The data returned by the request. (if success is 'true')
     *                  - `status` - (boolean) The validation status of the address. Either 'true' or 'false'.
     */
    public function validateAddress($param)
    {
        $url = $this->getWalletUrl() . 'address/validate';
        $res = $this->httpRequest($url, $param, 'validateAddress');
        return $res;
    }

    /**
     * Estimate the cost of withdraw an amount.
     *
     * @param array $param (optional) The parameters to send with the request. If empty, default parameters are used.
     *              - `amount` - (required) Total amount which you want to send.
     *              - `address` - (optional) Address of in which you want to send amount
     *              - `withdrawal_speed` - (optional) The speed of withdrawal. Either 'priority', 'medium' or 'low'.Default speed take from your wallet settings.
     * 
     * @return array The response contain the estimated cost of the withdrawal.
     *             - `success` - (boolean) The status of the request. Either 'true' or 'false'.
     *             - `data` - (array) The data returned by the request. (if success is 'true')
     *                  - `amount` - (string) Amount want to send.
     *                  - `transaction_fee` - (string) Transactions fee for given amount.
     *                  - `processing_fee` - (string) Processing fee for given amount.
     *                  - `total_amount` - (string) transaction_fee+processing_fee+amount. Amount to be deducted from wallet.
     *                  - `fees_structure` - (array) Fee structure.
     */
    public function estimateWithdraw($param = []): array
    {
        $url = $this->getWalletUrl() . 'withdraw/estimate';
        $res = $this->httpRequest($url, $param, 'estimateWithdraw');
        return $res;
    }

    /**
     * Withdraw an amount from wallet.
     *
     * @param array $param (optional) The parameters to send with the request. If empty, default parameters are used.
     *              - `address` - (required) Address of in which you want to send amount
     *              - `amount` - (required) Total amount which you want to send.
     *              - `withdrawal_speed` - (optional) The speed of withdrawal. Either 'priority', 'medium' or 'low'.Default speed take from your wallet settings.
     * 
     * @return array The response contain the transaction details of the withdrawal.
     *             - `success` - (boolean) The status of the request. Either 'true' or 'false'.
     *             - `data` - (array) The data returned by the request. (if success is 'true')
     *                  - `id` - (string) Unique ID of withdrawal transaction.
     *                  - `txid` - (string) Blockchain transaction id.
     *                  - `explorer_url` - (string) Third party explorer URL where the transaction status can be cross-checked.
     *                  - `amount` - (string) Sent or Withdrawn amount to a given address.
     *                  - `transaction_fee` - (string) Transaction fees for given amount.
     *                  - `processing_fee` - (string) Processing fee for given amount.
     *                  - `total_amount` - (string) transaction_fee+processing_fee+amount. Amount to be deducted from wallet.
     *                  - `to_address` - (string) It is address where Coins/Tokens is sent or received.
     *                  - `wallet_id` - (string) Unique ID of wallet.
     *                  - `wallet_name` - (string) Name of the wallet.
     *                  - `coin` - (string) Coin full name. E.g. Bitcoin.
     *                  - `coin_symbol` - (string) Symbol of coin. E.g. BTC for Bitcoin.
     *                  - `date` - (string) Date and time of transaction.
     *                  - `transaction_timestamp` - (integer) Timestamp of transaction created.
     *                  - `remaining_withdraw_limit_24h` - (string) Reamaining wallet withdrawal limit for 24 hour.
     */
    public function withdraw($param)
    {
        $url = $this->getWalletUrl() . 'withdraw';
        $res = $this->httpRequest($url, $param, 'withdraw');
        return $res;
    }

    /**
     * Get transaction details by transaction id.
     *
     * @param array $param (optional) The parameters to send with the request. If empty, default parameters are used.
     *              - `id` - (required) Unique id of your transaction. It is not blockchain transaction id. you will get this id from webhook data.
     * 
     * @return array The response contain the transaction details of the withdrawal.
     *             - `success` - (boolean) The status of the request. Either 'true' or 'false'.
     *             - `data` - (array) The data returned by the request. (if success is 'true')
     *                  - `id` - (string) Unique id of transaction.
     *                  - `txid` - (string) Blockchain transaction id.
     *                  - `explorer_url` - (string) Third party explorer URL where the transaction status can be cross-checked.
     *                  - `type` - (string) Type of transaction. Either 'receive' or 'send'.
     *                  - `status` - (string) Status of transaction. Either 'confirm' or 'pending'.
     *                  - `status_code` - (integer) Status code of transaction. Either 1 for 'confirm' or 0 for 'pending'.
     *                  - `coin` - (string) Coin full name. E.g. Bitcoin.
     *                  - `coin_symbol` - (string) Symbol of coin. E.g. BTC for Bitcoin.
     *                  - `wallet_id` - (string) Unique ID of wallet.
     *                  - `wallet_name` - (string) Name of the wallet.
     *                  - `address` - (string) It is address where Coins/Tokens is sent or received.
     *                  - `label` - (string) Label of the address.
     *                  - `amount` - (string) Amount of transactions that are sent / received.
     *                  - `confirmations` - (string) Number of confirmation from the blockchain transaction.
     *                  - `required_confirmations` - (string) At least this number of confirmations is required to confirm the transaction.
     *                  - `date` - (string) Date and time of transaction.
     *                  - `transaction_timestamp` - (integer) Timestamp of transaction created.
     */
    public function getTransaction($param)
    {
        $url = $this->getWalletUrl() . 'transaction';
        $res = $this->httpRequest($url, $param, 'getTransaction');
        return $res;
    }

    /**
     * Get transaction details by address.
     *
     * @param array $param (optional) The parameters to send with the request. If empty, default parameters are used.
     *              - `address` - (required) Address of which you want to get transaction details.
     * 
     * @return array The response contain the transaction details of the withdrawal.
     *             - `success` - (boolean) The status of the request. Either 'true' or 'false'.
     *             - `data` - (array) The data returned by the request. (if success is 'true')
     *                  - `coin` - (string) Coin full name. E.g. Bitcoin.
     *                  - `coin_symbol` - (string) Symbol of coin. E.g. BTC for Bitcoin.
     *                  - `wallet_id` - (string) Unique ID of wallet.
     *                  - `wallet_name` - (string) Name of the wallet.
     *                  - `address` - (string) It is address where Coins/Tokens is sent or received.
     *                  - `label` - (string) Label of the address.
     *                  - `expire_on` - (string) Expiry date of address.
     *                  - `expire_on_timestamp` - (integer) Timestamp of expiry time.
     *                  - `required_confirmations` - (string) At least this number of confirmations is required to confirm the transaction.
     *                  - `confirm_amount` - (string) Total confirm amount of address.
     *                  - `pending_amount` - (string) Total unconfirm amount of address.
     *                  - `transactions` - (array) List of transactions.
     *                      - `id` - (string) Unique id of transaction.
     *                      - `txid` - (string) Blockchain transaction id.
     *                      - `explorer_url` - (string) Third party explorer URL where the transaction status can be cross-checked.
     *                      - `type` - (string) Type of transaction. Either 'receive' or 'send'.
     *                      - `amount` - (string) Amount of transactions that are sent / received.
     *                      - `confirm_amount` - (string) Confirm amount of address.
     *                      - `pending_amount` - (string) Unconfirm amount of address.
     *                      - `confirmations` - (string) Number of confirmation from the blockchain transaction.
     *                      - `status` - (string) Status of transaction. Either 'confirm' or 'pending'.
     *                      - `status_code` - (integer) Status code of transaction. Either 1 for 'confirm' or 0 for 'pending'.
     *                      - `date` - (string) Date and time of transaction.
     *                      - `transaction_timestamp` - (integer) Timestamp of transaction created.
     */
    public function getTransactionByAddress($param)
    {
        $url = $this->getWalletUrl() . 'address/transactions';
        $res = $this->httpRequest($url, $param, 'getTransactionByAddress');
        return $res;
    }

    /**
     * Get wallet balance.
     *
     * @return array The response contain the newly created address or an error message.
     *             - `success` - (boolean) The status of the request. Either 'true' or 'false'.
     *             - `data` - (array) The data returned by the request. (if success is 'true')
     *                  - `balance` - (string) Total balance available in a wallet.
     *                  - `wallet_id` - (string) Wallet id.
     *                  - `wallet_name` - (string) Wallet name.
     *                  - `coin` - (string) Coin full name. E.g. Bitcoin.
     *                  - `coin_symbol` - (string) Symbol of coin. E.g. BTC for Bitcoin.
     *                  - `coin_logo` - (string) Coin logo url.
     *                  - `blockchain_network_name` - (string) Blockchain network name.
     *                  - `contract_address` - (string) Contract address of token.
     *                  - `contract_address_url` - (string) Explorer url of contract address.
     *                  - `chain_id` - (string) Blockchain id for EVM coins.
     *                  - `explorer_url` - (string) Third party explorer URL where the address can be cross-checked.
     *                  - `minimum_deposit_amount` - (string) Minimum deposite amount for coin.Below this amount transaction is not accepted.
     *                  - `remaining_withdraw_limit_24h` - (string) Reamaining wallet widhrawal limit for 24 hour.
     */
    public function getBalance()
    {
        $url = $this->getWalletUrl() . 'balance';
        $res = $this->httpRequest($url, [], 'getBalance');
        return $res;
    }

    /**
     * Create a new invoice.
     *
     * @param array $param (optional) The parameters to send with the request. If empty, default parameters are used.
     *              - `amount` - (required) Invoice Amount.
     *              - `name` - (Optional) It will display on invoice. Max 30 characters. It will display wallet name if this name is empty.
     *              - `email` - (Optional) It will display on invoice. Max 30 characters. It will display wallet name if this name is empty.
     *              - `fiat_currency` - (Optional) Fiat currency code. E.g. USD, INR, EUR etc.
     *              - `expiry_time_in_minutes` - (Optional) Invoice expiry time in minutes. Default 1440 minutes.
     *              - `notify_url` - (optional) URL on which you will be notify about payment.
     *              - `success_url` - (optional) User will be redirected to this url once payment done.
     *              - `fail_url` - (optional) User will be redirected to this url when user cancel payment.
     *              - `description` - (optional) The description for the invoice.
     *              - `custom_data1` - (optional) This data will be included in notify_url. Max 30 characters.
     *              - `custom_data2` - (optional) This data will be included in notify_url. Max 30 characters.
     * 
     * @return array The response contain the newly created invoice or an error message.
     *             - `success` - (boolean) The status of the request. Either 'true' or 'false'.
     *             - `data` - (array) The data returned by the request. (if success is 'true')
     *                  - `id` - (string) Unique ID of Invoice.
     *                  - `invoice_id` - (string) ID of the invoice.
     *                  - `url` - (string) Public URL of invoice.
     *                  - `total_amount` - (array) Total Amount in fiat/cryptocurrency.
     *                  - `paid_amount` - (array) Paid amount in fiat/cryptocurrency.
     *                  - `amount` - (string) Invoice amount in crypto currency.
     *                  - `usd_amount` - (string) Total invoice amount in USD.
     *                  - `conversion_rate` - (array) Rate of conversion when invoice created.
     *                  - `fiat_currency` - (string) Fiat currency code. E.g. USD, INR, EUR etc.
     *                  - `coin` - (string) Coin full name. E.g. Bitcoin.
     *                  - `coin_symbol` - (string) Symbol of coin. E.g. BTC for Bitcoin.
     *                  - `name` - (string) Name of the invoice.
     *                  - `description` - (string) Description of the invoice.
     *                  - `wallet_id` - (string) Wallet id.
     *                  - `wallet_name` - (string) Wallet name.
     *                  - `merchant_id` - (string) Merchant id.
     *                  - `status` - (string) Status of invoice. Either 'Pending', 'Paid', 'Under Paid', 'Over Paid', 'Expired' or 'Cancelled'.
     *                  - `status_code` - (integer) Status code of invoice. Either 0 for 'Pending', 1 for 'Paid', 2 for 'Under Paid', 3 for 'Over Paid', 4 for 'Expired' or 5 for 'Cancelled'.
     *                  - `notify_url` - (string) URL on which you will be notify about payment.
     *                  - `success_url` - (string) User will be redirected to this url once payment done.
     *                  - `fail_url` - (string) User will be redirected to this url when user cancel payment.
     *                  - `expire_on` - (string) Expiry date of invoice in UTC.
     *                  - `expire_on_timestamp` - (integer) Timestamp of expiry time.
     *                  - `invoice_date` - (string) Invoice created date in UTC.
     *                  - `invoice_date_timestamp` - (integer) Timestamp of invoice created date.
     *                  - `delete_after` - (string) The invoice is valid for 365 days from the date of creation and will be automatically deleted after this period. Ensure no coins or tokens are sent to the invoice address once it has been deleted.
     *                  - `delete_after_timestamp` - (integer) Timestamp of delete_after date.
     *                  - `custom_data1` - (string) Custom data 1 set by you.
     *                  - `custom_data2` - (string) Custom data 2 set by you.
     */
    public function createInvoice($param)
    {
        $url = $this->getInvoiceUrl() . 'create';
        $res = $this->httpRequest($url, $param, 'createInvoice');
        return $res;
    }

    /**
     * Get invoice details by invoice id.
     *
     * @param array $param (optional) The parameters to send with the request. If empty, default parameters are used.
     *              - `invoice_id` - (required) Unique id of invoice.
     * 
     * @return array The response contain the invoice details of the withdrawal.
     *             - `success` - (boolean) The status of the request. Either 'true' or 'false'.
     *             - `data` - (array) The data returned by the request. (if success is 'true')
     *                  - `id` - (string) Unique ID of Invoice.
     *                  - `invoice_id` - (string) ID of the invoice.
     *                  - `url` - (string) Public URL of invoice.
     *                  - `total_amount` - (array) Total Amount in fiat/cryptocurrency.
     *                  - `paid_amount` - (array) Paid amount in fiat/cryptocurrency.
     *                  - `amount` - (string) Invoice amount in crypto currency.
     *                  - `usd_amount` - (string) Total invoice amount in USD.
     *                  - `conversion_rate` - (array) Rate of conversion when invoice created.
     *                  - `fiat_currency` - (string) Fiat currency code. E.g. USD, INR, EUR etc.
     *                  - `coin` - (string) Coin full name. E.g. Bitcoin.
     *                  - `coin_symbol` - (string) Symbol of coin. E.g. BTC for Bitcoin.
     *                  - `name` - (string) Name of the invoice.
     *                  - `description` - (string) Description of the invoice.
     *                  - `wallet_id` - (string) Wallet id.
     *                  - `wallet_name` - (string) Wallet name.
     *                  - `merchant_id` - (string) Merchant id.
     *                  - `status` - (string) Status of invoice. Either 'Pending', 'Paid', 'Under Paid', 'Over Paid', 'Expired' or 'Cancelled'.
     *                  - `status_code` - (integer) Status code of invoice. Either 0 for 'Pending', 1 for 'Paid', 2 for 'Under Paid', 3 for 'Over Paid', 4
     *                  - `notify_url` - (string) URL on which you will be notify about payment.
     *                  - `success_url` - (string) User will be redirected to this url once payment done.
     *                  - `fail_url` - (string) User will be redirected to this url when user cancel payment.
     *                  - `expire_on` - (string) Expiry date of invoice in UTC.
     *                  - `expire_on_timestamp` - (integer) Timestamp of expiry time.
     *                  - `invoice_date` - (string) Invoice created date in UTC.
     *                  - `invoice_date_timestamp` - (integer) Timestamp of invoice created date.
     *                  - `delete_after` - (string) The invoice is valid for 365 days from the date of creation and will be automatically deleted after this period. Ensure no coins or tokens are sent to the invoice address once it has been deleted.
     *                  - `delete_after_timestamp` - (integer) Timestamp of delete_after date.
     *                  - `custom_data1` - (string) Custom data 1 set by you.
     *                  - `custom_data2` - (string) Custom data 2 set by you.
     */
    public function getInvoice($param)
    {
        $url = $this->getInvoiceUrl() . 'get';
        $res = $this->httpRequest($url, $param, 'getInvoice');
        return $res;
    }

    /**
     * Get fiat to crypto rate.
     *
     * @param array $param (optional) The parameters to send with the request. If empty, default parameters are used.
     *              - `fiat` - (required) Fiat Symbol.
     *              - `fiat_amount` - (required) Fiat Amount.
     *              - `crypto` - (optional) Crypto Symbol.
     * 
     * @return array The response contain the invoice details of the withdrawal.
     *             - `success` - (boolean) The status of the request. Either 'true' or 'false'.
     *             - `data` - (array) The data returned by the request. (if success is 'true')
     *                  - `price` - (string) Amount of cryptocurrency.
     *                  - `short_name` - (string) Short name of cryptocurrency.
     *                  - `name` - (string) Full name of crypto currency.
     */
    public function fiatToCryptoRate($param)
    {
        $url = $this->getRateUrl() . 'fiat-to-crypto';
        $res = $this->httpRequest($url, $param, 'fiatToCryptoRate');
        return $res;
    }

    /**
     * Get crypto to fiat rate.
     *
     * @param array $param (optional) The parameters to send with the request. If empty, default parameters are used.
     *              - `crypto` - (optional) Crypto Symbol.
     *              - `crypto_amount` - (required) Crypto Amount.
     *              - `fiat` - (required) Fiat Symbol.
     * 
     * @return array The response contain the invoice details of the withdrawal.
     *             - `success` - (boolean) The status of the request. Either 'true' or 'false'.
     *             - `data` - (array) The data returned by the request. (if success is 'true')
     *                  - `code` - (string) Short name of fiat currency. E.g. USD
     *                  - `currency` - (string) Full name of fiat currency. E.g. United States Dollar
     *                  - `amount` - (string) Crypto price of given fiat amount.
     */
    public function cryptoToFiatRate($param)
    {
        $url = $this->getRateUrl() . 'crypto-to-fiat';
        $res = $this->httpRequest($url, $param, 'cryptoToFiatRate');
        return $res;
    }

    /**
     * Get supported currency.
     *
     * @return array The response contain the supported currency list.
     *             - `success` - (boolean) The status of the request. Either 'true' or 'false'.
     *             - `data` - (array) The data returned by the request. (if success is 'true')
     *                  - `coin` - (string) Coin full name. E.g. Bitcoin.
     *                  - `coin_symbol` - (string) Symbol of coin. E.g. BTC for Bitcoin.
     *                  - `logo` - (string) Coin logo url.
     *                  - `network_name` - (string) Coin network name. E.g. Bitcoin Network for Bitcoin
     *                  - `explorer_url` - (string) Third party explorer URL where the transaction status can be cross-checked.
     *                  - `minimum_deposit_amount` - (string) Minimum deposite amount for coin.Below this amount transaction is not accepted.
     *                  - `price_in_usd` - (string) USD price of 1 Coin.
     *                  - `fees` - (array) Fee structure of coin.
     *                          - `low` - (array) Fees applicable for low transaction speed.
     *                              - `transaction_fees_type` - (string) Transaction fee type.E.g flat or percentage.
     *                              - `processing_fees_type` - (string) Processing fee type.E.g flat or percentage.
     *                              - `transaction_fee` - (string) Transaction fee charged on wallet Coins/Tokens widhrawal.
     *                              - `processing_fee` - (string) Processing fee charged on wallet Coins/Tokens widhrawal.
     *                              - `transaction_fee_with_gasstation` - (string) Transaction fee charged on wallet Coins/Tokens widhrawal when gas station is enable.
     *                              - `processing_fee_with_gasstation` - (string) Processing fee charged on wallet Coins/Tokens widhrawal when gas station is enable.
     *                          - `medium` - (array) Fees applicable for medium transaction speed.This contains above mentioned fields.
     *                          - `priority` - (array) Fees applicable for priority transaction speed.This contains above mentioned fields.
     */
    public function getSupportedCurrency()
    {
        $url = $this->getRateUrl() . 'supported-currency';
        $res = $this->httpRequest($url, [], 'getSupportedCurrency');
        return $res;
    }

    /**
     * Set request header for api call.
     *
     * @param string $function - Name of the function.
     * @return array The header of request.
     * 
     * @throws \Exception if api key and password not set.
     */
    private function setRequestHeader($function): array
    {
        $header = [];
        $userAgent = 'CR@' . $this->version . ',php plugin@' . $this->plugin_version;
        array_push($header, 'Content-Type: application/json');
        array_push($header, 'User-agent: ' . $userAgent);
        if (!in_array($function, ['fiatToCryptoRate', 'cryptoToFiatRate', 'getSupportedCurrency'])) {
            if (!isset($this->api_key) || !isset($this->password)) {
                throw new \Exception("Api key and password is required.");
            }
            array_push($header, 'X-Api-Key: ' . $this->api_key);
            array_push($header, 'X-Api-Password: ' . $this->password);
        }
        return $header;
    }

    /**
     * Send http request to coinremitter api.
     *
     * @param string $url - The url of api.
     * @param array $caller - Caller function name.
     * 
     * @return array The response contain the data returned by the request.
     *          - `success` - (boolean) The status of the request. Either 'true' or 'false'.
     *          `if success is 'true'`    
     *          - `data` - (array) The data returned by the request.
     *          `if success is 'false'`
     *          - `error` - (string) Error type.
     *          - `error_code` - (integer) Error code.
     *          - `msg` - (string) Error message.
     *          
     *          
     */
    private function httpRequest($url, $post = [], $caller = '')
    {
        if (!is_array($post)) {
            throw new \Exception("Invalid parameters.");
        }
        $header = $this->setRequestHeader($caller);
        $context =  stream_context_create([
            'http' => [
                'header' => $header,
                'ignore_errors' =>  true,
                'method' => 'POST',
                'content' => json_encode($post)
            ]
        ]);
        $fp = fopen($url, 'r', FALSE, $context);
        if ($fp === FALSE) {
            throw new \Exception("Coudn't connect to API URL.Try after sometime");
        }
        $response_body = fgets($fp);
        return json_decode($response_body, true);
        fclose($fp);
    }
}
