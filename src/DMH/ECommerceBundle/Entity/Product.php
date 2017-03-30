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
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * Product
 *
 * @ORM\Table(name="dmh_product")
 * @ORM\Entity(repositoryClass="DMH\ECommerceBundle\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ExclusionPolicy("all")
 *
 *
 *  @Hateoas\Relation(
 *      "model",
 *      href = @Hateoas\Route(
 *          "api_get_product_model",
 *          parameters = { "id" = "expr(object.getId())" },
 *     absolute = true
 *      ),
 *     exclusion = @Hateoas\Exclusion(groups = {"listProduct"})
 * )
 *
 * @Hateoas\Relation(
 *      "thumbnail",
 *      href = @Hateoas\Route(
 *          "api_get_product_thumbnail",
 *          parameters = { "id" = "expr(object.getId())" },
 *     absolute = true
 *      ),
 *     exclusion = @Hateoas\Exclusion(groups = {"listProduct"})
 * )
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"listProduct"})
     *
     * @Expose
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @Groups({"listProduct"})
     * @Expose
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     *
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
     *
     * @Groups({"listProduct"})
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
     * @Groups({"listProduct"})
     *
     */
    private $category;

    /**
     * @var Costume
     *
     * @ORM\ManyToOne(targetEntity="DMH\ECommerceBundle\Entity\Costume")
     * @JoinColumn(name="costume", referencedColumnName="id")
     *
     * @Groups({"listProduct"})
     *
     */
    private $costume;

    /**
     * @var Media
     * @ORM\OneToOne(targetEntity="DMH\ECommerceBundle\Entity\Media", cascade={"persist", "remove"})
     * @Expose
     */
    private $model3D;
    private $model3DDir;

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
        if ($this->model3D != null) {
            $this->setModel3DDir();
        }
        return $this->model3D;
    }

    public function getProductDir()
    {
        return $this->productDir;
    }

    /**
     *
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
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
        $this->model3DDir = $this->productDir."/model";
        if ($this->model3D != null) {
            $this->model3D->setUploadDir($this->model3DDir);
        }
        return $this;
    }

    /**
     * @VirtualProperty
     * @SerializedName("thumbnailLink")
     *
     * @Groups({})
     *
     * @return string
     */
    public function getThumbnailLink()
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
     * @Groups({})
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

    /**
     * @VirtualProperty
     * @SerializedName("modelLink")
     *
     * @Groups({})
     * @return string
     */
    public function getModel3DLink()
    {
        if($this->model3D != null)
        {
            $this->setModel3DDir();
            $dir = $this->model3D->getWebPath();
            return $dir;
        }
        return $dir = null;
    }
}
