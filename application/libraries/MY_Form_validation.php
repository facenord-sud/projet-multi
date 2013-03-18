<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
// ------------------------------------------------------------------------

/**
 * Form Validation Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Validation
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/form_validation.html
 */
class MY_Form_validation extends CI_Form_validation {

    protected $_error_prefix = '<div class="form_error">';
    protected $_error_suffix = '</div>';

//    function MY_Form_validation() {
//        parent::CI_Form_validation();
//    }

    /**
     * Enumerate
     * Doit contenir au moins une des values énumérée
     * Par défaut, les valeur sont séparé par des ,
     * 
     * @access	public
     * @param	string
     * @param	value
     * @return	bool
     */
    public function enum($str, $val) {
        $enums = explode(',', $val);
        return in_array($str, $enums);
    }

    // --------------------------------------------------------------------
}

// END Form Validation Class

/* End of file Form_validation.php */
/* Location: ./system/libraries/Form_validation.php */
