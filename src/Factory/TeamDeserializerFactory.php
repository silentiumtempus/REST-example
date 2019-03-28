<?php
declare(strict_types=1);

namespace App\Factory;

use App\Entity\TeamEntity;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

/**
 * Class TeamDeserializerFactory
 * @package App\Factory
 */
class TeamDeserializerFactory
{
    private $teamDeserializer;

    public function __construct()
    {
        $this->teamDeserializer = $this->prepareJsonTeamSDeserializer();
    }

    /**
     * @param Request $request
     * @param array $objectToPopulate
     * @return array|null
     */
    public function deserializeTeam(Request $request, array $objectToPopulate): ?TeamEntity
    {
        $deserializedTeam =
            $this->teamDeserializer->deserialize(
                $request->getContent(),
                TeamEntity::class,
                'json',
                $objectToPopulate
            );

        return $deserializedTeam;
    }

    /**
     * @return Serializer
     */
    private function prepareJsonEntityDeserializer(): Serializer
    {
        $deserializer = new Serializer(
            array(new GetSetMethodNormalizer()),
            array(new JsonEncoder()));

        return $deserializer;
    }

    /**
     * @return mixed
     */
    private function prepareJsonTeamSDeserializer(): Serializer
    {
        return $this->prepareJsonEntityDeserializer();

    }
}
