<?php

namespace Membership\Libraries;

use League\Plates\Engine;

class Mailer
{
    /**
     * @var PHPMailer
     */
    protected $mail;

    /**
     * View instance.
     *
     * @var \League\Plates\Engine
     */
    protected $view;

    /**
     * @var array
     */
    protected $settings = [
        'host' => '',
        'port' => '',
        'username' => '',
        'password' => '',
        'auth' => true,
        'secure' => 'tsl',
        'senderEmail' => '',
        'senderName' => '',
    ];

    /**
     * Debug mode.
     *
     * @var array
     */
    private $debugMode = [
        'debug' => 3,
        'development' => 2,
        'production' => 1,
        'testing' => 0,
    ];

    /**
     * Mailer constructor.
     *
     * @param array $settings
     *
     * @throws \InvalidArgumentException
     */
    public function __construct(array $settings = [], Engine $view)
    {
        $this->view = $view;
        $settings = array_merge($this->settings, $settings);

        $this->mail = new \PHPMailer(true);

        $this->mail->Host = $settings['host'];
        $this->mail->Port = $settings['port'];
        $this->mail->Username = $settings['username'];
        $this->mail->Password = $settings['password'];

        $this->mail->isSMTP();

        $this->mail->SMTPAuth = $settings['auth'];
        $this->mail->SMTPSecure = $settings['secure'];
    }

    /**
     * Setup Sender.
     *
     * @param string $senderEmail
     * @param string $senderName
     */
    public function setSender($senderEmail, $senderName)
    {
        $this->mail->setFrom($senderEmail, $senderName);

        return $this;
    }

    /**
     * Set mailer debug mode.
     *
     * @param string $mode
     *
     * @return $this
     */
    public function debugMode($mode)
    {
        if (!isset($this->debugMode[$mode])) {
            $mode = 'production';
        }

        $this->mail->SMTPDebug = $this->debugMode[$mode];

        return $this;
    }

    /**
     * Add recipient email address.
     *
     * @param string $address
     *
     * @return $this
     */
    public function to($address, $name = '')
    {
        $this->mail->addAddress($address, $name);

        return $this;
    }

    /**
     * Add email subject.
     *
     * @param string $subject
     *
     * @return $this
     */
    public function withSubject($subject)
    {
        $this->mail->Subject = $subject;

        return $this;
    }

    /**
     * Write email body.
     *
     * @param string $body
     * @param array  $data
     *
     * @return $this
     */
    public function withBody($body, array $data = [])
    {
        if (strpos($body, '::') !== false) {
            if (!$this->view instanceof Engine) {
                throw new \LogicException('View must be instance of '.Engine::class);
            }

            $this->mail->isHTML(true);

            $body = $this->view->render($body, $data);
        }

        $this->mail->Body = $body;

        return $this;
    }

    /**
     * Add attachments.
     *
     * @param array $attachments
     *
     * @return $this
     */
    public function addAttachments(array $files)
    {
        /** @var string $filepath */
        foreach ($files as $filepath) {
            $this->mail->addAttachment($filepath);
        }

        return $this;
    }

    /**
     * Send the thing.
     *
     * @return mixed
     */
    public function send()
    {
        return $this->mail->send();
    }
}
