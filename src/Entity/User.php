<?php
namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;
    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];
    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;
    /**
     * @ORM\Column(type="integer")
     */
    private $active;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\News", mappedBy="User")
     */
    private $news;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\News", mappedBy="User")
     */
    private $f;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\News", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $News;

    public function __construct()
    {
        $this->news = new ArrayCollection();
        $this->f = new ArrayCollection();
    }
    public function getId(): ?bool
    {
        return $this->id;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }
    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }
    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }
    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }
    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    public function getActive(): ?int
    {
        return $this->active;
    }
    public function setActive(int $active): self
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return Collection|News[]
     */
    public function getNews(): Collection
    {
        return $this->news;
    }

    public function addNews(News $news): self
    {
        if (!$this->news->contains($news)) {
            $this->news[] = $news;
            $news->setUser($this);
        }

        return $this;
    }

    public function removeNews(News $news): self
    {
        if ($this->news->contains($news)) {
            $this->news->removeElement($news);
            // set the owning side to null (unless already changed)
            if ($news->getUser() === $this) {
                $news->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|News[]
     */
    public function getF(): Collection
    {
        return $this->f;
    }

    public function addF(News $f): self
    {
        if (!$this->f->contains($f)) {
            $this->f[] = $f;
            $f->setUser($this);
        }

        return $this;
    }

    public function removeF(News $f): self
    {
        if ($this->f->contains($f)) {
            $this->f->removeElement($f);
            // set the owning side to null (unless already changed)
            if ($f->getUser() === $this) {
                $f->setUser(null);
            }
        }

        return $this;
    }

    public function setNews(?News $News): self
    {
        $this->News = $News;

        return $this;
    }
}