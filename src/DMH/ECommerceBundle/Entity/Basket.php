<?php

namespace DMH\ECommerceBundle\Entity;

use DMH\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * Basket
 *
 * @ORM\Table(name="dmh_basket")
 * @ORM\Entity(repositoryClass="DMH\ECommerceBundle\Repository\BasketRepository")
 */
class Basket
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
     * @var User
     *
     * @ORM\OneToOne(targetEntity="DMH\UserBundle\Entity\User", cascade={})
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     * @Serializer\Groups({})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="DMH\ECommerceBundle\Entity\BasketCreation", mappedBy="basket", cascade={"persist", "remove"})
     */
    private $items;


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
     * Constructor
     */
    public function __construct()
    {
        $this->creations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set user
     *
     * @param \DMH\UserBundle\Entity\User $user
     *
     * @return Basket
     */
    public function setUser(\DMH\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \DMH\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add item
     *
     * @param \DMH\ECommerceBundle\Entity\BasketCreation $item
     *
     * @return Basket
     */
    public function addItem(\DMH\ECommerceBundle\Entity\BasketCreation $item)
    {
        $this->items[] = $item;

        // On lie le basket à l'item
        $item->setBasket($this);

        return $this;
    }

    /**
     * Remove item
     *
     * @param \DMH\ECommerceBundle\Entity\BasketCreation $item
     */
    public function removeItem(\DMH\ECommerceBundle\Entity\BasketCreation $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }
}
