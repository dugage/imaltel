<?php 
/**
 *
 *
 * @package	CodeIgniter
 * @author	Benjamín García
 * @copyright	''
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	''
 * @since	Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter Documents Control Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Dugage Team
 * @link		https://dugage.com
 * 
 */
if ( ! function_exists('documents_control') )
{
    /*
    *Determina mediante consulta, si el cliente tiene como mínimo la documentoación
    *mínima requerida
    */
    function documents_control($id = 0) 
    {
        $result = true;
        //vector que contiene el listado de tipo de documentos requierdos
        $docuClose = array(

            "FACTURA" => 'FACTURA',
            "COBERTURA" => 'COBERTURA',
            "HERRAMIENTAS" => 'HERRAMIENTAS'
        );
        //hacemos uso de get_instance para poder utilizar desde
        //este espacio las librerías
        $CI =& get_instance();
        //cargamos la librería para conectarnos a la base de datos y utilizar
        //el query builder
        $CI->load->database();
        //medobtenemos toda la documentación del cliente
        $documents = $CI->db->get_where('attachments', array('tableRow' => 'cuentas','idRow' => $id));
        //recorremos la coleccón de documentos, comprobamos si hay coincidencia con los almacenados en 
        //el vector
        foreach ($documents->result() as $key => $document) {
            
            if( in_array($document->tipoDocumento, $docuClose) ) {
                //borramos el registro si hay coincidencia
                unset($docuClose[$document->tipoDocumento]);

            }
        }
        //si el vector $docuClose es igual a 0, result = false.
        if( count($docuClose) == 0 )
            $result = false;

        //devolvemos un verdadero o falso, donde  verdadero será que tiene pagos pendientes
        return $result;
    }
}
