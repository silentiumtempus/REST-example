<?php
declare(strict_types=1);

namespace App\DataTransformer;

use App\Interfaces\ResponseInterface;
use Doctrine\Common\Inflector\Inflector;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class ResponseTransformer
 * @package App\DataTransformer
 */
class ResponseTransformer
{
    // enable is response serialization is required
    // private const RESPONSE_FORMAT = 'json';
    public const CONTENT_TYPE = 'application/json';
    protected $data;
    private $serializer;
    protected $validator;

    /**
     * ResponseTransformer constructor.
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     */
    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ) {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * @param string $contentType
     */
    public function validateContentType(string $contentType): void
    {
        if (self::CONTENT_TYPE !== $contentType) {
            throw new ValidatorException(
                'Invalid content type header.',
                Response::HTTP_UNSUPPORTED_MEDIA_TYPE
            );
        }
    }

    /**
     * @param ResponseInterface|null $content
     * @param int $status
     * @return JsonResponse
     */
    public function createResponse(
        ResponseInterface $content = null,
        int $status = Response::HTTP_OK
    ): JsonResponse
    {
        // response serialization is disabled by default
        // $content = $this->serializer->serialize($content, self::RESPONSE_FORMAT);

        return new JsonResponse($content, $status, ['Content-Type' => self::CONTENT_TYPE]);
    }

    /**
     * @param ConstraintViolationListInterface $violations
     * @return string
     */
    public function createErrorMessage(ConstraintViolationListInterface $violations): string
    {
        $errors = [];
        /** @var ConstraintViolation $violation */
        foreach ($violations as $violation) {
            $errors[Inflector::tableize($violation->getPropertyPath())] = $violation->getMessage();
        }

        return json_encode(['errors' => $errors]);
    }
}
