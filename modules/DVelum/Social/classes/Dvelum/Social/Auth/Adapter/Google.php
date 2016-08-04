<?php
namespace Dvelum\Social\Auth\Adapter;

use Dvelum\Social\Auth\Adapter;

class Google extends Adapter
{
    protected function requestInfo()
    {

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
