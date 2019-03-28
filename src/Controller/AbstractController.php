<?php
declare(strict_types=1);

namespace App\Controller;

use App\Service\CommonEntityService;
use App\DataTransformer\ResponseTransformer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AbstractController
 * @package App\Controller
 */
abstract class AbstractController
{
    private $serializer;
    protected $validator;
    protected $responseTransformer;
    protected $commonEntityService;

    /**
     * AbstractController constructor.
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @param ResponseTransformer $responseTransformer
     * @param CommonEntityService $commonEntityService
     */
    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        ResponseTransformer $responseTransformer,
        CommonEntityService $commonEntityService
    ) {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->responseTransformer = $responseTransformer;
        $this->commonEntityService = $commonEntityService;
    }
}
