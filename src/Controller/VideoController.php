<?php

namespace App\Controller;

use App\Entity\Tricks;
use App\Form\VideoType;
use App\Entity\VideoUrls;
use App\Repository\TricksRepository;
use App\Repository\VideoUrlsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VideoController extends AbstractController
{
    /**
         * add videos
         *
         * @param string $slug
         * @param Request $request
         * @param EntityManagerInterface $em
         * @param TricksRepository $repoTrick
         * 
         * @return Response
         *
    */
    #[Route('/trick/{slug}/addVideo', name: 'app_video', methods: ['GET','POST'])]
    public function index(Request $request, EntityManagerInterface $em, TricksRepository $repoTrick, $slug): Response
    {
        $trick = $repoTrick->findOneBySlug($slug);

        $video = new VideoUrls();
        $trickform = $this->createForm(VideoType::class, $video);
        $trickform->handleRequest($request);
        $name = $trickform->get('name')->getData();
        
        if ($trickform->isSubmitted() && $trickform->isValid()) {
            $video->setName($name);
            $video->setTricks($trick);

            $em->persist($video);
            $em->flush();
            
            $this->addFlash('success', 'La vidéo a bien été ajoutée');

            return $this->redirectToRoute('app_single_trick', ['slug' => $slug]);
        }

        return $this->render('video/index.html.twig', [
            'trickform' => $trickform->createView(),
        ]);
    }

    #[Route('/trick/{slug}/editVideo/{id}', name: 'app_editVideo', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $em, TricksRepository $repoTrick, VideoUrlsRepository $videoRepo, string $slug, int $id): Response
    {
        $trick = $repoTrick->findOneBySlug($slug);

        $video = $videoRepo->findOneById($id);
        $trickform = $this->createForm(VideoType::class, $video);
        $trickform->handleRequest($request);
        $name = $trickform->get('name')->getData();
        
        if ($trickform->isSubmitted() && $trickform->isValid()) {
            $video->setName($name);
            $video->setTricks($trick);

            $em->persist($video);
            $em->flush();
            
            $this->addFlash('success', 'La vidéo a bien été modifier');

            return $this->redirectToRoute('app_single_trick', ['slug' => $slug]);
        }

        return $this->render('video/editVideo.html.twig', [
            'trickform' => $trickform->createView(),
            'video' => $video
        ]);
    }
/**
         * delete videos
         *
         * @param integer $id
         * @param string $slug
         * @param EntityManagerInterface $em
         * @param VideoUrlsRepository $videoRepo
         *
         * @return Response
    */
    #[Route('/trick/{slug}/deletVideo/{id}', name: 'app_delete_video', methods: ['GET'])]
    public function delete(EntityManagerInterface $em, VideoUrlsRepository $videoRepo, Request $request, $id, $slug): Response
    {
        $video = $videoRepo->findOneBy(["id" => $id]);

        $em->remove($video);
        $em->flush();

        $this->addFlash('success', 'video supprimer avec succés');
        return $this->redirectToRoute('app_single_trick', ['slug' => $slug]);

        return $this->render('video/index.html.twig', [
            'controller_name' => 'Figures',
        ]);
    }
}
