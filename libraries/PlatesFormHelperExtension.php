<?php
namespace League\Plates\Extension;

use \League\Plates\Engine;

class PlatesFormHelperExtension implements ExtensionInterface {

	protected $requestType;

	public function __construct($requestType) {
		$this->requestType = $requestType;
	}

	/**
     * Register extension functions.
     * @return null
     */
    public function register(Engine $engine) {
        $engine->registerFunction('fh_default_val', array($this, 'fhDefaultVal'));
        $engine->registerFunction('fh_input_select', array($this, 'fhInputSelect'));
        $engine->registerFunction('fh_error_css_class', array($this, 'fhErrorCssClass'));
        $engine->registerFunction('fh_show_errors', array($this, 'fhShowErrors'));
    }

    public function fhDefaultVal($name, $def_val = null, $handle_get_req = false) {
    	if ($this->requestType == 'GET') {
            if ($def_val) {
                return $def_val;
            } else {
                if ($handle_get_req) {
                    return isset($_GET[$name]) ? $_GET[$name] : '';
                }
            }
    		
    	} else if ($this->requestType == 'POST') {
    		return isset($_POST[$name]) ? $_POST[$name] : $def_val;
    	}

    	return false;
    }

    public function fhInputSelect($name, array $data, array $select_attrs = array()) {
    	$default_value = null;
    	if (isset($select_attrs['default'])) {
    		$default_value = $this->fhDefaultVal($name, $select_attrs['default'], true);
    	} else {
            $default_value = $this->fhDefaultVal($name, null, true);
        }

    	unset($select_attrs['default']);
        unset($select_attrs['name']);
        
    	$elements = array();
    	$str = '<select name="'.$name.'"';
    	foreach ($select_attrs as $key => $value) {
    		$str .= ' '.$key.'="'.$value.'"';
    	}

    	$str .= '>';
    	$elements[0] = $str;
    	$elements[1] = '<option value="" selected="selected">-- Pilih --</option>';

    	$key_selected = false;
    	$idx_start = 2;
    	foreach ($data as $key => $value) {
    		if ($key == $default_value) {
    			$key_selected = true;
    			$elements[$idx_start] = '<option value="'.$key.'" selected="selected">'.$value.'</option>';
    		} else {
    			$elements[$idx_start] = '<option value="'.$key.'">'.$value.'</option>';
    		}

    		$idx_start++;
    	}

    	if ($key_selected) {
    		$elements[1] = '<option value="">-- Pilih --</option>';
    	}

    	$elements[$idx_start] = '</select>';
    	return implode('', $elements);
    }

    public function fhErrorCssClass($name, $error_css_class, array $errors) {
        if (is_array($errors)) {
            if (isset($errors[$name])) {
                return $error_css_class;
            }
        }

        return '';
    }

    public function fhShowErrors($name, array $errors) {
        $errors_str = '';
        if (is_array($errors)) {
            if (isset($errors[$name])) {
                foreach ($errors[$name] as $item) {
                    $errors_str .= '<label class="error">'.$item.'</label><br />';
                }
            }
        }

        return $errors_str;
    }
}