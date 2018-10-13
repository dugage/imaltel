<?php 
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registros  extends MX_Controller
{
    private $nameClass;
    private $icono;
    private $proyecto;
    private $rol = 0;
    private $usuarioid = 0;
    private $totalRecord = 0;
    private $start = 0;
    private $start2 = 0;
    private $limit = 0;

	public function __construct()
	{
		parent::__construct();
        $this->nameClass = get_class($this);
        $this->proyecto = $this->doctrine->em->find("Entities\\Proyecto", 1);
        $this->icono = 'icon-notebook';
        //helper uploads
        $this->load->helper('upload_helper');
        $this->rol = $this->session->userdata('rol');
        $this->usuarioid = $this->session->userdata('usuarioid');
        //formate la fecha para pasarla a doctrine
        $this->load->helper('format_date_doctrine_helper');
        //lo utilizamos para comprar fechas
        $this->load->helper('my_playing_dates_helper');
        //comprobamos el rol del usuario y realizamos en count segun rol
        if($this->rol == 4)
        {

            $this->totalRecord = count($this->doctrine->em->getRepository("Entities\\Registros")->findBy(["idusuario" => $this->usuarioid,"oculto" => 0]));

        }else{

            $this->totalRecord = count($this->doctrine->em->getRepository("Entities\\Registros")->findAll());
        }

        $this->limit = 100;
	}

	
    public function index()
    {
        
        //pasamos los datos básicos del template
        $data['lang'] = "es";
        $data['title'] = $this->proyecto->getNombre()." | Panel de control";
        $data['view'] = strtolower(__FUNCTION__."_".$this->nameClass);
        $data['robots'] = 'noindex, nofollow';
        $data['project'] = $this->proyecto;
        $data['reference'] = strtoupper(__FUNCTION__."-".$this->nameClass);
        //icono del módulo
        $data['icono'] = $this->icono;
        // titulo del módulo
        $data['h1'] = $this->nameClass;
        //lista migas pan
        $data['breadcrumb'] = array($this->nameClass);
        //datos cabecera tabla
        $data['thead'] = array('ID','Empresa','Teléfono','Asignado','Fecha','Estado');
        //lista de parametros de busqueda del select del buscador
        $data['searcher'] = array('Razón social' => 'empresa' ,'Provincia' => 'provincia','Población' => 'poblacion','CP' => 'cp','CIF' => 'cif','Teléfono ' => 'telefono');
        //cadena add url paginación
        $data['searcher_param'] = "";
        //parametros que pasaremos a la consulta
        $f = null;
        $q = null;

        //paginación
        //comprobamos si el parametro 1 y 2 es != null, en caso afirmativo igualamos $this->start y $this->start2 a su valor
        //$this->start == al valor con el que inicializa,
        if($this->uri->segment(2) != null)
            $this->start = $this->uri->segment(2);

        if($this->uri->segment(3) != null)
            $this->start2 = $this->uri->segment(3);
        

        //pasamos a la vista los datos de start y limit
        $data['start'] = $this->start;
        $data['start2'] = $this->start2;
        $data['limit'] = $this->limit;
        //y el previous,next
        $data['previous'] = $this->start - $this->limit;
        //si start - 
        $data['next'] = $this->start + $this->limit;
        //pasamos el totalRecord
        $data['totalRecord'] = $this->totalRecord;

        /*
        comprobamos si los parametros de busqueda f y q existen,
        en caso afirmativo creamos una cadena que pasaremos a la url
        de paginación y los parametros para la consulta
        */
        if(isset($_GET['f']) AND isset($_GET['q']))
        {
            $data['searcher_param'] = '?f='.$_GET['f'].'&q='.$_GET['q'];
            $f = $_GET['f'];
            $q = $_GET['q'];
        }


        //si el usuario tiene rol == 4 alteramos el array borrando
        //  el campo asignado

        if($this->rol == 4){
            
            unset($data['thead'][3]);
        }

        //ruta para los botones y acciones
        $data['path'] = $this->uri->segment(1);
        //pasamos el rol del usuario
        $data['rol'] = $this->rol;
        //pasamos css para esta página
        $data['css'] = $this->load->view('css_module/css_module','',TRUE);
        //pasamos js para esta página
        $data['js'] = $this->load->view('js_module/js_module','',TRUE);

        //si el usuario es teleoperador = 4
        //mostramos sólo los registros asociados a el
        if($this->rol == 4){

            $data['getResultFirst'] = $this->doctrine->em->getRepository("Entities\\Registros")->findFirstDate($this->start,$this->limit,$f,$q,$this->usuarioid);
            //Comprobamos si los resultados de getResultFirst son iguales a 100, si es asi getResult = false, en caso contrario realizamos una resta y mostraremos como limit el resultado
            if(count($data['getResultFirst']) == $this->limit)
            {
                $data['getResult'] = null;

            }else{

                //sobrescrimimos el limit para la consulta
                $this->limit =  $this->limit - count($data['getResultFirst']).'<br/>';

                $data['getResult'] = $this->doctrine->em->getRepository("Entities\\Registros")->findByStateDate($data['start2'],$this->limit,$f,$q,$this->usuarioid);
                //cambiamos el valor de start2
                $data['start2'] += $this->limit;
            }
            

        }else{

            //obtenemos y mostramos todos los datos
            $data['getResultFirst'] = $this->doctrine->em->getRepository("Entities\\Registros")->findFirstDate($this->start,$this->limit,$f,$q);
            //Comprobamos si los resultados de getResultFirst son iguales a 100, si es asi getResult = false, en caso contrario realizamos una resta y mostraremos como limit el resultado

            if(count($data['getResultFirst']) == $this->limit)
            {
                $data['getResult'] = null;

            }else{

                //sobrescrimimos el limit para la consulta
                //$this->limit =  $this->limit - count($data['getResultFirst']).'<br/>';

                $data['getResult'] = $this->doctrine->em->getRepository("Entities\\Registros")->getRegistrosLimit($this->limit,$data['start2'],$f,$q);

                //cambiamos el valor de start2
                $data['start2'] += $this->limit;
                //sobreescribimos totalrecord
                $data['totalRecord'] = count($this->doctrine->em->getRepository("Entities\\Registros")->getRegistrosLimit(0,0,$f,$q));
                //si totalRecord - start es < $this->limit entonces next = totalRecord
                if(($data['totalRecord'] - $this->start) < $this->limit)
                {
                    $data['next'] = $data['totalRecord'];
                }
                
            }
            
        }
        //obtenemos todos los usuarios con rol teleoperador/a = 4
        $data['getUsuarios'] = $this->doctrine->em->getRepository("Entities\\Usuarios")->findBy(["idrol" => 4]);
        //obtenemos la lista de estados de registros
        $data['getEstadosregistros'] = $this->doctrine->em->getRepository("Entities\\Estadosregistros")->findAll();


        //cargamos la vista
        $this->load->view('templates/panel/layout',$data);
        //si existe la variable la eliminamos
        if($this->session->userdata('endJob'))
            $this->session->unset_userdata('endJob');

    }

	public function add()
	{
		// pasamos los datos básicos del template
        $data['lang'] = "es";
        $data['title'] = $this->proyecto->getNombre() . " | Panel de control";
        $data['view'] = strtolower(__FUNCTION__ . "_" . $this->nameClass);
        $data['robots'] = 'noindex, nofollow';
        $data['project'] = $this->proyecto;
        $data['reference'] = strtoupper(__FUNCTION__ . "-" . $this->nameClass);
        //icono del módulo
        $data['icono'] = $this->icono;
        // titulo del módulo
        $data['h1'] = $this->nameClass;
        //lista migas pan
        $data['breadcrumb'] = array(str_replace('_', ' ', $this->nameClass), 'Crear ' . substr(str_replace('_', ' ', $this->nameClass), 0, -1));
        //ruta para los botones y acciones
        $data['path'] = $this->uri->segment(1);
        //pasamos el rol del usuario
        $data['rol'] = $this->rol;
        //pasamos css para esta página
        $data['css'] = $this->load->view('css_module/css_module','',TRUE);
        //pasamos js para esta página
        $data['js'] = $this->load->view('js_module/js_module','',TRUE);

        //obtenemos todos los uausrios con rol teleoperador/a = 4
        $data['getUsuarios'] = $this->doctrine->em->getRepository("Entities\\Usuarios")->findBy(["idrol" => 4]);

        //comprobamos formulario submit
        if (isset($_POST['submit'])){

            //validamos los datos
            $this->form_validation->set_rules('empresa', 'Empresa', 'required');
            $this->form_validation->set_rules('telefono', 'Teléfono', 'required');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

            if($this->form_validation->run()){

                if($this->rol != 4)
                {
                    //obtenemos el usuario seleccionado
                    $usuario = $this->doctrine->em->find("Entities\\Usuarios", $this->input->post('usuario'));

                }else{

                    //obtenemos el usuario seleccionado
                    $usuario = $this->doctrine->em->find("Entities\\Usuarios", $this->usuarioid);
                }
                
                //obtenemos el estado, en este caso siempre estado 4 al crear
                $estado = $this->doctrine->em->find("Entities\\Estadosregistros", 4);
                //obtenemos el operador, en este caso siempre estado 0 que es sin asignar
                $operador = $this->doctrine->em->find("Entities\\Operadores", 0);

                $reg = new Entities\Registros;
                //Seteamos los datos
                $reg->setEmpresa($this->input->post('empresa'));
                $reg->setNumempleados($this->input->post('numEmpleados'));
                $reg->setTelefono(str_replace(' ', '', $this->input->post('telefono')));
                $reg->setAdministrador($this->input->post('administrador'));
                $reg->setPercontacto($this->input->post('perContacto'));
                $reg->setCif($this->input->post('cif'));
                $reg->setDireccion($this->input->post('direccion'));
                $reg->setSector($this->input->post('sector'));
                $reg->setProvincia($this->input->post('provincia'));
                $reg->setPoblacion($this->input->post('poblacion'));
                $reg->setEmail($this->input->post('email'));
                $reg->setCp($this->input->post('cp'));
                $reg->setWeb($this->input->post('web'));
                $reg->setComentario($this->input->post('comentario'));
                $reg->setFregistro(new \DateTime(formatDateDoct($this->input->post('fRegistro'))));
                $reg->setIdestado($estado);
                $reg->setIdusuario($usuario);
                $reg->setIdoperador($operador);

                //guardamos la entidad en la tabla users
                $this->doctrine->em->persist($reg);
                $this->doctrine->em->flush();

                //redireccionamos al edit
                redirect(site_url($data['path'] . '/edit/' . $reg->getId()));

            }
        }
        //cargamos la vista
        $this->load->view('templates/panel/layout', $data);

	}

	public function edit($id)
	{
        //pasamos los datos básicos del template
        $data['lang'] = "es";
        $data['title'] = $this->proyecto->getNombre() . " | Panel de control";
        $data['view'] = strtolower(__FUNCTION__ . "_" . $this->nameClass);
        $data['robots'] = 'noindex, nofollow';
        $data['project'] = $this->proyecto;
        $data['reference'] = strtoupper(__FUNCTION__ . "-" . $this->nameClass);
        //icono del módulo
        $data['icono'] = $this->icono;
        //titulo del módulo
        $data['h1'] = $this->nameClass;
        //lista migas pan
        $data['breadcrumb'] = array(str_replace('_', ' ', $this->nameClass), 'Editar ' . substr(str_replace('_', ' ', $this->nameClass), 0, -1));
        //ruta para los botones y acciones
        $data['path'] = $this->uri->segment(1);
        //pasamos el rol del usuario
        $data['rol'] = $this->rol;
        //pasamos css para esta página
        $data['css'] = $this->load->view('css_module/css_module','',TRUE);
        //pasamos js para esta página
        $data['js'] = $this->load->view('js_module/js_module','',TRUE);

        //obtenemos los datos del registro
        $data['getRegistro'] = $this->doctrine->em->find("Entities\\Registros", $id);
        //obtenemos todos los uausrios con rol teleoperador/a = 4
        $data['getUsuarios'] = $this->doctrine->em->getRepository("Entities\\Usuarios")->findBy(["idrol" => 4]);
        //obtenemos el listado de registro de llamadas del registro en el que estamos
        $data['getRegistroLlamadas'] = $this->doctrine->em->getRepository("Entities\\Registrollamadas")->findBy(["idresgistro" => $id]);

        //comprobamos formulario submit
        if (isset($_POST['submit']))
        {
            //validamos los datos
            $this->form_validation->set_rules('empresa', 'Empresa', 'required');
            $this->form_validation->set_rules('telefono', 'Teléfono', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

            //obtenemos el usuario seleccionado
            $usuario = $this->doctrine->em->find("Entities\\Usuarios", $this->input->post('usuario'));

            if($this->form_validation->run()){

                //Seteamos los datos

                $data['getRegistro']->setEmpresa($this->input->post('empresa'));
                $data['getRegistro']->setNumempleados($this->input->post('numEmpleados'));
                $data['getRegistro']->setTelefono(str_replace(' ', '', $this->input->post('telefono')));
                $data['getRegistro']->setAdministrador($this->input->post('administrador'));
                $data['getRegistro']->setPercontacto($this->input->post('perContacto'));
                $data['getRegistro']->setCif($this->input->post('cif'));
                $data['getRegistro']->setDireccion($this->input->post('direccion'));
                $data['getRegistro']->setEmail($this->input->post('email'));
                $data['getRegistro']->setSector($this->input->post('sector'));
                $data['getRegistro']->setProvincia($this->input->post('provincia'));
                $data['getRegistro']->setPoblacion($this->input->post('poblacion'));
                $data['getRegistro']->setCp($this->input->post('cp'));
                $data['getRegistro']->setWeb($this->input->post('web'));
                $data['getRegistro']->setComentario($this->input->post('comentario'));
                $data['getRegistro']->setFregistro(new \DateTime(formatDateDoct($this->input->post('fRegistro'))));
                $data['getRegistro']->setIdusuario($usuario);
                //actualizamos
                $this->doctrine->em->flush();

            }
        }

        //cargamos la vista
        $this->load->view('templates/panel/layout', $data);
	}

    public function view($id)
    {
        //pasamos los datos básicos del template
        $data['lang'] = "es";
        $data['title'] = $this->proyecto->getNombre() . " | Panel de control";
        $data['view'] = strtolower(__FUNCTION__ . "_" . $this->nameClass);
        $data['robots'] = 'noindex, nofollow';
        $data['project'] = $this->proyecto;
        $data['reference'] = strtoupper(__FUNCTION__ . "-" . $this->nameClass);
        //icono del módulo
        $data['icono'] = $this->icono;
        //titulo del módulo
        $data['h1'] = $this->nameClass;
        //lista migas pan
        $data['breadcrumb'] = array(str_replace('_', ' ', $this->nameClass), 'Ver ' . substr(str_replace('_', ' ', $this->nameClass), 0, -1));
        //ruta para los botones y acciones
        $data['path'] = $this->uri->segment(1);
        //pasamos el rol del usuario
        $data['rol'] = $this->rol;
        //pasamos js para esta página
        $data['js'] = $this->load->view('js_module/js_module','',TRUE);
        //pasamos css para esta página
        $data['css'] = $this->load->view('css_module/css_module','',TRUE);

        //obtenemos los datos del usuario
        $data['getRegistro'] = $this->doctrine->em->find("Entities\\Registros", $id);
        //obtenemos una lista de los estados registros
        $data['getEstadosregistros'] = $this->doctrine->em->getRepository("Entities\\Estadosregistros")->findAll();
        //obtenemos el listado de registro de llamadas del registro en el que estamos
        $data['getRegistroLlamadas'] = $this->doctrine->em->getRepository("Entities\\Registrollamadas")->findBy(["idresgistro" => $id]);
        //obtenemos el listado de operadores
        $data['getOpearadores'] = $this->doctrine->em->getRepository("Entities\\Operadores")->findAll();
        //obtenemos los usuarios comercial = 3
        $data['getComerciales'] = $this->doctrine->em->getRepository("Entities\\Usuarios")->findBy(["idrol" => 3,"estado" => 0]);
        //obtenemos los usuarios director comercial = 7
        $data['getDirectComerciales'] = $this->doctrine->em->getRepository("Entities\\Usuarios")->findBy(["idrol" => 7,"estado" => 0]);

        $data['id'] = $id;

        //fecha actual más 1
        $data['getNewDate'] = strtotime(date("d-m-Y")."+ 1 days");
        //hora actual más 1
        $data['getNewHour'] = strtotime(date("G:i")."+ 1 hours");

        //cargamos la vista
        $this->load->view('templates/panel/layout', $data);
    }

	public function delete($id)
	{
        //obtenemos el dato mediante id
        $getRow = $this->doctrine->em->getRepository("Entities\\Registros")->findOneBy(["id" => $id]);
        //eliminamos el item
        $this->doctrine->em->remove($getRow);
        $this->doctrine->em->flush();
        //ruta para los botones y acciones
        $path = $this->uri->segment(1);
        //redireccionamos
        redirect($path);
      
	}

    public function upload_registers()
    {
        if (isset($_POST['submit'])) {

            $upload_image = upload('file', 'uploads', 0, 0, '2048');
            //array donde almacenamos los datos de los registros con teléfonos repetidos
            $telRep = array();

            if (!$upload_image['upload'])
            {

                $data['lang'] = "es";
                $data['title'] = $this->proyecto->getNombre() . " | Panel de control";
                $data['view'] = 'errors/html/error_app';
                $data['robots'] = 'noindex, nofollow';
                $data['project'] = $this->proyecto;
                $data['reference'] = strtoupper(__FUNCTION__ . "-" . $this->nameClass);
                //icono del módulo
                $data['icono'] = $this->icono;
                // titulo del módulo
                $data['h1'] = $this->nameClass;
                //lista migas pan
                $data['breadcrumb'] = array($this->nameClass);
                //ruta para los botones y acciones
                $data['path'] = $this->uri->segment(1);

                $data['error'] = $upload_image['res'];
                $this->load->view('templates/panel/layout', $data);

            } else {

                //obtenemos el usuario seleccionado
                $usuario = $this->doctrine->em->find("Entities\\Usuarios", $this->input->post('usuario'));
                //obtenemos el estado, en este caso siempre estado 4
                $estado = $this->doctrine->em->find("Entities\\Estadosregistros", 4);
                //obtenemos el operador móvil, en este caso 0
                $operador = $this->doctrine->em->find("Entities\\Operadores", 0);
                $csv = file('assets/uploads/' . $upload_image['res']);

                foreach ($csv as $key => $value) {

                    $reg = new Entities\Registros;
                    //convertimos el valor en array solo si key es > 0
                    if($key > 0)
                    {


                        $registro = explode(";", $value);

                        //Comprobamos si existen estos campo, si no es así el registro
                        //no se créa
                        if(isset($registro[0]) AND isset($registro[5]))
                        {
                            //damos formato al los telefonos
                            $telefono = str_replace(' ', '', $registro[5]);
                            $telefono = str_replace('.', '', $telefono);
                            //si el campo es mayor de 9 caracteres, eliminamos los tres primeros
                            if(strlen($telefono) > 9)
                            {
                                $telefono = substr($telefono, strlen($telefono) - 9);
                            }
                            
                            $reg->setTelefono($telefono);


                            //si el campo referente a móvil no existe no lo registramos
                            if(isset($registro[6]))
                            {
                                $movil = str_replace(' ', '', $registro[6]);
                                $movil = str_replace('.', '', $movil);
                                //si el campo es mayor de 9 caracteres, eliminamos los tres primeros
                                if(strlen($movil) > 9)
                                {
                                    $movil = substr($movil, strlen($telefono) - 9); 
                                }

                                $reg->setMovil($movil);
                            }
                            //De esta forma comprobamos si no existen algunos campos, y en caso afirmativo
                            //Este se crea como vacío
                            for ($i=0; $i <= 14 ; $i++)
                            { 
                            	
                            	if(!isset($registro[$key]))
                            	{
                            		$registro[$key] = "";
                            	}
                            }
                            //Seteamos los datos
                            $reg->setEmpresa($registro[0]);
                            $reg->setDireccion($registro[1]);
                            $reg->setCp($registro[2]);
                            $reg->setPoblacion($registro[3]);
                            $reg->setProvincia($registro[4]);
                            $reg->setEmail($registro[7]);
                            $reg->setWeb($registro[8]);
                            $reg->setSector($registro[9]);
                            $reg->setNumempleados($registro[10]);
                            $reg->setAdministrador($registro[11]);
                            $reg->setPercontacto($registro[12]);
                            $reg->setCif($registro[13]);
                            $reg->setComentario($registro[14]);

                            $reg->setIdoperador($operador);
                            $reg->setIdestado($estado);
                            $reg->setIdusuario($usuario);
                            $reg->setFregistro(new \DateTime(formatDateDoct($this->input->post('fRegistro'))));

                            //consultamos si existe un usuario con el mismo teléfono, si es así
                            //no lo guardamos y almacenamos los datos en un array
                            $existReg = $this->doctrine->em->getRepository("Entities\\Registros")->findOneBy(["telefono" => $telefono]);
                            if(!$existReg)
                            {
                                //guardamos la entidad en la tabla registros
                                $this->doctrine->em->persist($reg);
                                $this->doctrine->em->flush();

                            }else{

                                $telRep[] = array(

                                    'Empresa' => $registro[0],
                                    'Direccion' => $registro[1],
                                    'CP' => $registro[2],
                                    'Ciudad' => $registro[3],
                                    'Provincia' => $registro[4],
                                    'Telefono' => $telefono,
                                    'Movil' => $movil,
                                    'Email' => $registro[7],
                                    'Web' => $registro[8],
                                    'Sector' => $registro[9],
                                    'Nempleados' => $registro[10],
                                    'Administrador' => $registro[11],
                                    'Pcontacto' => $registro[12],
                                    'CIF' => $registro[13],
                                    'Comentario' => $registro[14],
                                );

                            }
                            
                            
                        }
                        
                    }
                    
                }
                //comprobamos si el array telRep es mayor de 0
                if(count($telRep) > 0)
                {
                    $data['lang'] = "es";
                    $data['title'] = $this->proyecto->getNombre() . " | Panel de control";
                    $data['view'] = 'errors/html/error_app';
                    $data['robots'] = 'noindex, nofollow';
                    $data['project'] = $this->proyecto;
                    $data['reference'] = strtoupper(__FUNCTION__ . "-" . $this->nameClass);
                    //icono del módulo
                    $data['icono'] = $this->icono;
                    // titulo del módulo
                    $data['h1'] = $this->nameClass;
                    //lista migas pan
                    $data['breadcrumb'] = array($this->nameClass);
                    //ruta para los botones y acciones
                    $data['path'] = $this->uri->segment(1);

                    $data['error'] = 'Hay '.count($telRep).' registro/s duplicados.<br/>';
                    $data['error'] .= 'Puedes descargar el listado haciendo <a href="'.site_url('registros/createExcel?'.http_build_query(array('aParam' => $telRep))).'">click aquí</a>';
                    $this->load->view('templates/panel/layout', $data);
                    //echo json_encode($telRep);

                }else{

                    //redireccionamos al index
                    redirect($this->uri->segment(1));
                }
                
            }

        }else{

            show_404();
        }

    }

    public function edit_record($id1,$id2)
    {
        if (isset($_POST['submit'])){

            //obtenemos el usuario
            $recordCall = $this->doctrine->em->getRepository("Entities\\Registrollamadas")->find($id2);
            $record = $this->doctrine->em->getRepository("Entities\\Registros")->find($id1);
            $estado = $this->doctrine->em->getRepository("Entities\\Estadosregistros")->find($this->input->post('estados'));
            //almacenamos los estados que ocultan el registro de cara al operador
            $estados_oculta = array(7,8,9,12,13,14,15,16,18,20,21,24,23,25,26);

            //obtenemos todos los registros = date actual
            $nextRecord = $this->doctrine->em->getRepository("Entities\\Registros")->getNextRecord($this->usuarioid,$id1);

            //seteamos los datos
            $recordCall->setIdestado($estado);
            $recordCall->setEnd(new \DateTime("now"));
            $recordCall->setComentario($this->input->post('comentario'));
            //actualizamos
            $this->doctrine->em->flush();

            //seteamos los datos
            $record->setIdestado($estado);
            $record->setFregistro(new \DateTime(formatDateDoct($this->input->post('date'))));
            $record->setTregistro(str_replace(':', '.', $this->input->post('hour')));
            //si el estado coincide con algún valor del array este oculta el registro al operador
            if(in_array($estado->getId(), $estados_oculta))
            {

                $record->setOculto(1);
                /*
                si el estado es igual a 8 = cierre positivo, este realizará 4 acciones
                1.Creara automáticamente el cliente o lo editara en caso de estar creado
                2.Guarda el reporte en la tabla reportes apuntando al ID de nuevo lciente o
                cliente editado
                3.para con los datos dados en el desplegable crear el evento o cita para el comercial
                4.Creamos un seguimiento nuevo 1
                */
                if($estado->getId() == 8)
                    //llamamos a la privada generateCliente y le pasamos $record
                    $this->generateCliente($record);

            }
            /*
            si el estado es igual a 17 = CLientes con 3 o menos lineas, lo posponemos para dentro de 6 
            meses y no se oculta. 
            */
            if($estado->getId() == 17)
            {
                //almacenamos la fecha actual, mas tarde dependiendo del tipo de seguimiento
                //esta fecha tendra una suma de 6
                $fecha = date('d-m-Y');
                $fecha = add_days(180,$fecha);
                //actualizamos la fecha
                $record->setFregistro(new \DateTime(formatDateDoct($fecha)));
            }
            //Si el estado del registro es igual a mado info = 3, este se pospone una semana
            if($estado->getId() == 3)
            {
                $fecha = date('d-m-Y');
                $fecha = add_days(7,$fecha);
                //actualizamos la fecha
                $record->setFregistro(new \DateTime(formatDateDoct($fecha)));
            }

            //consultamos si los registros llamadas con estado = 5 y 6
            //si el count es >= 3 seteamos oculto = 1
            $recordCallEstado = $this->doctrine->em->getRepository("Entities\\Registrollamadas")->findBy(["idresgistro" => $id1,"idestado" => 5]);
            if(count($recordCallEstado) >= 3)
            {

                $record->setOculto(1);

            }else
            {
                $recordCallEstado = $this->doctrine->em->getRepository("Entities\\Registrollamadas")->findBy(["idresgistro" => $id1,"idestado" => 6]);
                if(count($recordCallEstado) >= 3)
                {

                    $record->setOculto(1);

                }
            }
            //actualizamos
            $this->doctrine->em->flush();

            if($nextRecord){

                //redireccionamos al siguiente
                redirect($this->uri->segment(1).'/view/'.$nextRecord->getId());

            }else{

                //redireccionamos index indicando que en este caso ya no quedan llamadas
                $session_data['endJob'] = TRUE;
                $this->session->set_userdata($session_data);
                redirect($this->uri->segment(1));
            }


        }

    }

    public function reasign_registers()
    {
        if (isset($_POST['submit'])) {

            $usuarioReg = $this->input->post('usuarioReg');
            $limit = $this->input->post('limit');
            $reasignar =  $this->input->post('reasignar');
            $provincia = $this->input->post('provincia');
            $poblacion = $this->input->post('poblacion');
            $cp = $this->input->post('cp');
            $estado = $this->input->post('estadoReg');
            $typeCon = $this->input->post('type');
            $date = $this->input->post('date');
           //obteenoms el usuario para reasignar
           $usuario = $this->doctrine->em->find("Entities\\Usuarios", $reasignar);

            $param = array(

                        'provincia' => $provincia,
                        'poblacion' => $poblacion,
                        'poblacion' => $poblacion,
                        'cp' => $cp,
                        'idestado' => $estado
                    );
           
           //obtenemos todos los registros asignados al usuario @usuarioReg
            $registros = $this->doctrine->em->getRepository("Entities\\Registros")->findByMultiple($param,$usuarioReg,$typeCon);

           //recorremos los usuarios, restando uno al final de la consutla a @limit
           //una vez limit es cero paramos de reasignar registros
           foreach($registros as $registro){

               if($limit > 0)
               {

                   $registro = $this->doctrine->em->getRepository("Entities\\Registros")->find($registro->getId());
                   //actualizamos el registro reasignando el usuario
                   $registro->setIdusuario($usuario);
                   //$registro->setFregistro(new \DateTime("now"));
                   $registro->setFregistro(new \DateTime($date));
                   $this->doctrine->em->flush();
                   $limit --;

               }else{

                   //redireccionamos al index
                   //redirect($this->uri->segment(1));
               }


           }
            //redireccionamos al index
            redirect($this->uri->segment(1));

        }else{

            show_404();
        }
    }

    public function add_record()
    {
        if($this->input->is_ajax_request())
        {
            $user = $this->doctrine->em->find("Entities\\Usuarios", $this->input->post('user'));
            $record = $this->doctrine->em->find("Entities\\Registros", $this->input->post('record'));
            $estado = $this->doctrine->em->getRepository("Entities\\Estadosregistros")->find(1);

            $regLlamada = new Entities\Registrollamadas;
            //seteamos
            $regLlamada->setIdregistro($record);
            $regLlamada->setIdestado($estado);
            $regLlamada->setIdusuario($user);
            //guardamos
            $this->doctrine->em->persist($regLlamada);
            $this->doctrine->em->flush();
            //enviamos el id del registroLlamada
            $json = $arrayName = array('id' => $regLlamada->getId());
            echo json_encode($json);

        }else{
            show_404();
        }
    }

    public function get_num_records()
    {
        if($this->input->is_ajax_request())
        {
            $id = $this->input->post('id');
            $provincia = $this->input->post('provincia');
            $poblacion = $this->input->post('poblacion');
            $cp = $this->input->post('cp');
            $estado = $this->input->post('estado');
            $typeCon = $this->input->post('typeCon');

            $param = array(

                        'provincia' => $provincia,
                        'poblacion' => $poblacion,
                        'poblacion' => $poblacion,
                        'cp' => $cp,
                        'idestado' => $estado
                    );

            $registros = $this->doctrine->em->getRepository("Entities\\Registros")->findByMultiple($param,$id,$typeCon);
            $registros = count($registros);
            $json = $arrayName = array('numRegistros' => $registros);
            echo json_encode($json);

        }else{
            show_404();
        }
    }

    public function checkRequiredRegister()
    {
        if($this->input->is_ajax_request())
        {
            //obtenemos el id del registro
            $id = $this->input->post('id');
            //consultamos el la entidad registro y obtenemos el item
            $record = $this->doctrine->em->find("Entities\\Registros", $id);
            //comprobamos si los datos obligatorios para pasar un registro a cierre positivo
            if($record->getCif() == "" OR $record->getCp() == "" OR $record->getDireccion() == "" OR $record->getPercontacto() == "" OR $record->getIdoperador()->getId() == 0 OR $record->getLineasmovil() == "" OR $record->getTelefono() == ""){

                echo "false";

            }else{

                echo "true";
            }

        }else{
            show_404();
        }
    }

    public function createExcel()
    {

        $separador = ";";
        //generamos las cabeceras para el archivo xls
        header("Cache-Control: public");
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=registros_duplicados.xls');
        echo utf8_decode("Empresa;Dirección;CP;Ciudad;Provincia;Teléfono;Móvil;Email;Web;Sector;N. Empleados;Administrador;P.Contacto;CIF;Comentario;\n");
        
        //imprimimos los datos
        foreach ($_GET['aParam'] as $key => $value)
        {
            echo $value['Empresa'].$separador.$value['Direccion'].$separador.$value['CP'].$separador.$value['Ciudad'].$separador.$value['Provincia'].$separador.$value['Telefono'].$separador.$value['Movil'].$separador.$value['Email'].$separador.$value['Web'].$separador.$value['Sector'].$separador.$value['Nempleados'].$separador.$value['Administrador'].$separador.$value['Pcontacto'].$separador.$value['CIF'].$separador.$value['Comentario']."\n";
        }
        
    }

    private function generateCliente($obj)
    {
        /*
            Este método nos genera una cuenta cliente pasando en $obj
            el objeto registros
        */

        //instanciamos la entidad
        $reg = new Entities\Cuentas;
        $id = 0;

        //comprobamos si existe ya el cliente, si es así, editamos, en caso contrario
        //realizamos un add
        $is_cliente = $this->doctrine->em->getRepository("Entities\\Cuentas")->findOneBy(["cif" => $obj->getCif()]);
        if($is_cliente)
            $reg = $this->doctrine->em->getRepository("Entities\\Cuentas")->findOneBy(["cif" => $obj->getCif()]);

        //seteamos los datos
        $reg->setNombre($obj->getEmpresa());
        $reg->setTelefono($obj->getTelefono());
        $reg->setTelefonoalt($obj->getMovil());
        $reg->setEmail($obj->getEmail());
        $reg->setCif($obj->getCif());
        $reg->setPersonacnt($obj->getPercontacto());
        //obtenemos el objeto usuario
        $usuario = $this->doctrine->em->find("Entities\\Usuarios", $this->usuarioid);
        $reg->setModificado($usuario);
        $reg->setIdusuario($usuario);
        $reg->setIdcomercial($this->input->post('usuario'));
        $reg->setDireccion($obj->getDireccion());
        $reg->setPoblacion($obj->getPoblacion());
        $reg->setProvincia($obj->getProvincia());
        $reg->setCp($obj->getCp());
        $reg->setDescripcion($this->input->post('comentario'));

        //obtenemos objeto operador
        $operador = $this->doctrine->em->find("Entities\\Operadores", $obj->getIdoperador());

        $reg->setIdoperador($operador);
        $reg->setLineasmovil($obj->getLineasmovil());
        $reg->setLineasdatos($obj->getLineasdatos());
        $reg->setAdsl($obj->getAdsl());
        $reg->setConectapymes($obj->getConectapymes());
        $reg->setCentralita($obj->getCentralita());
        $reg->setCentralitas($obj->getCentralitas());
        $reg->setTipocpyme($obj->getTipocpyme());
        $reg->setPermanencia($obj->getPermanencia());
        $reg->setTpermanencia($obj->getTpermanencia());
        $reg->setIdregistro($obj->getId());
        //guardamos la cuenta
        if($is_cliente == null)
            $this->doctrine->em->persist($reg);

        $this->doctrine->em->flush();
        //pasamos el id del cĺiente recien creado al metodo generateEvento 
        //para crear la oportunidad
        if($is_cliente)
        {

            $id = $is_cliente->getId();

        }else{

            $id = $reg->getId();
        }

        $cliente = $this->doctrine->em->find("Entities\\Cuentas", $id);
        $this->generateEvento($cliente);
        
    }

    private function generateEvento($obj)
    {
        //Obtenemos el usuario
        $user = $this->doctrine->em->find("Entities\\Usuarios", $this->input->post('usuario'));
        $reg = new Entities\Calendario;
        //Seteamos los datos
        $reg->setFecha(new \DateTime($this->input->post('fEvent').' '.$this->input->post('hEvent')));

        $reg->setComentario($this->input->post('comentario'));
        $reg->setIdusuario($user);
        $date = explode('-', $this->input->post('fEvent'));
        $reg->setYear($date[2]);
        $reg->setMonth($date[1]);
        $reg->setDay($date[0]);
        $hour = str_replace(':','',$this->input->post('hEvent'));
        $reg->setHour($hour/100);
        $reg->setIdcliente($obj);

        //guardamos la entidad en la tabla users
        $this->doctrine->em->persist($reg);
        $this->doctrine->em->flush();
        //ahora generamos nuevo uno en seguimiento.
        $evento = $this->doctrine->em->find("Entities\\Calendario", $reg->getId());
        $this->generateSeguimiento($evento);

    }

    private function generateSeguimiento($obj)
    {
        //obtenemos el último seguimiento actual = 1 y lo cerramos = 0
        $thisSeguimeinto = $this->doctrine->em->getRepository("Entities\\Cuentasseguimiento")->findOneBy(["idcliente" => $obj->getIdcliente()->getId(),"actual" => 1]);
        if( $thisSeguimeinto )
        {
            $thisSeguimeinto->setActual(0);
            $this->doctrine->em->flush();
        }
        //obtenemos los objetos usuario y faseventa y teleoperador
        $usuario = $this->doctrine->em->find("Entities\\Usuarios", $obj->getIdcliente()->getId());
        $estado = $this->doctrine->em->getRepository("Entities\\Estadosseguimiento")->findOneBy(["id" =>0]);

        $reg = new Entities\Cuentasseguimiento;
        $reg->setIdestado($estado);
        $reg->setIdusuario($obj->getIdusuario());
        $reg->setIdteleoperador($obj->getIdcliente()->getIdusuario()); 
        $reg->setIdcliente($obj->getIdcliente());
        $reg->setIdcalendario($obj);
        $reg->setTipo('Nuevo 1');
        $reg->setPositiveclose(1);
        $reg->setIdus($this->usuarioid);
        $reg->setIp($this->input->ip_address());
        $reg->setFromtool("Registros");
        $reg->setFseguimiento(new \DateTime(formatDateDoct($obj->getFecha()->format("d-m-Y"))));

        //guardamos el seguimiento
        $this->doctrine->em->persist($reg);
        $this->doctrine->em->flush();

        $this->generateReport($reg);

    }

    private function generateReport($obj)
    {
        $usuario = $this->doctrine->em->find("Entities\\Usuarios", $this->usuarioid);
        $reg = new Entities\Reportes;
        $reg->setIdusuario($usuario);
        $reg->setComentario($this->input->post('comentario'));
        $reg->setIdrow($obj->getIdcliente()->getId());
        $reg->setIdrows($obj->getIdcalendario()->getId());
        $reg->setTabla('cuentas');
        $reg->setTablas('calendario');
        //guardamos el seguimiento
        $this->doctrine->em->persist($reg);
        $this->doctrine->em->flush();
    }

    public function export_estados(){

        $csv = file('assets/csv/Oportunidades_cierre.csv');

        foreach ($csv as $key => $value)
        {

            if($key > 0)
            {
                $registro = explode(";", $value);
                echo '<input name="fEvent" type="text" value="'.$registro[6].'"/>';
                echo '<input name="comentario" type="text" value="Sin comentario"/>';
                echo '<input name="hEvent" type="text" value="9:00"/>';
                echo '<input name="usuario" type="text" value="'.$registro[1].'"/>';

                $param = array(
                    'fEvent' => $registro[6], 
                    'comentario' => 'Sin comentario',
                    'usuario' => $registro[1],
                    'hEvent' => '9:00'
                    );

                $cliente = $this->doctrine->em->getRepository("Entities\\Cuentas")->findOneBy(["cif" => $registro[2]]);

                if($cliente)
                {
                    $this->generateEvento_($cliente,$param);

                }else{

                    echo 'no cliente';
                }
                

            }

        }

    }

    ///////////////ESTO ES PARA ELIMINAR EN UN FUTURO
    private function generateEvento_($obj,$param)
    {
        //Obtenemos el usuario
        $user = $this->doctrine->em->find("Entities\\Usuarios",$param['usuario']);
        $reg = new Entities\Calendario;
        //Seteamos los datos
        $reg->setFecha(new \DateTime($param['fEvent'].' '.$param['hEvent']));

        $reg->setComentario($param['comentario']);
        $reg->setIdusuario($user);
        $date = explode('-', $param['fEvent']);
        $reg->setYear($date[0]);
        $reg->setMonth($date[1]);
        $reg->setDay($date[2]);
        $hour = str_replace(':','',$param['hEvent']);
        $reg->setHour($hour/100);
        $reg->setIdcliente($obj);

        //guardamos la entidad en la tabla users
        $this->doctrine->em->persist($reg);
        $this->doctrine->em->flush();
        //ahora generamos nuevo uno en seguimiento.
        $evento = $this->doctrine->em->find("Entities\\Calendario", $reg->getId());
        $this->generateSeguimiento_($evento,$param);

    }

    private function generateSeguimiento_($obj,$param)
    {
        //obtenemos los objetos usuario y faseventa
        $usuario = $this->doctrine->em->find("Entities\\Usuarios", $obj->getIdcliente()->getId());
        $estado = $this->doctrine->em->getRepository("Entities\\Estadosseguimiento")->findOneBy(["id" =>0]);

        $reg = new Entities\Cuentasseguimiento;
        $reg->setIdestado($estado);
        $reg->setIdusuario($obj->getIdusuario()); 
        $reg->setIdcliente($obj->getIdcliente());
        $reg->setIdcalendario($obj);
        $reg->setTipo('Oferta 1');
        $reg->setIdus($this->usuarioid);
        $reg->setIp($this->input->ip_address());
        $reg->setFromtool("Registros");
        $reg->setFseguimiento(new \DateTime(formatDateDoct($obj->getFecha()->format("d-m-Y"))));

        //guardamos el seguimiento
        $this->doctrine->em->persist($reg);
        $this->doctrine->em->flush();

        $this->generateReport_($reg,$param);

    }

    private function generateReport_($obj,$param)
    {
        $usuario = $this->doctrine->em->find("Entities\\Usuarios", $this->usuarioid);
        $reg = new Entities\Reportes;
        $reg->setIdusuario($usuario);
        $reg->setComentario($param['comentario']);
        $reg->setIdrow($obj->getIdcliente()->getId());
        $reg->setIdrows($obj->getIdcalendario()->getId());
        $reg->setTabla('cuentas');
        $reg->setTablas('calendario');
        //guardamos el seguimiento
        $this->doctrine->em->persist($reg);
        $this->doctrine->em->flush();
    }
}

?>