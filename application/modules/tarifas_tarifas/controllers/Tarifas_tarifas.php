<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tarifas_tarifas  extends MX_Controller
{
    private $nameClass;
    private $icono;
    private $proyecto;

	public function __construct()
	{
		parent::__construct();
        $this->nameClass = get_class($this);
        $this->proyecto = $this->doctrine->em->find("Entities\\Proyecto", 1);
        $this->icono = 'fa fa-book';
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
        $data['h1'] = str_replace('_',' ',$this->nameClass);
        //lista migas pan
        $data['breadcrumb'] = array(str_replace('_',' ',$this->nameClass));
        //datos cabecera tabla // editado
        $data['thead'] = array('ID','Valor');
        //ruta para los botones y acciones
        $data['path'] = $this->uri->segment(1).'/'.$this->uri->segment(2);
        //obtenemos y mostramos todos los datos // EDITADO
        $data['getResult'] = $this->doctrine->em->getRepository("Entities\\Tartarifas")->findAll();
        //cargamos la vista
        $this->load->view('templates/panel/layout',$data);
	}

    public function add()
    {
        // pasamos los datos básicos del template
        $data['lang'] = "es";
        $data['title'] = $this->proyecto->getNombre()." | Panel de control";
        $data['view'] = strtolower(__FUNCTION__ . "_" . $this->nameClass);
        $data['robots'] = 'noindex, nofollow';
        $data['reference'] = strtoupper(__FUNCTION__ . "-" . $this->nameClass);
        $data['project'] = $this->proyecto;
        //ruta para los botones y acciones
        $data['path'] = $this->uri->segment(1) . '/' . $this->uri->segment(2);
        //icono del módulo
        $data['icono'] = $this->icono;
        // titulo del módulo
        $data['h1'] = 'Crear '.substr(str_replace('_',' ',$this->nameClass), 0, -1);
        //lista migas pan
        $data['breadcrumb'] = array(str_replace('_',' ',$this->nameClass),'Crear '.substr(str_replace('_',' ',$this->nameClass), 0, -1));
        //obtenemos un listado con todos los grupos de tarifas
        $data['getGruposTarifas'] = $this->doctrine->em->getRepository("Entities\\Targrupos")->findAll();

        //comprobamos formulario submit
        if(isset($_POST['submit']))
        {
            //validamos los datos
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('Targrupo', 'Grupo', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

            if ($this->form_validation->run())
            {
            	//obtenemos el objeto grupo
        		$grupo = $this->doctrine->em->getRepository("Entities\\Targrupos")->findOneBy(["id" => $this->input->post('Targrupo')]);
                //instanciamos la entidad
                $tarifa = new Entities\Tartarifas;
                //seteamos los datos
                $tarifa->setNombre($this->input->post('nombre'));
                $tarifa->setIdgrupo($grupo);
                //guardamos
                $this->doctrine->em->persist($tarifa);
                $this->doctrine->em->flush();

                //redireccionamos al edit
                redirect(site_url($data['path'].'/edit/'.$tarifa->getId()));
            }
        }

        //cargamos la vista
        $this->load->view('templates/panel/layout',$data);
    }

    public function edit($id)
    {
        // pasamos los datos básicos del template
        $data['lang'] = "es";
        $data['title'] = $this->proyecto->getNombre()." | Panel de control";
        $data['view'] = strtolower(__FUNCTION__."_".$this->nameClass);
        $data['robots'] = 'noindex, nofollow';
        $data['reference'] = strtoupper(__FUNCTION__."-".$this->nameClass);
        $data['project'] = $this->proyecto;
        //ruta para los botones y acciones
        $data['path'] = $this->uri->segment(1).'/'.$this->uri->segment(2);

        $data['id'] = $id;
        //icono del módulo
        $data['icono'] = $this->icono;
        // titulo del módulo
        $data['h1'] = 'Editar '.substr(str_replace('_',' ',$this->nameClass), 0, -1);
        //lista migas pan
        $data['breadcrumb'] = array(str_replace('_',' ',$this->nameClass),'Editar '.substr(str_replace('_',' ',$this->nameClass), 0, -1));
        //obtenemos un listado con todos los grupos de tarifas
        $data['getGruposTarifas'] = $this->doctrine->em->getRepository("Entities\\Targrupos")->findAll();
        //obtenemos los datos por su id
        $data['getRow'] = $this->doctrine->em->find("Entities\\Tartarifas", $id);
        //obtenemos las configuraciones de la tarifa por su id
        $data['getCofigurations'] = $this->doctrine->em->getRepository("Entities\\Tarconfigurador")->findBy(["idtarifa" => $id]);
        //obtenemos un listado de los origenes
        $data['getOrigenes'] = $this->doctrine->em->getRepository("Entities\\Tarorigenes")->findAll();
        //obtenemos un listado de los terminaels
        $data['getTerminales'] = $this->doctrine->em->getRepository("Entities\\Tarterminales")->findAll();
        //obtenemos un listado de los paquetes
        $data['getPaquetes'] = $this->doctrine->em->getRepository("Entities\\Tarpaquetes")->findAll();
        //comprobamos formulario submit
        if(isset($_POST['submit']))
        {
            //validamos los datos
            $this->form_validation->set_rules('nombre', 'Nombre', 'required');
            $this->form_validation->set_rules('Targrupo', 'Grupo', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

            if ($this->form_validation->run())
            {
                //obtenemos tarifa
                $tarifa = $data['getRow'];
            	//obtenemos el objeto grupo
        		$grupo = $this->doctrine->em->getRepository("Entities\\Targrupos")->findOneBy(["id" => $this->input->post('Targrupo')]);
                //seteamos su nombre y lo actualizamos
                $data['getRow']->setNombre($this->input->post('nombre'));
                $tarifa->setIdgrupo($grupo);
                $this->doctrine->em->flush();
            }

        }
        //cargamos la vista
        $this->load->view('templates/panel/layout',$data);

    }

    public function delete($id,$id2 = 0)
    {
        if($id2 > 0)
        {

            //obtenemos el dato mediante id
            $getRow = $this->doctrine->em->getRepository("Entities\\Tarconfigurador")->findOneBy(["id" => $id]);
            //eliminamos el item
            $this->doctrine->em->remove($getRow);
            $this->doctrine->em->flush();
            //ruta para los botones y acciones
            $path = $this->uri->segment(1).'/'.$this->uri->segment(2).'/edit/'.$id2;

        }elseif($id2 == 0){

            //obtenemos el dato mediante id
            $getRow = $this->doctrine->em->getRepository("Entities\\Tartarifas")->findOneBy(["id" => $id]);
            //eliminamos el item
            $this->doctrine->em->remove($getRow);
            $this->doctrine->em->flush();
            //ruta para los botones y acciones
            $path = $this->uri->segment(1).'/'.$this->uri->segment(2);

        }
        //redireccionamos
        redirect(site_url($path));
        
    }

    public function setOrigen($id)
    {
    	if(isset($_POST['submit']))
    	{

    		//almacenamos el id origen
    		$origen = $this->input->post('origenes');
    		//obtenemos los objetos orignenes y tarifas
    		$origen = $this->doctrine->em->find("Entities\\Tarorigenes", $origen);
    		$tarifa = $this->doctrine->em->find("Entities\\Tartarifas", $id);
    		//instanciamos la entidad
            $config = new Entities\Tarconfigurador;
            //seteamos los datos
            $config->setIdorigen($origen);
            $config->setIdtarifa($tarifa);
            //guardamos
            $this->doctrine->em->persist($config);
            $this->doctrine->em->flush();
            //redireccionamos al edit
            redirect(site_url('/tarifas/tarifas/edit/'.$id));



    	}else{

    		show_404();
    	}
    }

    public function copyItem($id,$id2)
    {
    	$config = $this->doctrine->em->find("Entities\\Tarconfigurador", $id);
    	//instanciamos la entidad
        $newConfig = new Entities\Tarconfigurador;
        //seteamos los datos
        $newConfig->setIdorigen($config->getIdorigen());
        $newConfig->setIdtarifa($config->getIdtarifa());
        $newConfig->setIdterminal($config->getIdterminal());
        $newConfig->setIdpaquete($config->getIdpaquete());
        $newConfig->setComision($config->getComision());
        //guardamos
        $this->doctrine->em->persist($newConfig);
        $this->doctrine->em->flush();
    	//redireccionamos al edit
         redirect(site_url('/tarifas/tarifas/edit/'.$id2));
    }

}
