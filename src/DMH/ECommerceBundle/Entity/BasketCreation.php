<?php

namespace DMH\ECommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity
 * @ORM\Table(name="dmh_basket_creation")
 */
class BasketCreation
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var Basket
     *
     * @ORM\ManyToOne(targetEntity="DMH\ECommerceBundle\Entity\Basket", cascade={}, inversedBy="items")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Serializer\Groups({})
     */
    private $basket;

    /**
     * @var Creation
     *
     * @ORM\ManyToOne(targetEntity="DMH\ECommerceBundle\Entity\Creation", cascade={})
     * @ORM\JoinColumn(name="creation_id", nullable=false)
     *
     * @Serializer\Groups({})
     */
    private $creation;


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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return BasketCreation
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set basket
     *
     * @param \DMH\ECommerceBundle\Entity\Basket $basket
     *
     * @return BasketCreation
     */
    public function setBasket(\DMH\ECommerceBundle\Entity\Basket $basket)
    {
        $this->basket = $basket;

        return $this;
    }

    /**
     * Get basket
     *
     * @return \DMH\ECommerceBundle\Entity\Basket
     */
    public function getBasket()
    {
        return $this->basket;
    }

    /**
     * Set creation
     *
     * @param \DMH\ECommerceBundle\Entity\Creation $creation
     *
     * @return BasketCreation
     */
    public function setCreation(\DMH\ECommerceBundle\Entity\Creation $creation)
    {
        $this->creation = $creation;

        return $this;
    }

    /**
     * Get creation
     *
     * @return \DMH\ECommerceBundle\Entity\Creation
     */
    public function getCreation()
    {
        return $this->creation;
    }
}
