<?php

namespace App\Controller;

use App\Entity\Tricks;
use App\Entity\Comments;
use App\Form\CommentType;
use App\Service\Pagination;
use App\Repository\TricksRepository;
use App\Repository\CommentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentsController extends AbstractController
{
   /**
     * Paginated : Display paginated comments
     */
    #[Route('/trick/{slug}/comments/page/{page}', name: 'comments_paginated')]
    public function paginated(int $page = 1): Response
    {
        return $this->render('comment/index.html.twig', [
            
           
        ]);
    }

}
