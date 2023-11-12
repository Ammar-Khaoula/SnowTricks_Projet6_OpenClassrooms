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
    #[Route('/', name: 'app_home')]
    public function index(TricksRepository $repoTrick, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $tricks = $repoTrick->findTricksPaginated($page, 10);

        return $this->render('home/index.html.twig', [
            'tricks' => $tricks,
            
        ]);
    }
  
    #[Route('/trick/{slug}', name: 'app_single_trick')]
    public function single(TricksRepository $repoTrick, Request $request, EntityManagerInterface $em, CommentsRepository $commentRepo, string $slug): Response
    {
        $trick = $repoTrick->findOneBySlug($slug);

        $comment = new Comments;
        $comment->setTrick($trick);
        $comment->setAuthor($this->getUser());
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);
        if($commentForm->isSubmitted() && $commentForm->isValid()){
            $em->persist($comment);          
            $em->flush();

            $this->addFlash('success', 'commentaire ajouté avec succés');
            return $this->redirectToRoute('app_single_trick', ['slug' =>$trick->getSlug()]);
        }
        $page = $request->query->getInt('page', 1);
        $paginatedComment = $commentRepo->findCommentPaginated($page, $trick->getSlug(), 10);
        //dd($paginatedComment);

        return $this->render('home/single.html.twig', [
            'commentForm' => $commentForm->createView(),
            'trick' => $trick,
            'paginatedComment' => $paginatedComment
        ]);
    }
}
