<?php
declare(strict_types=1);

namespace App\Entity\Traits;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trait CommonTrait
 * @package App\Entity
 */
trait CommonTrait
{
    /**
     * @ORM\Id
     * @ORM\Column(type = "integer", nullable = false)
     * @ORM\GeneratedValue(strategy = "AUTO")
     */
    private $id;

    /**
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @ORM\Column(name="name", type="string", nullable=false)
     */
    private $name;

    /**
     * @return string
     */
    public function __toString(): ?string
    {
        return $this->name;
    }

    /**
     * Set id
     * @param int $id
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set name.
     * @param string $name
     * @return $this
     */
    public function setName(string $name = null): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }
}
