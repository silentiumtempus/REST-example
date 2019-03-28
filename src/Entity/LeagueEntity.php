<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\CommonTrait;
use App\Interfaces\ResponseInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Class LeagueEntity
 * @package App\Entity
 * @ORM\Entity
 * @UniqueEntity("name")
 * @ORM\Table(name="league")
 */
class LeagueEntity implements ResponseInterface
{
    use CommonTrait;

    /**
     * @Assert\Collection()
     * @Assert\NotBlank()
     * @ORM\OneToMany(targetEntity="TeamEntity", mappedBy = "league", cascade = {"remove"})
     */
    private $teams;

    /**
     * @return mixed
     */
    public function getTeams(): ?Collection
    {
        return $this->teams;
    }
}
