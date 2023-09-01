<?php

namespace App\Service;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Entity\User;
use App\Repository\TrickRepository;
use App\Repository\CommentRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class CommentService
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

    /**
     * Create comment for Trick
     */
    public function createComment(Trick $trick, $request, User $user): ?array
    {
        // Check trick
        if (!$trick) {
            return [
                'type' => 'danger',
                'message' => 'The trick does not exist !',
                'redirectRoute' => 'home',
                'paramsRoute' => []
            ];
        }

        // Check user
        if (!$user) {
            return [
                'type' => 'danger',
                'message' => 'You must be authenticated to perform this action.',
                'redirectRoute' => 'security_login',
                'paramsRoute' => []
            ];
        }

        // Create new comment
        $comment = new Comment;
        $comment->setTrick($trick);
        $comment->setContent($request->request->get('comment_form')['content']);
        $comment->setAuthor($user);
        $comment->setCreatedAt(new DateTimeImmutable('now'));
        $comment->setUpdateAt(new DateTimeImmutable('now'));

        $this->em->persist($comment);
        $this->em->flush();

        return [
            'type' => 'success',
            'message' => 'Your comment has been published.',
            'redirectRoute' => 'trick_show',
            'paramsRoute' => ['slug' => $trick->getSlug()]
        ];
    }

    /**
     * Delete comment for Trick
     */
    public function deleteComment($slug, $id, User $user): ?array
    {
        $trick = $this->trickRepository->findOneBy(['slug' => $slug]);

        // Check trick
        if (!$trick) {
            return [
                'type' => 'danger',
                'message' => 'The trick does not exist !',
                'redirectRoute' => 'home',
                'paramsRoute' => []
            ];
        }

        // Check user
        if (!$user) {
            return [
                'type' => 'danger',
                'message' => 'You must be authenticated to perform this action.',
                'redirectRoute' => 'security_login',
                'paramsRoute' => []
            ];
        }

        // Get comment by id
        $comment = $this->commentRepository->find($id);

        // Check comment
        if (!$comment) {
            return [
                'type' => 'danger',
                'message' => 'The comment does not exist !',
                'redirectRoute' => 'trick_show',
                'paramsRoute' => ['slug' => $trick->getSlug()]
            ];
        }

        // Check author
        if ($comment->getAuthor() !== $user) {
            return [
                'type' => 'danger',
                'message' => 'You are not the author of this comment.',
                'redirectRoute' => 'trick_show',
                'paramsRoute' => ['slug' => $trick->getSlug()]
            ];
        }

        // Remove comment
        $this->em->remove($comment);
        $this->em->flush();

        return [
            'type' => 'success',
            'message' => 'Your comment has been deleted.',
            'redirectRoute' => 'trick_show',
            'paramsRoute' => ['slug' => $trick->getSlug()]
        ];
    }
}
