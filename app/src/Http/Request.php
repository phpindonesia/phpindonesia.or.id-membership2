<?php

namespace Membership\Http;

use Membership\Collection;
use Membership\Models;
use Valitron\Validator;

class Request extends \Slim\Http\Request
{
    /**
     * @var Validator|null
     */
    protected $validator = null;

    /**
     * @param callable $validator
     * @return static
     */
    public function setValidator($validator)
    {
        $this->validator = $validator($this);

        return $this;
    }

    public function rules($rules, $fields = [])
    {
        if (is_string($rules) && $fields) {
            $this->validator->rule($rules, $fields);
        } else {
            $this->validator->rules($rules);
        }

        return $this;
    }

    /**
     * Validate request based on model rules
     *
     * @param callable|Models $model
     * @param callable|null $callback
     * @return Collection
     * @throws ValidatorException
     */
    public function validate($model, callable $callback = null)
    {
        if (null === $this->validator) {
            return null;
        }

        if ($model instanceof Models && is_callable($callback)) {
            $rules = method_exists($model, 'rules') && is_callable([$model, 'rules'])
                ? $model->rules($this->validator)
                : [];

            $this->validator->rules($rules);
        } elseif (is_callable($model)) {
            $callback = $model;
        }

        if (! $this->validator->validate()) {
            throw new ValidatorException('Invalid request input', $this->validator->errors());
        }

        $input = new Collection($this->getParsedBody());

        if ($callback) {
            return $model instanceof Models ? $callback($input, $model) : $callback($input);
        }

        return $input;
    }
}
