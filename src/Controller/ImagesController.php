<?php

namespace App\Controller;

use App\Entity\ImageUrls;
use App\Entity\Tricks;
use App\Form\PictureType;
use App\Repository\ImageUrlsRepository;
use App\Repository\TricksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImagesController extends AbstractController
{


    #[Route('/trick/{slug}/editImage/{id}', name: 'app_edit_image')]
    public function editImage(Request $request, EntityManagerInterface $em, SluggerInterface $slugger,ImageUrlsRepository $imageRepo, TricksRepository $trickRepo, $id, $slug): Response
    {
        $trick = $trickRepo->findOneBySlug($slug);
        $images = $imageRepo->findOneById($id);
        $imgform = $this->createForm(PictureType::class, $images);
        $imgform->handleRequest($request);
        $picture = $imgform->get('name')->getData();
        if($imgform->isSubmitted() ){
            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$picture->guessExtension();
                    $picture->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );

                $images->setName($newFilename);
            }     
                $em->persist($images);              
                $em->flush();

            $this->addFlash('success', 'image modifier avec succés');
            return $this->redirectToRoute('app_single_trick', ['slug' => $slug]);
        }

        return $this->render('images/editImage.html.twig', [
            'imgform' => $imgform->createView(),
            'images' => $images
        ]);
    }

    #[Route('/trick/{slug}/deletImage/{id}', name: 'app_delete_image')]
    public function delete(EntityManagerInterface $em, ImageUrlsRepository $imgRepo, Request $request, $id, $slug): Response
    {
        $image = $imgRepo->findOneBy(["id" => $id]);
        $nom = $image->getName(); 
        unlink($this->getParameter('images_directory'). '/'.$nom);

        $em->remove($image);
        $em->flush();

        $this->addFlash('success', 'image supprimer avec succés');
        return $this->redirectToRoute('app_single_trick', ['slug' => $slug]);

        return $this->render('tricks/ajout.html.twig', [
            'controller_name' => 'Figures',
        ]);
    }
}
