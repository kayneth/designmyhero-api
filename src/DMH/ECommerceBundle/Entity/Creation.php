<?php

namespace DMH\ECommerceBundle\Entity;

use DMH\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Creation
 *
 * @ORM\Table(name="dmh_creation")
 * @ORM\Entity(repositoryClass="DMH\ECommerceBundle\Repository\CreationRepository")
 * @ORM\HasLifecycleCallbacks()
 *
 * @Serializer\ExclusionPolicy("none")
 */
class Creation
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Groups({"listCreations"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @Groups({"listCreations"})
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
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="DMH\UserBundle\Entity\User", cascade={})
     * @ORM\JoinColumn(name="author", referencedColumnName="id", nullable=true)
     *
     * @Groups({"listCreations"})
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
     * @var Media
     * @ORM\OneToOne(targetEntity="DMH\ECommerceBundle\Entity\Media", cascade={"persist", "remove"})
     *
     */
    private $preview;
    private $previewDir;


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

    /**
     * Set private
     *
     * @param boolean $private
     *
     * @return Creation
     */
    public function setPrivate($private)
    {
        $this->private = $private;

        return $this;
    }

    /**
     * Get private
     *
     * @return boolean
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * Set thumbnail
     *
     * @param \DMH\ECommerceBundle\Entity\Media $thumbnail
     *
     * @return Creation
     */
    public function setPreview(\DMH\ECommerceBundle\Entity\Media $thumbnail = null)
    {
        $this->preview = $thumbnail;

        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return \DMH\ECommerceBundle\Entity\Media
     */
    public function getPreview()
    {
        return $this->preview;
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function setPreviewDir()
    {
        $this->previewDir = "uploads/creations/".$this->getId()."/preview";
        if ($this->preview != null) {
            $this->preview->setUploadDir($this->previewDir);
        }
        return $this;
    }

    /**
     * @Serializer\VirtualProperty()
     * @Serializer\SerializedName("previewLink")
     *
     * @Groups({"listCreations"})
     *
     * @return string
     */
    public function getThumbnailLink()
    {
        if($this->preview != null)
        {
            $this->setPreviewDir();
            $dir = $this->preview->getWebPath();
            return $dir;
        }
        return $dir = null;
    }
}
