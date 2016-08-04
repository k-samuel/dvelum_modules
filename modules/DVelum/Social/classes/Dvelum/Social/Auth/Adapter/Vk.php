<?php
namespace Dvelum\Social\Auth\Adapter;

use Dvelum\Social\Auth\Adapter;

class Vk extends Adapter
{

    protected function requestInfo(){

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
