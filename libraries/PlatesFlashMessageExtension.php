<?php
namespace League\Plates\Extension;

use \League\Plates\Engine;

class PlatesFlashMessageExtension implements ExtensionInterface {
	protected $flash;

	public function __construct($flash) {
		$this->flash = $flash;
	}

	/**
     * Register extension functions.
     * @return null
     */
    public function register(Engine $engine) {
        $engine->registerFunction('flash_messages', array($this, 'flashMessages'));
    }

	public function flashMessages() {
		return $this->flash->getMessages();
	}

}
