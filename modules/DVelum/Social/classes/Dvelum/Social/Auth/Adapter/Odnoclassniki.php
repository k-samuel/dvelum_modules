<?php
namespace Dvelum\Social\Auth\Adapter;

use Dvelum\Social\Auth\Adapter;

class Odnoklassniki extends Adapter
{
    protected function requestInfo()
    {
        $params = $this->options;
        $params['grant_type'] = $this->settings['grant_type'];

        $tokenInfo = $this->request($this->settings['access_token'], ['data' => $params]);

        if (isset($tokenInfo['access_token']) && isset($this->options['public_key'])) {
            $sign = md5("application_key={$this->options['public_key']}format=jsonmethod=users.getCurrentUser" . md5("{$tokenInfo['access_token']}{$this->options['client_secret']}"));
            $params = array(
                'method'          => 'users.getCurrentUser',
                'access_token'    => $tokenInfo['access_token'],
                'application_key' => $this->options['public_key'],
                'format'          => 'json',
                'sig'             => $sign
            );
            $userInfo = $this->request($this->settings['user_info_url'], $params);
            if (isset($userInfo['uid'])) {
                return $userInfo;
            }
        }
        return false;
    }

    protected function processInfo($responseInfo)
    {
        $info = parent::processInfo($responseInfo);

        if(isset($info['uid'])){
            $info['page'] =  'http://www.odnoklassniki.ru/profile/' . $info['uid'];
        }
        return $info;
    }
}
