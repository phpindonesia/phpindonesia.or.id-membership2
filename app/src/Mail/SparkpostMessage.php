<?php

namespace Membership\Mail;

use Http\Client\Exception\RequestException;
use Http\Client\HttpClient;
use Http\Message\MessageFactory\SlimMessageFactory;

class SparkpostMessage implements MessageInterface
{
    const ENDPOINT = 'https://api.sparkpost.com/api/v1/transmissions';

    /**
     * @var HttpClient
     */
    protected $client;

    /**
     * @var array
     */
    protected $payload;

    protected $content = [];

    protected $recipients = [];

    protected $key;

    public function __construct(HttpClient $mailer, $key)
    {
        $this->client = $mailer;
        $this->key = $key;
    }

    public function from($address, $name)
    {
        $this->content['from'] = ['name' => $name, 'email' => $address];

        return $this;
    }

    public function to($address, $name = '')
    {
        $this->recipients[] = [
            'address' => ['name' => $name, 'email' => $address]
        ];

        return $this;
    }

    public function subject($subject)
    {
        $this->content['subject'] = $subject;

        return $this;
    }

    public function content($body)
    {
        $this->content['html'] = $body;

        return $this;
    }

    public function attach(array $files)
    {
        return $this;
    }

    public function send()
    {
        try {
            $headers = [
                'Authorization' => $this->key,
                'Content-Type' => 'application/json'
            ];

            $body = [
                'recipients' => $this->recipients,
                'content' => $this->content,
                'options' => [
                    'transactional' => true,
                    'open_tracking' => true,
                    'click_tracking' => true,
                ],
            ];

            /** @var \Psr\Http\Message\RequestInterface $request */
            $request = (new SlimMessageFactory)
                ->createRequest('POST', self::ENDPOINT, $headers, json_encode($body, true));

            /** @var \Psr\Http\Message\ResponseInterface $response */
            $response = $this->client->sendRequest($request);

            return $response->getStatusCode() === 200;
        } catch (RequestException $e) {
            throw new MessageException($e->getMessage(), $e->getCode());
        }
    }
}
