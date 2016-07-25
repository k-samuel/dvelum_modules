<?php
namespace Dvelum\Scheduler\Queue;

abstract class Adapter
{
    abstract public function enqueue(Message $message);
    abstract public function dequeue(Message $message);
    abstract public function ack(Message $message);
    abstract public function consume(array $callback);
}