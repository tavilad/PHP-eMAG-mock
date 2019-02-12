<?php

namespace App\Controller;

use App\Entity\UserContactInfo;
use App\Form\UserContactInfoType;
use App\Repository\UserContactInfoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/contact/info")
 */
class UserContactInfoController extends AbstractController
{
    /**
     * @Route("/", name="user_contact_info_index", methods={"GET"})
     */
    public function index(UserContactInfoRepository $userContactInfoRepository): Response
    {
        return $this->render('user_contact_info/index.html.twig', ['user_contact_infos' => $userContactInfoRepository->findAll()]);
    }

    /**
     * @Route("/new", name="user_contact_info_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $userContactInfo = new UserContactInfo();
        $form = $this->createForm(UserContactInfoType::class, $userContactInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userContactInfo);
            $entityManager->flush();

            return $this->redirectToRoute('user_contact_info_index');
        }

        return $this->render('user_contact_info/new.html.twig', [
            'user_contact_info' => $userContactInfo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_contact_info_show", methods={"GET"})
     */
    public function show(UserContactInfo $userContactInfo): Response
    {
        return $this->render('user_contact_info/show.html.twig', ['user_contact_info' => $userContactInfo]);
    }

    /**
     * @Route("/{id}/edit", name="user_contact_info_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserContactInfo $userContactInfo): Response
    {
        $form = $this->createForm(UserContactInfoType::class, $userContactInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_contact_info_index', ['id' => $userContactInfo->getId()]);
        }

        return $this->render('user_contact_info/edit.html.twig', [
            'user_contact_info' => $userContactInfo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_contact_info_delete", methods={"DELETE"})
     */
    public function delete(Request $request, UserContactInfo $userContactInfo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userContactInfo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userContactInfo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_contact_info_index');
    }
}
