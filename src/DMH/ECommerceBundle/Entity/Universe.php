<?php

namespace DMH\ECommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Universe
 *
 * @ORM\Table(name="dmh_universe")
 * @ORM\Entity(repositoryClass="DMH\ECommerceBundle\Repository\UniverseRepository")
 *
 * @ExclusionPolicy("none")
 */
class Universe
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
     *
     * @Groups({"listProduct"})
     */
    private $name;

    /**
     * @var Media
     * @ORM\OneToOne(targetEntity="DMH\ECommerceBundle\Entity\Media", cascade={"persist", "remove"})
     * 
     */
    private $thumbnail;

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
     * @return Universe
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
     * Set thumbnail
     *
     * @param \DMH\ECommerceBundle\Entity\Media $thumbnail
     *
     * @return Universe
     */
    public function setThumbnail(\DMH\ECommerceBundle\Entity\Media $thumbnail = null)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return \DMH\ECommerceBundle\Entity\Media
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }
}
