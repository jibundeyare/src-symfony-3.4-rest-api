<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Promotion;
use AppBundle\Form\PromotionType;
use FOS\RestBundle\Controller\Annotations\Prefix;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Prefix("/api")
 */
class ApiPromotionController extends FOSRestController
{
    public function getPromotionsAction()
    {
        $repository = $this->getDoctrine()->getRepository(Promotion::class);

        $promotions = $repository->findAll();

        $view = $this->view($promotions, Response::HTTP_OK);

        return $this->handleView($view);
    }

    public function getPromotionAction($id)
    {
        $repository = $this->getDoctrine()->getRepository(Promotion::class);

        $promotion = $repository->find($id);

        if (!$promotion) {
            $view = $this->view(null, Response::HTTP_NOT_FOUND);

            return $this->handleView($view);
        }

        $view = $this->view($promotion, Response::HTTP_OK);

        return $this->handleView($view);
    }

    public function postPromotionAction(Request $request)
    {
        $promotion = new Promotion();
        $form = $this->createForm(PromotionType::class, $promotion, [
            'csrf_protection' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($promotion);
            $entityManager->flush();

            $view = $this->view($promotion, Response::HTTP_CREATED);

            return $this->handleView($view);
        }

        $view = $this->view($form, Response::HTTP_BAD_REQUEST);

        return $this->handleView($view);
    }

    public function putPromotionAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Promotion::class);
        $promotion = $repository->find($id);

        if (!$promotion) {
            $view = $this->view(null, Response::HTTP_NOT_FOUND);

            return $this->handleView($view);
        }

        $form = $this->createForm(PromotionType::class, $promotion, [
            'csrf_protection' => false,
            'method' => 'PUT',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($promotion);
            $entityManager->flush();

            $view = $this->view($promotion, Response::HTTP_OK);

            return $this->handleView($view);
        }

        $view = $this->view($form, Response::HTTP_NOT_MODIFIED);

        return $this->handleView($view);
    }

    public function deletePromotionAction(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Promotion::class);
        $promotion = $repository->find($id);

        if (!$promotion) {
            $view = $this->view(null, Response::HTTP_NOT_FOUND);

            return $this->handleView($view);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($promotion);
        $entityManager->flush();

        $view = $this->view(null, Response::HTTP_NO_CONTENT);

        return $this->handleView($view);
    }
}
