<?php
namespace Dvelum\Social\Auth\Adapter;
use Dvelum\Social\Auth\Adapter;

class Yandex extends Adapter
{
    protected function requestInfo()
    {
        $userInfo = false;
        $tokenInfo = [];

        $params = $this->options;
        $params['grant_type'] = $this->settings['grant_type'];

        $tokenInfo = $this->request($this->settings['access_token'], ['data' => $params]);

        if (isset($tokenInfo['access_token'])){
            $params = array(
                'format' => 'json',
                'oauth_token' => $tokenInfo['access_token']
            );
            $userInfo = $this->request($this->settings['user_info_url'], $params);
            if (isset($userInfo['id'])) {
                return $userInfo;
            }
        }
        return false;
    }
}
