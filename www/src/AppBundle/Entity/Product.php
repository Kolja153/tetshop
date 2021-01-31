<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
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
     * @Assert\Regex(pattern="/^[0-9a-zA-Z\s]*$/")
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     * @Assert\Type("float")
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Attribute")
     * @ORM\JoinTable(name="product_attribute",
     *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="attribute_id", referencedColumnName="id")}
     *      )
     */
    private $attributes;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="date", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="date", nullable=true)
     */
    private $updatedAt;

    /**
     * Product constructor.
     */
    public function __construct() {
        $this->attributes = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
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
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price.
     *
     * @param int $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Get attributes.
     *
     * @return string
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param Attribute $attribute
     */
    public function addAttribute(Attribute $attribute)
    {


        if (!$this->attributes->contains($attribute)){
            $this->attributes->add($attribute);
        }
    }

    /**
     * @param Attribute $attribute
     */
    public function removeAttribute(Attribute $attribute)
    {
        if ($this->attributes->contains($attribute)){
            $this->attributes->removeElement($attribute);
        }
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param ArrayCollection $attributes
     */
    public function setAttributes(ArrayCollection $attributes)
    {
        $this->attributes = $attributes;
    }
}
