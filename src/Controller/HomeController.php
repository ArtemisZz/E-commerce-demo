<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/home", name="home.")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param MovieRepository $movieRepository
     * @return Response
     */
    public function index(MovieRepository $movieRepository)
    {
        $movies = $movieRepository->findAll();
        return $this->render('home/home.html.twig',[
            'movies' => $movies
        ]);
    }

    /**
     * @Route("/movie/{id}", name="movie")
     * @param Movie $movie
     * @return Response
     */
    public function movie(Movie $movie)
    {
        return $this->render('home/movie.html.twig',[
            'movie' => $movie
        ]);
    }


}
