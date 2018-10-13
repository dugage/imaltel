<?php

namespace Entities;

/**
 * Tartarifas
 *
 * @Table(name="tarTarifas", indexes={@Index(name="idGrupo", columns={"idGrupo"})})
 * @Entity
 */
class Tartarifas
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
     * @Column(name="nombre", type="string", length=250, precision=0, scale=0, nullable=false, unique=false)
     */
    private $nombre;

    /**
     * @var \DateTime
     *
     * @Column(name="fAlta", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $falta;

    /**
     * @var \Targrupos
     *
     * @ManyToOne(targetEntity="Targrupos")
     * @JoinColumns({
     *   @JoinColumn(name="idGrupo", referencedColumnName="id", nullable=true)
     * })
     */
    private $idgrupo;

    public function __construct()
    {
         $this->falta = new \DateTime("now");
    }


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
     * @return Tartarifas
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
     * Set falta
     *
     * @param \DateTime $falta
     *
     * @return Tartarifas
     */
    public function setFalta($falta)
    {
        $this->falta = $falta;

        return $this;
    }

    /**
     * Get falta
     *
     * @return \DateTime
     */
    public function getFalta()
    {
        return $this->falta;
    }

    /**
     * Set idgrupo
     *
     * @param \Targrupos $idgrupo
     *
     * @return Tartarifas
     */
    public function setIdgrupo($idgrupo)
    {
        $this->idgrupo = $idgrupo;

        return $this;
    }

    /**
     * Get idgrupo
     *
     * @return \Targrupos
     */
    public function getIdgrupo()
    {
        return $this->idgrupo;
    }
}

