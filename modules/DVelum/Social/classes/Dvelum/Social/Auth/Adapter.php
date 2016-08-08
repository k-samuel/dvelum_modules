<?php
namespace Dvelum\Social\Auth;

abstract class Adapter
{
    protected $fields;
    protected $settings;
    protected $options;

    protected $error;

    protected $userInfo;

    public function __construct(array $options , array $config)
    {
        $this->options = $options;

        $this->fields = $config['fields'];
        $this->settings = $config['settings'];
    }

    public function getError()
    {
        return $this->error;
    }

    /**
     * Get user info property
     * @return string
     */
    public function getInfo($key)
    {
        if(isset($this->userInfo[$key])){
            return $this->userInfo[$key];
        }
        return '';
    }

    /**
     * @return bool
     */
    public function auth(){

        $result = $this->requestInfo();

        if($result){
            $this->userInfo = $this->processInfo($result);
        }
    }

    protected function request($url, $params, $json = true)
    {
        $curl =  $this->initRequest($url, $params);

        $result = curl_exec($curl);
        $info = curl_getinfo($curl);

        if(curl_errno($curl) > 0){
            $this->error = curl_error($curl);
        }

        if($info['http_code'] != 200) {
            $this->error = 'Invalid response code ' . $info['http_code'].' url: ' . $url;
        }

        curl_close($curl);

        /**
         * @todo  json_decode can fail
         */
        if($json)
            $result = json_decode($result, true);

        return $result;
    }

    protected  function initRequest($url, $params)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);

        if (isset($params['referer']))
            curl_setopt($curl, CURLOPT_REFERER, $params['referer']);


        if (isset($options['data'])) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $options['data']);
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        return $curl;
    }

    protected function processInfo($responseInfo)
    {
        $userInfo = [];
        $fieldMap = array_flip($this->fields);
        foreach ($responseInfo as $field => $value){
            if(isset($fieldMap[$field])){
                $userInfo[$fieldMap[$field]] = $value;
            }else{
                $userInfo[$field] = $value;
            }
        }
        return $userInfo;
    }

//    public function getAuthUrl()
//    {
//        $params = $this->prepareAuthParams();
//        return $result = $params['auth_url'] . '?' . urldecode(http_build_query($params['auth_params']));
//    }

    abstract protected function requestInfo();
}

