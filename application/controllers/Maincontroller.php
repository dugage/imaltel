<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maincontroller extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('format_date_doctrine_helper');
        $this->load->helper('my_playing_dates_helper');
    }

    public function ko($id)
    {
        $cif = "";
        $module = $this->input->post('module');
        $comentario = $this->input->post('comentario');
        //almacenamos la fecha actual, mas tarde dependiendo del tipo de seguimiento
        //esta fecha dentra una suma de meses que pueden ser 3 para nuevo o 6 para oferta
        $fecha = date('d-m-Y');
        //comprobamos el módulo desde el que se realiza la acción
        if($module == 'tareas')
        {
            //obtenemos los datos de la tarea
            $tarea = $this->doctrine->em->find("Entities\\Tareas", $id);
            $cif = $tarea->getIdcliente()->getCif();

        }elseif($module == 'cliente')
        {
            $cl = $this->doctrine->em->find("Entities\\Cuentas", $id);
            $cif = $cl->getCif();
        }
        //y con el DNI/CIF Obtenemos el registro y el cliente
        $registro = $this->doctrine->em->getRepository("Entities\\Registros")->findOneBy(["cif" => $cif]);
        $cliente = $this->doctrine->em->getRepository("Entities\\Cuentas")->findOneBy(["cif" => $cif]);

        if ($this->input->is_ajax_request())
        {

            $ko = $this->input->post('ko');


            switch ($ko)
            {

                case 'No interesa':
                    
                    $fecha = add_days(180,$fecha);

                    break;

                case 'Cobertura':
                    
                    $fecha = add_days(180,$fecha);
                    
                    break;

                case 'Oferta':
                    
                    $fecha = add_days(180,$fecha);
                    
                    break;

                case 'Permanencia':
                    
                    $fecha = add_days(180,$fecha);
                    
                    break;

                case 'Penalización':
                    
                    $fecha = add_days(180,$fecha);
                    
                    break;

                default:

                    $select = $this->input->post('select');
                    $radio = $this->input->post('radio');

                    if($radio == 'Permanencia' OR $radio == 'Penalización' OR $radio == 'Permanencia')
                    {
                        if($select > 1)
                        {
                            $select = $select - 30;
                        }
                    }
                    
                    $fecha = add_days($select,$fecha);

                    break;
                
            }

        }else{

            //obtenemos los datos de seguimiento
            $seguimiento = $this->doctrine->em->getRepository("Entities\\Cuentasseguimiento")->findOneBy(["idcalendario" => $tarea->getIdcalendario()]);

            if($seguimiento->getTipo() == 'Nuevo 1' OR $seguimiento->getTipo() == 'Nuevo 2' OR $seguimiento->getTipo() == 'Nuevo 3')
            {

                $fecha = add_days(90,$fecha);

            }

        }
        
        //obtenemos estado 27 = pospuesto para que el registro quede con dicho estado
        $estado = $this->doctrine->em->find("Entities\\Estadosregistros", 27);
        //si registro es igual null, entonces creamos el registro
        if(!$registro)
        {
            $registro_ = new Entities\Registros;

        }else{

            $registro_ = $registro;
        }

        //Seteamos los datos
        $registro_->setEmpresa($cliente->getNombre());
        $registro_->setTelefono(str_replace(' ', '', $cliente->getTelefono()));
        $registro_->setAdministrador($cliente->getPersonacnt());
        $registro_->setPercontacto($cliente->getPersonacnt());
        $registro_->setCif($cliente->getCif());
        $registro_->setDireccion($cliente->getDireccion());
        $registro_->setProvincia($cliente->getProvincia());
        $registro_->setPoblacion($cliente->getPoblacion());
        $registro_->setEmail($cliente->getEmail());
        $registro_->setCp($cliente->getCp());
        $registro_->setFregistro(new \DateTime(formatDateDoct($fecha)));
        $registro_->setOculto(0);
        $registro_->setIdestado($estado);
        $registro_->setIdusuario($cliente->getIdusuario());
        $registro_->setIdoperador($cliente->getIdoperador());

        if(!$registro)
            $this->doctrine->em->persist($registro_);
               
        $this->doctrine->em->flush();

        //cerramos tarea
        if($module == 'tareas')
        {
            $tarea->setEstado(1);


        }else{

            $tarea = $this->doctrine->em->getRepository("Entities\\Tareas")->findOneBy(["idcliente" => $id,"estado" => 0]);
            if( $tarea ) {

                $tarea->setEstado(1);
            }
            
        }

        if( $tarea ) {
            //comprobamos si hay mas tareas abiertas, y las cerramos
            $this->_closeTareas($tarea->getIdcliente());
        }

        $this->doctrine->em->flush();
        //cerramos el estado seguimiento cerrado y creamos el KO, comprobando si tarea no es null
        if($module == 'tareas')
        {
            
            $seguimiento = $this->doctrine->em->getRepository("Entities\\Cuentasseguimiento")->findOneBy(["idcliente" => $tarea->getIdcliente()->getId(),"actual" => 1]);
        }else{

            $seguimiento = $this->doctrine->em->getRepository("Entities\\Cuentasseguimiento")->findOneBy(["idcliente" => $id,"actual" => 1]);
        }
        
        $seguimiento->setActual(0);
        $this->doctrine->em->flush();
        //Cerramos en caso afirmativo el evento, comprobando si tarea no es null
        if($module == 'tareas')
        {
            $evento = $this->doctrine->em->getRepository("Entities\\Calendario")->findOneBy(["idcliente" => $tarea->getIdcliente()->getId(),"estado" => 0]);
        }else{

            $evento = $this->doctrine->em->getRepository("Entities\\Calendario")->findOneBy(["idcliente" => $id,"estado" => 0]);
        }

        if($evento)
        {

            $evento->setEstado(1);
            $this->doctrine->em->flush();

        }

        $newSeguimiento = new Entities\Cuentasseguimiento;
        $newSeguimiento->setIdusuario($seguimiento->getIdusuario());
        $newSeguimiento->setIdteleoperador($seguimiento->getIdteleoperador());
        $newSeguimiento->setIdcliente($seguimiento->getIdcliente());
        $newSeguimiento->setIdcalendario($seguimiento->getIdcalendario());
        $newSeguimiento->setTipo('Ko');
        $newSeguimiento->setIdestado($seguimiento->getIdestado());
        $newSeguimiento->setFseguimiento(new \DateTime("now"));
        $newSeguimiento->setFpospuesto(new \DateTime(formatDateDoct($fecha)));
        $newSeguimiento->setIdus($this->session->userdata('usuarioid'));
        $newSeguimiento->setIp($this->input->ip_address());
        //descomponemos la fecha
        $fecha_ = explode('-', $fecha);
        $newSeguimiento->setCodepospuesto($fecha_[2].$fecha_[1].$fecha_[0]);
        $this->doctrine->em->persist($newSeguimiento);
        $this->doctrine->em->flush();
        //guardamos el comentario en reportes
        $newReporte = new Entities\Reportes;
        //obtenemos el objeto usuario para capturar quien realizo el reporte
        $usuario = $this->doctrine->em->find("Entities\\Usuarios", $this->session->userdata('usuarioid'));

        $newReporte->setTabla("cuentas");
        $newReporte->setIdrow($cliente->getId());
        $newReporte->setComentario($comentario);
        $newReporte->setIdusuario($usuario);
        $this->doctrine->em->persist($newReporte);
        $this->doctrine->em->flush();
        //redireccionamos
        //redirect('tareas/edit/'.$id);

    }

    private function _closeTareas($id) 
    {
        //obtenemos el listado de tareas por id cliente
        $tareas = $this->doctrine->em->getRepository("Entities\\Tareas")->findBy(["idcliente" => $id,"estado" => 0]);
        //si contiene datos, los recorremos y los cerramos, uno por uno
        if ( $tareas ) {

            foreach ( $tareas as $key => $tarea ) {
                
                $tar = $this->doctrine->em->find("Entities\\Tareas", $tarea->getId());
                //cerramos la tarea
                $tar->setEstado(1);
                $this->doctrine->em->flush();
            }
        }

    }

    public function proponerKo($id = 0,$url){

        if( $id > 0 ) {
            //comprobamos si  url es = tareas
            if( $url == 'tareas' ) {
                //si es así, sobreescribimos $id con el id de cliente de tarea
                $tarea = $this->doctrine->em->find("Entities\\Tareas", $id);
                $id =  $tarea->getIdcliente()->getId(); 
            }
            //obtenemos el cliente
            $cli = $this->doctrine->em->find("Entities\\Cuentas", $id);
            //obtenemos el usuario comercial
            $usuariotfrom = $this->doctrine->em->find("Entities\\Usuarios", $cli->getIdcomercial());
            //obtenemos el usuario coordinador = 21
            $usuarioTo = $this->doctrine->em->find("Entities\\Usuarios", 21);
            //obtenemos cuentaSeguimiento acutal
            $cuentaSeguimiento = $this->doctrine->em->getRepository("Entities\\Cuentasseguimiento")->findOneBy(["idcliente" => $id,"actual" => 1]);
            //por problemas de duplicidad, y ya que no somos capaces de replicarlo, vamos a comprobar que una tarea, no comparta en proponer a ko ciertos parametros, en caso de dar resultados, no lo crearemos
            $haveTarea = $this->doctrine->em->getRepository("Entities\\Tareas")->findOneBy([
                "idcliente" => $cli->getId(),
                "idusuariofrom" => $usuariotfrom,
                "idusuarioto" => $usuarioTo,
                "idcalendario" => $cuentaSeguimiento->getIdcalendario(),
                "idcalendario" => "Proponer ko",
                "estado" => 0,
            ]);
            if($haveTarea == null) {

                //creamos la tarea nueva
                $nTarea = new Entities\Tareas;
                //establecemos las propiedades a través de los setters
                $nTarea->setIdcliente($cli);
                $nTarea->setIdusuariofrom($usuariotfrom);
                $nTarea->setIdusuarioto($usuarioTo);
                $nTarea->setIdcalendario($cuentaSeguimiento->getIdcalendario());
                $nTarea->setIdus($this->session->userdata('usuarioid'));
                $nTarea->setIp($this->input->ip_address());
                $nTarea->setTipo("Proponer ko");
                //guardamos la entidad en la tabla tareas
                $this->doctrine->em->persist($nTarea);
                $this->doctrine->em->flush();
                //según de donde venga la llamada al metodo hacemos un redirect
            }
            
            if( $url == 'clientes' ) {

                redirect($url.'/edit/'.$id);

            }elseif( $url == 'tareas' ) {
                //obtenemos el objeto del usuario que realiza la acción
                $usuario = $this->doctrine->em->find("Entities\\Usuarios", $this->session->userdata('usuarioid'));
                //realizamos el reporte
                $reg = new Entities\Reportes;
                //seteamos los datos
                $reg->setIdusuario($usuario);
                $reg->setComentario($this->input->post('text-reporte'));
                $reg->setIdrow($id);
                $reg->setTabla('cuentas');
                //guardamos el seguimiento
                $this->doctrine->em->persist($reg);
                $this->doctrine->em->flush();
                redirect($url);
            }

        }else{

            show_404();
        }

    }

    public function volverLlamar( $id = 0,$url,$fEvent,$hEvent,$comment ) {
        //obtenemos el usuario que realiza la acción
        $user = $this->doctrine->em->find("Entities\\Usuarios", $this->session->userdata('usuarioid'));
        //obtenemos el cliente
        $cli = $this->doctrine->em->find("Entities\\Cuentas",$id);
        
        if( $url == 'tareas') {

            $tarea = $this->doctrine->em->find("Entities\\Tareas", $id);
            $cli = $tarea->getIdcliente();
        }
        
        //instanciamos calendario
        $reg = new Entities\Calendario;
        //Seteamos los datos
        $reg->setFecha(new \DateTime($fEvent.' '.$hEvent));

        $reg->setComentario($comment);
        $reg->setIdusuario($user);
        $date = explode('-', $fEvent);

        $reg->setYear($date[2]);
        $reg->setMonth($date[1]);
        $reg->setDay($date[0]);
        $hour = str_replace(':','',$hEvent);
        $reg->setHour($hour/100);
        $reg->setIdcliente($cli);
        $reg->setType('Volver a llamar');
        //guardamos la entidad en la tabla users
        $this->doctrine->em->persist($reg);
        $this->doctrine->em->flush();
        
        redirect($url.'/edit/'.$id);
        //echo $user->getNombre();
        //echo 'volverLlamar';

    }

    public function checkCif()
    {
        if ($this->input->is_ajax_request())
        {
            //almacenamos el cif dado
            $cif = $this->input->post('cif');
            $id = $this->input->post('id');
            //comprobamos que el campo no está vacio
            if($cif == "")
            {
                echo 'El campo CIF no puede estar vacío.';
            }
            //comproibamos que tiene 9 caracteres
            elseif(strlen($cif) < 9 OR strlen($cif) > 9)
            {
                echo 'El campo CIF tiene que tener 9 caracteres.';

            }else{

                //comprobamos que el cif no exista, si es así avisamos al teleoperador
                //tanto en registros como en cuentas
                //si el resultado es null editamos el registro metiendo el cif
                $reg = $this->doctrine->em->getRepository("Entities\\Registros")->findOneBy(["cif" => $cif]);
                $cue = $this->doctrine->em->getRepository("Entities\\Cuentas")->findOneBy(["cif" => $cif]);

                if ($reg OR $cue)
                {
                    echo "<h3><strong>El CIF ya existe!!!</strong></h3>";
                    //si el CIF pertenece a otros registro
                    if($reg AND !$cue){

                        echo "Parece que el CIF ya esta asignado a otro Registro.<br/><br/>";
                         echo "<strong>Empresa:</strong> ".$reg->getEmpresa()."<br/>";
                        echo "<strong>Dirección:</strong> ".$reg->getDireccion()."<br/>";
                        echo "<strong>Telefono:</strong> ".$reg->getTelefono()."<br/>";
                        echo "<strong>Email:</strong> ".$reg->getEmail();
                        echo '<p>*Si los datos del cliente coinciden con los del registro puedes hacer click con "Guardar CIF", si no es así o no estas seguro. Por favor contacta con tu coordinadora.</p>';
                        echo '<p>';

                        echo '<button data-key="'.$id.'" data-cif="'.$cif.'" class="btn green checkCifaddCif" type="button">Guardar CIF</button>';
                        echo '<button style="margin-left:5px;" data-key="'.$id.'" data-cif="'.$cif.'" class="btn red checkCifgenerateCif" type="button">Generar CIF</button>';

                        echo '</p>';
                    }
                    //si el CIF Pertenence a otro Cliente
                    if($cue){
                        //obtenemos el seguimiento actual
                        $cueSe = $this->doctrine->em->getRepository("Entities\\Cuentasseguimiento")->findOneBy(["idcliente" => $cue->getId(),"actual" => 1]);
                        //obtenemos el comercial
                        $comercial = $this->doctrine->em->getRepository("Entities\\Usuarios")->findOneBy(["id" => $cue->getIdcomercial()]);
                        echo "Parece que el CIF ya esta asignado a un cliente.<br/><br/>";
                        //comprobamos si esta cuenta tiene seguimiento, si lo tiene mostramos el estado, la fecha y el comercial junto a la teleoperadora asociados, en caso contrario, pasamos sin seguimiento
                        if($cueSe){

                        	echo 'Este cliente se encuentra en : <button class="btn btn-danger">'.$cueSe->getTipo().'</button> desde '.$cueSe->getFalta()->format("d/m/Y h:m").'<br/><br/>';
                        	echo "<strong>Comercial:</strong> ".$comercial->getNombre()." ".$comercial->getApellidos()."<br/>";
                        	echo "<strong>Teleoperador/a:</strong> ".$cue->getIdusuario()->getNombre()." ".$cue->getIdusuario()->getApellidos()."<br/>";
                        }else{

                        	echo 'Este cliente se encuentra en : <button class="btn btn-default mt-sweetalert">Sin Seguimiento</button><br/><br/>';
                        }
                        echo "<strong>Empresa:</strong> ".$cue->getNombre()."<br/>";
                        echo "<strong>Dirección:</strong> ".$cue->getDireccion()."<br/>";
                        echo "<strong>Telefono:</strong> ".$cue->getTelefono()."<br/>";
                        echo "<strong>Email:</strong> ".$cue->getEmail();
                        //Si los estados de las cuentas son nuevos u ofertas no mostramos los botones de acción y avisamos
                        //al usuario de como tiene que actuar
                        //creamos el mensaje final
                        $message = '<p>*Si los datos del cliente coinciden con los del registro puedes hacer click con "Guardar CIF", si no es así o no estas seguro. Por favor contacta con tu coordinadora.</p>';
                        $message.= '<p>';

                        $message.= '<button data-key="'.$id.'" data-cif="'.$cif.'" class="btn green checkCifaddCif" type="button">Guardar CIF</button>';
                        $message.= '<button style="margin-left:5px;" data-key="'.$id.'" data-cif="'.$cif.'" class="btn red checkCifgenerateCif" type="button">Generar CIF</button>';
                        if($cueSe){

	                        if($cueSe->getTipo() == "Nuevo 1" OR $cueSe->getTipo() == "Nuevo 2" OR $cueSe->getTipo() == "Nuevo 3" OR $cueSe->getTipo() == "Oferta 1" OR $cueSe->getTipo() == "Oferta 2" OR $cueSe->getTipo() == "Oferta 3" OR $cueSe->getTipo() == "Oferta" OR $cueSe->getTipo() == "Cierre" OR $cueSe->getTipo() == "E.O.Modi"){

	                            echo '<p>*Este cliente esta en una fase de seguimiento de tipo Nuevo u Oferta, si tienes dudas de que hacer, por favor consulta con tu coordinador.</p>';

	                        }else{

	                            
	                        	echo $message;
	                        }

	                    }else{

	                    	echo $message;
	                    }
                        

                        echo '</p>';
                    }
                    
                }else{

                    echo $this->_addCif($id,$cif);
                    
                }
            }


        }else{

            show_404();
        }
    }

    public function addCif()
    {

        if ($this->input->is_ajax_request())
        {
            //almacenamos el cif dado
            $cif = $this->input->post('cif');
            $id = $this->input->post('id');
            echo $this->_addCif($id,$cif);

        }else{

            show_404();
        }

    }
    //esta función es utilizada para generar cif de incidencia.
    //que es un cif de incidencia, cuando un registro no tiene cif o el cif aportado se comprueba
    //que pertenece a otro cliente, y para dar continuidad al proceso de cierre positivo se genera un
    //cif de incidencia que tedrá el formato siguiente I de incidencia + el id del registro
    public function generateCif()
    {

        if ($this->input->is_ajax_request())
        {
            //almacenamos el id del registro
            $id = $this->input->post('id');
            //generamos el cif de incidencia
            $cif = "I";
            //obtenemos el número de ceros a insertar delante
            $zero = 8 - strlen($id);
            //añadimos los ceros al cif
            for ($i=0; $i < $zero ; $i++) { 
                
                $cif .= "0";
            }
            //finalmente añadimos el id del registro
            $cif .= $id;
            echo $this->_addCif($id,$cif);

        }else{

            show_404();
        }

    }

    private function _addCif($id,$cif)
    {

        $reg = $this->doctrine->em->find("Entities\\Registros", $id);
        $reg->setCif($cif);
        $this->doctrine->em->flush();

        return $cif;
    }

    public function set_reportar()
    {

        if ($this->input->is_ajax_request())
        {
            
            $idUsuario = $this->input->post('usuario');
            $id = $this->input->post('id');
            $tabla = $this->input->post('tabla');
            $ids = $this->input->post('ids');
            $tablas = $this->input->post('tablas');
            $tipoReporte = $this->input->post('tipoReporte');
            $comentario = $this->input->post('reporte');
            //obtenemos el objeto usuario
            $usuario = $this->doctrine->em->find("Entities\\Usuarios", $idUsuario);
            //obtenemos el objeto Estadosseguimiento
            $tipoR = $this->doctrine->em->find("Entities\\Estadosseguimiento", $tipoReporte);

            $reporte = new Entities\Reportes;
            $reporte->setIdrow($id);
            $reporte->setIdrows($ids);
            $reporte->setTabla($tabla);
            $reporte->setTablas($tablas);
            $reporte->setComentario($comentario);
            $reporte->setReporte($tipoR->getNombre());
            $reporte->setIdusuario($usuario);

            $this->doctrine->em->persist($reporte);
            $this->doctrine->em->flush();
            //comprobamos se se ha creado correctamente
            if($reporte->getId())
            {
                echo 'true';

            }else{

                echo 'false';
            }


        }else{

            show_404();
        }

    }

    public function no_permission()
    {
        $data['title'] = ' No permission';
        $data['robots'] = 'noindex, nofollow';
        $data['error_type'] = '401';
        $data['error_title'] = 'No autorizado.';
        $data['error_text'] = 'No tienes permiso para acceder a este apartado.<br/> Por favor contacta con soporte para más información.';
        
        $this->load->view('templates/errors/layout', $data);
        //echo 'Tu no tienes permiso.';
    }

}


















