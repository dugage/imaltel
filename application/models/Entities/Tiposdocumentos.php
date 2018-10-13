<?php
namespace Entities;

/**
 * Tiposdocumentos
 *
 * @Table(name="tiposDocumentos")
 * @Entity
 */
class Tiposdocumentos
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
     * @Column(name="valor", type="string", length=40, precision=0, scale=0, nullable=true, unique=false)
     */
    private $valor;

    /**
     * @var boolean
     *
     * @Column(name="oculto", type="boolean", precision=0, scale=0, nullable=true, unique=false)
     */
    private $oculto = 0;

    /**
     * @var boolean
     *
     * @Column(name="cierre", type="boolean", precision=0, scale=0, nullable=true, unique=false)
     */
    private $cierre = 0;


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
     * Set valor
     *
     * @param string $valor
     *
     * @return Tiposdocumento
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return string
     */
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set oculto
     *
     * @param boolean $oculto
     *
     * @return Tiposdocumento
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

    /**
     * Set cierre
     *
     * @param boolean $cierre
     *
     * @return Tiposdocumento
     */
    public function setCierre($cierre)
    {
        $this->cierre = $cierre;

        return $this;
    }

    /**
     * Get cierre
     *
     * @return boolean
     */
    public function getCierre()
    {
        return $this->cierre;
    }
}

