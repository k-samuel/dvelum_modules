<?php
namespace Dvelum\Schedule\Task;


class State
{
    protected $isStarted = false;
    protected $pid = false;
    protected $id;
    
    static public function factory()
    {
        return new static;
    }
}