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
     * @param CollectionInterface $settings
     * @param Plates $view
     * @throws \Exception
     */
    public function __construct(CollectionInterface $settings, Plates $view)
    {
        $driver = $settings['mail']['driver'];

        if (! array_key_exists($driver, $this->adapters)) {
            throw new \Exception('Email driver not found');
        }

        $adapter = new \ReflectionClass(new $this->adapters[$driver]);

        $this->adapter = $adapter->newInstance($settings);
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
