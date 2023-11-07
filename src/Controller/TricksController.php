<?php

namespace App\Controller;

use App\Entity\Tricks;
use App\Form\TricksType;
use App\Entity\ImageUrls;
use App\Entity\VideoUrls;
use App\Form\PictureType;
use App\Repository\TricksRepository;
use App\Repository\ImageUrlsRepository;
use App\Repository\VideoUrlsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class TricksController extends AbstractController
{

    #[Route('/addTricks', name: 'app_ajout_Trick')]
    public function add(Request $request, EntityManagerInterface $em, SluggerInterface $slugger, VideoUrlsRepository $videoRepo): Response
    {
        $trick = new Tricks();
        $trickform = $this->createForm(TricksType::class, $trick);
        $trickform->handleRequest($request);
        
        if($trickform->isSubmitted() && $trickform->isValid()){

            //add imageUrl
            $images = $trickform->get('imageUrls')->getData();            
            foreach($images as $image){
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $fichier = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $img = new ImageUrls();
                $img->setName($fichier);
                $trick->addImageUrl($img);
            }
            //add video  
            $videos = $trickform->get('videoUrls')->getData();
            if($videos){
                foreach($videos as $video){
                    if ($video->getName() !== null){
                        $trickVideo = new VideoUrls();
                        $trickVideo->setName($video->getName());
                        $trickVideo->setTricks($trick);

                        $em->persist($trickVideo);
                    }
                }
            }
                /*$videos = [$trickform->get('videoUrls')->getData()]; 
                dump($videos);
                foreach($videos as $vedio){
                    $videoUrl = new VideoUrls($vedio);                   
                    $trick->addVideoUrl($videoUrl);
                    $videoUrl->setName($vedio);
                    dump($videoUrl);
                }*/
                //dd($trick);

             //add piture
            $picture = $trickform->get('image')->getData();
            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$picture->guessExtension();
                try {
                    $picture->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $trick->setImage($newFilename);
            }
            //add slug
            $slug = $slugger->slug($trick->getName());
            $trick->setSlug($slug);

            $em->persist($trick);
            //dd($trick); 
            $em->flush();

            $this->addFlash('success', 'figure ajouté avec succés');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('tricks/addTrick.html.twig', [
            'trickform' => $trickform->createView()
        ]);
    }


    #[Route('/editTricks/{id}', name: 'app_edit_Trick')]
    public function edit(Request $request, EntityManagerInterface $em, SluggerInterface $slugger, TricksRepository $trickRepo, $id): Response
    {
        $trick = $trickRepo->findOneBy(["id" => $id]);
        $trickform = $this->createForm(TricksType::class, $trick);
        $trickform->handleRequest($request);
        
        if($trickform->isSubmitted() && $trickform->isValid()){
             //add slug
            $slug = $slugger->slug($trick->getName());
            $trick->setSlug($slug);

                //add imageUrl
                $images = $trickform->get('imageUrls')->getData();            
                foreach($images as $image){
                    $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    $safeFilename = $slugger->slug($originalFilename);
                    $fichier = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

                    $image->move(
                        $this->getParameter('images_directory'),
                        $fichier
                    );
                    $img = new ImageUrls();
                    $img->setName($fichier);
                    $trick->addImageUrl($img);
                }
        
             //add image
            $picture = $trickform->get('image')->getData();
            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$picture->guessExtension();

                try {
                    $picture->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $trick->setImage($newFilename);
            }

            $em->persist($trick);
            $em->flush();

            $this->addFlash('success', 'figure modifier avec succés');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('tricks/edit.html.twig', [
            'trickform' => $trickform->createView(),
            'trick' => $trick
        ]);
    }

    #[Route('/deleteTricks/{id}', name: 'app_delete_Trick')]
    public function delete(EntityManagerInterface $em, TricksRepository $trickRepo, $id): Response
    {
        $trick = $trickRepo->findOneBy(["id" => $id]);
        $em->remove($trick);
        $em->flush();

        $this->addFlash('success', 'figure supprimer avec succés');
        return $this->redirectToRoute('app_home');

        return $this->render('tricks/ajout.html.twig', [
            'controller_name' => 'Figures',
        ]);
    }


}
