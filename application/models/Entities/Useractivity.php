<?php
namespace Entities;

/**
 * Useractivity
 *
 * @Table(name="userActivity", indexes={@Index(name="idUsuario", columns={"idUsuario"})})
 * @Entity
 */
class Useractivity
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
     * @var \DateTime
     *
     * @Column(name="timeCnx", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $timecnx;

    /**
     * @var \DateTime
     *
     * @Column(name="timeOut", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     */
    private $timeout;

    /**
     * @var \DateTime
     *
     * @Column(name="fActivity", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $factivity;

    /**
     * @var \Usuarios
     *
     * @ManyToOne(targetEntity="Usuarios")
     * @JoinColumns({
     *   @JoinColumn(name="idUsuario", referencedColumnName="id", nullable=true)
     * })
     */
    private $idusuario;

    public function __construct()
    {
        $this->timecnx = new \DateTime("now");
        $this->factivity = new \DateTime("now");
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
     * Set timecnx
     *
     * @param \DateTime $timecnx
     *
     * @return Useractivity
     */
    public function setTimecnx($timecnx)
    {
        $this->timecnx = $timecnx;

        return $this;
    }

    /**
     * Get timecnx
     *
     * @return \DateTime
     */
    public function getTimecnx()
    {
        return $this->timecnx;
    }

    /**
     * Set timeout
     *
     * @param \DateTime $timeout
     *
     * @return Useractivity
     */
    public function setTimeout()
    {
        $this->timeout = new \DateTime("now");

        return $this;
    }

    /**
     * Get timeout
     *
     * @return \DateTime
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * Set factivity
     *
     * @param \DateTime $factivity
     *
     * @return Useractivity
     */
    public function setFactivity($factivity)
    {
        $this->factivity = $factivity;

        return $this;
    }

    /**
     * Get factivity
     *
     * @return \DateTime
     */
    public function getFactivity()
    {
        return $this->factivity;
    }

    /**
     * Set idusuario
     *
     * @param \Usuarios $idusuario
     *
     * @return Useractivity
     */
    public function setIdusuario($idusuario)
    {
        $this->idusuario = $idusuario;

        return $this;
    }

    /**
     * Get idusuario
     *
     * @return \Usuarios
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }
}

