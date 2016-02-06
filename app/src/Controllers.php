<?php
namespace Membership;

use Slim\Container;
use Slim\Http\Request;
use Slim\Exception\NotFoundException;

abstract class Controllers
{
    use ContainerAware;

    /**
     * Create Controller\Base instance
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;

        $this->setPageTitle();

        $this->view->addData([
            'gcaptchaSitekey' => null,
            'gcaptchaSecret'  => null,
            'gcaptchaEnable'  => false,
        ], 'sections::captcha');

        $this->view->addData([
            'session' => $container->get('session')->all(),
        ]);
    }

    /**
     * Assert is XHR request
     *
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     * @throws \Slim\Exception\NotFoundException
     */
    protected function assertXhrRequest($request, $response)
    {
        if (!$request->isXhr()) {
            throw new NotFoundException($request, $response);
        }
    }

    /**
     * Set Page main and sub title
     *
     * @param string $mainTitle     Main Page Title
     * @param string $subTitle      Sub Page Title
     */
    protected function setPageTitle($mainTitle = '', $subTitle = '')
    {
        $this->view->addData([
            'page_title' => $mainTitle,
            'sub_page_title' => $subTitle,
        ], 'layouts::system');
    }

    /**
     * Flash validation error messages
     *
     * @param array $errors
     */
    protected function flashValidationErrors(array $errors)
    {
        foreach ($errors as $field => $message) {
            $this->flash->addMessage('validation.errors.'.$field, implode(', ', $message));
        }

        if ($inputs = $this->request->getParsedBody()) {
            $this->flash->addMessage('form.inputs', serialize(array_filter($inputs)));
        }
    }

    /**
     * Add Form alert
     *
     * @param string $type
     * @param array  $message
     * @param array  $errors
     */
    protected function addFormAlert($type, $message, array $errors = [])
    {
        $this->flash->addMessage('form.alert.'.$type, $message);

        if (!is_array($message)) {
            $message = [$message];
        }

        if (!in_array($type, ['warning', 'success', 'error'])) {
            $type = 'warning';
        }

        $this->view->addData([
            'formAlert' => ['type' => $type, 'message' => $message]
        ], 'sections::alert');

        foreach ($errors as $field => $error) {
            $this->flash->addMessage('validation.errors.'.$field, implode(', ', $error));
        }

        if ($inputs = $this->request->getParsedBody()) {
            $this->flash->addMessage('form.inputs', serialize(array_filter($inputs)));
        }
    }

    /**
     * Enable Captcha
     *
     * return array
     */
    protected function enableCaptcha()
    {
        $settings = $this->settings->get('gcaptcha');
        $this->view->addData([
            'gcaptchaEnable'  => $settings['enable'],
            'gcaptchaSitekey' => $settings['sitekey'],
            'gcaptchaSecret'  => $settings['secret'],
        ], 'sections::captcha');

        return $settings;
    }

    /**
     * Simple helper to salt the password
     *
     * @param string $password
     * @return string
     */
    protected function salt($password)
    {
        $salt = $this->settings->get('salt_pwd');

        return md5($salt . $password);
    }
}
