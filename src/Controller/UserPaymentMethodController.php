<?php

namespace App\Controller;

use App\Entity\UserPaymentMethod;
use App\Form\UserPaymentMethodType;
use App\Repository\UserPaymentMethodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/payment/method")
 */
class UserPaymentMethodController extends AbstractController
{
    /**
     * @Route("/", name="user_payment_method_index", methods={"GET"})
     */
    public function index(UserPaymentMethodRepository $userPaymentMethodRepository): Response
    {
        return $this->render('user_payment_method/index.html.twig', ['user_payment_methods' => $userPaymentMethodRepository->findAll()]);
    }

    /**
     * @Route("/new", name="user_payment_method_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $userPaymentMethod = new UserPaymentMethod();
        $form = $this->createForm(UserPaymentMethodType::class, $userPaymentMethod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userPaymentMethod);
            $entityManager->flush();

            return $this->redirectToRoute('user_payment_method_index');
        }

        return $this->render('user_payment_method/new.html.twig', [
            'user_payment_method' => $userPaymentMethod,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_payment_method_show", methods={"GET"})
     */
    public function show(UserPaymentMethod $userPaymentMethod): Response
    {
        return $this->render('user_payment_method/show.html.twig', ['user_payment_method' => $userPaymentMethod]);
    }

    /**
     * @Route("/{id}/edit", name="user_payment_method_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserPaymentMethod $userPaymentMethod): Response
    {
        $form = $this->createForm(UserPaymentMethodType::class, $userPaymentMethod);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_payment_method_index', ['id' => $userPaymentMethod->getId()]);
        }

        return $this->render('user_payment_method/edit.html.twig', [
            'user_payment_method' => $userPaymentMethod,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_payment_method_delete", methods={"DELETE"})
     */
    public function delete(Request $request, UserPaymentMethod $userPaymentMethod): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userPaymentMethod->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userPaymentMethod);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_payment_method_index');
    }
}
