<?php

namespace App\ApiResource;

use App\Entity\TaskShare;
use App\Form\TaskShareType;
use App\Repository\TaskShareRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/taskshare')]
class TaskShareController extends AbstractController {

    #[Route('/', name: 'app_taskshare_index', methods: ['GET'])]
    public function index(TaskShareRepository $taskShareRepository): Response {

        $data = [];
        foreach ($taskShareRepository->findBy(['created_by' => $this->getUser()->getId()]) as $key) {
            $data[$key->getId()] = $key->toArray();
        }
        return $this->json([
                    'taskshare' => $data,
        ]);
    }

    #[Route('/new', name: 'app_taskshare_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $data = $request->request->all();
        $taskShare = new TaskShare();
        $form = $this->createForm(TaskShareType::class, $taskShare);
        $form->submit($data);

        
        
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $user = $entityManager->getRepository('\\App\\Entity\\User')->findOneBy(['email' => $request->get('shared_with')]);
//            dd($user);
            $taskShare->setCreatedBy($this->getUser()->getId());
            $taskShare->setSharedWith($user->getId());
            $entityManager->persist($taskShare);
            $entityManager->flush();

               return $this->json([$taskShare->toArray()]) ;
        }else {
            $errors = [];

            foreach ($form->getErrors(true, true) as $error) {
                $errors[] = $error->getMessage();
            }
            return $this->json(['msg' => 'erro ao salvar ', 'erros' => $errors
            ]);
        }
    }

    #[Route('/{token}', name: 'app_taskshare_show', methods: ['GET'])]
    public function show(EntityManagerInterface $entityManager, TaskShare $taskShare): Response {
      if($this-getUser()->getId() != $taskShare->getSharedWith() ) 
            return $this->json(['msg' => 'erro ao exibir, ele nao eh seu']);
      
      return $this->json([$taskShare->toArray()]) ;
      
      
    }

    #[Route('/{id}/edit', name: 'app_taskshare_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TaskShare $taskShare, EntityManagerInterface $entityManager): Response {
        $form = $this->createForm(TaskShareType::class, $taskShare);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_taskshare_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('taskshare/edit.html.twig', [
                    'task_share' => $taskShare,
                    'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_taskshare_delete', methods: ['POST'])]
    public function delete(Request $request, TaskShare $taskShare, EntityManagerInterface $entityManager): Response {
        if ($this->isCsrfTokenValid('delete' . $taskShare->getId(), $request->request->get('_token'))) {
            $entityManager->remove($taskShare);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_taskshare_index', [], Response::HTTP_SEE_OTHER);
    }
}
