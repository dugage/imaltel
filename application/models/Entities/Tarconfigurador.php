<?php

namespace Entities;

/**
 * Tarconfigurador
 *
 * @Table(name="tarConfigurador", indexes={@Index(name="idOrigen", columns={"idOrigen"}), @Index(name="idTarifa", columns={"idTarifa"})})
 * @Entity
 */
class Tarconfigurador
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
     * @var integer
     *
     * @Column(name="idTerminal", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $idterminal;

    /**
     * @var integer
     *
     * @Column(name="idPaquete", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $idpaquete;

    /**
     * @var string
     *
     * @Column(name="comision", type="decimal", precision=6, scale=2, nullable=true, unique=false)
     */
    private $comision = 0;

    /**
     * @var \Tarorigenes
     *
     * @ManyToOne(targetEntity="Tarorigenes")
     * @JoinColumns({
     *   @JoinColumn(name="idOrigen", referencedColumnName="id", nullable=true)
     * })
     */
    private $idorigen;

    /**
     * @var \Tartarifas
     *
     * @ManyToOne(targetEntity="Tartarifas")
     * @JoinColumns({
     *   @JoinColumn(name="idTarifa", referencedColumnName="id", nullable=true)
     * })
     */
    private $idtarifa;


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
     * Set idterminal
     *
     * @param integer $idterminal
     *
     * @return Tarconfigurador
     */
    public function setIdterminal($idterminal)
    {
        $this->idterminal = $idterminal;

        return $this;
    }

    /**
     * Get idterminal
     *
     * @return integer
     */
    public function getIdterminal()
    {
        return $this->idterminal;
    }

    /**
     * Set idpaquete
     *
     * @param integer $idpaquete
     *
     * @return Tarconfigurador
     */
    public function setIdpaquete($idpaquete)
    {
        $this->idpaquete = $idpaquete;

        return $this;
    }

    /**
     * Get idpaquete
     *
     * @return integer
     */
    public function getIdpaquete()
    {
        return $this->idpaquete;
    }

    /**
     * Set comision
     *
     * @param string $comision
     *
     * @return Tarconfigurador
     */
    public function setComision($comision)
    {
        $this->comision = $comision;

        return $this;
    }

    /**
     * Get comision
     *
     * @return string
     */
    public function getComision()
    {
        return $this->comision;
    }

    /**
     * Set idorigen
     *
     * @param \Tarorigenes $idorigen
     *
     * @return Tarconfigurador
     */
    public function setIdorigen($idorigen)
    {
        $this->idorigen = $idorigen;

        return $this;
    }

    /**
     * Get idorigen
     *
     * @return \Tarorigenes
     */
    public function getIdorigen()
    {
        return $this->idorigen;
    }

    /**
     * Set idtarifa
     *
     * @param \Tartarifas $idtarifa
     *
     * @return Tarconfigurador
     */
    public function setIdtarifa($idtarifa)
    {
        $this->idtarifa = $idtarifa;

        return $this;
    }

    /**
     * Get idtarifa
     *
     * @return \Tartarifas
     */
    public function getIdtarifa()
    {
        return $this->idtarifa;
    }
}

