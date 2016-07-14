<?php


namespace Webgears\Bundle\EventBundle\Listener;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\KernelEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Webgears\Bundle\EventBundle\Model\ActionEvent;
use Webgears\Bundle\EventBundle\Model\EventQueue;

class EventListener implements EventSubscriberInterface
{
    /**
     * When a event is received, add it to the queue
     *
     * @param ActionEvent $event
     */
    public function onEventReceived(ActionEvent $event)
    {
        EventQueue::getInstance()->push($event);
    }

    /**
     * When the kernel terminates, execute all postponed events
     *
     * @param KernelEvent $event
     */
    public function onKernelTerminate(KernelEvent $event)
    {
        $event_queue = EventQueue::getInstance();
        while (($event = $event_queue->pop()) !== null) {
            $event->action();
        }
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array(
            ActionEvent::NAME => 'onEventReceived',
            KernelEvents::TERMINATE => 'onKernelTerminate'
        );
    }
}