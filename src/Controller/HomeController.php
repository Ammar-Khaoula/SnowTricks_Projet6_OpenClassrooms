<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\TricksRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(TricksRepository $repoTrick): Response
    {
        $tricks = $repoTrick->findAll();
        //dd($tricks);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'tricks' => $tricks,
        ]);
    }
    #[Route('/trick/{slug}', name: 'app_single_trick')]
    public function single(TricksRepository $repoTrick, string $slug): Response
    {
        $trick = $repoTrick->findOneBySlug($slug);
        

        return $this->render('home/single.html.twig', [
            'controller_name' => 'HomeController',
            'trick' => $trick,

        ]);
    }
}
