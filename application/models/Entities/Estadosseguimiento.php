<?php

namespace Entities;

/**
 * Estadosseguimiento
 *
 * @Table(name="estadosSeguimiento")
 * @Entity
 */
class Estadosseguimiento
{
    /**
     * @var integer
     *
     * @Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="nombre", type="string", length=250, precision=0, scale=0, nullable=true, unique=false)
     */
    private $nombre;

    /**
     * @var boolean
     *
     * @Column(name="oculto", type="boolean", precision=0, scale=0, nullable=true, unique=false)
     */
    private $oculto = 0;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Estadosseguimiento
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set oculto
     *
     * @param boolean $oculto
     *
     * @return Estadosseguimiento
     */
    public function setOculto($oculto)
    {
        $this->oculto = $oculto;

        return $this;
    }

    /**
     * Get oculto
     *
     * @return boolean
     */
    public function getOculto()
    {
        return $this->oculto;
    }
}

