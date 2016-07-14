<?php


namespace Webgears\Bundle\EventBundle\Model;

use Symfony\Component\EventDispatcher\Event as BaseEvent;

abstract class ActionEvent extends BaseEvent
{
    const NAME = 'webgears.event_bundle.event';

    public abstract function action();
}