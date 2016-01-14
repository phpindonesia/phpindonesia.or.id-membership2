<?php
namespace League\Plates\Extension;

use \League\Plates\Engine;
use LogicException;
use \Psr\Http\Message\UriInterface;

class PlatesUriExtension implements ExtensionInterface {

    /**
     * The Slim's request URI Object.
     * @var \Psr\Http\Message\UriInterface
     */
    protected $uri;

    protected $router;

    protected $parts;

    protected $settings;

    public function __construct(UriInterface $uri, $router, $settings) {
        $this->uri = $uri;
        $this->router = $router;
        $this->settings = $settings;
        $path = null;

        if ($this->uri->getBasePath() != '') {
            $path = $this->uri->getPath();
        } else {
            $path = ltrim($this->uri->getPath(), '/');
        }

        $this->parts = explode('/', $path);
    }

    /**
     * Register extension functions.
     * @return null
     */
    public function register(Engine $engine)
    {
        $engine->registerFunction('uri_scheme', array($this, 'scheme'));
        $engine->registerFunction('uri_host', array($this, 'host'));
        $engine->registerFunction('uri_port', array($this, 'port'));
        $engine->registerFunction('uri_path', array($this, 'path'));
        $engine->registerFunction('uri_basepath', array($this, 'basePath'));
        $engine->registerFunction('uri_query', array($this, 'query'));
        $engine->registerFunction('uri_query_params', array($this, 'queryParams'));
        $engine->registerFunction('uri_match', array($this, 'runUri'));
        $engine->registerFunction('uri_path_for', array($this, 'pathFor'));
        $engine->registerFunction('uri_base_url', array($this, 'baseUrl'));
        $engine->registerFunction('uri_user_photo', array($this, 'userPhoto'));
    }

    public function pathFor($name, $data = [], $queryParams = [], $appName = 'default') {
        return $this->router->pathFor($name, $data, $queryParams);
    }

    public function baseUrl() {
        if (is_string($this->uri)) {
            return $this->uri;
        }

        if (method_exists($this->uri, 'getBaseUrl')) {
            return $this->uri->getBaseUrl();
        }
    }

    public function userPhoto($public_id = null, $options = [])
    {
        $default = $this->baseUrl().'/public/images/team.png';
        if (null === $public_id) {
            return $default;
        }

        try {
            $options += [
                'tags' => 'user-avatar',
                'crop' => 'fill',
            ];

            $cdn_upload_path = 'phpindonesia/'.$this->settings['mode'].'/';
            return \Cloudinary::cloudinary_url($cdn_upload_path.$public_id, $options);

        } catch (\Exception $e) {
            return $default;
        }
    }

    public function scheme() {
        return $this->uri->getScheme();
    }

    public function host() {
        return $this->uri->getHost();
    }

    public function port() {
        return $this->uri->getPort();
    }

    public function path() {
        return $this->uri->getPath();
    }

    public function basePath() {
        return $this->uri->getBasePath();
    }

    public function query() {
        return $this->uri->getQuery();
    }

    public function queryParams() {
        return $this->uri->getQueryParams();
    }

    /**
     * Perform URI check.
     * @param  null|integer|string $var1
     * @param  mixed               $var2
     * @param  mixed               $var3
     * @param  mixed               $var4
     * @return mixed
     */
    public function runUri($var1 = null, $var2 = null, $var3 = null, $var4 = null)
    {
        if (is_null($var1)) {
            return $this->uri->getPath();
        }

        if (is_numeric($var1) and is_null($var2)) {
            return $this->parts[$var1];
        }

        if (is_numeric($var1) and is_string($var2)) {
            return $this->checkUriSegmentMatch($var1, $var2, $var3, $var4);
        }

        if (is_string($var1)) {
            return $this->checkUriRegexMatch($var1, $var2, $var3);
        }

        throw new LogicException('Invalid use of the uri function.');
    }

    /**
     * Perform a URI segment match.
     * @param  integer $key
     * @param  string  $string
     * @param  mixed   $returnOnTrue
     * @param  mixed   $returnOnFalse
     * @return mixed
     */
    protected function checkUriSegmentMatch($key, $string, $returnOnTrue = null, $returnOnFalse = null)
    {
        if (isset($this->parts[$key]) && $this->parts[$key] === $string) {
            return is_null($returnOnTrue) ? true : $returnOnTrue;
        } else {
            return is_null($returnOnFalse) ? false : $returnOnFalse;
        }
    }

    /**
     * Perform a regular express match.
     * @param  string $regex
     * @param  mixed  $returnOnTrue
     * @param  mixed  $returnOnFalse
     * @return mixed
     */
    protected function checkUriRegexMatch($regex, $returnOnTrue = null, $returnOnFalse = null)
    {
        if (preg_match('#^' . $regex . '$#', $this->uri) === 1) {
            return is_null($returnOnTrue) ? true : $returnOnTrue;
        } else {
            return is_null($returnOnFalse) ? false : $returnOnFalse;
        }
    }

}
