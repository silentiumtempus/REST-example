<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\CommonTrait;
use App\Interfaces\ResponseInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class TeamEntity
 * @package App\Entity
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 * @UniqueEntity("name")
 * @ORM\Table(name="team")
 */
class TeamEntity implements ResponseInterface
{
    use CommonTrait;

    /**
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity = "LeagueEntity", inversedBy = "teams", cascade = {"remove"})
     * @ORM\JoinColumn(name = "league_id", referencedColumnName = "id")
     */
    protected $league;

    /**
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @ORM\Column(name="strip", type="string", nullable=false)
     */
    private $strip;

    /**
     * @param string $strip
     * @return TeamEntity
     */
    public function setStrip(string $strip = null): self
    {
        $this->strip = $strip;

        return $this;
    }

    /**
     * @return string
     */
    public function getStrip(): ?string
    {
        return $this->strip;
    }

    /**
     * @param LeagueEntity $leagueEntity
     * @return TeamEntity
     */
    public function setLeague(LeagueEntity $leagueEntity): self
    {
        $this->league = $leagueEntity;

        return $this;
    }

    /**
     * @return LeagueEntity
     */
    public function getLeague(): LeagueEntity
    {
        return $this->league;
    }
}
