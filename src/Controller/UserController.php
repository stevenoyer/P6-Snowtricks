<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/profile', name: 'user_profile')]
    public function show(): Response
    {
        return $this->render('user/show.html.twig');
    }

    #[Route('/profile/edit', name: 'user_edit')]
    public function edit(Request $request, EntityManagerInterface $em, FileUploader $fileUploader): Response
    {
        /** @var User */
        $user = $this->getUser();
        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            /** @var UploadedFile */
            $file = $form->get('avatar')->getData();
            if ($file)
            {
                $filename = $fileUploader->upload($file);
                $user->setAvatar($filename);
            }

            $em->flush();

            $this->addFlash('success', 'Votre profil a bien été modifié !');
            return $this->redirectToRoute('user_profile');
        }
        
        return $this->render('user/edit.html.twig', [
            'formView' => $form->createView()
        ]);
    }

}
