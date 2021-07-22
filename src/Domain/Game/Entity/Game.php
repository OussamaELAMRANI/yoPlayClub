<?php

namespace App\Domain\Game\Entity;

use App\Domain\Game\Repository\GameRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(name: 'logo', type: 'string', nullable: true)]
    private string $logoPath;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Game
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getLogoPath(): string
    {
        return $this->logoPath;
    }

    /**
     * @param string $logoPath
     * @return Game
     */
    public function setLogoPath(string $logoPath): self
    {
        $this->logoPath = $logoPath;

        return $this;
    }
}
