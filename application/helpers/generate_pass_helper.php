<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Benjamín García
 *
 * @package	CodeIgniter
 * @author	Benjamín García
 * @copyright	Benjamín García
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link
 * @since	Version 1.0.0
 */


/**
 * Info images Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Benjamín García
 */

// ------------------------------------------------------------------------

if ( !function_exists('generate_password'))
{
	/**
	 *This function return the widht of image
	 * @param	$str -> string
	 * @param	$pass -> password
	 * @param	$size -> size of pass
	 * @return	the generated password
	 */
	function generate_password()
	{
		
		$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890/()?";
		$pass = "";
		$size = rand(9,16);
		
		for($i=0;$i<$size;$i++) {
			
			$pass .= substr($str,rand(0,66),1);
			
		}
		
		return $pass;
		
	}
}

?>