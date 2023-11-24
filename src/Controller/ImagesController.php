<?php

namespace App\Controller;

use App\Entity\Tricks;
use App\Entity\ImageUrls;
use App\Entity\PictureTrick;
use App\Form\PictureType;
use App\Form\PictureTricksType;
use App\Repository\TricksRepository;
use App\Repository\ImageUrlsRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PictureTrickRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ImagesController extends AbstractController
{
  /**
         * modifier images
         *
         * @param integer $id
         * @param string $slug
         * @param Request $request
         * @param EntityManagerInterface $em
         * @param TricksRepository $trickRepo
         * @param ImageUrlsRepository $imageRepo
         * @param SluggerInterface $slugger
         * 
         * @return Response
         *
    */
    #[Route('/trick/{slug}/editImage/{id}', name: 'app_edit_image', methods: ['GET','POST'])]
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
            return $this->redirectToRoute('app_edit_Trick', ['slug' => $slug]);
        }

        return $this->render('images/editImage.html.twig', [
            'imgform' => $imgform->createView(),
            'images' => $images
        ]);
    }
   /**
         * Delete images
         *
         * @param EntityManagerInterface $em
         * @param ImageUrlsRepository $imgRepo
         * @param string $slug
         * @param integer $id
         *
         * @return Response
    */
    #[Route('/trick/{slug}/deletImage/{id}', name: 'app_delete_image', methods: ['GET'])]
    public function delete(EntityManagerInterface $em, ImageUrlsRepository $imgRepo, Request $request, $id, $slug): Response
    {
        $image = $imgRepo->findOneBy(["id" => $id]);
        $nom = $image->getName(); 
        unlink($this->getParameter('images_directory'). '/'.$nom);

        $em->remove($image);
        $em->flush();

        $this->addFlash('success', 'image supprimer avec succés');
        return $this->redirectToRoute('app_edit_Trick', ['slug' => $slug]);

        return $this->render('tricks/ajout.html.twig', [
            'controller_name' => 'Figures',
        ]);
    }
  /**
         * modifier un image
         *
         * @param integer $id
         * @param Request $request
         * @param EntityManagerInterface $em
         * @param TricksRepository $trickRepo
         * @param PictureTrickRepository $pictureTrick
         * @param SluggerInterface $slugger
         * @param string $slug
         * 
         * @return Response
         *
    */
    #[Route('/trick/{slug}/editpictureTrick/{id}', name: 'app_edit_pictureTrick', methods: ['GET', 'POST'])]
    public function editPictureTrick(Request $request, EntityManagerInterface $em, SluggerInterface $slugger, PictureTrickRepository $pictureTrick, TricksRepository $trickRepo, $slug, $id): Response
    {
        $trick = $trickRepo->findOneBySlug($slug);

        $images = $pictureTrick->findOneById($id);
        $form = $this->createForm(PictureTricksType::class, $images);
        $form->handleRequest($request);
        $picture = $form->get('name')->getData();
        if($form->isSubmitted() ){
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

        return $this->render('images/editPictureTrick.html.twig', [
            'form' => $form->createView(),
            'images' => $images
        ]);
    }
   /**
         * Delete image
         *
         * @param EntityManagerInterface $em
         * @param  PictureTrickRepository $imgRepo
         * @param string $slug
         * @param integer $id
         *
         * @return Response
    */
    #[Route('/trick/{slug}/deletPictureTrick/{id}', name: 'app_delete_pictureTrick', methods: ['GET'])]
    public function deletePictureTrick(EntityManagerInterface $em, PictureTrickRepository $imgRepo, Request $request, $id, $slug): Response
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
