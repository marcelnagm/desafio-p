<?php

namespace App\ApiResource;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\CustomAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController {

    #[Route('/api/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, CustomAuthenticator $authenticator, EntityManagerInterface $entityManager): Response {
        $data = json_decode($request->getContent(),true) ;

//         dd($data);
        
        
        if (!$this->getUser()->isAdmin())
            return $this->json(['msg' => 'Apenas adminstrado pode faze-lo']);


        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                    $userPasswordHasher->hashPassword(
                            $user,
                            $form->get('plainPassword')->getData()
                    )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->json(['msg' => 'Usuario regisrado com sucesso']);
        } else {
               $errors = [];

            foreach ($form->getErrors(true, true) as $error) {
                $errors[] = $error->getMessage();
            }
            return $this->json(['msg' => 'erro ao salvar ', 'erros' => $errors
            ]);
        }
    }
}
