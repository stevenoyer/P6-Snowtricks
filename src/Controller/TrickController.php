<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\CommentFormType;
use App\Form\TrickFormType;
use App\Media\ImageManagement;
use App\Media\VideoManagement;
use App\Repository\TrickRepository;
use App\Service\PictureUploader;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;

class TrickController extends AbstractController
{

    protected $pictureUploader;
    protected $em;
    protected $slugger;
    protected $trickRepository;

    public function __construct(PictureUploader $pictureUploader, EntityManagerInterface $em, SluggerInterface $slugger, TrickRepository $trickRepository)
    {
        $this->pictureUploader = $pictureUploader;
        $this->em = $em;
        $this->slugger = $slugger;
        $this->trickRepository = $trickRepository;
    }

    /**
     * Load more tricks
     */
    #[Route('/tricks/load/{start}', name: 'tricks_load', requirements: ["start" => "\d+"], methods: ['GET'])]
    public function load($start = 9)
    {
        $items = $this->trickRepository->findBy([], ['createdAt' => 'DESC'], 9, $start);

        return $this->render('trick/load.html.twig', [
            'items' => $items
        ]);
    }

    /**
     * Create trick
     */
    #[Route('/tricks/create', name: 'trick_create', methods: ['GET', 'POST'])]
    public function create(Request $request, ImageManagement $imageManagement, VideoManagement $videoManagement): Response
    {
        $trick = new Trick;
        $form = $this->createForm(TrickFormType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setSlug(strtolower($this->slugger->slug($trick->getTitle())));
            $trick->setCreatedAt(new DateTimeImmutable('now'));
            $trick->setUpdateAt(new DateTimeImmutable('now'));

            // Main image processing via a service
            $mainPicture = $form->get('mainPicture')->getData();
            if (!empty($mainPicture)) {
                $trick->setMainPicture($this->pictureUploader->upload($mainPicture));
            }

            /* If there is no main picture, set the default main picture */
            if (empty($mainPicture)) {
                $trick->setMainPicture('snowtricks_header.jpeg');
            }

            /** @var \App\Entity\User */
            $user = $this->getUser();
            $trick->setAuthor($user);

            // Processing images via a service
            $images = $form->getExtraData()['images'];
            if (!empty($images)) {
                $imageManagement->process($images, $trick);
            }

            // Processing videos via a service
            $videos = $form->getExtraData()['videos'];
            if (!empty($videos)) {
                $videoManagement->process($videos, $trick);
            }

            $this->addFlash('success', 'The trick has been successfully created.');
            $this->em->persist($trick);
            $this->em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('trick/create.html.twig', [
            'formView' => $form->createView()
        ]);
    }

    /**
     * Show a trick
     */
    #[Route('/tricks/details/{slug}', name: 'trick_show', methods: ['GET'])]
    public function show(Trick $trick): Response
    {
        $commentForm = $this->createForm(CommentFormType::class, null, ['action' => $this->generateUrl('add_comment', ['slug' => $trick->getSlug()])]);

        return $this->render('trick/show.html.twig', [
            'item' => $trick,
            'commentForm' => $commentForm->createView()
        ]);
    }

    /**
     * Edit a trick
     */
    #[Route('/tricks/edit/{slug}', name: 'trick_edit', methods: ['GET', 'POST'])]
    public function edit(Trick $trick, Request $request, ImageManagement $imageManagement, VideoManagement $videoManagement): Response
    {
        $form = $this->createForm(TrickFormType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setSlug(strtolower($this->slugger->slug($trick->getTitle())));
            $trick->setUpdateAt(new DateTimeImmutable('now'));

            // Main image processing via a service
            $mainPicture = $form->get('mainPicture')->getData();
            if (!empty($mainPicture)) {
                $trick->setMainPicture($this->pictureUploader->upload($mainPicture));
            }

            // Processing images via a service
            $images = $form->getExtraData()['images'];
            if (!empty($images)) {
                $imageManagement->process($images, $trick);
            }

            // Processing videos via a service
            $videos = $form->getExtraData()['videos'];
            if (!empty($videos)) {
                $videoManagement->process($videos, $trick);
            }

            $this->addFlash('success', 'The trick has been successfully updated.');
            $this->em->persist($trick);
            $this->em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('trick/edit.html.twig', [
            'formView' => $form->createView(),
            'trick' => $trick
        ]);
    }

    /**
     * Delete a trick
     */
    #[Route('/tricks/delete/{slug}', name: 'trick_delete', methods: ['GET'])]
    public function delete(Trick $trick): Response
    {
        $this->addFlash('success', 'The trick has been successfully deleted.');
        $this->em->remove($trick);
        $this->em->flush();

        return $this->redirectToRoute('home');
    }
}
