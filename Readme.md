# Webgears Event Queue Bundle


**Attention:** You'll need php-fpm for this bundle

Symfony2 provides a `kernel.terminate` [Event](http://symfony.com/doc/current/components/http_kernel/introduction.html#the-kernel-terminate-event),
which is usually used to perform some "heavy" action after the response has been streamed to the user.

This bundle adds a queue which can be used to add work that should not affect the response time for the user.
All events in this queue will be processed after the `kernel.terminate` event occurs.

```
Symfony2 Note:

Internally, the HttpKernel makes use of the fastcgi_finish_request PHP function.
This means that at the moment, only the PHP FPM server API is able to send a response to the client while the
server's PHP process still performs some tasks.  With all other server APIs, listeners to kernel.terminate
are still executed, but the response is not sent to the client until they are all completed.
```

## Installation

Install it via composer.

```json
   "repositories" : [{
       "type" : "vcs",
       "url" : "https://github.com/webgears/WebgearsEventBundle"
   }],
```

`composer require webgears/event-bundle`

Add it to the Symfony2 AppKernel:

```php

    public function registerBundles()
    {
        $bundles = array(
            ...
            new Webgears\Bundle\EventBundle\WebgearsEventBundle(),
            ...
        );
        ...
    }
```

## Usage

Invoke a service with some data after the `kernel.terminate` event.

```php
// Send a new event so that the service will be invoked
// when the kernel terminates
$service = $this->get('some_service');
$callable = [$service, 'some_service_method'];
$data = [$arg1, $arg2, $arg3];

$event = new CallableEvent($callable, $data);
$this->get('event_dispatcher')->dispatch(ActionEvent::NAME, $event);
```

You will also need to register the subscriber service:

```yml
services:
    webgears.event_bundle.queue_listener:
        class: Webgears\Bundle\EventBundle\Listener\EventSubscriber
        arguments: []
        tags:
          - { name: kernel.event_subscriber }
```
