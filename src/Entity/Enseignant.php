<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\File;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EnseignantRepository")
 */
class Enseignant implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(min=8, max=8, minMessage="Le numéro de cin doit être composer de 8 entier!")
     * @Assert\Positive
     */
    private $cin;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\Length(min=4, max=30)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\Length(min=4, max=30)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=4)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private $email;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\File(mimeTypes={ "image/*" })
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $specialite;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(min=4, max=30)
     */
    private $CV;

    /**
     * @var File
     *
     * @UploadableField(name="CV", path="uploads/tutoriels")
     *
     */

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ecole", inversedBy="Enseignant")
     */
    private $Ecole;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Stage", mappedBy="Enseignant")
     */
    private $Stage;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    public function __construct()
    {
        $this->Stage = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCin(): ?int
    {
        return $this->cin;
    }

    public function setCin(int $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getCV()
    {
        return $this->CV;
    }

    public function setCV($CV)
    {
        $this->CV = $CV;

        return $this;
    }

    public function getEcole(): ?Ecole
    {
        return $this->Ecole;
    }

    public function setEcole(?Ecole $Ecole): self
    {
        $this->Ecole = $Ecole;

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStage(): Collection
    {
        return $this->Stage;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->Stage->contains($stage)) {
            $this->Stage[] = $stage;
            $stage->setEnseignant($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->Stage->contains($stage)) {
            $this->Stage->removeElement($stage);
            // set the owning side to null (unless already changed)
            if ($stage->getEnseignant() === $this) {
                $stage->setEnseignant(null);
            }
        }

        return $this;
    }


    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
//        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
//        $roles[] = 'ROLE_ADMIN';

        return ['ROLE_ENSEIGNANT'];
    }

//    public function setRoles(array $roles): self
//    {
//        $this->roles = $roles;
//
//        return $this;
//    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }


    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


    public function serialize()
    {
        return serialize([
            $this->id,
            $this->email,
            $this->password
        ]);
        // TODO: Implement serialize() method.
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->email,
            $this->password
            ) = unserialize($serialized, ['allowed_classes' => false]);
        // TODO: Implement unserialize() method.
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->email;
    }

    public function __toString()
    {
        return (string)$this->nom;
        // TODO: Implement __toString() method.
    }
}
