<?php

namespace DMH\ECommerceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
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
 * @ORM\HasLifecycleCallbacks()
 * @ExclusionPolicy("all")
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

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="DMH\ECommerceBundle\Entity\Category")
     * @JoinColumn(name="category", referencedColumnName="id")
     *
     */
    private $category;

    /**
     * @var Costume
     *
     * @ORM\ManyToOne(targetEntity="DMH\ECommerceBundle\Entity\Costume")
     * @JoinColumn(name="costume", referencedColumnName="id")
     *
     */
    private $costume;

    /**
     * @var Media
     * @ORM\OneToOne(targetEntity="DMH\ECommerceBundle\Entity\Media", cascade={"persist", "remove"})
     * @Expose
     */
    private $model3D;
    private $model3DPattern;

    /**
     * @var Media
     * @ORM\OneToOne(targetEntity="DMH\ECommerceBundle\Entity\Media", cascade={"persist", "remove"})
     * @Expose
     */
    private $pattern;
    private $patternDir;

    private $productDir;

    public function __construct()
    {
        $this->setProductDir();
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
     * Set category
     *
     * @param \DMH\ECommerceBundle\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(\DMH\ECommerceBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \DMH\ECommerceBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set costume
     *
     * @param \DMH\ECommerceBundle\Entity\Costume $costume
     *
     * @return Product
     */
    public function setCostume(\DMH\ECommerceBundle\Entity\Costume $costume = null)
    {
        $this->costume = $costume;

        return $this;
    }

    /**
     * Get costume
     *
     * @return \DMH\ECommerceBundle\Entity\Costume
     */
    public function getCostume()
    {
        return $this->costume;
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
     * Set pattern
     *
     * @param \DMH\ECommerceBundle\Entity\Media $pattern
     *
     * @return Product
     */
    public function setPattern(\DMH\ECommerceBundle\Entity\Media $pattern = null)
    {
        $this->pattern = $pattern;
        if ($this->pattern != null) {
            $this->setPatternDir();
        }
        return $this;
    }

    /**
     * Get pattern
     *
     * @return \DMH\ECommerceBundle\Entity\Media
     */
    public function getPattern()
    {
        if ($this->pattern != null) {
            $this->setPatternDir();
        }
        return $this->pattern;
    }


    /**
     * Set model3D
     *
     * @param \DMH\ECommerceBundle\Entity\Media $model3D
     *
     * @return Product
     */
    public function setModel3D(\DMH\ECommerceBundle\Entity\Media $model3D = null)
    {
        $this->model3D = $model3D;

        return $this;
    }

    /**
     * Get model3D
     *
     * @return \DMH\ECommerceBundle\Entity\Media
     */
    public function getModel3D()
    {
        return $this->model3D;
    }

    public function getProductDir()
    {
        return $this->productDir;
    }

    /**
     * @ORM\PostLoad()
     */
    public function setProductDir($dir = null)
    {
        if($dir == null)
        {
            $universe = $this->getCostume()->getUniverse()->getId();
            $costume = $this->getCostume()->getId();
            $this->productDir = "uploads/models/".$universe."/costumes/".$costume."/products/".$this->id;
        }else{
            $this->dir = $dir;
        }
        return $this;

    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function setThumbnailDir()
    {
        if($this->productDir == null)
        {
            $this->setProductDir();
        }
        $this->thumbnailDir = $this->productDir."/image";
        if ($this->thumbnail != null) {
            $this->thumbnail->setUploadDir($this->thumbnailDir);
        }
        return $this;
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function setPatternDir()
    {
        if($this->productDir == null)
        {
            $this->setProductDir();
        }
        $this->patternDir = $this->productDir."/pattern";
        if ($this->pattern != null) {
            $this->pattern->setUploadDir($this->patternDir);
        }
        return $this;
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function setModel3DDir()
    {
        if($this->productDir == null)
        {
            $this->setProductDir();
        }
        $this->patternDir = $this->productDir."/model";
        if ($this->pattern != null) {
            $this->pattern->setUploadDir($this->patternDir);
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

    /**
     * @VirtualProperty
     * @SerializedName("patternLink")
     *
     * @return string
     */
    public function getPatternLink()
    {
        if($this->pattern != null)
        {
            $this->setPatternDir();
            $dir = $this->pattern->getWebPath();
            return $dir;
        }
        return $dir = null;
    }
}
