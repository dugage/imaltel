<?php 
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clientes extends MX_Controller
{
    private $nameClass;
    private $icono;
    private $proyecto;
    private $usuarioid = 0;
    private $rol = 0;
    private $start = 0;
    private $limit = 0;
    private $totalRecord = 0;

    public function __construct()
    {
        parent::__construct();
        $this->nameClass = get_class($this);
        $this->proyecto = $this->doctrine->em->find("Entities\\Proyecto", 1);
        $this->icono = 'icon-folder';
        $this->usuarioid = $this->session->userdata('usuarioid');
        $this->rol = $this->session->userdata('rol');
        //cargamos el helper para generación del pass
        $this->load->helper('generate_pass_helper');
        $this->load->helper('MY_encrypt_helper');
        $this->load->helper('documents_control');
        //formate la fecha para pasarla a doctrine
        $this->load->helper('format_date_doctrine_helper');
        //helper uploads
        $this->load->helper('upload_helper');
        $this->load->helper('my_playing_dates_helper');
        $this->load->library('../controllers/Maincontroller');
        $this->limit = 25;
        $this->totalRecord = count($this->doctrine->em->getRepository("Entities\\Cuentas")->findAll());
    }


    public function index()
    {
        //pasamos los datos básicos del template
        $data['lang'] = "es";
        $data['title'] = $this->proyecto->getNombre() . " | Panel de control";
        $data['view'] = strtolower(__FUNCTION__ . "_" . $this->nameClass);
        $data['robots'] = 'noindex, nofollow';
        $data['project'] = $this->proyecto;
        $data['reference'] = strtoupper(__FUNCTION__ . "-" . $this->nameClass);
        $data['rol'] = $this->rol;
        //icono del módulo
        $data['icono'] = $this->icono;
        // titulo del módulo
        $data['h1'] = $this->nameClass;
        //lista migas pan
        $data['breadcrumb'] = array($this->nameClass);
        //datos cabecera tabla
        $data['thead'] = array('ID', 'Nombre','Población','Tel','Seguimiento');
        //ruta para los botones y acciones
        $data['path'] = $this->uri->segment(1);
        //lista de parametros de busqueda del select del buscador
        $data['searcher'] = array('Razón social' => 'nombre' ,'Provincia' => 'provincia','Población' => 'poblacion','CP' => 'cp','CIF' => 'cif','Teléfono ' => 'telefono','Email' => 'email','Id' => 'id');
        //parametros que pasaremos a la consulta
        $f = null;
        $q = null;

        //obtenemos y mostramos todos los datos pasando el limit y satart para su paginación
        //si el parametro $this->uri->segment(2) es null mantenemos el valor por defecto
        // de $this->start, si no es así $this->start = $this->uri->segment(2)
        if($this->uri->segment(2) != null)
            $this->start = $this->uri->segment(2);

        //pasamos a la vista los datos de start y limit
        $data['start'] = $this->start;
        $data['limit'] = $this->limit;
        //y el previous,next
        $data['previous'] = $this->start - $this->limit;
        $data['next'] = $this->start + $this->limit;
        //pasamos el totalRecord
        $data['totalRecord'] = $this->totalRecord;
        /*
        comprobamos si los parametros de busqueda f y q existen,
        en caso afirmativo creamos una cadena que pasaremos a la url
        de paginación y los parametros para la consulta, si no es así
        searcher_param = empty
        */
        if(isset($_GET['f']) AND isset($_GET['q']))
        {
            $data['searcher_param'] = '/f='.$_GET['f'].'&q='.$_GET['q'];
            $f = $_GET['f'];
            $q = $_GET['q'];

        }else{

            $data['searcher_param'] = "";
        }


        $data['getResult'] = $this->doctrine->em->getRepository("Entities\\Cuentas")->getCuentasLimit($this->limit,$this->start,$f,$q);
        //si el usuario tiene rol de comercial = 3, mostramos una vista de sólo 
        //los clientes o cuentas asignados a el
        if($this->rol == 3)
        {
        	//$data['getResult'] = $this->doctrine->em->getRepository("Entities\\Cuentas")->findBy(["idcomercial" => $this->usuarioid]);

            $data['getResult'] = $this->doctrine->em->getRepository("Entities\\Cuentas")->getCuentasLimit(500,$this->start,$f,$q,$this->usuarioid,$this->rol);

        }elseif( $this->rol == 7 ) {
            //if el usuario es igual 7 = director comrcial, mostramos una visa sólo de sus cliente y de los de su equipo
            $data['getResult'] = $this->doctrine->em->getRepository("Entities\\Cuentas")->getCuentasLimit(1000,$this->start,$f,$q,$this->usuarioid,$this->rol);

        }

        //cargamos la vista
        $this->load->view('templates/panel/layout', $data);
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
        //ruta para los botones y acciones
        $data['path'] = $this->uri->segment(1);

        //icono del módulo
        $data['icono'] = $this->icono;
        // titulo del módulo
        $data['h1'] = 'Crear ' . $this->nameClass;
        //lista migas pan
        $data['breadcrumb'] = array($this->nameClass, 'Crear ' . $this->nameClass);

        //obtenemos y mostramos todos los usuarios
        $data['getUsuarios'] = $this->doctrine->em->getRepository("Entities\\Usuarios")->findAll();
        //obtenemos el listado de operadores
        $data['getOpearadores'] = $this->doctrine->em->getRepository("Entities\\Operadores")->findAll();

        //comprobamos formulario submit
        if (isset($_POST['submit'])){
            //validamos los datos
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('telefono', 'Telefono');
            $this->form_validation->set_rules('telefonoAlt', 'Teléfono alternativo');
            $this->form_validation->set_rules('email', 'Email', 'valid_email');
            $this->form_validation->set_rules('cif','CIF','required');
            $this->form_validation->set_rules('idUsuario','Asignado a','required');
            $this->form_validation->set_rules('personaCnt','Persona de Contacto');
            $this->form_validation->set_rules('notiPro','Notificar Propietario');
            $this->form_validation->set_rules('direccion', 'Direccion');
            $this->form_validation->set_rules('poblacion', 'Poblacion');
            $this->form_validation->set_rules('provincia', 'Provincia');
            $this->form_validation->set_rules('cp', 'Cp');
            $this->form_validation->set_rules('descripcion', 'Descripcion');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

            if ($this->form_validation->run()) {

                //instanciamos la entidad
                $reg = new Entities\Cuentas;
                //utilizamos el metodo privado seter data para setear los datos y le pasamos 
                //el tipo de accion que en este caso tiene que ser add
                $this->seter_data($reg,__FUNCTION__);

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
        //datos cabecera tabla
        $data['thead'] = array('ID','Nombre','Tipo','Documento','Fecha','Estado');
        $data['id'] = $id;
        //pasamos la ruta al modal
        $data['pathModal'] = 'clientes/edit/'.$id;
        //ruta para los botones y acciones
        $data['path'] = $this->uri->segment(1);
        //pasamos css para esta página
        $data['css'] = $this->load->view('css_module/css_module','',TRUE);
        //pasamos js para esta página
        $data['js'] = $this->load->view('js_module/js_module','',TRUE);

        $data['rol'] = $this->rol;

        $data['disableAusente'] = false;

        //todos los adjuntos del usuario
        $data['attachments'] = $this->doctrine->em->getRepository("Entities\\Attachments")->findBy(["idrow" => $id]);
        //almacenamos todos los roles ****Nota: revisar si procedea a eliminar después de modificaciones
        $data['usuarios'] = $this->doctrine->em->getRepository("Entities\\Usuarios")->findAll();
        //obtenemos los teleoperadores = rol 4
        $data['getToperadores'] = $this->doctrine->em->getRepository("Entities\\Usuarios")->findBy(["idrol" => 4]);
        //obtenemos los comarciales = rol 3
        $data['getComerciales'] = $this->doctrine->em->getRepository("Entities\\Usuarios")->findBy(["idrol" => 3,"estado" => 0]);
         //obtenemos los usuarios director comercial = 7
        $data['getDirectComerciales'] = $this->doctrine->em->getRepository("Entities\\Usuarios")->findBy(["idrol" => 7,"estado" => 0]);
        //obtenemos cliente
        $data['getRow'] = $this->doctrine->em->getRepository("Entities\\Cuentas")->findOneBy(["id" => $id]);
        //obtenemos de forma ordenada todos los seguimientos de esta cuenta
        //$data['getCuentasSeguimiento'] = $this->getCuentasSeguimiento($data['getRow']);
        $data['getCuentasSeguimiento'] = $this->doctrine->em->getRepository("Entities\\Cuentasseguimiento")->findBy(["idcliente" => $id]);
        //obtenemos el seguimiento actual
        $data['thisCuentasSeguimiento'] = $this->doctrine->em->getRepository("Entities\\Cuentasseguimiento")->findOneBy(["idcliente" => $id,"actual" => 1]);
        //obtenemos todos los estados seguimiento
        $data['getEstadosSeguimiento'] = $this->doctrine->em->getRepository("Entities\\Estadosseguimiento")->findBy(["oculto" => 0]);
        //obtenemos si es que hay, el listado de reportes
        $data['getReports'] =$this->doctrine->em->getRepository("Entities\\Reportes")->findBy(["idrow" => $id,"tabla" => "cuentas"]);

        //icono del módulo
        $data['icono'] = $this->icono;
        // titulo del módulo
        $data['h1'] = 'Editar ' . substr(str_replace('_', ' ', $this->nameClass), 0, -1);
        //lista migas pan
        $data['breadcrumb'] = array(str_replace('_', ' ', $this->nameClass), 'Crear ' . substr(str_replace('_', ' ', $this->nameClass), 0, -1));
        //obtenemos el listado de operadores
        $data['getOpearadores'] = $this->doctrine->em->getRepository("Entities\\Operadores")->findAll();
        //obtenemos el listado de Tipos de documentos
        $data['getTiposDocumentos']= $this->doctrine->em->getRepository("Entities\\Tiposdocumentos")->findBy(["oculto" => 0]);
        //comprobamos si este cliente tiene una tarea abierta
        $data['getTarea'] = $this->doctrine->em->getRepository("Entities\\Tareas")->findOneBy(["idcliente" => $id,"estado" => 0]);
        //comprobamos si el cliente tiene tarea proponer ko
        $data['getTareaProponerKo'] = $this->doctrine->em->getRepository("Entities\\Tareas")->findOneBy(["idcliente" => $id,"estado" => 0, 'tipo' => 'Proponer ko']);
        //comprobamos si el cliente tiene tarea ausente
        $data['getTareAusente'] = $this->doctrine->em->getRepository("Entities\\Tareas")->findOneBy(["idcliente" => $id,"estado" => 0, 'tipo' => 'Ausente-reconcertar(TMK)']);
        //si el usuario logado tiene tarea de este cliente
        $data['getTareaUser'] = $this->doctrine->em->getRepository("Entities\\Tareas")->findOneBy(["idcliente" => $id,"estado" => 0,"idusuarioto"=> $this->usuarioid]);

        if (isset($data['thisCuentasSeguimiento'])) {

	        if( $data['thisCuentasSeguimiento']->getTipo() == 'Oferta 3' OR $data['thisCuentasSeguimiento']->getTipo() == 'Cierre' OR $data['thisCuentasSeguimiento']->getTipo() == 'Firmado' OR $data['thisCuentasSeguimiento']->getTipo() == 'E.O.Modi') {

	        	$data['disableAusente'] = true;
	        }
        }
     	

        //array con las acciones según estado del seguimiento del cliente
        $data['accionesTareas'] = array(

                                        'Ausente' => 'Reconcertar',
                                        'Fac. Recogida' => 'Verificar', 
                                        'Oferta entregada' => 'Verificar',
                                        'Firmado' => 'No data',
                                        'Proponer ko' => 'Pasar a Ko',
                                        'Rdocu' => 'Verificar documentación'
                                    );

        //comprobamos formulario submit
        if (isset($_POST['submit'])) {

            //validamos los datos
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('telefono', 'Telefono');
            $this->form_validation->set_rules('telefonoAlt', 'Teléfono alternativo');
            $this->form_validation->set_rules('email', 'Email', 'valid_email');
            $this->form_validation->set_rules('cif','CIF','required');
            $this->form_validation->set_rules('idUsuario','Teleoperador','required');
            $this->form_validation->set_rules('idComercial','Comercial','required');
            $this->form_validation->set_rules('personaCnt','Persona de Contacto');
            $this->form_validation->set_rules('notiPro','Notificar Propietario');
            $this->form_validation->set_rules('direccion', 'Direccion');
            $this->form_validation->set_rules('poblacion', 'Poblacion');
            $this->form_validation->set_rules('provincia', 'Provincia');
            $this->form_validation->set_rules('cp', 'Cp');
            $this->form_validation->set_rules('descripcion', 'Descripcion');

            $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

            if ($this->form_validation->run()) 
            {

                $this->checkChangeUser($id,$this->input->post('idUsuario'),$this->input->post('idComercial'));
                //instanciamos la entidad
                $reg = $data['getRow'];
                //utilizamos el metodo privado seter data para setear los datos y le pasamos 
                //el tipo de accion que en este caso tiene que ser add
                $this->seter_data($reg,__FUNCTION__);

            }
        }

        //comprobamos formulario submit-attach en modal
        if (isset($_POST['submit-attach'])){

            $upload_image = $this->up_load('file','attachments_cuentas');
            //comprobamos si la subida ok, si no es así mostramos el error
            if($upload_image['upload'])
            {

                //instanciamos la entidad
                $reg = new Entities\Attachments;
                //seteamos los datos
                $reg->setIdrow($id);
                $reg->setTablerow('cuentas');
                $reg->setTipodocumento($this->input->post('tipo-documento'));
                $reg->setNombredocumento($this->input->post('nombreDocumento'));
                $reg->setAttached($upload_image['res']);
                //guardamos
                $this->doctrine->em->persist($reg);
                $this->doctrine->em->flush();

                redirect($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$id);

            }else{

                $data['lang'] = "es";
                $data['title'] = $this->proyecto->getNombre() . " | Panel de control";
                $data['view'] = 'errors/html/error_app';
                $data['robots'] = 'noindex, nofollow';
                $data['project'] = $this->proyecto;
                $data['reference'] = strtoupper(__FUNCTION__ . "-" . $this->nameClass);
                //ruta para los botones y acciones
                $data['path'] = $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$id;

                $data['error'] = $upload_image['res'];

            }
            

        }

        if(isset($_POST['submit-reporte']))
        {
        	//validamos los datos del formulario
            //si el rol es igual a 1-6 o 7 validamos tipo de reporte
            if( $this->rol == 1 OR $this->rol == 6 OR $this->rol == 7 )
        	   $this->form_validation->set_rules('tipo-reporte', 'Tipo de reporte', 'required');

            $this->form_validation->set_rules('text-reporte', 'Reporte', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

            if ($this->form_validation->run()) 
            {
                if( $_POST['tipo-reporte'] != 'Reportar' ) {

                    //almacenamos el tipo reporte
                    $tipoReporte = $this->input->post('tipo-reporte');
                    //comprobamos el tipo de acción que solicita desde el reporte
                    if( $tipoReporte == "Oferta 1" OR $tipoReporte == "Oferta 2" OR $tipoReporte == "Oferta 3" OR $tipoReporte == "Cierre" OR $tipoReporte == "Firmado") {
                        //llamamos a setAgendar y pasamos el  id del cliente
                        $this->setAgendar($id);

                    }elseif( $tipoReporte == "ProponerKo"){

                        //realizamos el reporte
                        $this->set_reporte($id, false);
                        //redireccionamos a maincontroller/proponerKo/$id
                        redirect(site_url('maincontroller/proponerKo/'.$id.'/'."clientes"));
                        
                    }elseif( $tipoReporte == "Volver a llamar"){
                        //alamacenamos los parametros
                        $fecha = $this->input->post('fEvent');
                        $hora = $this->input->post('hEvent');
                        $comentario = $this->input->post('text-reporte');
                        //realizamos el reporte
                        $this->set_reporte($id, false);
                        //redireccionamos a maincontroller/proponerKo/$id
                        //redirect(site_url('maincontroller/volverLlamar/'.$id.'/'."clientes"?=$fecha,$hora,$comentario));
                        $this->maincontroller->volverLlamar($id,"clientes",$fecha,$hora,$comentario);
                        
                    }else{

                        //llamaos a setTarea
                        $this->setTarea($data['getRow']);
                        //realizamos el reporte
                        $this->set_reporte($id);

                    }

                }else{

                    //guaradamos el reporte
                    $this->set_reporte($id);
                }
                
                
            }
        }

        //cargamos la vista
        $this->load->view('templates/panel/layout', $data);
    }

    public function delete($id)
    {

        //obtenemos el dato mediante id
        $getRow = $this->doctrine->em->getRepository("Entities\\Cuentas")->findOneBy(["id" => $id]);
        //eliminamos el item
        $this->doctrine->em->remove($getRow);
        $this->doctrine->em->flush();
        //ruta para los botones y acciones
        $path = $this->uri->segment(1);
        //redireccionamos
        redirect(site_url($path));

    }

    public function delete_att($id,$id2)
    {

         //obtenemos el dato mediante id
        $getRow = $this->doctrine->em->getRepository("Entities\\Attachments")->findOneBy(["id" => $id]);
        //eliminamos el item
        $this->doctrine->em->remove($getRow);
        $this->doctrine->em->flush();
        //borramos el archivo
        unlink('./assets/attachments_cuentas/'.$getRow->getAttached());
        //ruta para los botones y acciones
        $path = $this->uri->segment(1).'/edit/'.$id2;
        //redireccionamos
        redirect(site_url($path));

    }

    private function seter_data($reg,$type,$param = array())
    {

        //seteamos los datos
        $reg->setNombre($this->input->post('nombre'));
        $reg->setTelefono(str_replace(' ', '', $this->input->post('telefono')));
        $reg->setTelefonoalt(str_replace(' ', '', $this->input->post('telefonoAlt')));
        $reg->setEmail($this->input->post('email'));
        $reg->setCif($this->input->post('cif'));
        $reg->setPersonacnt($this->input->post('personaCnt'));
        //$reg->setNotipro($this->input->post('notiPro'));
        //$reg->setConvertidopre($this->input->post('convertidoPre'));
        //obtenemos el objeto usuario modi.o crea
        $modificado = $this->doctrine->em->find("Entities\\Usuarios", $this->usuarioid);
        $reg->setModificado($modificado);

        $reg->setDireccion($this->input->post('direccion'));
        $reg->setPoblacion($this->input->post('poblacion'));
        $reg->setProvincia($this->input->post('provincia'));
        //obtenemos el objeto del usuario, este es a quien se le asigno el cliente
        $usuario = $this->doctrine->em->find("Entities\\Usuarios", $this->input->post('idUsuario'));
        $reg->setIdusuario($usuario);
        $reg->setidComercial($this->input->post('idComercial'));
        $reg->setCp($this->input->post('cp'));
        $reg->setDescripcion($this->input->post('descripcion'));

        //$reg->setIdoperador($this->input->post('operador'));
        //$reg->setLineasmovil($this->input->post('lineasMovil'));
        //$reg->setLineasfijo($this->input->post('lineasFijo'));
        //$reg->setCentralita($this->input->post('centralita'));
        //$reg->setCentralitas($this->input->post('centralitas'));
        //$reg->setPermanencia($this->input->post('permanencia'));
        //$reg->setTpermanencia($this->input->post('tPermanencia'));

        //guardamos la entidad en la tabla users
        if($type == "add")
            $this->doctrine->em->persist($reg);

        $this->doctrine->em->flush();

    }

    private function checkChangeUser($cl,$tp,$co)
    {
        /*
            cl = id cliente
            tp = id teleoperador
            co O id comercial
        */

        //obtenemos el objeto usuario para tp y co
        $teleoperador = $this->doctrine->em->find("Entities\\Usuarios", $tp);
        $comercial = $this->doctrine->em->find("Entities\\Usuarios", $co);
        //consultamos si cl y tp nos da un resultado
        $clTp = $this->doctrine->em->getRepository("Entities\\Cuentas")->findOneBy(["id" => $cl,"idusuario" => $tp]);
        $clCo = $this->doctrine->em->getRepository("Entities\\Cuentas")->findOneBy(["id" => $cl,"idusuario" => $co]);
        //si el resultado es null, entendemos que el teleoperador ha cambiado, así que entramos para
        //cambiar el teleoperador vinculado a la cuenta seguimiento
        if($clTp == null)
        {

            $cSegui = $this->doctrine->em->getRepository("Entities\\Cuentasseguimiento")->findOneBy(["idcliente" => $cl,"actual" => 1]);
            
            if($cSegui)
            {
                //seteamos y guardamos
                $cSegui->setIdteleoperador($teleoperador);
                $this->doctrine->em->flush();
            }

        }
        //realizamos la misma operación con comercial, sólo que aquí también cambiamos
        //el comercial asignado al evento si hay alguno con estado a 0
        if($clCo == null)
        {
            $cSegui = $this->doctrine->em->getRepository("Entities\\Cuentasseguimiento")->findOneBy(["idcliente" => $cl,"actual" => 1]);
            if($cSegui)
            {
                //seteamos y guardamos
                $cSegui->setIdUsuario($comercial);
                $this->doctrine->em->flush();
            }

            $event = $this->doctrine->em->getRepository("Entities\\Calendario")->findOneBy(["idcliente" => $cl,"estado" => 0]);
            if($event)
            {
               //seteamos y guardamos
                $event->setIdUsuario($comercial);
                $this->doctrine->em->flush(); 
            }
            
        }

    }

    private function set_reporte($id,$redirect = true)
    {

        
        //obtenemos el objeto usuario
        $usuario = $this->doctrine->em->find("Entities\\Usuarios", $this->usuarioid);
        //obtenemos el tipo estado seguimiento si tipo reporte existe
        if( isset( $_POST['tipo-reporte'] ) )
        {

            $getEstadosSeguimiento = $this->doctrine->em->getRepository("Entities\\Estadosseguimiento")->findOneBy(["id" => $this->input->post('tipo-reporte')]);
            //llamamos al método get msn para almacenar si procede el mensaje adjunrto al comentario
            $msn = $this->_getReportMsn( $this->input->post('tipo-reporte') );
        }

        if( isset( $_POST['text-reporte'] ) )
            $comentario = $this->input->post('text-reporte');

        if( isset( $_POST['comentario'] ) )
            $comentario = $this->input->post('comentario');
        
        //creamos el reporte vinculado al cliente y al usuario que reporta
        $reporte = new Entities\Reportes;
        $reporte->setIdUsuario($usuario);
        $reporte->setIdrow($id);
        $reporte->setTabla('cuentas');
        $reporte->setComentario($msn.$comentario);
        //si tipo-reporte existe
        if( isset( $_POST['tipo-reporte'] ) )
            $reporte->setReporte($getEstadosSeguimiento->getNombre());

        $this->doctrine->em->persist($reporte);
        $this->doctrine->em->flush();

        if($redirect)
        	//redireccionamos al edit
        	redirect(site_url($this->uri->segment(1) . '/edit/' . $id));

        
    }

    private function _getReportMsn( $type )
    {
        //variable que almacena el mensaje;
        $msn = '';
        //menú para la selección deñ tipo de mensaje
        switch ($type) {

            case 'ProponerKo':
                
                $msn = '<h4><strong>Proponer Ko (DIRECTOR COMERCIAL)</strong></h4><br/>';

                break;

            case 'Volver a llamar':
                
                $msn = '<h4><strong>'.$type.' (DIRECTOR COMERCIAL)</strong></h4><br/>';

                break;
            
            default:
                
                $msn = '';

                break;
        }

        return $msn;
    }

    //subir archivos
    private function up_load($name,$folder)
    {

        $config['upload_path'] = 'assets/'.$folder;
        $config['allowed_types'] = '*';
        $config['max_size']     = '30720';
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['overwrite'] = FALSE;

        $this->load->library('upload');
        $this->upload->initialize($config);

        if($this->upload->do_upload($name))
        {

            $data_image = $this->upload->data();
            $upload_data = array(

                'upload' => TRUE,
                'res' => $data_image['file_name'],
            );

        }else
        {

            $upload_data = array(

                'upload' => FALSE,
                'res' => $this->upload->display_errors('<div class="alert alert-danger" role="alert">', '</div>'),
            );
        }

        return $upload_data;
    }

    private function getCuentasSeguimiento($obj)
    {
        //almacenamos todos los datos del seguimiento de forma ordenada para cada
        //parte del seguimiento de estado de la cuenta
        $cSeg = array();

        foreach ($obj->getCuentasseguimiento() as $key => $value)
        {
            if($value->getEstado() == 1)
            {
                $cSeg[$value->getTipo()] = array(

                    'id' => $value->getId(),
                    'tipo' => $value->getTipo(),
                    'idEstado' => $value->getIdEstado()->getId(),
                    'Fseguimiento' => $value->getFseguimiento()->format("d-m-Y"),
                    'realizado' => $value->getRealizado()
                );
            }
           
        }
                                 
        return $cSeg;

    }

    public function exportData()
    {
        if($this->input->is_ajax_request())
        {
            $path = $this->input->post('path');
            //dibujamos el html que pasaremos al body del modal
            $html = '<div class="form-group">';
            $html .= '<label>Selecciona un estado</label>';
            $html .= '<select name="estado" class="form-control">';
            $html .= '<option value="nuevo">Nuevo</option>';
            $html .= '<option value="oferta">Oferta</option>';
            $html .= '<option value="cierre">Cierre</option>';
            $html .= '</select>';
            $html .= '</div>';
            
            echo $html;

        }else{

            if(isset($_POST['submitModal']))
            {
                $estado = $this->input->post('estado');

                $result = $this->doctrine->em->getRepository("Entities\\Cuentas")->getCuentasByEstado($estado);

                $separador = ";";
                //generamos las cabeceras para el archivo xls
                header("Cache-Control: public");
                header('Content-Type: text/xls; charset=utf-8');
                header('Content-Disposition: attachment; filename=clientes_estado_'.$estado.'.xls');
                echo utf8_decode("CLIENTES ESTADO $estado;\n");
                echo utf8_decode("Teleoperadora;Asignado A;CIF;Cliente;Lineas Moviles;Lineas datos;Fecha cita;\n");

                foreach ($result as $key => $re) 
                {
                    echo $re->getIdcliente()->getIdusuario()->getNombre().$separador;
                    echo $re->getIdusuario()->getNombre().$separador;
                    echo $re->getIdcliente()->getCif().$separador;
                    echo $re->getIdcliente()->getNombre().$separador;
                    echo $re->getIdcliente()->getLineasmovil().$separador;
                    echo $re->getIdcliente()->getLineasdatos().$separador;
                    echo $re->getIdcalendario()->getFecha()->format("d/m/Y").$separador;
                    echo "\n";
                }
                

            }else{

                show_404();
            }

            
        }
    }

    public function setAgendar($id,$external = null)
    {
        if(isset($_POST['submit']) OR isset($_POST['submit-reporte']) OR isset($_POST['submit-AddSeEsModal']))
        {
            //obtenemos el objeto cliente
            $cliente = $this->doctrine->em->find("Entities\\Cuentas", $id);

            if( isset($_POST['submit']) OR isset($_POST['submit-AddSeEsModal']) ){

                if( $this->input->post('estado') == 'ProponerKo' ) {

                    //realizamos el reporte
                    $this->set_reporte($id, false);
                    //redireccionamos a maincontroller/proponerKo/$id
                    redirect(site_url('maincontroller/proponerKo/'.$id.'/'."clientes"));

                }else{

                    $seguimiento = explode(' ', $this->input->post('estado'));
                    $fecha = $this->input->post('fEvent');
                    $hora = $this->input->post('hEvent');
                    $tOperador = $this->input->post('toperador');
                    $comercial = $this->input->post('comercial');
                    $agendarSiNo = $this->input->post('agendarSiNo');
                    $agendarTipo = $this->input->post('agendarTipo');
                    $comentario = $this->input->post('comentario');

                }
                
            }elseif( isset($_POST['submit-reporte']) ) {

                $seguimiento = explode(' ', $this->input->post('tipo-reporte'));
                $fecha = $this->input->post('fEvent');
                $hora = $this->input->post('hEvent');
                $tOperador = $this->input->post('toperador');
                $comercial = $this->input->post('comercial');
                $agendarSiNo = 1;
                $agendarTipo = $this->input->post('agendarTipo');
                $comentario = $this->input->post('text-reporte');
            }

            //comprobamos si el cliente tiene ya asignado algún seguimiento
            //con actual = 1, si es así, lo pasamos a 0. Se realiza un
            //findBy en lugar del findOneBy ya que es posible que en la carga
            //realizada desde el Vtiguer tengamos duplicidades, de esta forma nos aseguramos de ir limpiando.
            $Cseguimiento = $this->doctrine->em->getRepository("Entities\\Cuentasseguimiento")->findBy(["idcliente" => $id,"actual" => 1]);

            if($Cseguimiento)
            {
                foreach ($Cseguimiento as $key => $seg)
                {
                    $seg_ = $this->doctrine->em->getRepository("Entities\\Cuentasseguimiento")->findOneBy(["id" => $seg->getId()]);

                    $seg_->setActual(0);
                    $this->doctrine->em->flush();
                }
            }
            
            //Ahora comprobamos si hay eventos abiertos en el calendario y al igual que con cuentasseguimiento
            //en caso afirmativo, cerramos los eventos. En este caso pasamos estado de 0 a 1
            $eventos = $this->doctrine->em->getRepository("Entities\\Calendario")->findBy(["idcliente" => $id,"estado" => 0]);

            if($eventos)
            {
                foreach ($eventos as $key => $evento)
                {
                    $evento_ = $this->doctrine->em->getRepository("Entities\\Calendario")->findOneBy(["id" => $evento->getId()]);

                    $evento_->setEstado(1);
                    $this->doctrine->em->flush();
                }
            }
            //Finalmente y como se ha realizado con eventos, cerramos todas las tareas que esten asociadas
            //al cliente.
            $tareas = $this->doctrine->em->getRepository("Entities\\Tareas")->findBy(["idcliente" => $id,"estado" => 0]);

            if($tareas)
            {
                foreach ($tareas as $key => $tarea)
                {
                    $tarea_ = $this->doctrine->em->getRepository("Entities\\Tareas")->findOneBy(["id" => $tarea->getId()]);

                    $tarea_->setEstado(1);
                    $this->doctrine->em->flush();
                }
            }

            //ahora solo queda crear la traza del seguimiento según el tipo de seguimiento
            if($seguimiento[0] == 'Nuevo' OR $seguimiento[0] == 'Oferta')
            {
                //si el susario decide crear un evento nuevo al cambiar el estado, entonces entramos y generamos un nuevo evento
                //en caso contrario, el evento que se tomara para vcincular el resto de estados será el que ya existía
                if($agendarSiNo == 1)
                {

                    $event = $this->generateEvento($cliente);

                }else{

                    $event = $this->doctrine->em->getRepository("Entities\\Calendario")->findOneBy(["idcliente" => $cliente->getId()]);

                    $this->generateSeguimiento($event);
                }

                //comprobamos si el teleoperador y el comercial son distintos de los actuales, si es así
                //los actualizamos en la ficha del cliente
                if($cliente->getidusuario()->getId() != $tOperador)
                {
                    $usuario = $this->doctrine->em->find("Entities\\Usuarios", $tOperador);
                    $cliente->setidusuario($usuario);
                    $this->doctrine->em->flush();
                }

                if($cliente->getidcomercial() != $comercial)
                {
                    $usuario = $this->doctrine->em->find("Entities\\Usuarios", $comercial);
                    $cliente->setidcomercial($usuario->getId());
                    $this->doctrine->em->flush();
                }


            }elseif($seguimiento[0] == 'Cierre'){

                if($agendarSiNo == 1)
                {
                    $event = $this->generateEvento($cliente,$agendarTipo);

                }else{

                    $event = $this->doctrine->em->getRepository("Entities\\Calendario")->findOneBy(["idcliente" => $cliente->getId()]);

                    $this->generateSeguimiento($event);
                }
                
                $usuariofrom = $this->doctrine->em->find("Entities\\Usuarios", $cliente->getIdcomercial());
                //cambio 20/03/2018
                //$usuarioto = $this->doctrine->em->find("Entities\\Usuarios", 28);
                $usuarioTo = $this->doctrine->em->getRepository("Entities\\equipos")->findOneBy(["idusuario" => $usuariofrom->getId()]);
                 //comprobamos que la consulta obtiene resultados, en caso negativo, el comercial tiene perfil de director y consultamos en usuarios
                if( $usuarioTo ) {

                    $usuarioTo = $usuarioTo->getIdmaster();
                    
                }else{

                    $usuarioTo = $this->doctrine->em->getRepository("Entities\\Usuarios")->findOneBy(["id" => $usuariofrom->getId()]);
                }
                //obtenemos el objento del evento recien creado
                //creamos una tarea de tipo cierre.
                $newTarea = new Entities\Tareas;
                $newTarea->setIdcliente($cliente);
                $newTarea->setIdusuariofrom($usuariofrom);
                $newTarea->setIdusuarioto( $usuarioTo);
                $newTarea->setIdcalendario($event);
                $newTarea->setTexto($comentario);
                //comprobamos el tipo de formulario
                if( isset($_POST['submit']) ) {

                    $newTarea->setTipo($this->input->post('estado'));;

                }elseif( isset($_POST['submit-reporte']) ) {

                    $newTarea->setTipo($this->input->post('tipo-reporte'));
                }
                
                $newTarea->setIdus($this->usuarioid);
                $newTarea->setIp($this->input->ip_address());
                //guardamos la entidad en la tabla users
                $this->doctrine->em->persist($newTarea);
                $this->doctrine->em->flush();
                //actualizamos el evento recien creado a cerrado
                //$event->setEstado(1);
                //$this->doctrine->em->flush();
                

            }elseif($seguimiento[0] == 'Firmado'){

                $event = $this->doctrine->em->getRepository("Entities\\Calendario")->findOneBy(["idcliente" => $cliente->getId()]);

                $this->generateSeguimiento($event);
            }
            //comprobamos si $exrternal es o no null
            if( $external == null) {

                //redireccionamos al edit
                redirect(site_url($this->uri->segment(1) . '/edit/' . $id));

            }else{

                redirect(site_url($external));
            }
            


        }else{

            show_404();
        }
    }
    /*
        Este método realiza lo siguiente
        1.comprueba que $id > 0, si es así
        2.comprueba mediante nombre empresa y CIF, si el registro existe
        3.si existe edita los datos del registro, edita la teleoperadora a la que está vinculado, y redirecciona a la 
        teleoperadora al registro para comenzar llamada
        4.si no existe, crea el registro, lo vincula a la teleoperadora y redireccionamos al registro para llamada
    */
    public function getRegistro($id = 0) {

        if( $id > 0 ) {
            //obtenemos usuario teleoperadora
            $user = $this->doctrine->em->find("Entities\\Usuarios", $this->usuarioid);
            //obtenemos el objeto cliente
            $cli = $this->doctrine->em->find("Entities\\Cuentas", $id);
            //obtenemos el estado id 4 sin estado para los nuevos registros
            $estado = $this->doctrine->em->find("Entities\\Estadosregistros", 4);
            //obtenemos el operador de telefonía 0 que es sin operador
            $operador = $this->doctrine->em->find("Entities\\Operadores", 0);
            //comprobamos si existe algún registro con los datos, nombre, cif, cp, telefono por separado
            $reg = array(

                        $this->doctrine->em->getRepository("Entities\\Registros")->findOneBy(["empresa" => $cli->getNombre()]),
                        $this->doctrine->em->getRepository("Entities\\Registros")->findOneBy(["cif" => $cli->getCif()]),
                        $this->doctrine->em->getRepository("Entities\\Registros")->findOneBy(["cp" => $cli->getCp()]),
                        $this->doctrine->em->getRepository("Entities\\Registros")->findOneBy(["telefono" => $cli->getTelefono()])
                    );
            //limpiamos los  null del vector reg y hacemos un count
            $reg = array_filter($reg);
            $countReg = count(array_filter($reg));
            //si el conteo de distinto de null en el vector es igual o mayor a 2, el editamos el registros
            //en caso contrario, creamos un registro nuevo.
            if( $countReg >= 2 ) {

                $reg[0]->setEmpresa($cli->getNombre());
                $reg[0]->setTelefono($cli->getTelefono());
                $reg[0]->setPercontacto($cli->getPersonacnt());
                $reg[0]->setCif($cli->getCif());
                $reg[0]->setDireccion($cli->getDireccion());
                $reg[0]->setProvincia($cli->getProvincia());
                $reg[0]->setPoblacion($cli->getPoblacion());
                $reg[0]->setEmail($cli->getEmail());
                $reg[0]->setCp($cli->getCp());
                $reg[0]->setIdusuario($user);
                //actualizamos el registro
                $this->doctrine->em->flush();
                //redireccionamos al registro
                redirect(site_url('/registros/view/'.$reg[0]->getId()));

            }else{

                $newReg = new Entities\Registros;
                //seteamos los datos para el nuevo registro
                $newReg->setEmpresa($cli->getNombre());
                $newReg->setTelefono($cli->getTelefono());
                $newReg->setPercontacto($cli->getPersonacnt());
                $newReg->setCif($cli->getCif());
                $newReg->setDireccion($cli->getDireccion());
                $newReg->setProvincia($cli->getProvincia());
                $newReg->setPoblacion($cli->getPoblacion());
                $newReg->setEmail($cli->getEmail());
                $newReg->setCp($cli->getCp());
                $newReg->setIdusuario($user);
                $newReg->setIdestado($estado);
                $newReg->setidoperador($operador);
                //guardamos en nuevo registro
                $this->doctrine->em->persist($newReg);
    			$this->doctrine->em->flush();
    			//redireccionamos al registro
                redirect(site_url('/registros/view/'.$newReg->getId()));
            }

        }else{

            show_404();
        }
    }
    private function generateEvento($obj,$agendarTipo = false)
    {
        //Obtenemos el usuario
        $user = $this->doctrine->em->find("Entities\\Usuarios", $this->input->post('comercial'));
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
        //comprobamos si Revisar = name="check-event" esta marcado
        if(isset($_POST['check-event']))
        {
            $reg->setCheckit(1);
        }
        
        //guardamos la entidad en la tabla users
        $this->doctrine->em->persist($reg);
        $this->doctrine->em->flush();
        //ahora generamos nuevo uno en seguimiento.
        $evento = $this->doctrine->em->find("Entities\\Calendario", $reg->getId());

        $this->generateSeguimiento($evento,$agendarTipo);
        return $evento;

    }

    private function generateSeguimiento($obj,$agendarTipo = FALSE)
    {
        //obtenemos los objetos usuario y faseventa
        $usuario = $this->doctrine->em->find("Entities\\Usuarios", $this->input->post('comercial'));
        

        $reg = new Entities\Cuentasseguimiento;
        $reg->setIdusuario($usuario);
        $reg->setIdteleoperador($obj->getIdcliente()->getIdusuario());
        $reg->setIdcliente($obj->getIdcliente());
        $reg->setIdcalendario($obj);
        $reg->setIdus($this->usuarioid);
        $reg->setIp($this->input->ip_address());
        $reg->setFromtool("Clientes");

        if($agendarTipo)
        {
            $reg->setTipo($agendarTipo);
            //llamamos al metodo para obtener el tipo de estado, y le pasamos el estado seleccionado
            $estado = $this->_getIdEstadoSeguimiento();

        }else{

            //comprobamos el tipo de formulario
            if( isset($_POST['submit']) OR isset($_POST['submit-AddSeEsModal']) ) {

                $reg->setTipo($this->input->post('estado'));
                //llamamos al metodo para obtener el tipo de estado, y le pasamos el estaod seleccionado
                $estado = $this->_getIdEstadoSeguimiento($this->input->post('estado'));

            }elseif( isset($_POST['submit-reporte']) ) {

                $reg->setTipo($this->input->post('tipo-reporte'));
                //llamamos al metodo para obtener el tipo de estado, y le pasamos el estado seleccionado
                $estado = $this->_getIdEstadoSeguimiento($this->input->post('tipo-reporte'));
            }
            
        }

        $reg->setIdestado($estado);
        
        $reg->setFseguimiento(new \DateTime(formatDateDoct($obj->getFecha()->format("d-m-Y"))));

        //guardamos el seguimiento
        $this->doctrine->em->persist($reg);
        $this->doctrine->em->flush();

        $this->generateReport($reg);

    }

    private function _getIdEstadoSeguimiento($type = NULL)
    {
    	//alamcenamos el id del tipo de seguimiento
    	$id = 0;
    	//menú para seleccionar el tipo de estado seguimiento
    	switch ( $type ) {

    		case 'Firmado':
    			
    			$id = 6;

    			break;

            case 'Cierre':
                
                $id = 13;

                break;
    		
    		default:
    			
    			$id = 0;

    			break;
    	}
    	//obtenemos el estado 
    	$estado = $this->doctrine->em->getRepository("Entities\\Estadosseguimiento")->findOneBy(["id" =>$id]);
    	//y lo devolvemos el objeto
    	return $estado;

    }

    private function generateReport($obj)
    {
        $usuario = $this->doctrine->em->find("Entities\\Usuarios", $this->usuarioid);
        $cliente = $this->doctrine->em->find("Entities\\cuentas", $obj->getIdcliente()->getId());

        $reg = new Entities\Reportes;
        $reg->setIdusuario($usuario);
        //comprobamos el tipo de formulario
        if( isset($_POST['submit']) OR isset($_POST['submit-AddSeEsModal']) ) {

            $reg->setComentario($this->input->post('comentario'));

        }elseif( isset($_POST['submit-reporte']) ) {

            $reg->setComentario($this->input->post('text-reporte'));
        }
        
        $reg->setIdrow($obj->getIdcliente()->getId());
        $reg->setIdrows($obj->getIdcalendario()->getId());
        $reg->setTabla('cuentas');
        $reg->setTablas('calendario');
        //guardamos el seguimiento
        $this->doctrine->em->persist($reg);
        $this->doctrine->em->flush();
        //actualizamos la descripción del cliente
        if( isset($_POST['submit']) )
            $cliente->setDescripcion($this->input->post('comentario'));

        $this->doctrine->em->flush();
    }

    private function setTarea($obj)
    {
        //variable para controlar la cantidad de tareas a crear según el tipo de reporte
        $loop = 0;
        //consultamos si hay tarea abierta de vinculada a este cliente
        $tarea = $this->doctrine->em->getRepository("Entities\\Tareas")->findOneBy(["idcliente" => $obj->getId(),"estado" => 0]);
        //comprobamos si hay un evento en el calendario abierto
        $calendario = $this->doctrine->em->getRepository("Entities\\Calendario")->findOneBy(["idcliente" => $obj->getId(),"estado" => 0]);
        //obtenemos el cuentaSeguimiento
        $cuentaSe = $this->doctrine->em->getRepository("Entities\\Cuentasseguimiento")->findOneBy(["idcliente" => $obj->getId(),"actual" => 1]);
        //comprobamos si hay tare, en caso afirmativo, la cerramos
        if( $tarea ) {
            //seteamos estado a cierre
            $tarea->setEstado(1);
            //actualizamos
            $this->doctrine->em->flush();
        }
        //si hay un evento en el calendario lo cerramos
        if( $calendario ) {
            //seteamos estado a cierre
            $calendario->setEstado(1);
            //actualizamos
            $this->doctrine->em->flush();
        }
        //obtenemos el objeto tipo reporte
        $tipoReporte = $this->doctrine->em->find("Entities\\Estadosseguimiento", $this->input->post('tipo-reporte'));
        //actualizamos el idEstado
        $cuentaSe->setIdestado($tipoReporte);
        $this->doctrine->em->flush();

        //obtenemos el objeto usuarios para usuariofrom "El comercial"
        $usuariotfrom = $this->doctrine->em->find("Entities\\Usuarios", $obj->getIdcomercial());
        //creamos la tarea nueva
        //si el tipo de reposte es = Fac.Recogida = 2, $loop = 1
        if( $this->input->post('tipo-reporte') == 2 )
            $loop = 1;

        for ($i=0; $i <= $loop; $i++) { 

            $nTarea = new Entities\Tareas;
            //establecemos las propiedades a través de los setters
            $nTarea->setIdcliente($obj);
            //si la variable loop es igual a 0, es una tarea normal
            if( $loop == 0 ) {

                $nTarea->setIdusuariofrom($usuariotfrom);
                $nTarea->setIdusuarioto($obj->getIdusuario());
                //si el tipo de reporte desde reporte es igual a 1 = Ausente-reconcertar()TMK, lo marcamos como Ausente-reconcertar()TMK.
                if( $this->input->post('tipo-reporte') == 1 )
                    $nTarea->setTipo('Ausente-reconcertar(TMK)');

            }else{
                //en caso contrario, entramos y comprobamos el valor de i,
                //si es igual a 0, la tarea es de tipo Updocu, y su usuario from  y to son iguales
                //si es igual a 1 entonces el usuario to es igual al director comercial y es de tipo Rdocu
                if( $i == 0 ) {

                    $nTarea->setIdusuariofrom($usuariotfrom);
                    $nTarea->setIdusuarioto($usuariotfrom);
                    $nTarea->setTipo('Updocu');

                }else{

                    $usuarioTo = $this->doctrine->em->getRepository("Entities\\equipos")->findOneBy(["idusuario" => $usuariotfrom->getId()]);
                    $nTarea->setIdusuariofrom($usuariotfrom);
                    $nTarea->setIdusuarioto($usuarioTo->getIdmaster());
                    $nTarea->setTipo('Rdocu');
                }
            }
            //si hay calendario abierto, le pasamos el calendario, si no el calendario vinculado de la tarea
            if( $calendario ) {

                $nTarea->setIdcalendario($calendario);

            }elseif( $tarea ) {

                $nTarea->setIdcalendario($tarea->getIdcalendario());
            }

            $nTarea->setIdus($this->usuarioid);
            $nTarea->setIp($this->input->ip_address());
            //guardamos la  tarea
            $this->doctrine->em->persist($nTarea);
            $this->doctrine->em->flush();
        }

    }

}

?>