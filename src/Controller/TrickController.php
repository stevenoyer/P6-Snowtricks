<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use DateTimeImmutable;
use App\Form\TrickFormType;
use App\Form\CommentFormType;
use App\Service\TrickService;
use App\Media\ImageManagement;
use App\Media\VideoManagement;
use App\Service\PictureUploader;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrickController extends AbstractController
{

    protected $pictureUploader;
    protected $em;
    protected $slugger;
    protected $trickRepository;
    protected $trickService;

    public function __construct(PictureUploader $pictureUploader, EntityManagerInterface $em, SluggerInterface $slugger, TrickRepository $trickRepository, TrickService $trickService)
    {
        $this->pictureUploader = $pictureUploader;
        $this->em = $em;
        $this->slugger = $slugger;
        $this->trickRepository = $trickRepository;
        $this->trickService = $trickService;
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

            $create = $this->trickService->createTrick($trick, $form, $this->getUser());

            $this->addFlash($create['type'], $create['message']);
            return $this->redirectToRoute($create['redirectRoute'], $create['paramsRoute']);
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

            $update = $this->trickService->editTrick($trick, $form, $this->getUser());

            $this->addFlash($update['type'], $update['message']);
            return $this->redirectToRoute($update['redirectRoute'], $update['paramsRoute']);
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
        $delete = $this->trickService->deleteTrick($trick);

        $this->addFlash($delete['type'], $delete['message']);
        return $this->redirectToRoute($delete['redirectRoute'], $delete['paramsRoute']);
    }
}
