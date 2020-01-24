<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\EtudiantRepository")
 */
class Etudiant implements UserInterface, \Serializable
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
     * @Assert\Length(min=3, max=30)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\Length(min=4, max=30)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     */
    private $image;


    /**
     * @ORM\Column(type="integer")
     * @Assert\Length(min=2, max=2)
     */
    private $age;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ecole", inversedBy="Etudiant")
     */
    private $Ecole;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Classe", inversedBy="Etudiant")
     */
    private $Classe;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Stage", inversedBy="Etudiant")
     */
    private $Stage;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

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

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

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

    public function getClasse(): ?Classe
    {
        return $this->Classe;
    }

    public function setClasse(?Classe $Classe): self
    {
        $this->Classe = $Classe;

        return $this;
    }

    public function getStage(): ?Stage
    {
        return $this->Stage;
    }

    public function setStage(?Stage $Stage): self
    {
        $this->Stage = $Stage;

        return $this;
    }

    public function __toString()
    {
        return (string)$this->nom;
        // TODO: Implement __toString() method.
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
        return ['ROLE_ETUDIANT'];
    }

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

}
