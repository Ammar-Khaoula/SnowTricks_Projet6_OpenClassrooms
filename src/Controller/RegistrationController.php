<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use App\Repository\UsersRepository;
use App\Security\UsersAuthenticator;
use App\Service\JWTService;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    /**
     * register
     * 
     * @return Response
     */
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UsersAuthenticator $authenticator, 
    EntityManagerInterface $entityManager, SendMailService $mail, JWTService $jwt): Response
    {
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            //generate JWT
            $header = [
                'typ' => 'JWT',
                'alg' => 'HS256'
            ];

            $payload = [
                'user_id' => $user->getId()
            ];

            $token = $jwt->generate($header, $payload,
            $this->getParameter('app.jwtsecret'));

            //send mail
            $mail->send(
                'khaoula.doss@gmail.com',
                $user->getEmail(),
                'Activation de votre compte sur le site SnowTricks',
                'register',
                compact('user', 'token')
            );
            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verif/{token}', name: 'verify_user')]
    public function verifyUser($token, JWTService $jwt, 
    UsersRepository $usersRepository, EntityManagerInterface $entityManager): Response
    {
        //verified if token is valid and is not expir and is not edit
        if($jwt->isValid($token) && !$jwt->isExpired($token) && 
        $jwt->check($token, $this->getParameter('app.jwtsecret'))){
            //requipered payload
            $payload = $jwt->getPayload($token);
            //requipered userToken
            $user = $usersRepository->find($payload['user_id']);
            //user exists but not yet validate his account
            if($user && !$user->getIsVerified()){
                $user->setIsVerified(true);
                $entityManager->flush($user);
                $this->addFlash('success', 'utilisateur activé');
                return $this->redirectToRoute('app_home');
            }
        }
        $this->addFlash('danger', 'le token est invalide ou a expiré');
            return $this->redirectToRoute('app_login');
    }
/**
     * mail verified
     * 
     * @return Response
     */
    #[Route('/renoiverif', name: 'resend_verif')]
    public function resendVerif(JWTService $jwt, SendMailService $mail,
    UsersRepository $usersRepository): Response
    {
        $user = $this->getUser();
        if(!$user){
            $this->addFlash('danger', 'Vous devez être connecté pour accéder à cette page');
            return $this->redirectToRoute('app_login');
        }

        if($user->getIsVerified()){
            $this->addFlash('warning', 'cet utilisateur est déjà activé');
            return $this->redirectToRoute('app_home');
        }
        //generate JWT
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];

        $payload = [
            'user_id' => $user->getId()
        ];

        $token = $jwt->generate($header, $payload,
        $this->getParameter('app.jwtsecret'));

        //send mail
        $mail->send(
            'khaoula.doss@gmail.com',
            $user->getEmail(),
            'Activation de votre compte sur le site SnowTricks',
            'register',
            compact('user', 'token')
        );
        $this->addFlash('success', 'Email de vérification envoyé');
            return $this->redirectToRoute('app_login');
    }
}
