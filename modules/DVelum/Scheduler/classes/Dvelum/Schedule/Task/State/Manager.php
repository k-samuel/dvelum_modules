<?php
namespace Dvelum\Schedule\Task\State;
use Dvelum\Schedule;

class Manager
{
    /**
     * @var Adapter $adapter
     */
    protected $adapter;

    /**
     * @param Schedule\Task $task
     */
    public function start(Schedule\Task $task)
    {
        return $this->adapter->start($task);
    }
    
    public function stop(Schedule\Task $task)
    {
        return $this->adapter->stop($task); 
    }
    
    
    public function isStarted(Schedule\Task $task)
    {
        
    }

}