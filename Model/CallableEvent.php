<?php


namespace Webgears\Bundle\EventBundle\Model;

class CallableEvent extends ActionEvent
{
    /** @var callable */
    protected $service;

    /** @var array */
    protected $data;

    /**
     * ActionEvent constructor.
     *
     * @param callable $service
     * @param array $data
     */
    public function __construct(callable $service, array $data)
    {
        $this->service = $service;
        $this->data = $data;
    }


    public function action() {
        call_user_func_array($this->service, $this->data);
    }
}