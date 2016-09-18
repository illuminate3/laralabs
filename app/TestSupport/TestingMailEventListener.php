<?php namespace App\TestSupport;

use Swift_Events_EventListener;
use Swift_Events_SendEvent;

class TestingMailEventListener implements Swift_Events_EventListener
{
    /** @var TestsEmails */
    protected $testCase;

    public function __construct($testCase)
    {
        $this->testCase = $testCase;
    }

    public function beforeSendPerformed(Swift_Events_SendEvent $event)
    {
        $this->testCase->addEmail($event->getMessage());
    }

    public function sendPerformed(Swift_Events_SendEvent $event)
    {
        $this->testCase->addEmail($event->getMessage());
    }
}