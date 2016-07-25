<?php
namespace Dvelum\Schedule;

class Task
{
    /**
     * @var integer $id
     */
    protected $id;

    /**
     * @var Task\State;
     */
    protected $state;

    /**
     * @var \Db_Object $dbObject
     */
    protected $dbObject;

    public function __construct(\Db_Object $dbObject)
    {
        $this->dbObject = $dbObject;
        $this->state = Task\State::factory();
    }

    /**
     * @return Task\State
     */
    public function getState()
    {
        return $this->state;
    }
}