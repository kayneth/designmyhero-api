<?php

namespace DMH\ECommerceBundle\Entity;

use DMH\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Creation
 *
 * @ORM\Table(name="dmh_creation")
 * @ORM\Entity(repositoryClass="DMH\ECommerceBundle\Repository\CreationRepository")
 */
class Creation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var boolean
     *
     *  @ORM\Column(name="private", type="boolean")
     */
    private $private;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="DMH\UserBundle\Entity\User", cascade={})
     * @ORM\JoinColumn(name="author", referencedColumnName="id")
     * @Serializer\Groups({})
     */
    private $author;

    /**
     * @var Product
     *
     * @ORM\ManyToMany(targetEntity="DMH\ECommerceBundle\Entity\Product", cascade={})
     * @ORM\JoinTable(name="dmh_creation_product")
     *
     * @Serializer\Groups({})
     */
    private $products;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->private = false;
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Creation
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set author
     *
     * @param \DMH\UserBundle\Entity\User $author
     *
     * @return Creation
     */
    public function setAuthor(\DMH\UserBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \DMH\UserBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Add product
     *
     * @param \DMH\ECommerceBundle\Entity\Product $product
     *
     * @return Creation
     */
    public function addProduct(\DMH\ECommerceBundle\Entity\Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \DMH\ECommerceBundle\Entity\Product $product
     */
    public function removeProduct(\DMH\ECommerceBundle\Entity\Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }
}
