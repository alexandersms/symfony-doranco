<?php
namespace App\Entity;
use DateTime;
use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 */
class Produit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=128)
     * @Assert\Length(
     *      min = 4,
     *      max = 128
     * )
     */
    private $name;
    /**
     * @ORM\Column(type="text")
     *  * @Assert\Length(
     *      min = 25,
     *      max = 4000
     * )
     */
    private $description;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $nbViews;
    /**
     * @ORM\Column(type="decimal", precision=9, scale=2)
     */
    private $price;
    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;
    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished;
    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $imageName;

    /**
     * @var File
     * @Vich\UploadableField(mapping="miniature_produit", fileNameProperty="imageName")
     * 
     */
    private $imageFile;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Tag", inversedBy="produits")
     */
    private $tags;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categories;
    /**
     * @ORM\Column(type="string", length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;
    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->nbViews = 0;
        
    }


    /**
     * @ORM\PrePersist
     */
    public function prePersDate()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Met à jour le slug par rapport au name
     */
     public function updateSlug()
     {
         //On recupere le slugger
        $slugify = new Slugify();
        //On utilise le slugger ... 
        // ... sur le name
        // ... pour mettre à jour le slug
        $this->slug = $slugify->slugify($this->name);
        return $this;
         
     }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(string $name): self
    {
        $this->name = $name;
        //On met à jour le slug
        $this->updateSlug();
        return $this;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }
    public function getPrice()
    {
        return $this->price;
    }
    public function setPrice($price): self
    {
        $this->price = $price;
        return $this;
    }
    public function getNbViews(): ?int
    {
        return $this->nbViews;
    }
    public function setNbViews(int $nbViews): self
    {
        $this->nbViews = $nbViews;
        return $this;
    }
    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }
    
    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;
        return $this;
    }
    public function getIsPublished(): ?bool
    {
        return $this->isPublished;
    }
    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;
        return $this;
    }
    public function getImageName(): ?string
    {
        return $this->imageName;
    }
    public function setImageName(string $imageName): self
    {
        $this->imageName = $imageName;
        return $this;
    }
    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }
    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }
        return $this;
    }
    public function removeTag(Tag $tag): self
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }
        return $this;
    }
    public function getCategories(): ?Category
    {
        return $this->categories;
    }
    public function setCategories(?Category $categories): self
    {
        $this->categories = $categories;
        return $this;
    }
    public function getSlug(): ?string
    {
        return $this->slug;
    }
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * On affiche le nom du produit
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Get the value of imageFile
     *
     * @return  File
     */ 
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * Set the value of imageFile
     *
     * @param  File  $imageFile
     *
     * @return  self
     */ 
    public function setImageFile(File $imageFile)
    {
        $this->imageFile = $imageFile;

        return $this;
    }
}