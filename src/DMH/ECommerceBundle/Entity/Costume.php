<?php

namespace DMH\ECommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Costume
 *
 * @ORM\Table(name="dmh_costume")
 * @ORM\Entity(repositoryClass="DMH\ECommerceBundle\Repository\CostumeRepository")
 *
 * @ExclusionPolicy("none")
 */
class Costume
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Groups({"listProduct"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Groups({"listProduct"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var Universe
     *
     * @ORM\ManyToOne(targetEntity="DMH\ECommerceBundle\Entity\Universe")
     * @JoinColumn(name="universe", referencedColumnName="id")
     * @Groups({"listProduct"})
     */
    private $universe;


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
     * @return Costume
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Costume
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set universe
     *
     * @param \DMH\ECommerceBundle\Entity\Universe $universe
     *
     * @return Costume
     */
    public function setUniverse(\DMH\ECommerceBundle\Entity\Universe $universe = null)
    {
        $this->universe = $universe;

        return $this;
    }

    /**
     * Get universe
     *
     * @return \DMH\ECommerceBundle\Entity\Universe
     */
    public function getUniverse()
    {
        return $this->universe;
    }
}
