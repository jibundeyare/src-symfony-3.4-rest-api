<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Student;
use AppBundle\Form\StudentType;
use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Prefix("/api")
 */
class ApiStudentController extends FOSRestController
{
    public function getStudentsAction()
    {
        $repository = $this->getDoctrine()->getRepository(Student::class);

        $students = $repository->findAll();

        $view = $this->view($students, Response::HTTP_OK);

        return $this->handleView($view);
    }

    public function getStudentAction($id)
    {
        $repository = $this->getDoctrine()->getRepository(Student::class);

        $student = $repository->find($id);

        if (!$student) {
            $view = $this->view(null, Response::HTTP_NOT_FOUND);

            return $this->handleView($view);
        }

        $view = $this->view($student, Response::HTTP_OK);

        return $this->handleView($view);
    }

    public function postStudentAction(Request $request)
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student, [
            'csrf_protection' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($student);
            $entityManager->flush();

            $view = $this->view($student, Response::HTTP_CREATED);

            return $this->handleView($view);
        }

        $view = $this->view($form, Response::HTTP_BAD_REQUEST);

        return $this->handleView($view);
    }

    public function putStudentAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Student::class);
        $student = $repository->find($id);

        if (!$student) {
            $view = $this->view(null, Response::HTTP_NOT_FOUND);

            return $this->handleView($view);
        }

        $form = $this->createForm(StudentType::class, $student, [
            'csrf_protection' => false,
            'method' => 'PUT',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($student);
            $entityManager->flush();

            $view = $this->view($student, Response::HTTP_OK);

            return $this->handleView($view);
        }

        $view = $this->view($form, Response::HTTP_NOT_MODIFIED);

        return $this->handleView($view);
    }

    public function deleteStudentAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Student::class);
        $student = $repository->find($id);

        if (!$student) {
            $view = $this->view(null, Response::HTTP_NOT_FOUND);

            return $this->handleView($view);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($student);
        $entityManager->flush();

        $view = $this->view(null, Response::HTTP_NO_CONTENT);

        return $this->handleView($view);
    }
}
