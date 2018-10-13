<?php 
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oportunidades extends MX_Controller
{
    private $nameClass;
    private $icono;
    private $proyecto;
    private $start = 0;
    private $limit = 0;
    private $totalRecord = 0;

    public function __construct()
    {
        parent::__construct();
        $this->nameClass = get_class($this);
        $this->proyecto = $this->doctrine->em->find("Entities\\Proyecto", 1);
        $this->icono = 'icon-bulb';
        //cargamos el helper para generación del pass
        $this->load->helper('generate_pass_helper');
        $this->load->helper('MY_encrypt_helper');
        //formate la fecha para pasarla a doctrine
        $this->load->helper('format_date_doctrine_helper');
        //helper uploads
        $this->load->helper('upload_helper');
        $this->limit = 25;
        $this->totalRecord = count($this->doctrine->em->getRepository("Entities\\Oportunidades")->findAll());
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
        //icono del módulo
        $data['icono'] = $this->icono;
        // titulo del módulo
        $data['h1'] = $this->nameClass;
        //lista migas pan
        $data['breadcrumb'] = array($this->nameClass);
        //datos cabecera tabla
        $data['thead'] = array('ID', 'Nombre');
        //ruta para los botones y acciones
        $data['path'] = $this->uri->segment(1);

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


        //obtenemos y mostramos todos los date_offset_get()
        $data['getResult'] = $this->doctrine->em->getRepository("Entities\\Oportunidades")->getOportunidadesLimit($this->limit,$this->start);

        //cargamos la vista
        $this->load->view('templates/panel/layout', $data);
    }



    public function add()
    {
        // pasamos los datos básicos del template
        $data['lang'] = "es";
        $data['title'] = $this->proyecto->getNombre() . "| Admin Dashboard";
        $data['view'] = strtolower(__FUNCTION__ . "_" . $this->nameClass);
        $data['robots'] = 'noindex, nofollow';
        $data['project'] = $this->proyecto;
        $data['reference'] = strtoupper(__FUNCTION__ . "-" . $this->nameClass);
        //ruta para los botones y acciones
        $data['path'] = $this->uri->segment(1);

        //pasamos css para esta página
        $data['css'] = $this->load->view('css_module/css_module','',TRUE);
        //pasamos js para esta página
        $data['js'] = $this->load->view('js_module/js_module','',TRUE);

        //icono del módulo
        $data['icono'] = $this->icono;
        // titulo del módulo
        $data['h1'] = 'Crear '.substr($this->nameClass, 0, -2);
        //lista migas pan
        $data['breadcrumb'] = array($this->nameClass,'Crear '.substr($this->nameClass, 0, -2));

        //obtenemos los usuarios
        $data['getUsuarios'] = $this->doctrine->em->getRepository("Entities\\Usuarios")->findAll();
        //obtenemos fases de vetnas
        $data['getFaseVenta'] = $this->doctrine->em->getRepository("Entities\\Faseventas")->findAll();
        //obtenemos listado de las cuentas, pasando el $max para limitar la salida
        $data['getCuentas'] = $this->doctrine->em->getRepository("Entities\\Cuentas")->getCuentasLimit($this->limit);
        //total de cuentas
        $data['totalCuentas'] = count($this->doctrine->em->getRepository("Entities\\Cuentas")->findAll());
        //máximo número de registro para modal cuentas
        $data['max'] = $this->limit;


         //comprobamos formulario submit
        if (isset($_POST['submit'])){

            //validamos los datos
            $this->form_validation->set_rules('oportunidad', 'Nombre Oportunidad', 'required');
            $this->form_validation->set_rules('idcuenta','Cuenta','required');
            $this->form_validation-> set_rules('idUsuario','Usuario','required');
            $this->form_validation->set_rules('venta','Fase Venta','required');
            $this->form_validation->set_rules('fechaci','Fecha Cita','required');


            $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

            if($this->form_validation->run()){

                //obtenemos el usuario seleccionado
                $cuenta = $this->doctrine->em->find("Entities\\Cuentas", $this->input->post('idcuenta'));
                $usuario = $this->doctrine->em->find("Entities\\Usuarios", $this->input->post('idUsuario'));
                $venta= $this->doctrine->em->find("Entities\\Faseventas", $this->input->post('venta'));
                //instanciamos el objeto
                $reg = new Entities\Oportunidades;
                //utilizamos el metido privado seter data para setear los datos y le pasamos el tipo de
                //accion que en este caso tiene que ser add
                $param = array('cuenta' => $cuenta,'usuario' => $usuario,'venta' => $venta);
                $this->seter_data($reg,__FUNCTION__,$param);

                //redireccionamos al edit
                redirect(site_url($data['path'] . '/edit/' . $reg->getId()));

            }

        }

        if (isset($_POST['cuenta'])) {
                $this->add_cuentas();
            }

        //cargamos la vista
        $this->load->view('templates/panel/layout',$data);
    }

    public function edit($id)
    {
        // pasamos los datos básicos del template
        $data['lang'] = "es";
        $data['title'] = $this->proyecto->getNombre() . "| Admin Dashboard";
        $data['view'] = strtolower(__FUNCTION__ . "_" . $this->nameClass);
        $data['robots'] = 'noindex, nofollow';
        $data['project'] = $this->proyecto;
        $data['reference'] = strtoupper(__FUNCTION__ . "-" . $this->nameClass);
        //ruta para los botones y acciones
        $data['path'] = $this->uri->segment(1);

        //pasamos css para esta página
        $data['css'] = $this->load->view('css_module/css_module','',TRUE);
        //pasamos js para esta página
        $data['js'] = $this->load->view('js_module/js_module','',TRUE);

        //icono del módulo
        $data['icono'] = $this->icono;
        // titulo del módulo
        $data['h1'] = 'Crear '.substr($this->nameClass, 0, -2);
        //lista migas pan
        $data['breadcrumb'] = array($this->nameClass,'Crear '.substr($this->nameClass, 0, -2));

        //obtenemos los datos de la oportunidad mediante el id
        $data['oportunidad'] = $this->doctrine->em->find("Entities\\Oportunidades", $id);

        //obtenemos los usuarios
        $data['getUsuarios'] = $this->doctrine->em->getRepository("Entities\\Usuarios")->findAll();
        //obtenemos fases de vetnas
        $data['getFaseVenta'] = $this->doctrine->em->getRepository("Entities\\Faseventas")->findAll();
        //obtenemos listado de las cuentas, pasando el $max para limitar la salida
        $data['getCuentas'] = $this->doctrine->em->getRepository("Entities\\Cuentas")->getCuentasLimit($this->limit);
        //total de cuentas
        $data['totalCuentas'] = count($this->doctrine->em->getRepository("Entities\\Cuentas")->findAll());
        //máximo número de registro
        $data['max'] = $this->limit;


         //comprobamos formulario submit
        if (isset($_POST['submit'])){

            //validamos los datos
            $this->form_validation->set_rules('oportunidad', 'Nombre Oportunidad', 'required');
            $this->form_validation->set_rules('idcuenta','Cuenta','required');
            $this->form_validation-> set_rules('idUsuario','Usuario','required');
            $this->form_validation->set_rules('venta','Fase Venta','required');
            $this->form_validation->set_rules('fechaci','Fecha Cita','required');


            $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

            if($this->form_validation->run()){

                //obtenemos el usuario seleccionado
                $cuenta = $this->doctrine->em->find("Entities\\Cuentas", $this->input->post('idcuenta'));
                $usuario = $this->doctrine->em->find("Entities\\Usuarios", $this->input->post('idUsuario'));
                $venta= $this->doctrine->em->find("Entities\\Faseventas", $this->input->post('venta'));
                //instanciamos el objeto
                //$reg = new Entities\Oportunidades;
                $reg=$data['oportunidad'];
                //utilizamos el metido privado seter data para setear los datos y le pasamos el tipo de
                //accion que en este caso tiene que ser add
                $param = array('cuenta' => $cuenta,'usuario' => $usuario,'venta' => $venta);
                $this->seter_data($reg,'edit',$param);

                //redireccionamos al edit
                redirect(site_url($data['path'] . '/edit/' . $reg->getId()));

            }
        }

        if (isset($_POST['cuenta'])) {
                $this->add_cuentas();
            }

        //cargamos la vista
        $this->load->view('templates/panel/layout',$data);
    }

    public function delete($id)
    {

        //obtenemos el dato mediante id
        $getRow = $this->doctrine->em->getRepository("Entities\\Oportunidades")->findOneBy(["id" => $id]);
        //eliminamos el item
        $this->doctrine->em->remove($getRow);
        $this->doctrine->em->flush();
        //ruta para los botones y acciones
        $path = $this->uri->segment(1);
        //redireccionamos
        redirect(site_url($path));

    }

    public function pagination()
    {
        if ($this->input->is_ajax_request())
        {
            $max = $this->input->post('max');
            $start = $this->input->post('start');
            $entity = $this->input->post('entity');

            //obtenemos listado de las cuentas, pasando el $max para limitar la salida
        $data['getCuentas'] = $this->doctrine->em->getRepository("Entities\\".$entity)->getCuentasLimit($this->limit,$start);
            
            echo $this->load->view('include/modal/table_cuentas',$data, TRUE);
           
        }else{

            show_404();
        }
    }


    public function search()
    {
        if ($this->input->is_ajax_request())
        {

            $entity = $this->input->post('entity');
            $q = $this->input->post('q');
            $param = $this->input->post('param');

            //obtenemos listado de las cuentas, pasando el $max para limitar la salida
        $data['getCuentas'] = $this->doctrine->em->getRepository("Entities\\".$entity)->getCuentasLimit($this->limit,0,$q,$param);

        if($data['getCuentas'])
        {
            echo $this->load->view('include/modal/table_cuentas',$data, TRUE);

        }else{

            echo '<div class="alert alert-warning" role="alert">La consulta no ha arrojado ningún resultado.</div>';
        }
            
            
           
        }else{

            show_404();
        }
    }

    public function select_account()
    {
        if ($this->input->is_ajax_request())
        {
            $id = $this->input->post('id');
            
            //obtenemos la cuenta seleccionada mediante su ID
            $getCuenta = $this->doctrine->em->find("Entities\\Cuentas", $id);
            //creamos el array con los datos del la cuenta
            $json = array('id' => $id,'nombre' => $getCuenta->getNombre());
            echo json_encode($json);
            
        }else{

            show_404();
        }
    }

    public function add_cuentas()
    {
        //instanciamos la entidad
        $reg = new Entities\Cuentas;
        //obtenemos el usuario
        $usuario = $this->doctrine->em->find("Entities\\Usuarios", $this->input->post('idUsuario'));

        //seteamos los datos
        $reg->setNombre($this->input->post('nombre'));
        $reg->setTelefono(str_replace(' ', '', $this->input->post('telefono')));
        $reg->setTelefonoalt(str_replace(' ', '', $this->input->post('telefonoAlt')));
        $reg->setEmail($this->input->post('email'));
        $reg->setCif($this->input->post('cif'));
        $reg->setPersonacnt($this->input->post('personaCnt'));
        //si notiPro esta chequeado
        if($this->input->post('notiPro'))
        {
            $reg->setNotipro(1);
        }

        $reg->setDireccion($this->input->post('direccion'));
        $reg->setPoblacion($this->input->post('poblacion'));
        $reg->setProvincia($this->input->post('provincia'));
        $reg->setIdusuario($usuario);
        $reg->setCp($this->input->post('cp'));

        //guardamos
        $this->doctrine->em->persist($reg);
        $this->doctrine->em->flush();

        //redireccionamos al edit
        redirect(site_url($data['path'].'/oportunidades/add/'));

    }

    private function seter_data($reg,$type,$param = array())
    {

        //Seteamos los datos
        $reg->setNombre($this->input->post('oportunidad'));
        $reg->setCif($this->input->post('cif')); 
        $reg->setCp($this->input->post('cp'));
        $reg->setPoblacion($this->input->post('poblacion'));
        $reg->setOperadora($this->input->post('operadora'));
        $reg->setLineasmoviles($this->input->post('lineamo'));
        $reg->setLineasdatos($this->input->post('lineada'));
        $reg->setAdsl($this->input->post('adsl'));
        $reg->setConectapyme($this->input->post('pymes'));
        $reg->setHistorial($this->input->post('historial'));
        $reg->setTeleoperadora($this->input->post('teleoperadora'));
        $reg->setFacturacrm($this->input->post('facturacrm'));

        $reg->setPreentrcliente($this->input->post('presupuestocli'));

        $reg->setPresupuestocrm(new \DateTime(formatDateDoct($this->input->post('presupuestocrm'))));
        $reg->setCoberturacrm(new \DateTime(formatDateDoct($this->input->post('coberturacrm'))));
        $reg->setPresupuestocrm(new \DateTime(formatDateDoct($this->input->post('citapre'))));
        //$reg->setPreentrcliente($this->input->post('precliente'));
        $reg->setCitaentrpresupuesto(new \DateTime(formatDateDoct($this->input->post('citapre'))));
        $reg->setFecproxllamada(new \DateTime(formatDateDoct($this->input->post('fechalla'))));
        $reg->setFechacita(new \DateTime(formatDateDoct($this->input->post('fechaci'))));
        $reg->setTarea($this->input->post('tarea'));//
        $reg->setN2(new \DateTime(formatDateDoct($this->input->post('n2'))));
        $reg->setN3(new \DateTime(formatDateDoct($this->input->post('n3'))));
        $reg->setOferta2(new \DateTime(formatDateDoct($this->input->post('oferta2'))));
        $reg->setOferta3(new \DateTime(formatDateDoct($this->input->post('oferta3'))));
        $reg->setCierra(new \DateTime(formatDateDoct($this->input->post('cierre'))));
        $reg->setFechako(new \DateTime(formatDateDoct($this->input->post('fechako'))));
        $reg->setConverg($this->input->post('converg'));

        $reg->setFecfactura(new \DateTime(formatDateDoct($this->input->post('factura'))));
        //$reg->setTeleoperadora($this->input->post('canguro'));
        //$reg->setTeleoperadora($this->input->post('vol'));


        $reg->setIdusuario($param['usuario']);
        $reg->setIdcuenta($param['cuenta']);
        $reg->setIdfaseventa($param['venta']);


        //guardamos la entidad en la tabla users
        if($type == "add")
            $this->doctrine->em->persist($reg);

        $this->doctrine->em->flush();

    }

}

?>