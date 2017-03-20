<?php

namespace DMH\ECommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\AccessorOrder;
use JMS\Serializer\Annotation\SerializedName;

/**
 * Product
 *
 * @ORM\Table(name="dmh_product")
 * @ORM\Entity(repositoryClass="DMH\ECommerceBundle\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks
 * @ExclusionPolicy("none")
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Expose
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @Expose
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     * @Expose
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Expose
     */
    private $description;

    /**
     * @var Media
     * @ORM\OneToOne(targetEntity="DMH\ECommerceBundle\Entity\Media", cascade={"persist", "remove"})
     * @Expose
     */
    private $thumbnail;

    private $thumbnailDir;

    private $costume;

    private $model;


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
     * @return Product
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
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Product
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set thumbnail
     *
     * @param \DMH\ECommerceBundle\Entity\Media $thumbnail
     *
     * @return Product
     */
    public function setThumbnail(\DMH\ECommerceBundle\Entity\Media $thumbnail = null)
    {
        $this->thumbnail = $thumbnail;
        if ($this->thumbnail != null) {
            $this->setThumbnailDir();
        }
        return $this;
    }
    /**
     * Get thumbnail
     *
     * @return \DMH\ECommerceBundle\Entity\Media
     */
    public function getThumbnail()
    {
        if ($this->thumbnail != null) {
            $this->setThumbnailDir();
        }
        return $this->thumbnail;
    }
    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function setThumbnailDir()
    {
        $this->thumbnailDir = "uploads/products/".$this->id."/image";
        if ($this->thumbnail != null) {
            $this->thumbnail->setUploadDir($this->thumbnailDir);
        }
        return $this;
    }
    /**
     * @VirtualProperty
     * @SerializedName("thumbnailLink")
     *
     * @return string
     */
    public function getThumnbnailLink()
    {
        if($this->thumbnail != null)
        {
            $this->setThumbnailDir();
            $dir = $this->thumbnail->getWebPath();
            return $dir;
        }
        return $dir = null;
    }
}

