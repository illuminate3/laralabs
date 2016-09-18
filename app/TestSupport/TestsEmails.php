<?php namespace App\TestSupport;

use Mail;
use Swift_Mime_Message;

trait TestsEmails
{
    /**
     * Delivered emails.
     */
    protected $emails = [];

    /**
     * Register a listener for new emails.
     *
     * @before
     */
    public function setUpMailTracking()
    {
        Mail::getSwiftMailer()
            ->registerPlugin(new TestingMailEventListener($this));
    }

    /**
     * Assert that at least one email was sent.
     */
    protected function seeEmailWasSent()
    {
        $this->assertNotEmpty(
            $this->emails, 'No emails have been sent.'
        );

        return $this;
    }

    /**
     * Assert that no emails were sent.
     */
    protected function seeEmailWasNotSent()
    {
        $this->assertEmpty(
            $this->emails, 'Did not expect any emails to have been sent.'
        );

        return $this;
    }

    /**
     * Assert that the given number of emails were sent.
     *
     * @param integer $count
     *
     * @return $this
     */
    protected function seeEmailsSent($count)
    {
        $emailsSent = count($this->emails);
        $this->assertCount(
            $count, $this->emails,
            "Expected $count emails to have been sent, but $emailsSent were."
        );

        return $this;
    }

    /**
     * Assert that the last email's body equals the given text.
     *
     * @param string             $body
     * @param Swift_Mime_Message $message
     *
     * @return $this
     */
    protected function seeEmailEquals($body, Swift_Mime_Message $message = null)
    {
        $this->assertEquals(
            $body, $this->getEmail($message)->getBody(),
            "No email with the provided body was sent."
        );

        return $this;
    }

    /**
     * Assert that the last email's body contains the given text.
     *
     * @param string             $excerpt
     * @param Swift_Mime_Message $message
     *
     * @return $this
     */
    protected function seeEmailContains($excerpt, Swift_Mime_Message $message = null)
    {
        $this->assertContains(
            $excerpt, $this->getEmail($message)->getBody(),
            "No email containing the provided body was found."
        );

        return $this;
    }

    /**
     * Assert that the last email's subject matches the given string.
     *
     * @param string             $subject
     * @param Swift_Mime_Message $message
     *
     * @return $this
     */
    protected function seeEmailSubject($subject, Swift_Mime_Message $message = null)
    {
        $this->assertEquals(
            $subject, $this->getEmail($message)->getSubject(),
            "No email with a subject of $subject was found."
        );

        return $this;
    }

    /**
     * Assert that the last email was sent to the given recipient.
     *
     * @param string             $recipient
     * @param Swift_Mime_Message $message
     *
     * @return $this
     */
    protected function seeEmailTo($recipient, Swift_Mime_Message $message = null)
    {
        $this->assertArrayHasKey(
            $recipient, (array)$this->getEmail($message)->getTo(),
            "No email was sent to $recipient."
        );

        return $this;
    }

    /**
     * Assert that the last email was delivered by the given address.
     *
     * @param string             $sender
     * @param Swift_Mime_Message $message
     *
     * @return $this
     */
    protected function seeEmailFrom($sender, Swift_Mime_Message $message = null)
    {
        $this->assertArrayHasKey(
            $sender, (array)$this->getEmail($message)->getFrom(),
            "No email was sent from $sender."
        );

        return $this;
    }

    /**
     * Store a new swift message.
     *
     * @param Swift_Mime_Message $email
     */
    public function addEmail(Swift_Mime_Message $email)
    {
        $this->emails[] = $email;
    }

    /**
     * Retrieve the appropriate swift message.
     *
     * @param Swift_Mime_Message $message
     *
     * @return Swift_Mime_Message
     */
    public function getEmail(Swift_Mime_Message $message = null)
    {
        $this->seeEmailWasSent();

        return $message ? $message : $this->lastEmail();
    }

    /**
     * Retrieve the mostly recently sent swift message.
     *
     * @return Swift_Mime_Message
     */
    protected function lastEmail()
    {
        return end($this->emails);
    }
}