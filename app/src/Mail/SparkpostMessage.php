<?php

namespace Membership\Mail;

class SparkpostMessage implements MessageInterface
{
    /**
     * @var \SparkPost\SparkPost
     */
    protected $mailer;

    /**
     * @var array
     */
    protected $payload;

    public function __construct(array $settings = [])
    {
        $settings = array_merge($this->settings, $settings);

        $client = new \Http\Client\Curl\Client(
            new \Http\Message\MessageFactory\SlimMessageFactory(),
            new \Http\Message\StreamFactory\SlimStreamFactory()
        );

        $this->mailer = new \SparkPost\SparkPost($client, [
            'key' => $settings['sparkpost']['key']
        ]);
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
