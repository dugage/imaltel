<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Operadores  extends MX_Controller
{
    private $nameClass;
    private $icono;
    private $proyecto;

	public function __construct()
	{
		parent::__construct();
        $this->nameClass = get_class($this);
        $this->proyecto = $this->doctrine->em->find("Entities\\Proyecto", 1);
        $this->icono = 'icon-screen-smartphone';
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
        $data['getResult'] = $this->doctrine->em->getRepository("Entities\\Operadores")->findAll();

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
        //ruta para los botones y acciones
        $data['path'] = $this->uri->segment(1) . '/' . $this->uri->segment(2);

        //icono del módulo
        $data['icono'] = $this->icono;
        // titulo del módulo
        $data['h1'] = 'Crear '.substr(str_replace('_',' ',$this->nameClass), 0, -2);
        //lista migas pan
        $data['breadcrumb'] = array(str_replace('_',' ',$this->nameClass),'Crear '.substr(str_replace('_',' ',$this->nameClass), 0, -2));

        //comprobamos formulario submit
        if(isset($_POST['submit']))
        {
            //validamos los datos // EDITADO
            $this->form_validation->set_rules('valor', 'Valor', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

            if ($this->form_validation->run())
            {
                //instanciamos la entidad //EDITADO
                $venta = new Entities\Operadores;
                //seteamos los datos // EDITADO
                $venta->setValor($this->input->post('valor'));
                //guardamos //EDITADO
                $this->doctrine->em->persist($venta);
                $this->doctrine->em->flush();

                //redireccionamos al edit // EDITADO
                redirect(site_url($data['path'].'/edit/'.$venta->getId()));
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
        //ruta para los botones y acciones
        $data['path'] = $this->uri->segment(1).'/'.$this->uri->segment(2);

        //icono del módulo
        $data['icono'] = $this->icono;
        // titulo del módulo
        $data['h1'] = 'Editar '.substr(str_replace('_',' ',$this->nameClass), 0, -2);
        //lista migas pan
        $data['breadcrumb'] = array(str_replace('_',' ',$this->nameClass),'Editar '.substr(str_replace('_',' ',$this->nameClass), 0, -2));

        //obtenemos los datos por su id
        $data['getRow'] = $this->doctrine->em->find("Entities\\Operadores", $id);
        //comprobamos formulario submit
        if(isset($_POST['submit']))
        {
            //validamos los datos
            $this->form_validation->set_rules('valor', 'Valor', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger" role="alert">', '</div>');

            if ($this->form_validation->run())
            {
                //seteamos su nombre y lo actualizamos
                $data['getRow']->setValor($this->input->post('valor'));
                $this->doctrine->em->flush();
            }

        }
        //cargamos la vista
        $this->load->view('templates/panel/layout',$data);

    }

    public function delete($id)
    {
        //obtenemos el dato mediante id
        $getRow = $this->doctrine->em->getRepository("Entities\\Faseventas")->findOneBy(["id" => $id]);
        //eliminamos el item
        $this->doctrine->em->remove($getRow);
        $this->doctrine->em->flush();
        //ruta para los botones y acciones
        $path = $this->uri->segment(1).'/'.$this->uri->segment(2);
        //redireccionamos
        redirect(site_url($path));
    }

}
