<?php
namespace Dvelum\Social\Auth\Adapter;

use Dvelum\Social\Auth\Adapter;

class Facebook extends Adapter
{
    protected function requestInfo()
    {
        $userInfo = false;

        $tokenInfo = [];

        parse_str($this->request($this->settings['access_token'], $this->options, false), $tokenInfo);

        if (count($tokenInfo) > 0 && isset($tokenInfo['access_token'])) {
            $params = array('access_token' => $tokenInfo['access_token']);
            $userInfo = $this->request($this->settings['user_info_url'], $params);
            if (isset($userInfo['id'])) {
                return $userInfo;
            }
        }
        return false;
    }

    protected function processInfo($responseInfo)
    {
        $info = parent::processInfo($responseInfo);

        // Add avatar
        if(isset($info['username'])){
            $info['avatar'] =  'http://graph.facebook.com/' . $info['username'] . '/picture?type=large';
        }

        return $info;
    }

//    protected function getAuthParams()
//    {
//        return [
//            'auth_url'    => $this->settings['auth_url'],
//            'auth_params' => array(
//                'client_id'     => $this->options['client_id'],
//                'redirect_uri'  => $this->options['redirect_uri'],
//                'response_type' => $this->settings['auth_params']['response_type'],
//                'scope'         => $this->settings['auth_params']['scope']
//            )
//        ];
//    }
}
