<?php

namespace Membership\Mail;

use SparkPost\SparkPost;

class SparkpostMessage implements MessageInterface
{
    /**
     * @var SparkPost
     */
    protected $mailer;

    /**
     * @var array
     */
    protected $payload;

    public function __construct(SparkPost $mailer)
    {
        $this->mailer = $mailer;
    }

    public function from($address, $name)
    {
        $this->payload['content']['from'] = [
            'name' => $name,
            'email' => $address,
        ];

        return $this;
    }

    public function to($address, $name = '')
    {
        $this->payload['recipients']['address'] = [
            'name' => $name,
            'email' => $address,
        ];;

        return $this;
    }

    public function subject($subject)
    {
        $this->payload['subject'] = $subject;

        return $this;
    }

    public function content($body)
    {
        if (is_array($body)) {
            $this->payload['subject'] = $body;
        } else {
            $this->payload['subject']['html'] = $body;
        }

        return $this;
    }

    public function attach(array $files)
    {
        return $this;
    }

    public function send()
    {
        $this->mailer->setOptions(['async' => false]);

        try {
            return $this->mailer->transmissions->post($this->payload);
        } catch (\Exception $e) {
            throw new MessageException($e->getMessage(), $e->getCode());
        }
    }
}
