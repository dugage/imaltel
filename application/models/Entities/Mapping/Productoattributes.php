<?php



use Doctrine\Mapping as ORM;

/**
 * Productoattributes
 *
 * @Table(name="productoAttributes", indexes={@Index(name="id_product", columns={"id_product"}), @Index(name="id_attribute", columns={"id_attribute"}), @Index(name="id_attribute_value", columns={"id_attribute_value"})})
 * @Entity
 */
class Productoattributes
{
    /**
     * @var integer
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="impact", type="decimal", precision=6, scale=2, nullable=false)
     */
    private $impact;

    /**
     * @var boolean
     *
     * @Column(name="state", type="boolean", nullable=true)
     */
    private $state = '1';

    /**
     * @var integer
     *
     * @Column(name="orden", type="integer", nullable=true)
     */
    private $orden = '1';

    /**
     * @var \Atributosvalores
     *
     * @ManyToOne(targetEntity="Atributosvalores")
     * @JoinColumns({
     *   @JoinColumn(name="id_attribute_value", referencedColumnName="id")
     * })
     */
    private $idAttributeValue;

    /**
     * @var \Productos
     *
     * @ManyToOne(targetEntity="Productos")
     * @JoinColumns({
     *   @JoinColumn(name="id_product", referencedColumnName="id")
     * })
     */
    private $idProduct;

    /**
     * @var \Atributos
     *
     * @ManyToOne(targetEntity="Atributos")
     * @JoinColumns({
     *   @JoinColumn(name="id_attribute", referencedColumnName="id")
     * })
     */
    private $idAttribute;


}

