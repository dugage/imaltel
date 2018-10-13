<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['panel'] = 'home';
//pruebas
$route['panel/pruebas'] = 'home/pruebas';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
//rutas configuración
$route['configuracion/roles'] = 'roles';
$route['configuracion/roles/add'] = 'roles/add';
$route['configuracion/roles/edit/(:num)'] = 'roles/edit/$1';
$route['configuracion/roles/delete/(:num)'] = 'roles/delete/$1';
//rutas fase_ventas
$route['configuracion/fases-venta'] = 'fase_ventas';
$route['configuracion/fases-venta/add'] = 'fase_ventas/add';
$route['configuracion/fases-venta/edit/(:num)'] = 'fase_ventas/edit/$1';
$route['configuracion/fases-venta/delete/(:num)'] = 'fase_ventas/delete/$1';
//rutas estados_registros
$route['configuracion/estados-registros'] = 'estados_registros';
$route['configuracion/estados-registros/add'] = 'estados_registros/add';
$route['configuracion/estados-registros/edit/(:num)'] = 'estados_registros/edit/$1';
$route['configuracion/estados-registros/delete/(:num)'] = 'estados_registros/delete/$1';
//rutas operadores
$route['configuracion/operadores'] = 'operadores';
$route['configuracion/operadores/add'] = 'operadores/add';
$route['configuracion/operadores/edit/(:num)'] = 'operadores/edit/$1';
$route['configuracion/operadores/delete/(:num)'] = 'operadores/delete/$1';
//rutas estados_registros
$route['configuracion/estados-seguimiento'] = 'estados_seguimiento';
$route['configuracion/estados-seguimiento/add'] = 'estados_seguimiento/add';
$route['configuracion/estados-seguimiento/edit/(:num)'] = 'estados_seguimiento/edit/$1';
$route['configuracion/estados-seguimiento/delete/(:num)'] = 'estados_seguimiento/delete/$1';
//rutas tipos documentos
$route['configuracion/tipos-documentos'] = 'tipos_documentos';
$route['configuracion/tipos-documentos/add'] = 'tipos_documentos/add';
$route['configuracion/tipos-documentos/edit/(:num)'] = 'tipos_documentos/edit/$1';
$route['configuracion/tipos-documentos/delete/(:num)'] = 'tipos_documentos/delete/$1';


// rutas usuarios
$route['usuario'] = 'usuarios';
$route['usuario/add'] = 'usuarios/add';
$route['usuario/edit/(:num)'] = 'usuarios/edit/$1';
$route['usuario/delete/(:num)'] = 'usuarios/delete/$1';

//rutas registros
$route['registros'] = 'registros';
$route['registros/(:num)/(:num)'] = 'registros';
$route['registros/add'] = 'registros/add';
$route['registros/edit/(:num)'] = 'registros/edit/$1';
$route['registros/delete/(:num)'] = 'registros/delete/$1';
$route['registros/view/(:num)'] = 'registros/view/$1';
$route['registros/upload_registers/(:any)'] = 'registros/upload_registers/$1';

// rutas cuentas
$route['clientes'] = 'clientes';
$route['clientes/(:num)'] = 'clientes';
$route['cuentas/add'] = 'cuenta/add';
$route['cuentas/edit/(:num)'] = 'cuenta/edit/$1';
$route['cuentas/delete/(:num)'] = 'cuenta/delete/$1';
$route['cuentas/view/(:num)'] = 'cuenta/view/$1';
$route['clientes/delete-att/(:num)/(:num)'] = 'clientes/delete_att/$1/$2';

//rutas oportunidades
$route['oportunidades'] = 'oportunidades';
$route['oportunidades/(:num)'] = 'oportunidades';
$route['oportunidades/add'] = 'oportunidades/add';
$route['oportunidades/edit/(:num)'] = 'oportunidades/edit/$1';
$route['oportunidades/delete/(:num)'] = 'oportunidades/delete/$1';
$route['oportunidades/view/(:num)'] = 'oportunidades/view/$1';

//rutas calendario
$route['calendario/get_calendar/(:num)/(:num)'] = 'calendario/get_calendar/$1/$2';

//rutas precontactos
$route['precontactos/export/(:num)'] = 'precontactos/export/$1';
//rutas tarifas
$route['tarifas/grupos'] = 'tarifas_grupos';
$route['tarifas/grupos/add'] = 'tarifas_grupos/add';
$route['tarifas/grupos/edit/(:num)'] = 'tarifas_grupos/edit/$1';
$route['tarifas/grupos/delete/(:num)'] = 'tarifas_grupos/delete/$1';

$route['tarifas/origenes'] = 'tarifas_origenes';
$route['tarifas/origenes/add'] = 'tarifas_origenes/add';
$route['tarifas/origenes/edit/(:num)'] = 'tarifas_origenes/edit/$1';
$route['tarifas/origenes/delete/(:num)'] = 'tarifas_origenes/delete/$1';

$route['tarifas/terminales'] = 'tarifas_terminales';
$route['tarifas/terminales/add'] = 'tarifas_terminales/add';
$route['tarifas/terminales/edit/(:num)'] = 'tarifas_terminales/edit/$1';
$route['tarifas/terminales/delete/(:num)'] = 'tarifas_terminales/delete/$1';

$route['tarifas/paquetes'] = 'tarifas_paquetes';
$route['tarifas/paquetes/add'] = 'tarifas_paquetes/add';
$route['tarifas/paquetes/edit/(:num)'] = 'tarifas_paquetes/edit/$1';
$route['tarifas/paquetes/delete/(:num)'] = 'tarifas_paquetes/delete/$1';

$route['tarifas/tarifas'] = 'tarifas_tarifas';
$route['tarifas/tarifas/add'] = 'tarifas_tarifas/add';
$route['tarifas/tarifas/edit/(:num)'] = 'tarifas_tarifas/edit/$1';
$route['tarifas/tarifas/delete/(:num)/(:num)'] = 'tarifas_tarifas/delete/$1/$2';
$route['tarifas/tarifas/delete/(:num)'] = 'tarifas_tarifas/delete/$1';

$route['archivador'] = 'biblioteca';
$route['archivador/newFolder'] = 'biblioteca/newFolder';
$route['archivador/deleteFolder'] = 'biblioteca/deleteFolder';
$route['archivador/deleteFile'] = 'biblioteca/deleteFile';

//ruta no permission
$route['no-permission'] = 'maincontroller/no_permission';
