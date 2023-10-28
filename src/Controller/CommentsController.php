<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentsController extends AbstractController
{
    #[Route('/comments', name: 'app_comments')]
    public function index(): Response
    {
        $comment  = new Comments;
        $commetForm = $this->createForm(CommentType::class, $comment);

        return $this->render('comments/index.html.twig', [
            'commetForm' => $commetForm->createView()
        ]);
    }
}
