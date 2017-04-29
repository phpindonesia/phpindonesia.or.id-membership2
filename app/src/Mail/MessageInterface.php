<?php

namespace Membership\Mail;

interface MessageInterface
{
    /**
     * Setup Sender
     *
     * @param string $address
     * @param string $name
     * @return $this
     */
    public function from($address, $name);

    /**
     * Add recipient email address.
     *
     * @param string $address
     * @param string $name
     * @return $this
     */
    public function to($address, $name = '');

    /**
     * Add email subject.
     *
     * @param string $subject
     * @return $this
     */
    public function subject($subject);

    /**
     * Write email body.
     *
     * @param string $body
     * @return $this
     */
    public function content($body);

    /**
     * Add attachments.
     *
     * @param array $files
     * @return $this
     */
    public function attach(array $files);

    /**
     * Send the thing.
     *
     * @return mixed
     */
    public function send();
}
