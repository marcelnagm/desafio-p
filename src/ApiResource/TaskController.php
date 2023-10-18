<?php

namespace App\ApiResource;

use App\Entity\Task;
use App\Form\TaskType ;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/task')]
class TaskController extends AbstractController {


    #[Route('/', name: 'app_task_index', methods: ['GET'])]
    public function index(TaskRepository $taskRepository): Response {
        
        
        foreach ($taskRepository->findBy(['created_by' =>$this->getUser()->getId()]) as $key) {
            $data[$key->getId()] = $key->toArray();
        }
        return $this->json([
                    'tasks' => $data,
        ]);
    }

    #[Route('/new', name: 'app_task_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {

        $data = $request->request->all();
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task, ['csrf_protection' => false,]);
        $form->submit($data);

//         dd($task);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser(); // null or UserInterface, if logged in
            // .
            $task->setCreatedBy($user->getId());
//               dd($task);
//            $task->setCreateAt(new \DateTimeImmutable());
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->json([$task->toArray()]);
        } else {
            $errors = [];

            foreach ($form->getErrors(true, true) as $error) {
                $errors[] = $error->getMessage();
            }
            return $this->json(['msg' => 'erro ao salvar ', 'erros' => $errors
            ]);
        }
    }

    #[Route('/{id}', name: 'app_task_show', methods: ['GET'])]
    public function show(Task $task): Response {

        $user = $this->getUser();
        if ($task->getCreatedBy() != $user->getId())
            return $this->json(['msg' => 'erro ao exibir ']);

        return $this->json([
                    $task->toArray()
        ]);
    }

    #[Route('/{id}/edit', name: 'app_task_edit', methods: ['POST'])]
    public function edit(Request $request, Task $task, EntityManagerInterface $entityManager): Response {
        $user = $this->getUser();
        if ($task->getCreatedBy() != $user->getId())
            return $this->json(['msg' => 'A task  nao eh sua para poder editar']);

        $data = $request->request->all();

        $form = $this->createForm(TaskType::class, $task, ['csrf_protection' => false,]);
        $form->submit($data);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->json([
                        $task->toArray()
            ]);
        }
        $errors = [];

        foreach ($form->getErrors(true, true) as $error) {
            $errors[] = $error->getMessage();
        }
        return $this->json(['msg' => 'erro ao atualizar ', 'erros' => $errors
        ]);
    }

    #[Route('/{id}/terminate', name: 'app_task_terminate', methods: ['POST'])]
    public function terminate(Request $request,  EntityManagerInterface $entityManager,$id): Response {
    
        
        $task = $entityManager->getRepository('\\App\\Entity\\Task')->find($id);
        if (!$task)
            return $this->json(['msg' => 'erro ao remover ']);
        $user = $this->getUser();
        if ($task->getCreatedBy() != $user->getId())
            return $this->json(['msg' => 'Voce nao pode terminar uma task que nao eh sua']);

        $task->setFinishedAt($request->request->get('finished_at'));
        $entityManager->persist($task);
        $entityManager->flush();

                return $this->json([
                        $task->toArray()
            ]);
    }
    
    #[Route('/{id}', name: 'app_task_delete', methods: ['DELETE'])]
    public function delete(Request $request, Task $task, EntityManagerInterface $entityManager): Response {
        if (!$task)
            return $this->json(['msg' => 'erro ao remover ']);
        $user = $this->getUser();
        if ($task->getCreatedBy() != $user->getId())
            return $this->json(['msg' => 'erro ao remover ']);


        $entityManager->remove($task);
        $entityManager->flush();

        return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
    }
}
