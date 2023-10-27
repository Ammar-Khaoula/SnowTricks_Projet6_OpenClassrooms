<?php

namespace App\Controller;

use App\Entity\Tricks;
use App\Form\TricksType;
use App\Repository\TricksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class TricksController extends AbstractController
{

    #[Route('/ajoutTricks', name: 'app_ajout_Trick')]
    public function add(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $trick = new Tricks();
        $trickform = $this->createForm(TricksType::class, $trick);
        $trickform->handleRequest($request);
        
        if($trickform->isSubmitted() && $trickform->isValid()){

            //add imageUrl
            /*$images = $trickform->get('imageUrls')->getData();            
            foreach($images as $image){
    
            }*/
            
             //add image
             $picture = $trickform->get('image')->getData();
             if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$picture->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $picture->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $trick->setImage($newFilename);
            }

             

            //add slug
            $slug = $slugger->slug($trick->getName());
            $trick->setSlug($slug);

            $em->persist($trick);
            $em->flush();

            $this->addFlash('success', 'figure ajouté avec succés');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('tricks/ajout.html.twig', [
            'trickform' => $trickform->createView()
        ]);
    }


    #[Route('/editTricks/{id}', name: 'app_edit_Trick')]
    public function edit(TricksRepository $trick, $id): Response
    {
        return $this->render('tricks/edit.html.twig', [
            'controller_name' => 'Figures',
        ]);
    }
    #[Route('/deleteTricks/{id}', name: 'app_delete_Trick')]
    public function delete(TricksRepository $trick, $id): Response
    {
        return $this->render('tricks/ajout.html.twig', [
            'controller_name' => 'Figures',
        ]);
    }

}
