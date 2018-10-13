<?php
namespace Repositories;
use Doctrine\ORM\EntityRepository;

/**
 * Class RegistrosRepositorio
 * @package Repositories
 */
class RegistrosRepositorio extends EntityRepository
{

  /**
   * @var string
   */
  private $entity = "Entities\\Registros";

  /**
   * @return array
   */

    public function findFirstDate($start,$max,$f,$q,$usuario = false)
    {
      //montamos el wehre para los parametros de búsqueda
      $where = "";

      if($f AND $q)
      {
        if($f == 'cp')
        {

          $where = "AND u.".$f." = ".$q;

        }else{

            $where = "AND u.".$f." LIKE '%".$q."%'";
        }
      }

      //echo $where;

      if(!$usuario)
      {

        $query = $this->_em->createQuery("SELECT u FROM $this->entity u WHERE u.fregistro = CURRENT_DATE() $where ORDER BY u.fregistro ASC,u.tregistro ASC, u.idestado ASC")
        ->setFirstResult($start)
        ->setMaxResults($max);

      }else{

        $query = $this->_em->createQuery("SELECT u FROM $this->entity u WHERE u.idusuario = $usuario AND u.fregistro = CURRENT_DATE() AND u.oculto = 0 $where ORDER BY u.fregistro ASC,u.tregistro ASC, u.idestado ASC")
        ->setFirstResult($start)
        ->setMaxResults($max);


      }

      return $query->getResult();

    }

    public function findByStateDate($start,$max,$f,$q,$usuario = false)
    {

      //montamos el wehre para los parametros de búsqueda
      $where = "";

      if($f AND $q)
      {
        if($f == 'cp' OR $f == 'telefono')
        {

          $where = "AND u.".$f." = ".$q;

        }else{

            $where = "AND u.".$f." LIKE '%".$q."%'";
        }
      }

      if(!$usuario)
      {

        $query = $this->_em->createQuery("SELECT u FROM $this->entity u WHERE u.fregistro != CURRENT_DATE() $where ORDER BY u.fregistro ASC,u.tregistro ASC, u.idestado ASC")
        ->setFirstResult($start)
        ->setMaxResults($max);
        

      }else{

        $query = $this->_em->createQuery("SELECT u FROM $this->entity u WHERE u.idusuario = $usuario AND u.fregistro != CURRENT_DATE() AND u.oculto = 0 $where ORDER BY u.fregistro ASC,u.tregistro ASC, u.idestado ASC")
        ->setFirstResult($start)
        ->setMaxResults($max);  

      }

      return $query->getResult(); 

    }


    public function getNextRecord($usuario,$id)
    {   
          /*
          Consutamos primero comprobando entre otros parametros la hora para la que esta programáda
          la llamada es menor o igual, es decir si esta dentro de la hora a la que al cliente se le
          propuesto la llamada, si no es así, y el resultadoi es null, consultaremos si tenemos para
          este día programadas llamadas sin estado, es decir nuevas.
          */

        //almacenamos la hora actual en la que realizamos la consulta
        $hour = date('G.i');
        $query = $this->_em->createQuery("SELECT u FROM $this->entity u WHERE u.idusuario = $usuario AND u.id != $id AND u.fregistro = CURRENT_DATE() AND u.oculto = 0 AND u.tregistro <= $hour ORDER BY u.tregistro ASC, u.idestado ASC")
            ->setMaxResults(1);

        if($query->getOneOrNullResult() == null)
        {

          $query = $this->_em->createQuery("SELECT u FROM $this->entity u WHERE u.idusuario = $usuario AND u.id != $id AND u.fregistro = CURRENT_DATE() AND u.oculto = 0 AND u.idestado = 4 ORDER BY u.tregistro ASC, u.idestado ASC")
            ->setMaxResults(1);

        }
        
        return $query->getOneOrNullResult();
    }

    public function findByMultiple($param,$usuario,$type)
    {

      $where = "";

      foreach ($param as $key => $value) 
      {
        if($value != null)
        {
          if($key == "idestado" AND $type == 1)
          {

            $where .= "AND u.$key != $value ";

          }else
          {
            $where .= "AND u.$key = '$value' ";
          }

          
        }
        
      }

      $query = $this->_em->createQuery("SELECT u FROM $this->entity u WHERE u.idusuario = $usuario $where");
      return $query->getResult();

    }

    public function getRegistrosLimit($max,$start,$f,$q)
    {

      //montamos el wehre para los parametros de búsqueda
      $where = "";

      if($f AND $q)
      {
        if($f == 'cp' OR $f == 'telefono')
        {

          $where = "WHERE u.".$f." = ".$q;

        }else{

            $where = "WHERE u.".$f." LIKE '%".$q."%'";
        }
      }

      if($max > 0)
      {
        $query = $this->_em->createQuery("SELECT u FROM $this->entity u $where")
        ->setFirstResult($start)
        ->setMaxResults($max);

      }else{

        $query = $this->_em->createQuery("SELECT u FROM $this->entity u $where");
      }
      
      return $query->getResult();

    }

}
