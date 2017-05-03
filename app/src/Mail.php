<?php

namespace Membership;

use Projek\Slim\Plates;
use Slim\Interfaces\CollectionInterface;

class Mail
{
    /**
     * @var array
     */
    protected $adapters = [
        'smpt' => Mail\SmtpMessage::class,
        'sparkpost' => Mail\SparkpostMessage::class,
    ];

    /**
     * @var Mail\MessageInterface
     */
    protected $adapter = null;

    /**
     * @var \League\Plates\Engine
     */
    protected $view;

    /**
     * Create new Mail instance.
     *
     * @param Mail\MessageInterface $adapter
     * @param Plates $view
     * @param array $appSettings
     * @throws \Exception
     */
    public function __construct(Mail\MessageInterface $adapter, Plates $view, $appSettings = [])
    {
        if ($appSettings) {
            $adapter->from($appSettings['email'], $appSettings['name']);
        }

        $this->adapter = $adapter;
        $this->view = $view->getPlates();
    }

    /**
     * Add recipient(s).
     *
     * @param array|string $address
     * @param string $name
     * @return static
     */
    public function to($address, $name = '')
    {
        $this->adapter->to($address, $name);

        return $this;
    }

    /**
     * Add sender.
     *
     * @param array|string $address
     * @param string $name
     * @return static
     */
    public function from($address, $name = '')
    {
        $this->adapter->from($address, $name);

        return $this;
    }

    /**
     * Add subject.
     *
     * @param array|string $subject
     * @return static
     */
    public function subject($subject)
    {
        $this->adapter->subject($subject);

        return $this;
    }

    /**
     * Send the email.
     *
     * @param string|array $view
     * @param array $data
     * @param callable $callback
     */
    public function send($view, array $data = [], callable $callback = null)
    {
        if ($callback) {
            $callback($this->adapter);
        }

        $this->adapter->content(
            $this->view->render($view, $data)
        );

        $this->adapter->send();
    }
}
