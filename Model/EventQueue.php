<?php


namespace Webgears\Bundle\EventBundle\Model;


class EventQueue
{
    /** @var EventQueue */
    protected static $instance;

    public static function getInstance()
    {
        if(self::$instance === null) {
            self::$instance = new EventQueue();
        }
        return self::$instance;
    }

    /** @var ActionEvent[] */
    protected $event_queue = [];

    /**
     * EventQueue constructor.
     */
    private function __construct()
    {
    }

    /**
     * Add a new event
     *
     * @param ActionEvent $event
     * @return $this
     */
    public function push(ActionEvent $event)
    {
        $this->event_queue[] = $event;

        return $this;
    }

    /**
     * Return all event
     *
     * @return ActionEvent[]
     */
    public function getAll()
    {
        return $this->event_queue;
    }

    /**
     * Return the next event in the queue
     *
     * @return ActionEvent|null
     */
    public function pop()
    {
        return array_shift($this->event_queue);
    }
}