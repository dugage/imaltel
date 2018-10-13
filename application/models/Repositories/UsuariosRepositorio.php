<?php
namespace Repositories;
use Doctrine\ORM\EntityRepository;

/**
 * Class UsuariosRepositorio
 * @package Repositories

 */
class UsuariosRepositorio extends EntityRepository
{

  /**
   * @var string
   */
  private $entityUser = "Entities\\Usuarios";
  private $entityCallRegistry = "Entities\\Registrollamadas";
  private $entityUseractivity = "Entities\\Useractivity";
  private $entityCuentasseguimiento = "Entities\\Cuentasseguimiento";
  private $entityRegsitros = "Entities\\Registros";
  private $entityCuentas = "Entities\\Cuentas";
  private $entityTareas = "Entities\\Tareas";
  private $entityPrecontactos = "Entities\\Precontactos";

  /**
   * @return array
   */

    public function personalizedReport($rt,$user,$from = '2017-06-01',$to = '2017-06-05')
    {
      //Almacenamos los datos para el informe 
      $data = array();

      switch ($rt)
      {

        case 1:

            if($user == 0)
            {


              $query = $this->_em->createQuery("SELECT u,COUNT(u.id) AS calls, a FROM $this->entityCallRegistry u JOIN u.idusuario a WHERE u.start <= '$to' AND u.start >= '$from' GROUP BY u.idusuario");
              

            }elseif($user > 0){

              $query = $this->_em->createQuery("SELECT u,COUNT(u.id) AS calls, a FROM $this->entityCallRegistry u JOIN u.idusuario a WHERE u.start <= '$to' AND u.start >= '$from' AND u.idusuario = $user GROUP BY u.idusuario");

            }

            $data['header'] = 'Operario;Llamadas';
            $data['filename'] = 'Llamadas';
            $data['rt'] = 1;
            $data['query'] = $query->getScalarResult();
            
          
          break;
        
        case 2:

          if($user == 0)
            {

              $from = '2017-06-07';
              $to = '2017-06-08';

              $query = $this->_em->createQuery("SELECT u, MAX(u.timeout) AS TIMEOUT, SUM(u.timecnx) AS TOTALCNX, SUM(u.timeout) AS TOTALOUT, a FROM $this->entityUseractivity u JOIN u.idusuario a WHERE u.factivity <= '$to' AND u.factivity >= '$from' GROUP BY u.idusuario,u.factivity" );
              

            }elseif($user > 0){

              $query = $this->_em->createQuery("SELECT u, MAX(u.timeout) AS TIMEOUT, SUM(u.timecnx) AS TOTALCNX, SUM(u.timeout) AS TOTALOUT, a FROM $this->entityUseractivity u JOIN u.idusuario a WHERE u.factivity <= '$to' AND u.factivity >= '$from' AND u.idusuario = $user GROUP BY u.idusuario,u.factivity");
            }

            $data['header'] = 'Operario;Inicio;Fin;T.Conectado;T.Desconectado;Fecha';
            $data['filename'] = 'Tiempo conexión';
            $data['rt'] = 2;
            $data['query'] = $query->getScalarResult();
          
          break;

        case 3:

            if($user == 0)
            {

              $from = '2017-06-07';
              $to = '2017-06-08';

              $query = $this->_em->createQuery("SELECT u, COUNT(u.id) AS TOTALREG, a, r, e FROM $this->entityCallRegistry u JOIN u.idusuario a JOIN u.idresgistro r JOIN u.idestado e WHERE u.start <= '$to' AND u.start >= '$from' GROUP BY u.idusuario,u.idestado");
              

            }elseif($user > 0){

              $query = $this->_em->createQuery("SELECT u, COUNT(u.id) AS TOTALREG, a, r, e FROM $this->entityCallRegistry u JOIN u.idusuario a JOIN u.idresgistro r JOIN u.idestado e WHERE u.start <= '$to' AND u.start >= '$from' AND u.idusuario = $user GROUP BY u.idusuario,u.idestado");

            }

            $data['header'] = 'Operario;Registro;Estado;Fecha;Total';
            $data['filename'] = 'Estado Regsitro';
            $data['rt'] = 3;
            $data['query'] = $query->getScalarResult();
         
          break;

        case 4:

            if($user == 0)
            {

              $from = '2017-06-07';
              $to = '2017-06-08';

              $query = $this->_em->createQuery("SELECT u, MAX(u.timeout) AS TIMEOUT, SUM(u.timecnx) AS TOTALCNX, SUM(u.timeout) AS TOTALOUT, a FROM $this->entityUseractivity u JOIN u.idusuario a WHERE u.factivity <= '$to' AND u.factivity >= '$from' GROUP BY u.idusuario,u.factivity" );
              

            }elseif($user > 0){

              $query = $this->_em->createQuery("SELECT u, SUM(u.timeout) AS TOTALOUT, a FROM $this->entityUseractivity u JOIN u.idusuario a WHERE u.factivity <= '$to' AND u.factivity >= '$from' AND u.idusuario = $user GROUP BY u.idusuario,u.factivity");
            }

            $data['header'] = 'Operario; T.Descanso;Fecha';
            $data['filename'] = 'Tiempo descanso';
            $data['rt'] = 4;
            $data['query'] = $query->getScalarResult();
          
          break;
      }

      return $data;

    }

    public function standartReport($rt,$user,$from = '2017-06-01',$to = '2017-06-05')
    {

      $query = $this->_em->createQuery("SELECT u FROM $this->entity u WHERE u.fregistro = CURRENT_DATE() ORDER BY u.fregistro ASC,u.tregistro ASC, u.idestado ASC");

      return $query->getResult();

    }

    public function getReport($rt,$user,$from,$to,$rol)
    {
      
       //convertimos la fecha a un int ejem: 20170921 y la feha a formato sql
        $from_ = explode('-', $from);
        $fromQ = $from_[2].'-'.$from_[1].'-'.$from_[0];
        $from_ = $from_[2].$from_[1].$from_[0];
        $from_ = (int)$from_ ;

        $to_ = explode('-', $to);
        $toQ = $to_[2].'-'.$to_[1].'-'.$to_[0];
        $to_ = $to_[2].$to_[1].$to_[0];
        $to_ = (int)$to_;
        //almacenamos el campo de quien extraemos los datos según su rol: 3->comercial, 4->teleoperador, 7->Directorcomercial
        $userField1 = "";
        $userField2 = "";

        if($rol == 3 OR $rol == 7)
        {

          $userField1 = "c.idusuario";
          $userField2 = "c.idteleoperador";

        }elseif($rol == 4){

          $userField1 = "c.idteleoperador";
          $userField2 = "c.idusuario";

        }

      switch ($rt)
      {

        case 1:

            if($user > 0)
            {
              $query = $this->_em->createQuery("SELECT c, u, co, cli FROM $this->entityCuentasseguimiento c JOIN $userField1 u JOIN $userField2 co JOIN c.idcliente cli WHERE c.codealta <= $to_ AND c.codealta >= $from_ AND $userField1 = $user AND c.tipo = 'Nuevo 1' AND c.positiveclose = 1");
              
            }elseif( $user == 0 ){
              //COUNT(c.id) AS TOTAL
              $query = $this->_em->createQuery("SELECT c, u, co, cli FROM $this->entityCuentasseguimiento c JOIN $userField1 u JOIN c.idusuario co JOIN c.idcliente cli WHERE u.estado = 0 AND c.codealta <= $to_ AND c.codealta >= $from_ AND c.tipo = 'Nuevo 1' AND c.positiveclose = 1");
              
            }
            
          break;

          case 2:

            if($user > 0)
            {
              $query = $this->_em->createQuery("SELECT c, u, co, cli FROM $this->entityCuentasseguimiento c JOIN $userField1 u JOIN $userField2 co JOIN c.idcliente cli WHERE c.actual = 1 AND $userField1 = $user AND c.tipo IN ('Nuevo 1','Nuevo 2','Nuevo 3') ORDER BY c.codealta DESC");
              
            }elseif( $user == 0 ){

              $query = $this->_em->createQuery("SELECT c, u, co, cli FROM $this->entityCuentasseguimiento c JOIN c.idcliente cli JOIN $userField1 u JOIN $userField2 co WHERE u.estado = 0 AND c.actual = 1 AND c.tipo IN ('Nuevo 1','Nuevo 2','Nuevo 3') ORDER BY c.codealta DESC");
              
            }
            
          break;

          case 3:

            if($user > 0)
            {
              $query = $this->_em->createQuery("SELECT c, u, co, cli FROM $this->entityCuentasseguimiento c JOIN $userField1 u JOIN $userField2 co JOIN c.idcliente cli WHERE c.actual = 1 AND $userField1 = $user AND c.tipo IN ('Oferta 1','Oferta 2','Oferta 3','Citar E.O.','Oferta') ORDER BY c.codealta DESC");
              
            }elseif( $user == 0 ){

              $query = $this->_em->createQuery("SELECT c, u, co, cli FROM $this->entityCuentasseguimiento c JOIN c.idcliente cli JOIN $userField1 u JOIN $userField2 co WHERE u.estado = 0 AND c.actual = 1 AND c.tipo IN ('Oferta 1','Oferta 2','Oferta 3','Citar E.O.','Oferta') ORDER BY c.codealta DESC");
              
            }
            
          break;

          case 4:

            if($user > 0)
            {
              $query = $this->_em->createQuery("SELECT c, u, co, cli FROM $this->entityCuentasseguimiento c JOIN $userField1 u JOIN $userField2 co JOIN c.idcliente cli WHERE c.actual = 1 AND $userField1 = $user AND c.tipo IN('Cierre','E.O.Modi')");
              
            }elseif( $user == 0 ){

              $query = $this->_em->createQuery("SELECT c, u, co, cli FROM $this->entityCuentasseguimiento c JOIN c.idcliente cli JOIN $userField1 u JOIN $userField2 co WHERE u.estado = 0 AND c.actual = 1 AND c.tipo IN('Cierre','E.O.Modi')");
              
            }
            
          break;

          case 5:

            if($user > 0)
            {

              $query = $this->_em->createQuery("SELECT c, u, co, cli FROM $this->entityCuentasseguimiento c JOIN c.idcliente cli JOIN $userField1 u JOIN $userField2 co WHERE c.codealta <= $to_ AND c.codealta >= $from_ AND $userField1 = $user AND c.tipo = 'Ko'");
              
            }elseif( $user == 0 ){
              //el GROUP BY hay que consultar si se elimina finalmente.
              $query = $this->_em->createQuery("SELECT c, u, co, cli FROM $this->entityCuentasseguimiento c JOIN c.idcliente cli JOIN $userField1 u JOIN $userField2 co WHERE u.estado = 0 AND c.codealta <= $to_ AND c.codealta >= $from_ AND c.tipo = 'Ko' GROUP BY cli.cif");
              
            }

            break;

          case 6:

            if($user > 0)
            {

              $query = $this->_em->createQuery("SELECT c, u, co, cli FROM $this->entityCuentasseguimiento c JOIN c.idcliente cli JOIN $userField1 u JOIN $userField2 co WHERE c.codepospuesto <= $to_ AND c.codepospuesto >= $from_ AND $userField1 = $user AND c.tipo = 'Ko'");
              
            }elseif( $user == 0 ){

              $query = $this->_em->createQuery("SELECT c, u, co, cli FROM $this->entityCuentasseguimiento c JOIN c.idcliente cli JOIN $userField1 u JOIN $userField2 co WHERE u.estado = 0 AND c.codepospuesto <= $to_ AND c.codepospuesto >= $from_ AND c.tipo = 'Ko'");
              
            }

            break;

          case 7:
          case 8:

            //almacenamos el id de su estado registro
            $estadoRegsitro = 0;

            if($rt == 6){

              $estadoRegsitro = 27;

            }elseif($rt == 7){

              $estadoRegsitro = 1;

            }elseif($rt == 8){

              $estadoRegsitro = 2;
            }

            if($user > 0)
            {
 
              $query = $this->_em->createQuery("SELECT c,u FROM $this->entityRegsitros c JOIN c.idusuario u WHERE c.idestado = $estadoRegsitro AND c.fregistro <= $to_ AND c.fregistro >= $from_ AND c.idusuario = $user");
              
            }elseif( $user == 0 ){

              $query = $this->_em->createQuery("SELECT c,u FROM $this->entityRegsitros c JOIN c.idusuario u WHERE u.estado = 0 AND c.idestado = $estadoRegsitro AND c.fregistro <= $to_ AND c.fregistro >= $from_");
              
            }
            
          break;

          case 9:

            if($user > 0)
            {

              $query = $this->_em->createQuery("SELECT c, u, co, cli FROM $this->entityCuentasseguimiento c JOIN $userField1 u JOIN $userField2 co JOIN c.idcliente cli WHERE c.codealta <= $to_ AND c.codealta >= $from_ AND $userField1 = $user AND c.actual = 1");
            
            }elseif($user == 0){


                $query = $this->_em->createQuery("SELECT c, u, co, cli FROM $this->entityCuentasseguimiento c JOIN $userField1 u JOIN $userField2 co JOIN c.idcliente cli WHERE u.estado = 0 AND c.codealta <= $to_ AND c.codealta >= $from_ AND c.actual = 1");

            }
          
          break;

          case 10:

            $query = $this->_em->createQuery("SELECT c FROM $this->entityCuentas c WHERE c.sin_seguimiento = 1");

          break;

          case 11:
          case 12:

          //montamos el IN dependiendo del tipo de informe de incidencia
          if( $rt == 11 ) {
            //IN para nuevos
            $whereIn = "'Nuevo 1','Nuevo 2','Nuevo 3'";

          }elseif( $rt == 12 ) {
            //IN para ofertas
            $whereIn = "'Oferta 1','Oferta 2','Oferta 3'";
          }
           
            $codealta = date("Ymd"); 

            if($user > 0)
            {

              $query = $this->_em->createQuery("SELECT c,cli,co,tel FROM $this->entityCuentasseguimiento c JOIN c.idcliente cli JOIN c.idusuario co JOIN c.idteleoperador tel WHERE c.codealta < $codealta AND $userField1 = $user AND c.actual = 1 AND c.tipo IN ($whereIn)");

            }else{

              $query = $this->_em->createQuery("SELECT c,cli,co,tel FROM $this->entityCuentasseguimiento c JOIN c.idcliente cli JOIN c.idusuario co JOIN c.idteleoperador tel WHERE c.codealta < $codealta AND c.actual = 1 AND c.tipo IN ($whereIn)");
            }
          	
          break;
          //Informe incidencias tareas documentación
          case 13:

            if($user > 0)
            {

              
              $query = $this->_em->createQuery("SELECT c,cli,co,dco FROM $this->entityTareas c JOIN c.idcliente cli JOIN c.idusuariofrom co JOIN c.idusuarioto dco WHERE c.idusuariofrom = $user AND c.estado = 0 AND c.tipo = 'Rdocu'");

            }else{

              $query = $this->_em->createQuery("SELECT c,cli,co,dco FROM $this->entityTareas c JOIN c.idcliente cli JOIN c.idusuariofrom co JOIN c.idusuarioto dco WHERE c.estado = 0 AND c.tipo = 'Rdocu'");
            }
            
          break;

          case 14:

            if($user > 0)
            {

              
              $query = $this->_em->createQuery("SELECT p,c FROM $this->entityPrecontactos p JOIN p.idusuario c WHERE p.falta <= '$toQ' AND p.falta >= '$fromQ' AND p.idusuario = $user");

            }else{

              $query = $this->_em->createQuery("SELECT p,c FROM $this->entityPrecontactos p JOIN p.idusuario c WHERE p.falta <= '$toQ' AND p.falta >= '$fromQ'");
            }
            
          break;

      }

      $result = $query->getScalarResult();
      $data = $this->drawReport($rt,$result,$user,$from,$to,$rol);

      return $data;

    }

    private function drawReport($rt,$result,$user,$from,$to,$rol)
    {

      $total = 0;
      $totalLineas = 0;
      $data['dateRange'] = $from.' · '.$to;
      $data['trTd'] = '';
      //almacenamos el campo de quien extraemos los datos según su rol: 3->comercial, 4->teleoperador, 7->Directorcomercial
      $userField = "";
      if($rol == 3 OR $rol == 7)
      {

        $user1 = "Comercial";
        $user2 = "Teleoperador";

      }elseif($rol == 4){

        $user1 = "Teleoperador";
        $user2 = "Comercial";

      }

      if(isset($user1) OR isset($user2))
      {
        $data['header'] = "ID;CIF; Cliente;Líneas;CP;Población;Tel;P.contacto;$user1;$user2; Tipo;Fecha;días;\n";
      }

      switch ($rt)
      {
          case 1:

            $data['documentTitle'] = 'Cierres Positivos';

            if($user > 0){

              $data['header'] = 'ID;CIF;Cliente;Líneas;CP;Población;Tel;P.contacto;'.$user1.';'.$user2.';Cierres Positivos;Fecha';
              

              foreach ($result as $key => $value)
              {
                
                $data['trTd'] .= '<tr>';

                $data['trTd'] .= '<td>'.$value['cli_id'].'</td>';
                $data['trTd'] .= '<td>'.$value['cli_cif'].'</td>';
                $data['trTd'] .= '<td><a target="_blank" href="'.site_url('clientes/edit/'.$value['cli_id']).'">'.$value['cli_nombre'].'</a></td>';
                $data['trTd'] .= '<td>'.$value['cli_lineasmovil'].'</td>';
                $data['trTd'] .= '<td>'.$value['cli_cp'].'</td>';
                $data['trTd'] .= '<td>'.$value['cli_poblacion'].'</td>';
                $data['trTd'] .= '<td>'.$value['cli_telefono'].'</td>';
                $data['trTd'] .= '<td>'.$value['cli_personacnt'].'</td>';
                $data['trTd'] .= '<td>'.$value['u_nombre'].' '.$value['u_apellidos'].'</td>';
                $data['trTd'] .= '<td>'.$value['co_nombre'].' '.$value['co_apellidos'].'</td>';
                $data['trTd'] .= '<td>1</td>';
                $data['trTd'] .= '<td>'.$value['c_falta']->format("d-m-Y").'</td>';

                $data['trTd'] .= '</tr>';
                $totalLineas += $value['cli_lineasmovil'];
              }

              $total = $total = count($result);

              $data['trTd'] .= '<tr>';

              $data['trTd'] .= '<td></td>';
              $data['trTd'] .= '<td></td>';
              $data['trTd'] .= '<td></td>';
              $data['trTd'] .= '<td>Total: '.$totalLineas.'</td>';
              $data['trTd'] .= '<td></td>';


            }elseif($user == 0){

              $data['header'] = 'ID;CIF;Cliente;Líneas;CP;Población;Tel;P.contacto;'.$user1.';'.$user2.';Cierres Positivos;Fecha';
              $data['trTd'] = '';

              foreach ($result as $key => $value)
              {
                
                $data['trTd'] .= '<tr>';
                $data['trTd'] .= '<td>'.$value['cli_id'].'</td>';
                $data['trTd'] .= '<td>'.$value['cli_cif'].'</td>';
                $data['trTd'] .= '<td><a target="_blank" href="'.site_url('clientes/edit/'.$value['cli_id']).'">'.$value['cli_nombre'].'</a></td>';
                $data['trTd'] .= '<td>'.$value['cli_lineasmovil'].'</td>';
                $data['trTd'] .= '<td>'.$value['cli_cp'].'</td>';
                $data['trTd'] .= '<td>'.$value['cli_poblacion'].'</td>';
                $data['trTd'] .= '<td>'.$value['cli_telefono'].'</td>';
                $data['trTd'] .= '<td>'.$value['cli_personacnt'].'</td>';
                $data['trTd'] .= '<td>'.$value['u_nombre'].' '.$value['u_apellidos'].'</td>';
                $data['trTd'] .= '<td>'.$value['co_nombre'].' '.$value['co_apellidos'].'</td>';
                $data['trTd'] .= '<td>1</td>';
                $data['trTd'] .= '<td>'.$value['c_falta']->format("d-m-Y").'</td>';
                

                $data['trTd'] .= '</tr>';
                $totalLineas += $value['cli_lineasmovil'];

                
              }
              $total = $total = count($result);

              $data['trTd'] .= '<tr>';

              $data['trTd'] .= '<td></td>';
              $data['trTd'] .= '<td></td>';
              $data['trTd'] .= '<td></td>';
              $data['trTd'] .= '<td>Total: '.$totalLineas.'</td>';
              $data['trTd'] .= '<td></td>';

            }

          break;

          case 2:
          case 3:
          case 4:
          case 5:

            if($rt == 2){ $data['documentTitle'] = 'Nuevos';}
            if($rt == 3){ $data['documentTitle'] = 'Ofertas';}
            if($rt == 4){ $data['documentTitle'] = 'Cierres';}
            if($rt == 5){ $data['documentTitle'] = 'Ko';}
            //iniciamos @registro a false
            $registros = false;
            //almacena el objeto registro en caso de tenerlo asociado el cliente
            $registros = null;
            //si el informe es de tipo ko = 5 cambiamos la cabecera de la tabla
            if( $rt == 5 )
              $data['header'] = "ID;CIF;Cliente;Líneas;CP;Población;Tel;P.contacto;$user1;$user2; Estado;Fecha;Días;F.Pospuesto;E.registro\n"; 

            foreach ($result as $key => $value)
            {
              
              //variable para pintar de rojo los días.
              $red = "";
              $datetime1 = date_create($value['c_falta']->format('Y-m-d'));
              $datetime2 = date_create(date('Y-m-d'));
              $interval = $datetime1->diff($datetime2)->format('%a');
              //si el tipo de informe es igual a 3, comprobamos si el número de diás pasados es mayor de 2
              if( $rt == 3 ) {

                if($interval > 2 AND ($value['c_tipo'] == 'Oferta 1' OR $value['c_tipo'] == 'Oferta 2' OR $value['c_tipo'] == 'Oferta 3'))
                  $red = 'style="color:red;"';
              }
              
              //si el informe es de tipo ko = 5 consultamos si tiene enlazado un registro
              if( $rt == 5 )
                $registros = $this->_em->find("Entities\\Registros", $value['cli_idregistro']);

              $data['trTd'] .= '<tr>';

              $data['trTd'] .= '<td>'.$value['cli_id'].'</td>';
              $data['trTd'] .= '<td>'.$value['cli_cif'].'</td>';
              $data['trTd'] .= '<td><a target="_blank" href="'.site_url('clientes/edit/'.$value['cli_id']).'">'.$value['cli_nombre'].'</a></td>';
              $data['trTd'] .= '<td>'.$value['cli_lineasmovil'].'</td>';
              $data['trTd'] .= '<td>'.$value['cli_cp'].'</td>';
              $data['trTd'] .= '<td>'.$value['cli_poblacion'].'</td>';
              $data['trTd'] .= '<td>'.$value['cli_telefono'].'</td>';
              $data['trTd'] .= '<td>'.$value['cli_personacnt'].'</td>';
              $data['trTd'] .= '<td>'.$value['u_nombre'].' '.$value['u_apellidos'].'</td>';
              $data['trTd'] .= '<td>'.$value['co_nombre'].' '.$value['co_apellidos'].'</td>';
              $data['trTd'] .= '<td>'.$value['c_tipo'].'</td>';
              $data['trTd'] .= '<td>'.$value['c_falta']->format("d-m-Y").'</td>';
              $data['trTd'] .= '<td '.$red.'>'.$interval.'</td>';
              //si registro es distinto de null mostramos los datos fecha de pospuesto y el estado actual del registro
              if( $rt == 5 ) {

                if( $registros ) {

                  $data['trTd'] .= '<td>'.$registros->getFregistro()->format('d-m-Y').'</td>';
                  $data['trTd'] .= '<td>'.$registros->getIdestado()->getNombre().'</td>';

                }else{

                  $data['trTd'] .= '<td>No data</td>';
                  $data['trTd'] .= '<td>No data</td>';

                }

              }

              $data['trTd'] .= '</tr>';

              $totalLineas += $value['cli_lineasmovil'];
            }

            $data['trTd'] .= '<tr>';

            $data['trTd'] .= '<td></td>';
            $data['trTd'] .= '<td></td>';
            $data['trTd'] .= '<td></td>';
            $data['trTd'] .= '<td>Total: '.$totalLineas.'</td>';
            $data['trTd'] .= '<td></td>';

            $total = count($result);
            

          break;

          case 6:
            
            $data['header'] = "ID;CIF;Cliente;Líneas;CP;Población;Tel;P.contacto;$user1;$user2;Estado;Fecha;E.registro;F.registro\n";

            foreach ($result as $key => $value)
            {

              $registros = $this->_em->find("Entities\\Registros", $value['cli_idregistro']);
              
              $data['trTd'] .= '<tr>';
              $data['trTd'] .= '<td>'.$value['cli_id'].'</td>';
              $data['trTd'] .= '<td>'.$value['cli_cif'].'</td>';
              $data['trTd'] .= '<td><a target="_blank" href="'.site_url('clientes/edit/'.$value['cli_id']).'">'.$value['cli_nombre'].'</a></td>';
              $data['trTd'] .= '<td>'.$value['cli_lineasmovil'].'</td>';
              $data['trTd'] .= '<td>'.$value['cli_cp'].'</td>';
              $data['trTd'] .= '<td>'.$value['cli_poblacion'].'</td>';
              $data['trTd'] .= '<td>'.$value['cli_telefono'].'</td>';
              $data['trTd'] .= '<td>'.$value['cli_personacnt'].'</td>';
              $data['trTd'] .= '<td>'.$value['u_nombre'].' '.$value['u_apellidos'].'</td>';
              $data['trTd'] .= '<td>'.$value['co_nombre'].' '.$value['co_apellidos'].'</td>';
              $data['trTd'] .= '<td>'.$value['c_tipo'].'</td>';
              $data['trTd'] .= '<td>'.$value['c_falta']->format("d-m-Y").'</td>';
              if($registros){

                $data['trTd'] .= '<td>'.$registros->getIdestado()->getNombre().'</td>';
                $data['trTd'] .= '<td>'.$registros->getFregistro()->format("d-m-Y").'</td>';

              }else{

                $data['trTd'] .= '<td>No data</td>';
                $data['trTd'] .= '<td>No data</td>';
              }

              $data['trTd'] .= '</tr>';

              $totalLineas += $value['cli_lineasmovil'];

            }


            $data['trTd'] .= '<tr>';

            $data['trTd'] .= '<td></td>';
            $data['trTd'] .= '<td></td>';
            $data['trTd'] .= '<td></td>';
            $data['trTd'] .= '<td>Total: '.$totalLineas.'</td>';
            $data['trTd'] .= '<td></td>';

            $total = count($result);

          break;

          case 7:
          case 8:

            $data['documentTitle'] = 'Pospuestos';
            $data['header'] = "ID;CIF;Cliente;Líneas;CP;Población;Tel;P.contacto;Teleoperador;Fecha";

            foreach ($result as $key => $value)
            {

                $data['trTd'] .= '<tr>';

                $data['trTd'] .= '<td>'.$value['c_id'].'</td>';
                $data['trTd'] .= '<td>'.$value['c_cif'].'</td>';
                $data['trTd'] .= '<td><a target="_blank" href="'.site_url('registros/edit/'.$value['c_id']).'">'.$value['c_empresa'].'</a></td>';
                $data['trTd'] .= '<td>'.$value['c_telefono'].'</td>';
                $data['trTd'] .= '<td>'.$value['c_lineasmovil'].'</td>';
                $data['trTd'] .= '<td>'.$value['c_cp'].'</td>';
                $data['trTd'] .= '<td>'.$value['c_poblacion'].'</td>';
                $data['trTd'] .= '<td>'.$value['c_telefono'].'</td>';
                $data['trTd'] .= '<td>'.$value['c_percontacto'].'</td>';
                $data['trTd'] .= '<td>'.$value['u_nombre'].' '.$value['u_apellidos'].'</td>';
                $data['trTd'] .= '<td>'.$value['c_fregistro']->format("d-m-Y").'</td>';

                $totalLineas += $value['c_lineasmovil'];

            }

            $data['trTd'] .= '<tr>';

            $data['trTd'] .= '<td></td>';
            $data['trTd'] .= '<td></td>';
            $data['trTd'] .= '<td></td>';
            $data['trTd'] .= '<td>Total: '.$totalLineas.'</td>';
            $data['trTd'] .= '<td></td>';

            $total = count($result);

          break;

          case 9:

            if($user > 0){

              $data['header'] = 'CIF;Cliente;'.$user1.';'.$user2.';Tipo;Fecha';


              foreach ($result as $key => $value)
              {

                $datetime1 = date_create($value['c_falta']->format('Y-m-d'));
                $datetime2 = date_create(date('Y-m-d'));
                $interval = $datetime1->diff($datetime2)->format('%a');
                
                $data['trTd'] .= '<tr>';

                $data['trTd'] .= '<td>'.$value['cli_cif'].'</td>';
                $data['trTd'] .= '<td><a target="_blank" href="'.site_url('clientes/edit/'.$value['cli_id']).'">'.$value['cli_nombre'].'</a></td>';
                $data['trTd'] .= '<td>'.$value['u_nombre'].' '.$value['u_apellidos'].'</td>';
                $data['trTd'] .= '<td>'.$value['co_nombre'].' '.$value['co_apellidos'].'</td>';
                $data['trTd'] .= '<td>'.$value['c_tipo'].'</td>';
                $data['trTd'] .= '<td>'.$value['c_falta']->format("d-m-Y").'</td>';
                $data['trTd'] .= '<td>'.$interval.'</td>';

                $data['trTd'] .= '</tr>';

                $total = $key + 1;

              }
              
            }else{

              $data['header'] = 'ID;CIF;Cliente;Líneas;CP;Población;Tel;P.contacto;'.$user1.';'.$user2.';Tipo;Fecha;dias';
              
              foreach ($result as $key => $value)
              {
                $datetime1 = date_create($value['c_falta']->format('Y-m-d'));
                $datetime2 = date_create(date('Y-m-d'));
                $interval = $datetime1->diff($datetime2)->format('%a');
                
                $data['trTd'] .= '<tr>';

                $data['trTd'] .= '<td>'.$value['cli_id'].'</td>';
                $data['trTd'] .= '<td>'.$value['cli_cif'].'</td>';
                $data['trTd'] .= '<td><a target="_blank" href="'.site_url('clientes/edit/'.$value['cli_id']).'">'.$value['cli_nombre'].'</a></td>';
                $data['trTd'] .= '<td>'.$value['cli_lineasmovil'].'</td>';
                $data['trTd'] .= '<td>'.$value['cli_cp'].'</td>';
                $data['trTd'] .= '<td>'.$value['cli_poblacion'].'</td>';
                $data['trTd'] .= '<td>'.$value['cli_telefono'].'</td>';
                $data['trTd'] .= '<td>'.$value['cli_personacnt'].'</td>';
                $data['trTd'] .= '<td>'.$value['u_nombre'].' '.$value['u_apellidos'].'</td>';
                $data['trTd'] .= '<td>'.$value['co_nombre'].' '.$value['co_apellidos'].'</td>';
                $data['trTd'] .= '<td>'.$value['c_tipo'].'</td>';
                $data['trTd'] .= '<td>'.$value['c_falta']->format("d-m-Y").'</td>';
                $data['trTd'] .= '<td>'.$interval.'</td>';

                $data['trTd'] .= '</tr>';

                $total = $key + 1;

              }

            }
           

          break;

          case 10:

            $data['documentTitle'] = 'Sin Seguimiento';
            $data['header'] = "ID;CIF;Cliente;Líneas;CP;Población;Tel;P.contacto;\n";
            //generamos la tabla para mostrarla
            foreach ($result as $key => $value)
            {
                $data['trTd'] .= '<tr>';

                $data['trTd'] .= '<td>'.$value['c_id'].'</td>';
                $data['trTd'] .= '<td>'.$value['c_cif'].'</td>';
                $data['trTd'] .= '<td><a target="_blank" href="'.site_url('clientes/edit/'.$value['c_id']).'">'.$value['c_nombre'].'</a></td>';
                $data['trTd'] .= '<td>'.$value['c_lineasmovil'].'</td>';
                $data['trTd'] .= '<td>'.$value['c_cp'].'</td>';
                $data['trTd'] .= '<td>'.$value['c_poblacion'].'</td>';
                $data['trTd'] .= '<td>'.$value['c_telefono'].'</td>';
                $data['trTd'] .= '<td>'.$value['c_personacnt'].'</td>';

                $data['trTd'] .= '</tr>';

                $total = count($result);
            }

          break;

          case 11:
          case 12:

            //títúlo segñun el tipo de informe
            if( $rt == 11 ) {

              $data['documentTitle'] = 'Incidencias | Nuevos';

            }elseif( $rt == 12 ) {

              $data['documentTitle'] = 'Incidencias | Ofertas';

            }

          	$count = 0;
            $data['header'] = "ID;CIF;Cliente;Líneas;CP;Teleoperadora;Comercial;Estado;Fecha;Días;\n";
            //generamos la tabla para mostrarla
            foreach ($result as $key => $value)
            {

            	$idcliente = $value['cli_id'];
            	$codealta = date("Ymd");

            	$query = $this->_em->createQuery("SELECT ta FROM $this->entityTareas ta WHERE ta.idcliente = $idcliente AND ta.estado = 0");

            	$result = $query->getScalarResult();
            	

            	if(count($result) > 0){

            		if($result[0]['ta_falta']->format("Ymd") < $codealta){
	                  //calculamos los días pasados entre el actual y la fecha de alta de la tarea
	                  $datetime1 = date_create($result[0]['ta_falta']->format('Y-m-d'));
	                  $datetime2 = date_create(date('Y-m-d'));
	                  $interval = $datetime1->diff($datetime2)->format('%a');

            			$data['trTd'] .= '<tr>';

                    $data['trTd'] .= '<td>'.$value['cli_id'].'</td>';
		                $data['trTd'] .= '<td>'.$value['cli_cif'].'</td>';
		                $data['trTd'] .= '<td><a target="_blank" href="'.site_url('clientes/edit/'.$value['cli_id']).'">'.$value['cli_nombre'].'</a></td>';
		                $data['trTd'] .= '<td>'.$value['cli_lineasmovil'].'</td>';
		                $data['trTd'] .= '<td>'.$value['cli_cp'].'</td>';
		                $data['trTd'] .= '<td>'.$value['tel_nombre'].' '.$value['tel_apellidos'].'</td>';
		                $data['trTd'] .= '<td>'.$value['co_nombre'].' '.$value['co_apellidos'].'</td>';
		                $data['trTd'] .= '<td>'.$value['c_tipo'].'</td>';
		                $data['trTd'] .= '<td>'.$result[0]['ta_falta']->format("d/m/Y").'</td>';
                    	$data['trTd'] .= '<td>'.$interval.'</td>';

		                $totalLineas += $value['cli_lineasmovil'];
		                $count++;

            		}
            	}

                $total = $count;
            }

        	$data['trTd'] .= '<tr>';

            $data['trTd'] .= '<td></td>';
            $data['trTd'] .= '<td></td>';
            $data['trTd'] .= '<td>Total: '.$totalLineas.'</td>';
            $data['trTd'] .= '<td></td>';

          break;
          //Informe de incidencias Documentación
          case 13:

            $count = 0;
            $codealta = date("Ymd");
            $data['documentTitle'] = 'Incidencias | Documentación';
            $data['header'] = "ID;CIF; Cliente;Líneas;CP;D.Comercial;Comercial;Fecha;Días;\n";

            //generamos la tabla para mostrarla
            foreach ($result as $key => $value)
            {
              if( ( $codealta - $value['c_falta']->format("Ymd") ) >= 2 ) {

                //calculamos los días pasados entre el actual y la fecha de alta de la tarea
                $datetime1 = date_create($value['c_falta']->format('Y-m-d'));
                $datetime2 = date_create(date('Y-m-d'));
                $interval = $datetime1->diff($datetime2)->format('%a');

                $data['trTd'] .= '<tr>';

                $data['trTd'] .= '<td>'.$value['cli_id'].'</td>';
                $data['trTd'] .= '<td>'.$value['cli_cif'].'</td>';
                $data['trTd'] .= '<td><a target="_blank" href="'.site_url('clientes/edit/'.$value['cli_id']).'">'.$value['cli_nombre'].'</a></td>';
                $data['trTd'] .= '<td>'.$value['cli_lineasmovil'].'</td>';
                $data['trTd'] .= '<td>'.$value['cli_cp'].'</td>';
                $data['trTd'] .= '<td>'.$value['dco_nombre'].' '.$value['dco_apellidos'].'</td>';
                $data['trTd'] .= '<td>'.$value['co_nombre'].' '.$value['co_apellidos'].'</td>';
                $data['trTd'] .= '<td>'.$value['c_falta']->format("d/m/Y").'</td>';
                $data['trTd'] .= '<td>'.$interval.'</td>';

                $totalLineas += $value['cli_lineasmovil'];
                $count++;
              }

              
            }

            $data['trTd'] .= '<tr>';

            $data['trTd'] .= '<td></td>';
            $data['trTd'] .= '<td></td>';
            $data['trTd'] .= '<td>Total: '.$totalLineas.'</td>';
            $data['trTd'] .= '<td></td>';

            $total = $count;

          break;
          //Informe precontactos
          case 14:

            $data['documentTitle'] = 'Precontactos';
            $data['header'] = "CIF;Cliente;Teleono;Polbación;CP;Comercial;Fecha;\n";
            //generamos la tabla para mostrarla
            foreach ($result as $key => $value)
            {
              
              $data['trTd'] .= '<tr>';
              $data['trTd'] .= '<td>'.$value['p_cif'].'</td>';
              $data['trTd'] .= '<td>'.$value['p_nombre'].'</td>';
              $data['trTd'] .= '<td>'.$value['p_telefono'].'</td>';
              $data['trTd'] .= '<td>'.$value['p_poblacion'].'</td>';
              $data['trTd'] .= '<td>'.$value['p_cp'].'</td>';
              $data['trTd'] .= '<td>'.$value['c_nombre'].' '.$value['c_apellidos'].'</td>';
              $data['trTd'] .= '<td>'.$value['p_falta']->format("d/m/Y").'</td>';
              $data['trTd'] .= '</tr>';

              $total = count($result);
            }

            $data['trTd'] .= '<td></td>';
            $data['trTd'] .= '<td></td>';
            $data['trTd'] .= '<td></td>';
            $data['trTd'] .= '<td></td>';
            $data['trTd'] .= '<td></td>';

          break;
      }

      $data['trTd'] .= '<td>Total resultado: '.$total.'</td>';
      $data['trTd'] .= '<td></td>';

      $data['trTd'] .= '</tr>';

      return $data;
    }


}
