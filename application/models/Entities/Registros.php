<?php

namespace Entities;

/**
 * Registros
 *
 * @Table(name="registros", indexes={@Index(name="fk_re_es", columns={"idEstado"}), @Index(name="idUsuario", columns={"idUsuario"}), @Index(name="fk_re_op", columns={"idOperador"})})
  @Entity(repositoryClass="Repositories\RegistrosRepositorio")
 */
class Registros
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
     * @Column(name="empresa", type="string", length=250, precision=0, scale=0, nullable=true, unique=false)
     */
    private $empresa;

    /**
     * @var integer
     *
     * @Column(name="numEmpleados", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $numempleados;

    /**
     * @var string
     *
     * @Column(name="sector", type="string", length=100, precision=0, scale=0, nullable=true, unique=false)
     */
    private $sector;

    /**
     * @var integer
     *
     * @Column(name="telefono", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $telefono;

    /**
     * @var integer
     *
     * @Column(name="movil", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $movil;

    /**
     * @var string
     *
     * @Column(name="administrador", type="string", length=250, precision=0, scale=0, nullable=true, unique=false)
     */
    private $administrador;

    /**
     * @var string
     *
     * @Column(name="perContacto", type="string", length=250, precision=0, scale=0, nullable=true, unique=false)
     */
    private $percontacto;

    /**
     * @var string
     *
     * @Column(name="cif", type="string", length=10, precision=0, scale=0, nullable=true, unique=false)
     */
    private $cif;

    /**
     * @var string
     *
     * @Column(name="direccion", type="string", length=250, precision=0, scale=0, nullable=true, unique=false)
     */
    private $direccion;

    /**
     * @var integer
     *
     * @Column(name="cp", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $cp;

    /**
     * @var string
     *
     * @Column(name="provincia", type="string", length=250, precision=0, scale=0, nullable=true, unique=false)
     */
    private $provincia;

    /**
     * @var string
     *
     * @Column(name="poblacion", type="string", length=250, precision=0, scale=0, nullable=true, unique=false)
     */
    private $poblacion;

    /**
     * @var string
     *
     * @Column(name="web", type="string", length=250, precision=0, scale=0, nullable=true, unique=false)
     */
    private $web;

    /**
     * @var string
     *
     * @Column(name="email", type="string", length=250, precision=0, scale=0, nullable=true, unique=false)
     */
    private $email;

    /**
     * @var string
     *
     * @Column(name="comentario", type="text", length=65535, precision=0, scale=0, nullable=true, unique=false)
     */
    private $comentario;

    /**
     * @var \DateTime
     *
     * @Column(name="fRegistro", type="datetime", precision=0, scale=0, nullable=true, unique=false)
     */
    private $fregistro;

    /**
     * @var string
     *
     * @Column(name="tRegistro", type="decimal", precision=4, scale=2, nullable=true, unique=false)
     */
    private $tregistro;

    /**
     * @var boolean
     *
     * @Column(name="oculto", type="boolean", precision=0, scale=0, nullable=true, unique=false)
     */
    private $oculto;

    /**
     * @var integer
     *
     * @Column(name="lineasMovil", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $lineasmovil;

    /**
     * @var integer
     *
     * @Column(name="lineasDatos", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $lineasdatos;

    /**
     * @var integer
     *
     * @Column(name="adsl", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $adsl;

    /**
     * @var integer
     *
     * @Column(name="conectaPymes", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $conectapymes;

    /**
     * @var boolean
     *
     * @Column(name="centralita", type="boolean", precision=0, scale=0, nullable=true, unique=false)
     */
    private $centralita;

    /**
     * @var integer
     *
     * @Column(name="centralitas", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $centralitas;

    /**
     * @var string
     *
     * @Column(name="tipoCpyme", type="string", length=250, precision=0, scale=0, nullable=true, unique=false)
     */
    private $tipocpyme;

    /**
     * @var boolean
     *
     * @Column(name="permanencia", type="boolean", precision=0, scale=0, nullable=true, unique=false)
     */
    private $permanencia;

    /**
     * @var integer
     *
     * @Column(name="tPermanencia", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $tpermanencia;

    /**
     * @var \Estadosregistros
     *
     * @ManyToOne(targetEntity="Estadosregistros")
     * @JoinColumns({
     *   @JoinColumn(name="idEstado", referencedColumnName="id", nullable=true)
     * })
     */
    private $idestado;

    /**
     * @var \Usuarios
     *
     * @ManyToOne(targetEntity="Usuarios")
     * @JoinColumns({
     *   @JoinColumn(name="idUsuario", referencedColumnName="id", nullable=true)
     * })
     */
    private $idusuario;

    /**
     * @var \Operadores
     *
     * @ManyToOne(targetEntity="Operadores")
     * @JoinColumns({
     *   @JoinColumn(name="idOperador", referencedColumnName="id", nullable=true)
     * })
     */
    private $idoperador;

    public function __construct()
    {
        $this->oculto = 0;
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
     * Set empresa
     *
     * @param string $empresa
     *
     * @return Registros
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return string
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set numempleados
     *
     * @param integer $numempleados
     *
     * @return Registros
     */
    public function setNumempleados($numempleados)
    {
        $this->numempleados = $numempleados;

        return $this;
    }

    /**
     * Get numempleados
     *
     * @return integer
     */
    public function getNumempleados()
    {
        return $this->numempleados;
    }

    /**
     * Set sector
     *
     * @param string $sector
     *
     * @return Registros
     */
    public function setSector($sector)
    {
        $this->sector = $sector;

        return $this;
    }

    /**
     * Get sector
     *
     * @return string
     */
    public function getSector()
    {
        return $this->sector;
    }

    /**
     * Set telefono
     *
     * @param integer $telefono
     *
     * @return Registros
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return integer
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set movil
     *
     * @param integer $movil
     *
     * @return Registros
     */
    public function setMovil($movil)
    {
        $this->movil = $movil;

        return $this;
    }

    /**
     * Get movil
     *
     * @return integer
     */
    public function getMovil()
    {
        return $this->movil;
    }

    /**
     * Set administrador
     *
     * @param string $administrador
     *
     * @return Registros
     */
    public function setAdministrador($administrador)
    {
        $this->administrador = $administrador;

        return $this;
    }

    /**
     * Get administrador
     *
     * @return string
     */
    public function getAdministrador()
    {
        return $this->administrador;
    }

    /**
     * Set percontacto
     *
     * @param string $percontacto
     *
     * @return Registros
     */
    public function setPercontacto($percontacto)
    {
        $this->percontacto = $percontacto;

        return $this;
    }

    /**
     * Get percontacto
     *
     * @return string
     */
    public function getPercontacto()
    {
        return $this->percontacto;
    }

    /**
     * Set cif
     *
     * @param string $cif
     *
     * @return Registros
     */
    public function setCif($cif)
    {
        $this->cif = $cif;

        return $this;
    }

    /**
     * Get cif
     *
     * @return string
     */
    public function getCif()
    {
        return $this->cif;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Registros
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set cp
     *
     * @param integer $cp
     *
     * @return Registros
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return integer
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set provincia
     *
     * @param string $provincia
     *
     * @return Registros
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return string
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set poblacion
     *
     * @param string $poblacion
     *
     * @return Registros
     */
    public function setPoblacion($poblacion)
    {
        $this->poblacion = $poblacion;

        return $this;
    }

    /**
     * Get poblacion
     *
     * @return string
     */
    public function getPoblacion()
    {
        return $this->poblacion;
    }

    /**
     * Set web
     *
     * @param string $web
     *
     * @return Registros
     */
    public function setWeb($web)
    {
        $this->web = $web;

        return $this;
    }

    /**
     * Get web
     *
     * @return string
     */
    public function getWeb()
    {
        return $this->web;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Registros
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set comentario
     *
     * @param string $comentario
     *
     * @return Registros
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Get comentario
     *
     * @return string
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * Set fregistro
     *
     * @param \DateTime $fregistro
     *
     * @return Registros
     */
    public function setFregistro($fregistro)
    {
        $this->fregistro = $fregistro;

        return $this;
    }

    /**
     * Get fregistro
     *
     * @return \DateTime
     */
    public function getFregistro()
    {
        return $this->fregistro;
    }

    /**
     * Set tregistro
     *
     * @param string $tregistro
     *
     * @return Registros
     */
    public function setTregistro($tregistro)
    {
        $this->tregistro = $tregistro;

        return $this;
    }

    /**
     * Get tregistro
     *
     * @return string
     */
    public function getTregistro()
    {
        return $this->tregistro;
    }

    /**
     * Set oculto
     *
     * @param boolean $oculto
     *
     * @return Registros
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
     * Set lineasmovil
     *
     * @param integer $lineasmovil
     *
     * @return Cuentas
     */
    public function setLineasmovil($lineasmovil)
    {
        $this->lineasmovil = $lineasmovil;

        return $this;
    }

    /**
     * Get lineasmovil
     *
     * @return integer
     */
    public function getLineasmovil()
    {
        return $this->lineasmovil;
    }

    /**
     * Set lineasdatos
     *
     * @param integer $lineasdatos
     *
     * @return Cuentas
     */
    public function setLineasdatos($lineasdatos)
    {
        $this->lineasdatos = $lineasdatos;

        return $this;
    }

    /**
     * Get lineasdatos
     *
     * @return integer
     */
    public function getLineasdatos()
    {
        return $this->lineasdatos;
    }

    /**
     * Set adsl
     *
     * @param integer $adsl
     *
     * @return Cuentas
     */
    public function setAdsl($adsl)
    {
        $this->adsl = $adsl;

        return $this;
    }

    /**
     * Get adsl
     *
     * @return integer
     */
    public function getAdsl()
    {
        return $this->adsl;
    }

    /**
     * Set conectapymes
     *
     * @param integer $conectapymes
     *
     * @return Cuentas
     */
    public function setConectapymes($conectapymes)
    {
        $this->conectapymes = $conectapymes;

        return $this;
    }

    /**
     * Get conectapymes
     *
     * @return integer
     */
    public function getConectapymes()
    {
        return $this->conectapymes;
    }

    /**
     * Set centralita
     *
     * @param boolean $centralita
     *
     * @return Cuentas
     */
    public function setCentralita($centralita)
    {
        $this->centralita = $centralita;

        return $this;
    }

    /**
     * Get centralita
     *
     * @return boolean
     */
    public function getCentralita()
    {
        return $this->centralita;
    }

    /**
     * Set centralitas
     *
     * @param integer $centralitas
     *
     * @return Cuentas
     */
    public function setCentralitas($centralitas)
    {
        $this->centralitas = $centralitas;

        return $this;
    }

    /**
     * Get centralitas
     *
     * @return integer
     */
    public function getCentralitas()
    {
        return $this->centralitas;
    }

    /**
     * Set tipocpyme
     *
     * @param string $tipocpyme
     *
     * @return Cuentas
     */
    public function setTipocpyme($tipocpyme)
    {
        $this->tipocpyme = $tipocpyme;

        return $this;
    }

    /**
     * Get tipocpyme
     *
     * @return string
     */
    public function getTipocpyme()
    {
        return $this->tipocpyme;
    }

    /**
     * Set permanencia
     *
     * @param boolean $permanencia
     *
     * @return Cuentas
     */
    public function setPermanencia($permanencia)
    {
        $this->permanencia = $permanencia;

        return $this;
    }

    /**
     * Get permanencia
     *
     * @return boolean
     */
    public function getPermanencia()
    {
        return $this->permanencia;
    }

    /**
     * Set tpermanencia
     *
     * @param integer $tpermanencia
     *
     * @return Cuentas
     */
    public function setTpermanencia($tpermanencia)
    {
        $this->tpermanencia = $tpermanencia;

        return $this;
    }

    /**
     * Get tpermanencia
     *
     * @return integer
     */
    public function getTpermanencia()
    {
        return $this->tpermanencia;
    }

    /**
     * Set idoperador
     *
     * @param \Operadores $idoperador
     *
     * @return Cuentas
     */
    public function setIdoperador($idoperador)
    {
        $this->idoperador = $idoperador;

        return $this;
    }

    /**
     * Get idoperador
     *
     * @return \Operadores
     */
    public function getIdoperador()
    {
        return $this->idoperador;
    }

    /**
     * Set idestado
     *
     * @param \Estadosregistros $idestado
     *
     * @return Registros
     */
    public function setIdestado($idestado)
    {
        $this->idestado = $idestado;

        return $this;
    }

    /**
     * Get idestado
     *
     * @return \Estadosregistros
     */
    public function getIdestado()
    {
        return $this->idestado;
    }

    /**
     * Set idusuario
     *
     * @param \Usuarios $idusuario
     *
     * @return Registros
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

