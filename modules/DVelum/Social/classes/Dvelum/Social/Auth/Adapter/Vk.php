<?php
namespace Dvelum\Social\Auth\Adapter;

use Dvelum\Social\Auth\Adapter;

class Vk extends Adapter
{

    protected function requestInfo()
    {
        $userInfo = false;

        $tokenInfo = $this->request($this->settings['access_token'], $this->options, false);

        if (isset($tokenInfo['access_token'])) {
            $params = array(
                'uids'         => $tokenInfo['user_id'],
                'fields'       => 'uid,first_name,last_name,screen_name,sex,bdate,photo_big',
                'access_token' => $tokenInfo['access_token']
            );
            $userInfo = $this->get($this->settings['user_info_url'], $params);

            if (isset($tokenInfo['email'])) {
                $userInfo['response'][0]['email'] = $tokenInfo['email'];
            }

            if (isset($userInfo['response'][0]['uid'])) {
                return $userInfo['response'][0];
            }
        }
        return false;
    }

    protected function processInfo($responseInfo)
    {
        $info = parent::processInfo($responseInfo);

        // Add page url
        if(isset($info['screen_name'])){
            $info['page'] = 'https://vk.com/' . $info['screen_name'];
        }

        // Add user sex
        if (isset($info['sex'])) {
            $info['sex'] = ($info['sex'] == 1) ? 'female' : 'male';
        }

        // Add user name
        $firstName = '';
        $lastName = '';

        if(isset($info['first_name']))
            $firstName = $info['first_name'];

        if(isset($info['last_name']))
            $lastName = $info['last_name'];

        $name = trim($firstName . ' ' .  $lastName);

        if(!empty($name))
            $info['name'] = $name;

        return $info;
    }
}
