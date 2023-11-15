<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UserType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfileController extends AbstractController
{
      /**
         * Profil User
         *
         * @param integer $id
         * @param UsersRepository $userRepo
         * 
         * @return Response
         *
    */
    #[Route('/profil/{id}', name: 'app_profile', methods: ['GET'])]
    public function index(UsersRepository $userRepo, $id): Response
    {
        $user = $userRepo->findOneById($id);
        return $this->render('profile/index.html.twig', [
            'user' => $user,
        ]);
    }
  /**
         * modifier profil
         *
         * @param integer $id
         * @param Request $request
         * @param EntityManagerInterface $em
         * @param UsersRepository $userRepo
         * @param SluggerInterface $slugger
         * @param UserPasswordHasherInterface $userPasswordHasher

         * @return Response
         *
    */
        #[Route('/profil/{id}/edit', name: 'app_editProfile', methods: ['GET','POST'])]
        public function edit(Request $request, EntityManagerInterface $em, SluggerInterface $slugger, UserPasswordHasherInterface $userPasswordHasher, UsersRepository $userRepo, $id): Response
        {
            $user = $userRepo->findOneById($id);
            
            if(!$this->getUser()){
                return $this->redirectToRoute('app_login');
            }
            
            $userform = $this->createForm(UserType::class, $user);
            $userform->handleRequest($request);
            $picture = $userform->get('avatar')->getData();
            
            if($userform->isSubmitted() && $userform->isValid()){
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $userform->get('plainPassword')->getData()
                    ));
                if ($picture) {
                    $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$picture->guessExtension();
    
                    // Move the file to the directory where brochures are stored
                    try {
                        $picture->move(
                            $this->getParameter('avatar_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }
    
                    // updates the 'brochureFilename' property to store the PDF file name
                    // instead of its contents
                    $user->setAvatar($newFilename);
                }
    
                $em->persist($user);
                $em->flush();
    
                $this->addFlash('success', 'figure ajouté avec succés');
                return $this->redirectToRoute('app_profile', ['id'=>$id]);
            }

        return $this->render('profile/editProfil.html.twig', [
            'userform' => $userform->createView(),
            'user' => $user,
        ]);
    }
}
