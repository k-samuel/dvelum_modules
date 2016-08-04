<?php
namespace Dvelum\Social\Auth\Adapter;

use Dvelum\Social\Auth\Adapter;

class Twitter extends Adapter
{
    protected function requestInfo(){

    }

    protected function processInfo($responseInfo)
    {
        $info = parent::processInfo($responseInfo);

        // Add page url
        if (isset($info['screen_name'])) {
            $info['page'] = 'https://twitter.com/' . $info['screen_name'];
        }

        if (isset($info['profile_image_url'])) {
            $info['avatar'] = implode('', explode('_normal', $info['profile_image_url']));
        }
    }
}
