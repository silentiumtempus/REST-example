<?php
declare(strict_types=1);

namespace App\Service;

use App\Interfaces\ResponseInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CommonEntityService
 * @package App\Service
 */
class CommonEntityService
{
    private $em;

    /**
     * CommonEntityService constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param ResponseInterface $context
     */
    public function persistSingleEntity(ResponseInterface $context): void
    {
        $this->em->persist($context);
        $this->em->flush();
    }

    /** */
    public function mergeSingleEntity(): void
    {
        $this->em->flush();
    }
}
