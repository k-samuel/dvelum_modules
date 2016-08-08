<?php
namespace Dvelum\Social\Auth\Adapter;

use Dvelum\Social\Auth\Adapter;

class Google extends Adapter
{
    protected function requestInfo()
    {
        $params = $this->options;
        $params['grant_type'] = $this->settings['grant_type'];

        $tokenInfo = $this->request($this->settings['access_token'], ['data' => $params]);

        if (isset($tokenInfo['access_token'])) {
                $params['access_token'] = $tokenInfo['access_token'];
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

        if (isset($info['birthday'])) {
            $info['birthday'] = str_replace('0000', date('Y'), $info['birthday']);
            $info['birthday'] = date('d.m.Y', strtotime($info['birthday']));
        }

        return $info;
    }
}
