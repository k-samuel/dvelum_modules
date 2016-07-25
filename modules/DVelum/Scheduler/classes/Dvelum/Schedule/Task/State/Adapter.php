<?php
namespace Dvelum\Schedule\Task\State;
use Dvelum\Schedule;

abstract class Adapter
{
    abstract public function start(Schedule\Task $task);
    abstract public function stop(Schedule\Task $task);
    
}