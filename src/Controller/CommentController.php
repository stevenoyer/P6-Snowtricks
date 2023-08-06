<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use App\Repository\TrickRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/tricks/details/{slug}/comment', name: 'add_comment', methods: 'POST')]
    public function create($slug, Request $request, TrickRepository $trickRepository, EntityManagerInterface $em): Response
    {
        $trick = $trickRepository->findOneBy(['slug' => $slug]);
        if (!$trick) 
        {
            $this->addFlash('danger', 'The trick does not exist !');
            return $this->redirectToRoute('home');
        }

        if (!$this->getUser()) 
        {
            $this->addFlash('danger', 'You must be authenticated to perform this action.');
            return $this->redirectToRoute('security_login');
        }

        $comment = new Comment;
        $comment->setTrick($trick);
        $comment->setContent($request->request->get('comment_form')['content']);
        $comment->setAuthor($this->getUser());
        $comment->setCreatedAt(new DateTimeImmutable('now'));
        $comment->setUpdateAt(new DateTimeImmutable('now'));

        $em->persist($comment);
        $em->flush();

        $this->addFlash('success', 'Your comment has been published.');
        return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug()]);
    }

    #[Route('/tricks/details/{slug}/comment/{id}/delete', name: 'delete_comment', methods: 'GET')]
    public function delete($slug, $id, TrickRepository $trickRepository, EntityManagerInterface $em, CommentRepository $commentRepository): Response
    {
        $trick = $trickRepository->findOneBy(['slug' => $slug]);
        if (!$trick) 
        {
            $this->addFlash('danger', 'The trick does not exist !');
            return $this->redirectToRoute('home');
        }

        if (!$this->getUser()) 
        {
            $this->addFlash('danger', 'You must be authenticated to perform this action.');
            return $this->redirectToRoute('security_login');
        }
        
        $comment = $commentRepository->find($id);
        if (!$comment) 
        {
            $this->addFlash('danger', 'The comment does not exist !');
            return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug()]);
        }

        if ($comment->getAuthor() !== $this->getUser())
        {
            $this->addFlash('danger', 'You are not the author of this comment.');
            return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug()]);
        }

        $em->remove($comment);
        $em->flush();

        $this->addFlash('success', 'Your comment has been deleted.');
        return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug()]);
    }
}
