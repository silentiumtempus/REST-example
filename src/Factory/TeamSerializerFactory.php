<?php
declare(strict_types=1);

namespace App\Factory;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Class TeamSerializerFactory
 * @package App\Factory
 */
class TeamSerializerFactory
{
    private $teamSerializer;

    /**
     * TeamSerializerFactory constructor.
     */
    public function __construct()
    {
        $this->teamSerializer = $this->prepareTeamJsonSerializer();
    }

    /**
     * @param array $teams
     * @return array
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function serializeTeams(array $teams): ?array
    {
        $serializedTeams = null;
        foreach ($teams as $team)
        {
            $serializedTeams[] = $this->teamSerializer->normalize($team);
        }

        return $serializedTeams;
    }

    /**
     * @return ObjectNormalizer
     */
    private function prepareEntityJsonNormalizer(): ObjectNormalizer
    {
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setSerializer(new Serializer([$normalizer], [$encoder]));
        $normalizer->setCircularReferenceHandler(function ($object) {

            return $object->__toString();
        });

        return $normalizer;
    }

    /**
     * @param ObjectNormalizer $normalizer
     * @return ObjectNormalizer
     */
    private function setTeamIgnoredAttributes(ObjectNormalizer $normalizer): ObjectNormalizer
    {
        $normalizer->setIgnoredAttributes(
            array('teams' => 'league'));

        return $normalizer;
    }

    /**
     * @return ObjectNormalizer
     */
    private function prepareTeamJsonSerializer(): ObjectNormalizer
    {
        $normalizer = $this->prepareEntityJsonNormalizer();
        $normalizer = $this->setTeamIgnoredAttributes($normalizer);

        return $normalizer;

    }
}
