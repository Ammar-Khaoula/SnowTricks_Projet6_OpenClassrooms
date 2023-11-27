<?php

namespace App\Controller;

use App\Entity\Tricks;
use App\Entity\Comments;
use App\Service\Pagination;
use App\Form\CommentType;
use App\Repository\TricksRepository;
use App\Repository\CategoryRepository;
use App\Repository\CommentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
      /**
         * get tricks
         *
         * @param Request $request
         * @param TricksRepository $repoTrick
         *
         * @return Response
    */
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(TricksRepository $repoTrick, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $tricks = $repoTrick->findTricksPaginated($page, 9);

        return $this->render('home/index.html.twig', [
            'tricks' => $tricks,
            
        ]);
    }
 
}
