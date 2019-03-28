<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\TeamEntity;
use App\Entity\LeagueEntity;
use App\Service\TeamService;
use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class TeamController
 * @package App\Controller
 * @Route("leagues")
 */
class TeamController extends AbstractController
{
    /**
     * @param Request $request
     * @param TeamService $teamService
     * @param LeagueEntity $league
     * @return JsonResponse
     * @Route("{leagueId}/teams",
     *     name="team-list",
     *     requirements = {
     *          "leagueId" = "\d+",
     *     },
     *     defaults = {
     *          "leagueId" = 16,
     *     },
     *     methods = {"GET","HEAD"})
     * @ParamConverter(
     *     "league",
     *      class="App\Entity\LeagueEntity",
     *      options = {"id" = "leagueId"},
     *      isOptional = "false"
     * )
     * @throws ExceptionInterface
     */
    public function listTeams(
        Request $request,
        TeamService $teamService,
        LeagueEntity $league = null
    ): JsonResponse
    {
        $this->responseTransformer->validateContentType($request->headers->get('content_type'));

        return new JsonResponse(
            $teamService->listTeamsByLeague($league,
                $request->request->get('page', 0))
        );
    }

    /**
     * @param Request $request
     * @param TeamService $teamService
     * @param LeagueEntity $league
     * @return JsonResponse
     * @Route("/{leagueId}/teams",
     *     name = "team-create",
     *     requirements = {
     *          "leagueId" = "\d+",
     *     },
     *     defaults = {
     *          "leagueId" = 1,
     *     },
     *      methods = {"PUT"})
     * @ParamConverter("league",
     *     class = "App\Entity\LeagueEntity",
     *     options = {"id" = "leagueId"},
     *     isOptional = "false"
     * )
     */
    public function createTeam(
        Request $request,
        TeamService $teamService,
        LeagueEntity $league = null
    ): JsonResponse
    {
        $this->responseTransformer->validateContentType($request->headers->get('content_type'));
        $newTeam = $teamService->createOneTeam($request->request, $league);
        $errors = $this->validator->validate($newTeam);
        if (count($errors) > 0) {
            throw new ValidationException(
                $this->responseTransformer->createErrorMessage($errors),
                Response::HTTP_BAD_REQUEST
            );
        } else {
            $this->commonEntityService->persistSingleEntity($newTeam);
        }

        return $this->responseTransformer->createResponse($newTeam, Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @param TeamService $teamService
     * @param TeamEntity $team
     * @return JsonResponse
     * @Route("/{leagueId}/teams/{teamId}",
     *     name = "team-update",
     *     requirements = {
     *          "leagueId" = "\d+",
     *          "teamId" = "\d+"
     *     },
     *     defaults = {
     *          "leagueId" = "",
     *          "teamId" = ""
     *     },
     *      methods = {"PATCH"}
     * )
     * @ParamConverter(
     *     "team",
     *      class="App\Entity\TeamEntity",
     *      options = { "mapping" : {"leagueId" : "league", "teamId" : "id"}},
     *      isOptional = "false"
     * )
     */
    public function updateTeam(
        Request $request,
        TeamService $teamService,
        TeamEntity $team = null
    ): JsonResponse
    {
        $this->responseTransformer->validateContentType($request->headers->get('content_type'));
        $updatedTeam = $teamService->updateOneTeam($request, $team);
        $errors = $this->validator->validate($updatedTeam);
        if (count($errors) > 0) {
            throw new ValidationException(
                $this->responseTransformer->createErrorMessage($errors),
                Response::HTTP_BAD_REQUEST
            );
        } else {
            $this->commonEntityService->mergeSingleEntity();
        }

        return $this->responseTransformer->createResponse($updatedTeam, Response::HTTP_CREATED);
    }
}
