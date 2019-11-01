<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmailHistoryRepository")
 *  @ApiResource(
 *     forceEager= false,
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write", "register"}}
 * )
 */
class EmailHistory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"info_user"})
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Groups({"info_user", "register"})
     */
    private $froms;

    /**
     * @ORM\Column(type="string")
     * @Groups({"info_user", "register"})
     */
    private $subject;

    /**
     * @ORM\Column(type="text")
     * @Groups({"info_user", "register"})
     */
    private $body;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\User", mappedBy="mailHistory", cascade={"persist", "remove"})
     * @Groups({"read"})
     */
    private $user;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFroms(): ?string
    {
        return $this->froms;
    }

    public function setFroms(string $froms): self
    {
        $this->froms = $froms;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setMailHistory($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->contains($user)) {
            $this->user->removeElement($user);
            // set the owning side to null (unless already changed)
            if ($user->getMailHistory() === $this) {
                $user->setMailHistory(null);
            }
        }

        return $this;
    }
}
