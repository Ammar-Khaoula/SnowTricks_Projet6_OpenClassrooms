<?php

namespace App\Controller;

use App\Form\ResetPasswordFormType;
use App\Form\ResetPasswordRequestType;
use App\Repository\UsersRepository;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/connexion', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername, 
            'error' => $error]);
    }

    #[Route(path: '/deconnexion', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    #[Route(path: '/oubli-pass', name: 'forgotten_password')]
    public function forgottenPassword(
        Request $request,
        UsersRepository $usersRepository,
        TokenGeneratorInterface $tokenGenerator,
        EntityManagerInterface $entityManager,
        SendMailService $mail
        ): Response
    {
        $form = $this->createForm(ResetPasswordRequestType::class);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $user = $usersRepository->findOneByName($form->get('name')->getData());
            
            //if user exist
            if($user){
                //generate token
                $token = $tokenGenerator->generateToken();
                $user->setResetToken($token);
                $entityManager->persist($user);
                $entityManager->flush();

                //generate password reset link
                $url = $this->generateUrl('reset_pass', ['token' => $token],
                UrlGeneratorInterface::ABSOLUTE_URL);
                
                //create data mail
                $context = compact('url', 'user');

                //sendMail
                $mail->send(
                    'khaoula.doss@gmail.com',
                    $user->getEmail(),
                    'réinitialisation de mot de passe',
                    'password_reset',
                    $context
                );
                $this->addFlash('success', 'Email envoyer avec succes');
                return $this->redirectToRoute('app_login');
            }
            $this->addFlash('danger', 'un probléme est servenu');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reset_password_request.html.twig', [
            'requestPassForm' => $form->createView()
        ]);
    }
    #[Route(path: '/oubli-pass/{token}', name: 'reset_pass')]
        public function resetPass(
            string $token,
            Request $request,
            UsersRepository $usersRepository,
            EntityManagerInterface $entityManager,
            UserPasswordHasherInterface $passwordHasher
        ):Response
        {
            $user = $usersRepository->findOneByResetToken($token);

                if($user){
                    $form = $this->createForm(ResetPasswordFormType::class);

                    $form->handleRequest($request);

                    if($form->isSubmitted() && $form->isValid()){
                        $user->setResetToken('');
                        $user->setPassword(
                            $passwordHasher->hashPassword(
                                $user,
                                $form->get('password')->getData()
                            )
                        );
                        $entityManager->persist($user);
                        $entityManager->flush();
                            $this->addFlash('success', 'mot de passe changé avec succés');
                            return $this->redirectToRoute('app_login');
                    }

                    return $this->render('security/reset_password.html.twig', [
                        'passForm' => $form->createView()
                    ]);
                }
            $this->addFlash('danger', 'jeton invalide');
            return $this->redirectToRoute('app_login');
        }
}
