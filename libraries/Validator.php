<?php
namespace App\Libraries;

use \League\Plates\Engine;

class Validator {
	protected $validator;
	protected $plates;

	public function __construct(Engine $plates) {
		$this->plates = $plates;
	}

	public function createInput(array $input) {
		$this->validator = new \Valitron\Validator($input);
	}

	public function addNewRule($rule_name, $callback, $message) {
		\Valitron\Validator::addRule($rule_name, $callback, $message);
	}

	public function rule($rule, $fields) {
		$num_args = func_num_args();
		$args = func_get_args();

		if ($num_args == 3) {
			$this->validator->rule($rule, $fields, $args[2]);
		} else if ($num_args == 4) {
			$this->validator->rule($rule, $fields, $args[2], $args[3]);
		} else if ($num_args == 5) {
			$this->validator->rule($rule, $fields, $args[2], $args[3], $args[4]);
		} else {
			$this->validator->rule($rule, $fields);
		}
	}

	public function errors() {
		return $this->validator->errors();
	}

	public function validate() {
		if ($this->validator->validate()) {
			return true;
		}

		$this->plates->addData(array('_view_validation_errors_' => $this->validator->errors()));
		return false;
	}
}