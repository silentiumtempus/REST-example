<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\LeagueEntity;
use App\Service\LeagueService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class LeagueController
 * @package App\Controller
 * @Route("/leagues")
 */
class LeagueController extends AbstractController
{
    /**
     * @param Request $request
     * @param $leagueService $leagueService
     * @param LeagueEntity $league
     * @return JsonResponse
     * @Route("/{leagueId}",
     *     name="league-delete",
     *     requirements = {
     *          "leagueId" = "\d+",
     *     },
     *     defaults = {
     *          "leagueId" = 16,
     *     },
     *     methods = {"DELETE"})
     * @ParamConverter(
     *     "league",
     *      class="App\Entity\LeagueEntity",
     *      options = {"id" = "leagueId"},
     *      isOptional = "false"
     * )
     */
    public function deleteLeague(
        Request $request,
        LeagueService $leagueService,
        LeagueEntity $league = null
    ): JsonResponse
    {
        $this->responseTransformer->validateContentType($request->headers->get('content_type'));
        $leagueService->deleteLeague($league);

        return new JsonResponse($this->responseTransformer->createResponse(null, Response::HTTP_CREATED));
    }
}