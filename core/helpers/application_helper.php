<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Bonfire
 *
 * An open source project to allow developers get a jumpstart their development of CodeIgniter applications
 *
 * @package   Bonfire
 * @author    Bonfire Dev Team
 * @copyright Copyright (c) 2011 - 2013, Bonfire Dev Team
 * @license   http://guides.cibonfire.com/license.html
 * @link      http://cibonfire.com
 * @since     Version 1.0
 * @filesource
 */

/**
 * Application Helpers
 *
 * Pulls together various helper functions from across the core modules
 * to ease editing and minimize physical files that need loaded.
 *
 * @package    Bonfire
 * @subpackage Helpers
 * @category   Helpers
 * @author     Bonfire Dev Team
 * @link       http://guides.cibonfire.com/helpers/application_helpers.html
 *
 */

if(!function_exists('is_home')) {
    function is_home() {
        global $URI;
        if($URI->uri_string()=='')
            return true;
        else
            return false;
    }
}

if ( ! function_exists('showStatus')) {
    function showStatus($status) {
        $class = '';
        switch ($status)
        {
            case 1:
                $class = " label-success";
                break;
            case 0:
            default:
                $class = " label-warning";
                break;

        }
        $str="<span class='label {$class}'>";
        if ($status == 1)
        {
            $str.=lang('Active');
        }
        else
        {
            $str.=lang('Deactive');
        }
        $str.='</span>';
        return $str;
    }
}

if(!function_exists('strToDate')) {
    function strToDate($var='',$time='') {
        return implode("-", array_reverse(explode("/", $var))).$time;
    }
}
if(!function_exists('dateToStr')) {
    function dateToStr($date='') {
        if($date!='' AND $date!='0000-00-00') {
            return date("d/m/Y",strtotime($date));
        }
    }
}

if(!function_exists('datetimeToStr')) {
    function datetimeToStr($date='') {
        if($date!='' AND $date!='0000-00-00 00:00:00') {
            return date("d/m/Y H:i:s",strtotime($date));
        }
    }
}


//--------------------------------------------------------------------
// Module Functions
//--------------------------------------------------------------------

if ( ! function_exists('module_folders'))
{
	/**
	 * Returns an array of the folders that modules are allowed to be stored in.
	 * These are set in *bonfire/application/third_party/MX/Modules.php*.
	 *
	 * DEPRECATED in 0.7.1. Use Modules::folders() instead.
	 *
	 * @return array The folders that modules are allowed to be stored in.
	 */
	function module_folders()
	{
		return config_item('modules_locations');
	}
}

//--------------------------------------------------------------------

if ( ! function_exists('module_list'))
{
	/**
	 * Returns a list of all modules in the system.
	 *
	 * DEPRECATED in 0.7.1. Use Modules::list() instead.
	 *
	 * @param bool $exclude_core Whether to exclude the Bonfire core modules or not
	 *
	 * @return array A list of all modules in the system.
	 */
	function module_list($exclude_core=false)
	{
		return Modules::list_modules($exclude_core);
	}
}

//--------------------------------------------------------------------

if ( ! function_exists('module_controller_exists'))
{
	/**
	 * Determines whether a controller exists for a module.
	 *
	 * DEPRECATED in 0.7.1. Use Modules::controller_exists() instead.
	 *
	 * @param $controller string The name of the controller to look for (without the .php)
	 * @param $module string The name of module to look in.
	 *
	 * @return boolean
	 */
	function module_controller_exists($controller=null, $module=null)
	{
		return Modules::controller_exists($controller, $module);
	}
}

//--------------------------------------------------------------------

if ( ! function_exists('module_file_path'))
{
	/**
	 * Finds the path to a module's file.
	 *
	 * DEPRECATED in 0.7.1. Use Modules::file_path() instead.
	 *
	 * @param $module string The name of the module to find.
	 * @param $folder string The folder within the module to search for the file (ie. controllers).
	 * @param $file string The name of the file to search for.
	 *
	 * @return string The full path to the file.
	 */
	function module_file_path($module=null, $folder=null, $file=null)
	{
		return Modules::file_path($module, $folder, $file);
	}
}

//--------------------------------------------------------------------

if( ! function_exists('module_path'))
{
	/**
	 * Returns the path to the module and it's specified folder.
	 *
	 * DEPRECATED in 0.7.1. Use Modules::file_path() instead.
	 *
	 * @param $module string The name of the module (must match the folder name)
	 * @param $folder string The folder name to search for. (Optional)
	 *
	 * @return string The path, relative to the front controller.
	 */
	function module_path($module=null, $folder=null)
	{
		return Modules::path($module, $folder);
	}
}

//--------------------------------------------------------------------

if ( ! function_exists('module_files'))
{
	/**
	 * Returns an associative array of files within one or more modules.
	 *
	 * @param $module_name string If not NULL, will return only files from that module.
	 * @param $module_folder string If not NULL, will return only files within that folder of each module (ie 'views')
	 * @param $exclude_core boolean Whether we should ignore all core modules.
	 *
	 * @return array An associative array, like: array('module_name' => array('folder' => array('file1', 'file2')))
	 */
	function module_files($module_name=null, $module_folder=null, $exclude_core=false)
	{
		return Modules::files($module_name, $module_folder, $exclude_core);
	}
}

//--------------------------------------------------------------------

if ( ! function_exists('module_config'))
{
	/**
	 * Returns the 'module_config' array from a modules config/config.php
	 * file. The 'module_config' contains more information about a module,
	 * and even provide enhanced features within the UI. All fields are optional
	 *
	 * @author Liam Rutherford (http://www.liamr.com)
	 *
	 * <code>
	 * $config['module_config'] = array(
	 * 	'name'			=> 'Blog', 			// The name that is displayed in the UI
	 *	'description'	=> 'Simple Blog',	// May appear at various places within the UI
	 *	'author'		=> 'Your Name',		// The name of the module's author
	 *	'homepage'		=> 'http://...',	// The module's home on the web
	 *	'version'		=> '1.0.1',			// Currently installed version
	 *	'menu'			=> array(			// A view file containing an <ul> that will be the sub-menu in the main nav.
	 *		'context'	=> 'path/to/view'
	 *	)
	 * );
	 * </code>
	 *
	 * DEPRECATED in 0.7.1. Use Modules::config() instead.
	 *
	 * @param $module_name string The name of the module.
	 * @param $return_full boolean If true, will return the entire config array. If false, will return only the 'module_config' portion.
	 *
	 * @return array An array of config settings, or an empty array if empty/not found.
	 */
	function module_config($module_name=null, $return_full=false)
	{
		return Modules::config($module_name, $return_full);
	}
}

//--------------------------------------------------------------------
// Misc. Helpers
//--------------------------------------------------------------------

if ( ! function_exists('dump'))
{
	/**
	 * Outputs the given variables with formatting and location. Huge props
	 * out to Phil Sturgeon for this one (http://philsturgeon.co.uk/blog/2010/09/power-dump-php-applications).
	 * To use, pass in any number of variables as arguments.
	 *
	 * @return void
	 */
	function dump()
	{
		list($callee) = debug_backtrace();
		$arguments = func_get_args();
		$total_arguments = count($arguments);

		echo '<fieldset style="background:#fefefe !important; border:2px red solid; padding:5px">' . PHP_EOL .
			'<legend style="background:lightgrey; padding:5px;">' . $callee['file'] . ' @ line: ' . $callee['line'] . '</legend>' . PHP_EOL .
			'<pre>';

	    $i = 0;
	    foreach ($arguments as $argument)
	    {
			echo '<br/><strong>Debug #' . (++$i) . ' of ' . $total_arguments . '</strong>: ';

			if ( (is_array($argument) || is_object($argument)) && count($argument))
			{
				print_r($argument);
			}
			else
			{
				var_dump($argument);
			}
		}

		echo '</pre>' . PHP_EOL .
			'</fieldset>' . PHP_EOL;
	}
}

//--------------------------------------------------------------------

if ( ! function_exists('e'))
{
	/**
	 * A convenience function to make sure your output is safe to display.
	 * Helps to defeat XSS attacks by running the text through htmlspecialchars().
	 *
	 * Should be used anywhere you are displaying user-submitted text.
	 *
	 * @param String $str The text to process and output
	 *
	 * @return void
	 */
	function e($str)
	{
		echo htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
	}
}

//--------------------------------------------------------------------

if ( ! function_exists('js_escape'))
{
	/**
	 * Like html_escape() for JavaScript string literals.
	 *
	 * Inside attributes like onclick, you need to use
	 * html_escape() *as well*. Inside script tags,
	 * html_escape() would do the wrong thing, and
	 * js_escape is enough on it's own.
	 *
	 * Useful for confirm() or alert() - but of course not
	 * document.write() or similar, so take care.
	 *
	 * @param String $str The string to process
	 *
	 * @return String    The escaped string
	 */
	function js_escape($str)
	{
		/*
		$escape =
			// Obvious string literal escapes:
			'\'' . "\"" . "\\" .

			// Newlines could also break the literal;
			// escape all the C0 controls including \r\n
			"\0..\037" .

			// Escape </script> - n.b. '<' alone wouldn't work.
			// This works for HTML - XHTML would need much more here.
			"\/";
		*/

		return addcslashes($str, "\"'\\\0..\037\/");
	}
}

//--------------------------------------------------------------------

if ( ! function_exists('array_implode'))
{
	/**
	 * Implode an array with the key and value pair giving a glue,
	 * a separator between pairs and the array to implode.
	 *
	 * Encode Query Strings
	 * @example $query = url_encode( array_implode( '=', '&', $array ) );
	 *
	 * @param string $glue      The glue between key and value.
	 * @param string $separator Separator between pairs.
	 * @param array  $array     The array to implode.
	 *
	 * @return string A string with the combined elements.
	 */
	function array_implode($glue, $separator, $array)
	{
		if ( ! is_array( $array ) )
		{
			return $array;
		}

		$string = array();

		foreach ( $array as $key => $val )
		{
			if ( is_array( $val ) )
			{
				$val = implode( ',', $val );
			}

			$string[] = "{$key}{$glue}{$val}";
		}

		return implode( $separator, $string );

	}//end array_implode()
}
//--------------------------------------------------------------------

if ( ! function_exists('obj_value'))
{
	/**
	 *
	 * @param object $obj   Object
	 * @param string $key   Name of the object element
	 * @param string $type  Input type
	 * @param int    $value Value to check the key against
	 *
	 * @return null|string
	 */
	function obj_value($obj, $key, $type='text', $value=0)
	{
		if (isset($obj->$key))
		{
			switch ($type)
			{
				case 'checkbox':
				case 'radio':
					if ($obj->$key == $value)
					{
						return 'checked="checked"';
					}
					break;

				case 'select':
					if ($obj->$key == $value)
					{
						return 'selected="selected"';
					}
					break;

				case 'text':
				default:
					return $obj->$key;
			}
		}

		return null;

	}//end obj_value()
}
//--------------------------------------------------------------------

if ( ! function_exists('iif'))
{
	/**
	* If then Else Statement wrapped in one function, If $expression = true then $returntrue else $returnfalse
	*
	* @param mixed $expression    IF Statement to be checked
	* @param mixed $returntrue    What to Return on True
	* @param mixed $returnfalse   What to Return on False
	* @param bool  $echo          Defaults to false, if set to true will echo instead of return
	*
	* @return mixed    If echo is set to true will echo the value of the expression, defaults to returning the value
	*/
	function iif($expression, $returntrue, $returnfalse = '', $echo = false )
	{
		$return = $expression ? $returntrue : $returnfalse;

        if ( $echo === false ) {
            return $return;
        }

        echo $return;
	}//end iif()
}

if(!function_exists('getAvatar')) {
    function getAvatar($url) {
        if(is_file($url)) {
            return image_url($url);
        }
        else {
            $ci =&get_instance();
            return image_url($ci->config->item('avatar_default'));
        }
    }
}

//--------------------------------------------------------------------



//--------------------------------------------------------------------