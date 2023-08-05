<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
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

    #[Route('/tricks/create', name: 'trick_create')]
    public function create(Request $request, ImageManagement $imageManagement, VideoManagement $videoManagement): Response
    {
        $trick = new Trick;
        $form = $this->createForm(TrickFormType::class, $trick);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid())
        {   
            $trick->setSlug(strtolower($this->slugger->slug($trick->getTitle())));
            $trick->setCreatedAt(new DateTimeImmutable('now'));
            $trick->setUpdateAt(new DateTimeImmutable('now'));

            $mainPicture = $form->get('mainPicture')->getData();
            if (!empty($mainPicture))
            {
                $trick->setMainPicture($this->pictureUploader->upload($mainPicture));
            }

            /* If there is no main picture, set the default main picture */
            if (empty($mainPicture))
            {
                $trick->setMainPicture('snowtricks_header.jpeg');
            }

            /** @var \App\Entity\User */
            $user = $this->getUser();
            $trick->setAuthor($user);
            
            $images = $form->getExtraData()['images'];
            if (!empty($images))
            {
                $imageManagement->process($images, $trick);
            }

            $videos = $form->getExtraData()['videos'];
            if (!empty($videos))
            {
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

    #[Route('/tricks/details/{slug}', name: 'trick_show')]
    public function show($slug): Response
    {
        $trick = $this->trickRepository->findOneBy([
            'slug' => $slug
        ]);

        return $this->render('trick/show.html.twig', [
            'item' => $trick
        ]);
    }

    #[Route('/tricks/edit/{slug}', name: 'trick_edit')]
    public function edit($slug, Request $request, ImageManagement $imageManagement, VideoManagement $videoManagement): Response
    {
        $trick = $this->trickRepository->findOneBy([
            'slug' => $slug
        ]);

        $form = $this->createForm(TrickFormType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $trick->setSlug(strtolower($this->slugger->slug($trick->getTitle())));
            $trick->setUpdateAt(new DateTimeImmutable('now'));

            $mainPicture = $form->get('mainPicture')->getData();
            if (!empty($mainPicture))
            {
                $trick->setMainPicture($this->pictureUploader->upload($mainPicture));
            }

            $images = $form->getExtraData()['images'];
            if (!empty($images))
            {
                $imageManagement->process($images, $trick);
            }

            $videos = $form->getExtraData()['videos'];
            if (!empty($videos))
            {
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

    #[Route('/tricks/delete/{slug}', name: 'trick_delete')]
    public function delete($slug): Response
    {
        $trick = $this->trickRepository->findOneBy(['slug' => $slug]);

        if ($trick)
        {
            $this->addFlash('success', 'The trick has been successfully deleted.');
            $this->em->remove($trick);
            $this->em->flush();
        }

        return $this->redirectToRoute('home');
    }
    
}
