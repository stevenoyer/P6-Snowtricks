<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Repository\CommentRepository;
use App\Repository\TrickRepository;
use App\Service\CommentService;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    private $commentRepository;
    private $commentService;

    public function __construct(CommentRepository $commentRepository, CommentService $commentService)
    {
        $this->commentRepository = $commentRepository;
        $this->commentService = $commentService;
    }

    /**
     * Create comment
     */
    #[Route('/tricks/details/{slug}/comment', name: 'add_comment', methods: ['POST'])]
    public function create(Trick $trick, Request $request): Response
    {
        $create = $this->commentService->createComment($trick, $request, $this->getUser());

        $this->addFlash($create['type'], $create['message']);
        return $this->redirectToRoute($create['redirectRoute'], $create['paramsRoute']);
    }

    /**
     * Delete comment
     */
    #[Route('/tricks/details/{slug}/comment/{id}/delete', name: 'delete_comment', methods: ['GET'])]
    public function delete($slug, $id): Response
    {
        $delete = $this->commentService->deleteComment($slug, $id, $this->getUser());

        $this->addFlash($delete['type'], $delete['message']);
        return $this->redirectToRoute($delete['redirectRoute'], $delete['paramsRoute']);
    }

    /**
     * Load more comment
     */
    #[Route('/tricks/details/{id}/comments/load/{start}', name: 'load_comments', requirements: ["start" => "\d+"], methods: ['GET'])]
    public function loadMore($id, $start = 10)
    {
        $comments = $this->commentRepository->findBy(['trick' => $id], ['createdAt' => 'DESC'], 10, $start);

        return $this->render('comment/load.html.twig', [
            'comments' => $comments
        ]);
    }
}
