<?php

namespace Membership\Mail;

class SmtpMessage implements MessageInterface
{
    /**
     * @var \PHPMailer
     */
    protected $mailer;

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
        'senderName'  => '',
    ];

    /**
     * Debug mode
     *
     * @var array
     */
    private $debugMode = [
        'debug' => 3,
        'development' => 2,
        'production' => 1,
        'testing' => 0,
    ];

    public function __construct(array $settings = [])
    {
        $settings = array_merge($this->settings, $settings);

        $this->mailer = new \PHPMailer(true);

        $this->mailer->Host = $settings['host'];
        $this->mailer->Port = $settings['port'];
        $this->mailer->Username = $settings['username'];
        $this->mailer->Password = $settings['password'];

        $this->mailer->isSMTP();

        $this->mailer->SMTPAuth = $settings['auth'];
        $this->mailer->SMTPSecure = $settings['secure'];
    }

    public function debugMode($mode)
    {
        if (!isset($this->debugMode[$mode])) {
            $mode = 'production';
        }

        $this->mailer->SMTPDebug = $this->debugMode[$mode];

        return $this;
    }

    public function from($address, $name)
    {
        $this->mailer->setFrom($address, $name);

        return $this;
    }

    public function to($address, $name = '')
    {
        $this->mailer->addAddress($address, $name);

        return $this;
    }

    public function subject($subject)
    {
        $this->mailer->Subject = $subject;

        return $this;
    }

    public function content($body)
    {
        $this->mailer->Body = $body;

        return $this;
    }

    public function attach(array $files)
    {
        foreach ($files as $filepath) {
            $this->mailer->addAttachment($filepath);
        }

        return $this;
    }

    public function send()
    {
        try {
            return $this->mailer->send();
        } catch (\phpmailerException $e) {
            throw new MessageException($e->getMessage(), $e->getCode());
        }
    }
}
