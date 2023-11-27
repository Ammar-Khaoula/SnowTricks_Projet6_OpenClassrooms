<?php

namespace App\Controller;

use App\Entity\Tricks;
use App\Entity\Comments;
use App\Form\TricksType;
use App\Entity\ImageUrls;
use App\Entity\VideoUrls;
use App\Form\CommentType;
use App\Form\PictureType;
use App\Entity\PictureTrick;
use App\Repository\TricksRepository;
use App\Repository\CommentsRepository;
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

    /**
     * get trick by slug
     *
     * @param Request $request
     * @param TricksRepository $repoTrick
     *  @param CommentsRepository $commentRepo
     * @param  EntityManagerInterface $em
     * @param integer $slug
     *
     * @return Response
     */
    #[Route('/trick/{slug}', name: 'app_single_trick', methods: ['GET', 'POST'])]
    public function single(TricksRepository $repoTrick, Request $request, EntityManagerInterface $em, CommentsRepository $commentRepo, string $slug): Response
    {
        $trick = $repoTrick->findOneBySlug($slug);

        $comment = new Comments;
        $comment->setTrick($trick);
        $comment->setAuthor($this->getUser());
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $em->persist($comment);
            $em->flush();

            $this->addFlash('success', 'commentaire ajouté avec succés');
            return $this->redirectToRoute('app_single_trick', ['slug' => $trick->getSlug()]);
        }
        $page = $request->query->getInt('page', 1);
        $paginatedComment = $commentRepo->findCommentPaginated($page, $trick->getSlug(), 10);

        return $this->render('home/single.html.twig', [
            'commentForm' => $commentForm->createView(),
            'trick' => $trick,
            'paginatedComment' => $paginatedComment
        ]);
    }
    /**
     * add trick
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param SluggerInterface $slugger
     * 
     * @return Response
     * 
     */

    #[Route('/addTricks', name: 'app_ajout_Trick', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $trick = new Tricks();
        $trickform = $this->createForm(TricksType::class, $trick);
        $trickform->handleRequest($request);

        if ($trickform->isSubmitted() && $trickform->isValid()) {

            //add imageUrl
            $images = $trickform->get('imageUrls')->getData();
            foreach ($images as $image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $fichier = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();

                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $img = new ImageUrls();
                $img->setName($fichier);
                $trick->addImageUrl($img);
            }
            //add piture
            $picture = $trickform->get('pictureTrick')->getData();
            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $picture->guessExtension();
                try {
                    $picture->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $image = new PictureTrick();
                $image->setName($newFilename);
                $trick->setPictureTrick($image);
            }
            //add slug
            $slug = $slugger->slug($trick->getName());
            $trick->setSlug($slug);

            $em->persist($trick);
            $em->flush();

            $this->addFlash('success', 'figure ajouté avec succés');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('tricks/addTrick.html.twig', [
            'trickform' => $trickform->createView()
        ]);
    }

    /**
     * modifier trick
     *
     * @param string $slug
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param TricksRepository $trickRepo
     * @param SluggerInterface $slugger
     * 
     * @return Response
     *
     */
    #[Route('/editTricks/{slug}', name: 'app_edit_Trick', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $em, SluggerInterface $slugger, TricksRepository $trickRepo, $slug): Response
    {
        $trick = $trickRepo->findOneBy(["slug" => $slug]);
        $trickform = $this->createForm(TricksType::class, $trick);
        $trickform->handleRequest($request);

        if ($trickform->isSubmitted() && $trickform->isValid()) {
            //add slug
            $slug = $slugger->slug($trick->getName());
            $trick->setSlug($slug);

            //add imageUrl
            $images = $trickform->get('imageUrls')->getData();
            foreach ($images as $image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $fichier = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();

                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $img = new ImageUrls();
                $img->setName($fichier);
                $trick->addImageUrl($img);
            }

            //add image
            $picture = $trickform->get('pictureTrick')->getData();
            if ($picture) {
                $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $picture->guessExtension();

                try {
                    $picture->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $image = new PictureTrick();
                $image->setName($newFilename);
                $trick->setPictureTrick($image);
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
    /**
     * Delete trick
     *
     * @param EntityManagerInterface $em
     * @param TricksRepository $trickRepo
     * @param integer $id
     *
     * @return Response
     */
    #[Route('/deleteTricks/{id}', name: 'app_delete_Trick', methods: ['GET'])]
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
