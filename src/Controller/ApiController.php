<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;

/**
 * @Route("/api", name="api.")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/movies", name="getAll",methods={"GET"})
     * @param MovieRepository $movieRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function getMovies(MovieRepository $movieRepository, Request $request)
    {
        $movies = $movieRepository->transformAll();
        return new JsonResponse($movies,200);
    }

    /**
     * @Route("/movies/{id}", name="get",methods={"GET"})
     * @param MovieRepository $movieRepository
     * @param int $id
     * @return JsonResponse
     */
    public function getMovie(MovieRepository $movieRepository, int $id)
    {
        $movie = $movieRepository->find($id);
        if($movie == null){
            return new JsonResponse([
                'errors' => "Not found",
            ], 403);
        }
        $movie_json = $movieRepository->transform($movie);
        return new JsonResponse($movie_json,200);
    }

    /**
     * @Route("/movies/", name="post", methods={"POST"})
     * @param MovieRepository $movieRepository
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     * @IsGranted("ROLE_ADMIN")
     */
    public function postMovie(MovieRepository $movieRepository, int $id,Request $request)
    {
        $data = json_decode(
            $request->getContent(),
            true
        );
        $movie = $movieRepository->find($id);
        if($movie == null){
            return new JsonResponse([
                'errors' => "Not found",
            ], 403);
        }
        $movie_json = $movieRepository->transform($movie);
        return new JsonResponse($movie_json,200);
    }
}
