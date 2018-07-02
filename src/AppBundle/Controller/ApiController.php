<?php
// src/AppBundle/Controller/ApiController.php
namespace AppBundle\Controller;

use AppBundle\Entity\Student;
use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\FOSRestController;

/**
 * @Prefix("/api")
 */
class ApiController extends FOSRestController
{
    public function randomLatency()
    {
        usleep(random_int(1, 3) * 1000000);
    }

    public function getStudentsAction()
    {
        // @hack simulation de temps de latence entre 1 et 3 secondes
        $this->randomLatency();

        $repository = $this->getDoctrine()->getRepository(Student::class);

        $students = $repository->findAll();

        $view = $this->view($students, 200)
            ->setFormat('json')
        ;

        return $this->handleView($view);
    }

    public function getStudentAction($id)
    {
        // @hack simulation de temps de latence entre 1 et 3 secondes
        $this->randomLatency();

        $repository = $this->getDoctrine()->getRepository(Student::class);

        $student = $repository->find($id);

        $view = $this->view($student, 200)
            ->setFormat('json')
        ;

        return $this->handleView($view);
    }
}
