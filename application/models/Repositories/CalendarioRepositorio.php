<?php
namespace Repositories;
use Doctrine\ORM\EntityRepository;

/**
 * Class CalendarioRepositorio
 * @package Repositories
 */
class CalendarioRepositorio extends EntityRepository
{

  /**
   * @var string
   */
  private $entity = "Entities\\Calendario";

  /**
   * @return array
   */
    //devuelve un listado de los eventos que tiene asignado el usuario para el mes seleccionado
    public function getEvents($user,$date,$cd,$check = 0)
    {

      $date = explode('-', $date);
      //comprobamos si el usuario que realiza la solicitud es comercial o director comercial, donde comerial es igual a 0
      //y director comercial es igual a 1
      if($cd == 0)
      {
         $query = $this->_em->createQuery("SELECT c, u, o,cs,op FROM $this->entity c JOIN c.idusuario u JOIN c.idcliente o JOIN o.cuentasSeguimiento cs JOIN o.idoperador op  WHERE c.year = $date[0] AND c.month = $date[1] AND c.idusuario IN($user) ORDER BY c.hour ASC");

       }elseif( $cd == 1){

          //obtenemos la lista de director/es comercial/es
          $cdList = $this->_em->createQuery("SELECT c FROM Entities\\Equipos c WHERE c.idmaster IN($user)");
          //s check es igual a 0, la consulta es sobre el comracial/es seleccioandos, en caso de ser igual a 
          //1 esta es sobre los eventos check = 1
          if($check == 0)
          {

            //y la recorremos formando un string separado por comas con los usuarios cde tipo comercial
            $user = "";
            foreach ($cdList->getResult() as $key => $cd)
            {
              $user .= $cd->getIdusuario()->getId().',';
            }
            //eliminamos la última coma
            $user = substr($user, 0, -1);

            $query = $this->_em->createQuery("SELECT c, u, o,cs FROM $this->entity c JOIN c.idusuario u JOIN c.idcliente o JOIN o.cuentasSeguimiento cs  WHERE c.year = $date[0] AND c.month = $date[1] AND c.idusuario IN($user) AND c.checkit = 1 ORDER BY c.hour ASC");

          }elseif($check == 1){

              $query = $this->_em->createQuery("SELECT c, u, o,cs FROM $this->entity c JOIN c.idusuario u JOIN c.idcliente o JOIN o.cuentasSeguimiento cs WHERE c.year = $date[0] AND c.month = $date[1] AND c.idusuario IN($user) AND c.checkit = 1 ORDER BY c.hour ASC");
          }
       }
     

      return $query->getArrayResult();

    }

    public function getEventsList($user,$y,$m,$d)
    {

      $query = $this->_em->createQuery("SELECT c, u FROM $this->entity c JOIN c.idusuario u WHERE c.year = $y AND c.month = $m AND c.day = $d AND c.idusuario = $user");

      return $query->getArrayResult();

    }

    public function getEventDetail($id)
    {

      $query = $this->_em->createQuery("SELECT c, u, cl,top, op, r FROM $this->entity c JOIN c.idusuario u JOIN c.idcliente cl JOIN cl.idoperador op JOIN cl.idusuario top JOIN u.idrol r WHERE c.id = $id");

      return $query->getScalarResult();

    }

    public function getEventByDate($idUsuario,$year,$month,$day)
    {


      //$query = $this->_em->createQuery("SELECT u FROM $this->entity u WHERE u.year = $year AND u.month = $month AND u.day = $day AND u.idusuario = $idUsuario AND u.estado = 0");
      $query = $this->_em->createQuery("SELECT u FROM $this->entity u WHERE u.idusuario = $idUsuario AND u.estado = 0");
      return $query->getResult();

    }

}
