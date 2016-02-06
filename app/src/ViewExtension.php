<?php
namespace Membership;

use League\Plates\Engine;
use League\Plates\Extension\ExtensionInterface;
use Slim\Http\Request;
use Slim\Flash\Messages as FlashMessage;

class ViewExtension implements ExtensionInterface
{
    /**
     * @var \Slim\Http\Request
     */
    protected $request;

    /**
     * @var \Slim\Flash\Messages
     */
    protected $flash;

    /**
     * @var string
     */
    protected $mode;

    /**
     * View Extention
     *
     * @param \Slim\Http\Request $request
     */
    public function __construct(Request $request, FlashMessage $flash, $mode = 'development')
    {
        $this->request = $request;
        $this->flash = $flash;
        $this->mode = $mode;
    }

    /**
     * {@inheritdoc}
     */
    public function register(Engine $engine)
    {
        // Add app view data
        $engine->addData([
            'validation_errors' => [],
            'base_js'  => [],
            'base_css' => [],
        ]);

        // Form helpers
        $engine->registerFunction('userPhoto', [$this, 'userPhoto']);
        $engine->registerFunction('requestBody', [$this, 'requestBody']);
        $engine->registerFunction('formFieldError', [$this, 'fieldError']);
        $engine->registerFunction('formInputSelect', [$this, 'inputSelect']);
        $engine->registerFunction('formInputMethod', [$this, 'inputMethod']);

        // Flash Message helpers
        $engine->registerFunction('flashMessages', [$this->flash, 'getMessages']);
        $engine->registerFunction('flashMessage', [$this->flash, 'getMessage']);

        // Register validation helpers
        $engine->registerFunction('validationErrors', function (array $errors = []) use ($engine) {
            $engine->addData(['validation_errors' => $errors]);
        });

        // Register view js helpers
        $engine->registerFunction('appendJs', function (array $jsFiles = []) use ($engine) {
            $engine->addData(['base_js' => $jsFiles]);
        });

        // Register view css helpers
        $engine->registerFunction('appendCss', function (array $cssFiles = []) use ($engine) {
            $engine->addData(['base_css' => $cssFiles]);
        });
    }

    /**
     * Retrieve user photo from CDN
     *
     * @param string $publicId User photo public ID
     * @param array  $options  CDN options
     * @return string
     */
    public function userPhoto($publicId = null, $options = [])
    {
        $default = $this->template->asset('/images/team.png');
        if (null === $publicId) {
            return $default;
        }

        try {
            $options += [
                'tags' => 'user-avatar',
                'crop' => 'fill',
            ];

            $cdnTargetPath = 'phpindonesia/'.$this->mode.'/';
            return \Cloudinary::cloudinary_url($cdnTargetPath.$publicId, $options);
        } catch (\Exception $e) {
            return $default;
        }
    }

    /**
     * Retrieve previous form input
     *
     * @param string $name    Input Name
     * @param mixed  $default Default value if Input name not available
     * @return mixed
     */
    public function requestBody($name, $default = null)
    {
        if ($formInputs = $this->flash->getMessage('form.inputs')) {
            $formInputs = unserialize($formInputs[0]);

            if (is_array($default) && isset($default[$name])) {
                $default = $default[$name];
            }

            return isset($formInputs[$name]) ? $formInputs[$name] : $default;
        }

        return $default;
    }

    /**
     * Retrieve Request method override
     *
     * @param string $method Request methods [GET|POST|PUT|DELETE]
     * @return mixed
     */
    public function inputMethod($method)
    {
        return '<input type="hidden" name="_METHOD" value="' . strtoupper($method) . '" />';
    }

    /**
     * Generate form <select> based on $data array
     *
     * @param string $name       Name attribute
     * @param array  $data       List of data
     * @param array  $attributes Optiona html attributes
     * @return string
     */
    public function inputSelect($name, array $data, array $attributes = [])
    {
        $default = isset($attributes['default']) ? $attributes['default'] : null;
        $reqInput = $this->requestBody($name, $default);
        unset($attributes['default']);

        $attrs = [];
        foreach ($attributes as $key => $value) {
            $attrs[] = $key.'="'.$value.'"';
        }

        $elements = [
            '<select name="'.$name.'"'.($attrs ? implode(' ', $attrs) : '').'>',
            '<option value="" >-- Pilih --</option>'
        ];

        foreach ($data as $key => $value) {
            $selected = '';
            if ($key == $reqInput) {
                $selected = ' selected="selected"';
            }

            $elements[] = '<option value="'.$key.'"'.$selected.'>'.$value.'</option>';
        }

        $elements[] = '</select>';
        return implode('', $elements);
    }

    /**
     * Retrieve error message each input $name
     *
     * @param string $name Input name
     * @return string
     */
    public function fieldError($name)
    {
        if ($error = $this->flash->getMessage('validation.errors.'.$name)) {
            return '<p class="alert alert-error">'.implode(', ', $error).'</p>';
        }
    }
}
