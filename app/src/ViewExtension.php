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
     * @param Slim\Http\Request $request
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

        $engine->registerFunction('parsedBodyParam', [$this->request, 'getParsedBodyParam']);
        $engine->registerFunction('formInputSelect', [$this, 'inputSelect']);
        $engine->registerFunction('formFieldError', [$this, 'showFieldError']);

        $engine->registerFunction('userPhoto', [$this, 'userPhoto']);
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

    public function inputSelect($name, array $data, array $attributes = [])
    {
        $default = isset($attributes['default']) ? $attributes['default'] : null;
        $reqParam = $this->request->getParsedBodyParam($name, $default);
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
            if ($key == $reqParam) {
                $selected = ' selected="selected"';
            }

            $elements[] = '<option value="'.$key.'"'.$selected.'>'.$value.'</option>';
        }

        $elements[] = '</select>';
        return implode('', $elements);
    }

    public function showFieldError($name)
    {
        if ($error = $this->flash->getMessage('validation.errors.'.$name)) {
            return '<p class="error">'.implode(', ', $error).'</p>';
        }
    }
}
