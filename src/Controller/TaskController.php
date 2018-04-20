<?php

namespace App\Controller;

use App\Entity\Task;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class TaskController extends Controller
{
    /**
     * @Route("/task", name="task")
     */
    public function new(Request $request)
    {
        // create a task and give it some dummy data for this example
        $task = new Task();
        $task->setTask('Write a blog post');
        $task->setDueDate(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($task)
            ->add('task', TextType::class)
            ->add('dueDate', DateTimeType::class)
            ->add('save', SubmitType::class, array('label' => 'Create Task'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                // $form->getData() holds the submitted values
                // but, the original `$task` variable has also been updated
                $task = $form->getData();
//$task->setTask("zadanie");
                // ... perform some action, such as saving the task to the database
                // for example, if Task is a Doctrine entity, save it!
                $em = $this->getDoctrine()->getManager();
                $em->persist($task);
                $em->flush();

                return $this->redirectToRoute('task');
            } else
                return $this->render('test2.html.twig', array(
                    'form' => $form->createView(),
                ));
        }
        return $this->render('test2.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
