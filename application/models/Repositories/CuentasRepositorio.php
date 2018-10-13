<?php
namespace Repositories;
use Doctrine\ORM\EntityRepository;

/**
 * Class CuentasRepositorio
 * @package Repositories
 */
class CuentasRepositorio extends EntityRepository
{

  /**
   * @var string
   */
  private $entity = "Entities\\Cuentas";

  /**
   * @return array
   */

    public function getCuentasLimit($max,$start=0,$f,$q,$userId = 0,$rol = 0)
    {

      //montamos el wehre para los parametros de búsqueda
      $where = "";
      //variable donde almacenamos el resultado y el tipo de resultado
      $result = array();
      //$f='cif';

      if($f AND $q)
      {
        //llamamos al metodo para dibujar el where
        $where = $this->_drawWhere($f,$q);
        //si @usuarioId es mayor de 0, añadimos un AND y filtramos la búsqueda por idcomercial
        if( $userId > 0 AND $rol == 3) {

          $where .= " AND u.idcomercial = $userId AND u.id > 0";
        }
        //si el rol es = 7, consultamos y obtenemos el equipo del director comercial
        if( $userId > 0 AND $rol == 7 ) {

          $equipo = $this->_em->getRepository("Entities\\Equipos")->findBy(["idmaster" => $userId]);
          $in = "";
          //montamos el string para la consulta IN
          foreach ($equipo as $key => $eq) {
            $in .= $eq->getIdusuario()->getId().',';
          }
          //add al propio dir.comercial
          $in .= $userId;
          //mostamos en IN para su consulta
          $where .= " AND u.idcomercial IN($in) AND u.id > 0";

        }

      }else{

        //si @usuarioId es mayor de 0, añadimos un AND y filtramos la búsqueda por idcomercial
        if( $userId > 0) {

          $where .= " WHERE u.idcomercial = $userId AND u.id > 0";
        }
      }

      $query = $this->_em->createQuery("SELECT u FROM $this->entity u $where")
      ->setFirstResult($start)
      ->setMaxResults($max);
      //comprobamos si la consulta devuelve o no resultado, en caso negativo, realizamos una consulta abierta
      if( $query->getResult() ) {
        
        $result = array('is_mine' => TRUE,'result' => $query->getResult() );

      }else{

        //Volvemos a dibujar el where
        $where = $this->_drawWhere($f,$q);
        $query = $this->_em->createQuery("SELECT u FROM $this->entity u $where")
        ->setFirstResult($start)
        ->setMaxResults($max);
        //en caso de que la consutla encuentre un resultado pero el resultado no este vinculado a el
        $result = array('is_mine' => FALSE,'result' => $query->getResult() );
      }

      return $result;

    }

    public function getCuentasByEstado($estado)
    {
      switch ($estado) 
      {

        case 'nuevo':
          
           $query = $this->_em->createQuery("SELECT c, cl FROM Entities\\Cuentasseguimiento c JOIN c.idcliente cl WHERE c.actual = 1 AND c.tipo IN('Nuevo 1','Nuevo 2','Nuevo 3','Citar E.O.')");

          break;

        case 'oferta':
          
           $query = $this->_em->createQuery("SELECT c, cl FROM Entities\\Cuentasseguimiento c JOIN c.idcliente cl WHERE c.actual = 1 AND c.tipo IN('Oferta 1','Oferta 2','Oferta 3')");

          break;

        case 'cierre':
          
           $query = $this->_em->createQuery("SELECT c, cl FROM Entities\\Cuentasseguimiento c JOIN c.idcliente cl WHERE c.actual = 1 AND c.tipo IN('Cierre','E.O.Modi')");

          break;

      }
     

      return $query->getResult();
    }

    private function _drawWhere($f,$q){
      //variable donde almacenamos el WHERE
      $where = "";
      //comprobamos los tipos de datos
      if( $f == 'cp' OR $f == 'telefono' )
      {
        //where si son datos numéricos
        $where = "WHERE u.".$f." = ".$q." AND u.id > 0";

      }else{
          //where si son cadenas de texto
          $where = "WHERE u.".$f." LIKE '%".$q."%'"." AND u.id > 0";
      }
      //devolvemos el resultado
      return $where;
    }

}
