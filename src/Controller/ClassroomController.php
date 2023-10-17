<?php

namespace App\Controller;
use App\Entity\Classroom;
use App\Form\ClassroomType;
use App\Repository\ClassroomRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }


   /**
     * @Route("/list", name="list")
     */
    public function list(ClassroomRepository $repo): Response
    {
        $class=$repo->findAll();
        return $this-> render('classroom/list.html.twig'  ,[
            'classroom'=>$class,    
        ]);
    }

   /**
     * @Route("/add", name="add")
     */

    public function add(Request $request)
    {
        $classroom= new Classroom();
        $form= $this->createForm(classroomType::class, $classroom);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($classroom);
            $em->flush();

            return $this->redirectToRoute('list');
        }

        return $this->render('classroom/add.html.twig'   ,[
            'form'=>$form->createView(),
        ]);

    }
}
