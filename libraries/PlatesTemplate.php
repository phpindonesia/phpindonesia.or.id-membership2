<?php
namespace Slim\Views;

use Psr\Http\Message\ResponseInterface;

class PlatesTemplate implements \ArrayAccess {
    protected $plates;
    protected $defaultVariables = [];

    public function __construct($template_path, $settings = []) {
        $this->plates = new \League\Plates\Engine($template_path);
    }

    public function loadExtension(\League\Plates\Extension\ExtensionInterface $extension) {
        $this->plates->loadExtension($extension);
    }

    public function addFolder($folder_name, $path_to_folder) {
        $this->plates->addFolder($folder_name, $path_to_folder);
    }

    /**
     * Fetch rendered template
     *
     * @param  string $template Template pathname relative to templates directory
     * @param  array  $data     Associative array of template variables
     *
     * @return string
     */
    public function fetch($template, $data = []) {
        $data = array_merge($this->defaultVariables, $data);
        $tpl_object = $this->plates->make($template);
        $tpl_object->data($data);

        return $tpl_object->render();
    }

    /**
     * Output rendered template
     *
     * @param ResponseInterface $response
     * @param  string $template Template pathname relative to templates directory
     * @param  array $data Associative array of template variables
     * @return ResponseInterface
     */
    public function render(ResponseInterface $response, $template, $data = []) {
        $response->getBody()->write($this->fetch($template, $data));
        return $response;
    }

    public function getPlates() {
        return $this->plates;
    }

    /********************************************************************************
     * ArrayAccess interface
     *******************************************************************************/

    /**
     * Does this collection have a given key?
     *
     * @param  string $key The data key
     *
     * @return bool
     */
    public function offsetExists($key) {
        return array_key_exists($key, $this->defaultVariables);
    }

    /**
     * Get collection item for key
     *
     * @param string $key The data key
     *
     * @return mixed The key's value, or the default value
     */
    public function offsetGet($key) {
        return $this->defaultVariables[$key];
    }

    /**
     * Set collection item
     *
     * @param string $key   The data key
     * @param mixed  $value The data value
     */
    public function offsetSet($key, $value) {
        $this->defaultVariables[$key] = $value;
    }

    /**
     * Remove item from collection
     *
     * @param string $key The data key
     */
    public function offsetUnset($key) {
        unset($this->defaultVariables[$key]);
    }

    /********************************************************************************
     * Countable interface
     *******************************************************************************/

    /**
     * Get number of items in collection
     *
     * @return int
     */
    public function count() {
        return count($this->defaultVariables);
    }

    /********************************************************************************
     * IteratorAggregate interface
     *******************************************************************************/

    /**
     * Get collection iterator
     *
     * @return \ArrayIterator
     */
    public function getIterator() {
        return new \ArrayIterator($this->defaultVariables);
    }

}
