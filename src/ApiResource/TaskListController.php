<?php

namespace App\ApiResource;

use App\Entity\TaskList;
use App\Form\TaskListType;
use App\Repository\TaskListRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



#[Route('/api/tasklist')]
class TaskListController extends AbstractController {

    #[Route('/', name: 'app_tasklist_index', methods: ['GET'])]
    public function index(TaskListRepository $taskRepository): Response {
        $data = [];
        foreach ($taskRepository->findBy(['created_by' =>$this->getUser()->getId()]) as $key) {
            $data[$key->getId()] = $key->toArray();
        }
        return $this->json([
                    'tasks' => $data,
        ]);
    }

    #[Route('/new', name: 'app_tasklist_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {

        $data = $request->request->all();
        $task = new TaskList();
        $form = $this->createForm(TaskListType::class, $task, ['csrf_protection' => false,]);
        $form->submit($data);

//         dd($task);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();// null or UserInterface, if logged in
        // .
            $task->setCreatedBy($user->getId());
//               dd($task);
//            $task->setCreateAt(new \DateTimeImmutable());
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->json([$task->toArray()]) ;
        } else {
            $errors = [];

            foreach ($form->getErrors(true, true) as $error) {
                $errors[] = $error->getMessage();
            }
            return $this->json(['msg' => 'erro ao salvar ', 'erros' => $errors
            ]);
        }
    }

    #[Route('/{id}', name: 'app_tasklist_show', methods: ['GET'])]
    public function show(TaskList $task,EntityManagerInterface $entityManager): Response {
        $user = $this->getUser();
        if ($task->getCreatedBy() != $user->getId())
            return $this->json(['msg' => 'erro ao exibir, ele nao eh seu']);
        $data =[];
        foreach ($entityManager->getRepository('\\App\\Entity\\Task')->findBy(['tasklist_id' => $task->getId()]) as $key) {
            $data[$key->getId()] = $key->toArray();
        }
        
        
        return $this->json([
                    'taskslist' => $task->toArray(),
                    'tasks' => $data
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tasklist_edit', methods: ['POST'])]
    public function edit(Request $request, TaskList $task, EntityManagerInterface $entityManager): Response {

        $user = $this->getUser();
        if ($task->getCreatedBy() != $user->getId())
            return $this->json(['msg' => 'erro ao remover ']);
        
        
        $data = $request->request->all();

        $form = $this->createForm(TaskListType::class, $task, ['csrf_protection' => false,]);
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

    #[Route('/{id}', name: 'app_tasklist_delete', methods: ['DELETE'])]
    public function delete(Request $request, TaskList $task, EntityManagerInterface $entityManager): Response {
        $user = $this->getUser();
        if ($task->getCreatedBy() != $user->getId())
            return $this->json(['msg' => 'erro ao remover ']);
        
        
            $entityManager->remove($task);
            $entityManager->flush();
        

        return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
    }
}
