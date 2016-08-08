<?php
namespace Dvelum\Social\Auth\Adapter;

use Dvelum\Social\Auth\Adapter;

class Mailru extends Adapter
{
    protected function requestInfo()
    {
        $params = $this->options;
        $params['grant_type'] = $this->settings['grant_type'];

        $tokenInfo = $this->request($this->settings['access_token'], $params);
        if (isset($tokenInfo['access_token']))
        {
                $sign = md5("app_id={$this->options['clientId']}method=users.getInfosecure=1session_key={$tokenInfo['access_token']}{$this->options['clientSecret']}");
                $params = array(
                    'method'       => 'users.getInfo',
                    'secure'       => '1',
                    'app_id'       => $this->options['clientId'],
                    'session_key'  => $tokenInfo['access_token'],
                    'sig'          => $sign
                );
                $userInfo = $this->get($this->settings['user_info_url'], $params);
                if (isset($userInfo[0]['uid'])) {
                    return array_shift($userInfo);
                }
        }
        return false;
    }

    protected function processInfo($responseInfo)
    {
        $info = parent::processInfo($responseInfo);

        if(isset($info['sex'])) {
            $info['sex'] = ($this->userInfo['sex'] == 1) ? 'female' : 'male';
        }

        return $info;
    }
}
