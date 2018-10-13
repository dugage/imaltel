<?php
if (!defined( 'BASEPATH')) exit('No direct script access allowed');
/*
	@rol = almacena el rol del usuario logeado
	@uriCheck = es un array donde almacenamos key:las urls donde queremos contrlar los accesos => value: los roles que no tienen permiso.
	@uri = variable donde almacenasmos la url actual donde se encuentra el usuario
*/
class Permission
{
    private $CI;
  	private $rol = 0;
  	private $uriCheck = array();
  	private $uri = '';

    function __construct()
    {

      	$this->CI =& get_instance();
  		$this->CI->load->helper('url');
  		$this->CI->load->database();

  		if(!isset($this->CI->session))
  		{
  			$this->CI->load->library('session');
  		}

  		$this->uriCheck = array(

  				'biblioteca' => '0',
  				'registros' => '3',
  		);

  		$this->rol = $this->CI->session->userdata('rol');
  		$this->uri = $this->CI->uri->uri_string();

    }

	public function check_permission()
	{

		if((array_key_exists($this->uri, $this->uriCheck)))
		{
			$rols = explode(',', $this->uriCheck[$this->uri]);

			foreach ($rols as $key => $value) {
				
				if($this->rol == $value)
				{
					redirect('no-permission');
				}
				
			}

		}
	}

}
