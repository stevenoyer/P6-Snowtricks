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
    private $em;
    private $trickRepository;
    private $commentRepository;

    public function __construct(EntityManagerInterface $em, TrickRepository $trickRepository, CommentRepository $commentRepository)
    {
        $this->em = $em;
        $this->trickRepository = $trickRepository;
        $this->commentRepository = $commentRepository;
    }

    #[Route('/tricks/details/{slug}/comment', name: 'add_comment', methods: ['POST'])]
    public function create($slug, Request $request): Response
    {
        $trick = $this->trickRepository->findOneBy(['slug' => $slug]);
        if (!$trick) {
            $this->addFlash('danger', 'The trick does not exist !');
            return $this->redirectToRoute('home');
        }

        if (!$this->getUser()) {
            $this->addFlash('danger', 'You must be authenticated to perform this action.');
            return $this->redirectToRoute('security_login');
        }

        $comment = new Comment;
        $comment->setTrick($trick);
        $comment->setContent($request->request->get('comment_form')['content']);
        $comment->setAuthor($this->getUser());
        $comment->setCreatedAt(new DateTimeImmutable('now'));
        $comment->setUpdateAt(new DateTimeImmutable('now'));

        $this->em->persist($comment);
        $this->em->flush();

        $this->addFlash('success', 'Your comment has been published.');
        return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug()]);
    }

    #[Route('/tricks/details/{slug}/comment/{id}/delete', name: 'delete_comment', methods: ['GET'])]
    public function delete($slug, $id): Response
    {
        $trick = $this->trickRepository->findOneBy(['slug' => $slug]);
        if (!$trick) {
            $this->addFlash('danger', 'The trick does not exist !');
            return $this->redirectToRoute('home');
        }

        if (!$this->getUser()) {
            $this->addFlash('danger', 'You must be authenticated to perform this action.');
            return $this->redirectToRoute('security_login');
        }

        $comment = $this->commentRepository->find($id);
        if (!$comment) {
            $this->addFlash('danger', 'The comment does not exist !');
            return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug()]);
        }

        if ($comment->getAuthor() !== $this->getUser()) {
            $this->addFlash('danger', 'You are not the author of this comment.');
            return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug()]);
        }

        $this->em->remove($comment);
        $this->em->flush();

        $this->addFlash('success', 'Your comment has been deleted.');
        return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug()]);
    }

    #[Route('/tricks/details/{id}/comments/load/{start}', name: 'load_comments', requirements: ["start" => "\d+"], methods: ['GET'])]
    public function loadMore($id, $start = 10)
    {
        $comments = $this->commentRepository->findBy(['trick' => $id], ['createdAt' => 'DESC'], 10, $start);

        return $this->render('comment/load.html.twig', [
            'comments' => $comments
        ]);
    }
}
