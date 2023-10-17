<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }


     /**
     * @Route("/listS", name="listS")
     */
    public function list(StudentRepository $repo): Response
    {
        $student=$repo->findAll();
        return $this-> render('student/list.html.twig'  ,[
            'student'=>$student,    
        ]);
    }


/**
     * @Route("/addS", name="addS")
     */

     public function add(Request $request)
     {
         $student= new Student();
         $form= $this->createForm(StudentType::class, $student);
         $form->handleRequest($request);
 
 
         if($form->isSubmitted() && $form->isValid()){
             $em=$this->getDoctrine()->getManager();
             $em->persist($student);
             $em->flush();
 
             return $this->redirectToRoute('listS');
         }
 
         return $this->render('student/add.html.twig'   ,[
             'form'=>$form->createView(),
         ]);
 
     }



    
/**
     * @Route("/update/{id}", name="update")
     */


     public function update(StudentRepository $repo, Request $request , $id){
        $student=$repo->find($id);  
        $form= $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();

            return $this->redirectToRoute('listS');
        }

        return $this->render('student/update.html.twig'   ,[
            'form'=>$form->createView(),
        ]);
     }
/**
     * @Route("/delete/{id}", name="delete")
     */
public function delete($id,StudentRepository $repo)
{
$data=$repo->find($id);
$em=$this->getDoctrine()->getManager();
$em->remove($data);
$em->flush();
return $this->redirectToRoute(('listS'));
}


}
