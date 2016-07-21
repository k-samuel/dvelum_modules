<?php
namespace Dvelum\Scheduler;

abstract class Queue
{
    abstract public function enqueue(\Dvelum\Scheduler\Queue\Message $message);
    abstract public function dequeue(\Dvelum\Scheduler\Queue\Message $message);
    abstract public function ack(\Dvelum\Scheduler\Queue\Message $message);
    abstract public function consume(array $callback);
}