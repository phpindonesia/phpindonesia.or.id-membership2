<?php

namespace Membership\Http;

use Membership\ContainerAware;
use Membership\Models\Users;
use Slim\Container;
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

        $session = $container->get('session');

        $this->setPageTitle();

        if ($session->get('user_id')) {
            $this->setHeaderLogin();
        }

        $this->view->addData([
            'gcaptchaSitekey' => null,
            'gcaptchaSecret'  => null,
            'gcaptchaEnable'  => false,
        ], 'section::captcha');

        $this->view->addData([
            'session' => $session->all(),
        ]);
    }

    /**
     * Assert is XHR request
     *
     * @param Request  $request
     * @param Response $response
     * @throws NotFoundException
     */
    protected function assertXhrRequest(Request $request, Response $response)
    {
        if (!$request->isXhr()) {
            throw new NotFoundException($request, $response);
        }
    }

    /**
     * Assert is HTML request
     *
     * @param Request  $request
     * @param Response $response
     * @throws \Slim\Exception\NotFoundException
     */
    protected function assertHTMLRequest(Request $request, Response $response)
    {
        if ($request->isXhr()) {
            throw new NotFoundException($request, $response);
        }
    }

    /**
     * Set Page main and sub title
     *
     * @param string $mainTitle Main Page Title
     * @param string $subTitle  Sub Page Title
     */
    protected function setPageTitle($mainTitle = '', $subTitle = '')
    {
        $this->view->addData([
            'page_title' => $mainTitle,
            'sub_page_title' => $subTitle,
        ], 'layout::system');
    }

    /**
     * Flash validation error messages
     *
     * @param array $errors
     */
    protected function flashValidationErrors(array $errors)
    {
        foreach ($errors as $field => $message) {
            $this->flash->addMessage('validation._errors.'.$field, implode(', ', $message));
        }

        if ($inputs = $this->request->getParsedBody()) {
            $this->flash->addMessage('form.inputs', serialize(array_filter($inputs)));
        }
    }

    /**
     * Add Form alert
     *
     * @param string $type
     * @param string $message
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
        ], 'section::alert');

        foreach ($errors as $field => $error) {
            $this->flash->addMessage('validation._errors.'.$field, implode(', ', $error));
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
        ], 'section::captcha');

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

    /**
     * Set Username and Photo to header template
     *
     */
    protected function setHeaderLogin()
    {
        $profile = (new Users())->getProfile();

        $this->view->addData([
            'header_photo' => $profile['photo'],
            'header_username' => $profile['username'],
        ], 'section::header');
    }
}
