<?php
namespace CoinRemitter;

class CoinRemitter {
    //use Config;
    /**
     * 
     * @var string endpoint of api
     */
    private $url='https://coinremitter.com/api/';
     /**
     * 
     * @var string of api version
     */
    private $version = 'v3';
    /**
     * 
     * @var string of api version
     */
    private $plugin_version = '0.1.3';
    /**
     *
     * @var string  coin for which this api is used.
     */
    private $coin;
    /**
     *
     * @var array() parameters which will be send to api call.
     */
    private $param; 
    /**
     * 
     * @param arraya $param pass valid coin detail with api_key,password,coin etc.
     */
    public function __construct($param=[]) {
        if(isset($param['coin'])){
            $coin = strtoupper($param['coin']);
            $this->coin = $coin;    
        }else{
            throw new \Exception('Coin short name is required');
        }
        
        if(isset($param['api_key']) && isset($param['password'])){
            $this->param['api_key']=$param['api_key'];
            $this->param['password']=$param['password'];
        }else{
            throw new \Exception('Api key and Password is required');
        }

        if(!function_exists('curl_version')){
            throw new \Exception("php-curl is not enabled. Install it");
        }
    }
    /**
     * get balance of specified coin.
     * @return array() returns array with success or error response.
     */
    public function get_balance(){
        $url = $this->url.$this->version.'/'.$this->coin.'/get-balance';
        $res = $this->curl_call($url, $this->param);
        return $res;
    }
    /**
     * get new address for specified coin.
     * @param string $label Optional, label assign to new address.
     * @return array() returns array with success or error response.
     */
    public function get_new_address($param=[]){
        $url = $this->url.$this->version.'/'.$this->coin.'/get-new-address';
        $this->param = array_merge($this->param,$param);
        $res = $this->curl_call($url, $this->param);
        return $res;
    }
    /**
     * validate address for specified coin.
     * @param string $address address to verify.
     * @return array() returns array with success or error response.
     */
    public function validate_address($param){
        $url = $this->url.$this->version.'/'.$this->coin.'/validate-address';
        $this->param = array_merge($this->param,$param);
        $res = $this->curl_call($url, $this->param);
        return $res;
    }
    /**
     * withdraw coin to specific address.
     * @param array() $param pass to_address and amount in array to withdraw amount.
     * @return array() returns array with success or error response.
     */
    public function withdraw($param=[]){
        $url = $this->url.$this->version.'/'.$this->coin.'/withdraw';
        $this->param = array_merge($this->param,$param);
        $res = $this->curl_call($url, $this->param);
        return $res;
    }
    /**
     * get transaction details of given transaction id.
     * @param string $id pass id to get transaction detail.
     * @return array() returns array with success or error response.
     */
    public function get_transaction($param){
        $url = $this->url.$this->version.'/'.$this->coin.'/get-transaction';
        $this->param = array_merge($this->param,$param);
        $res = $this->curl_call($url, $this->param);
        return $res;
    }
    /**
     * get transactions details by given address.
     * @param string $address pass address to get all realted transactions.
     * @return array() returns array with success or error response.
     */
    public function get_transaction_by_address($param){
        $url = $this->url.$this->version.'/'.$this->coin.'/get-transaction-by-address';
        $this->param = array_merge($this->param,$param);
        $res = $this->curl_call($url, $this->param);
        return $res;
    }
    /**
     * create invoice for deposit balance.
     * @param array() $param pass parameters in array to generate invoice.
     * @return array() returns array with success or error response.
     */
    public function create_invoice($param=[]){
        $url = $this->url.$this->version.'/'.$this->coin.'/create-invoice';
        $this->param = array_merge($this->param,$param);
        $res = $this->curl_call($url, $this->param);
        return $res;
    }

    /**
     * get invoice details of given invoice id.
     * @param string $id pass id to get invoice detail.
     * @return array() returns array with success or error response.
     */
    public function get_invoice($param){
        $url = $this->url.$this->version.'/'.$this->coin.'/get-invoice';
        $this->param = array_merge($this->param,$param);
        $res = $this->curl_call($url, $this->param);
        return $res;
    }

    /**
     * Get Fiat to Crypto rate.
     * @param array() pass fiat_symbol and fiat_amount as key.
     * @return array() returns array with success or error response.
     */
    public function get_fiat_to_crypto_rate($param){
        $url = $this->url.$this->version.'/'.$this->coin.'/get-fiat-to-crypto-rate';
        $this->param = array_merge($this->param,$param);
        $res = $this->curl_call($url, $this->param);
        return $res;
    }

    /**
     * get all coin usd rate.
     * @return array() returns array with success or error response.
     */
    public function get_coin_rate(){
        $url = $this->url.$this->version.'/'.$this->coin.'/get-coin-rate';
        $res = $this->curl_call($url, $this->param);
        return $res;
    }

    /**
     * 
     * @param string $url
     * @param array $post optional, parameters.
     * @return array()
     */
    public  function curl_call($url, $post = '') {
	
        if(!isset($post['api_key']) && !isset($post['password'])){
            return $this->error_res('Please set API_KEY and PASSWORD for '.$this->coin);
        }
        
        $userAgent = 'CR@' . $this->version . ',php plugin@'.$this->plugin_version; // 0.1.3

        $postStr = http_build_query($post);
        $options = array(
            'http' =>
                array(
                    'method'  => "POST", //We are using the POST HTTP method.
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n"."User-agent:".$userAgent,
                    'content' => $postStr //Our URL-encoded query string.
                ),
               
        );

        $streamContext  = stream_context_create($options);
        //Use PHP's file_get_contents function to carry out the request.
        //We pass the $streamContext variable in as a third parameter.
        $result = file_get_contents($url, false, $streamContext);
        //If $result is FALSE, then the request has failed.
        if($result === false){
            //If the request failed, throw an Exception containing
            //the error.
            /*$error = error_get_last();
            throw new Exception('POST request failed: ' . $error['message']);*/
            return $this->error_res();
        }
        //If everything went OK, return the response.
        if(!is_array($result)){
            $result = json_decode($result,true);
        }
        return $result;
    }
    /**
     * 
     * @param string $msg optional,message to be return
     * @return array()
     */
    private function error_res($msg =''){
        $res = [
            'flag'=>0,
            'msg'=>'error'
        ];
        if($msg){
            $res['msg']=$msg;
        }
        
        return $res;
    }

}

