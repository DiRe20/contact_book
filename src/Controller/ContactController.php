<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/', name: 'app_contact')]
    public function index(ContactRepository $contactRepository): Response
    {
        return $this->render('contact/index.html.twig', [
            'contacts' => $contactRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_contact_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactFormType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();
            return $this->json(['success' => true]);
        }

        return $this->render('contact/_modal.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/remove', name: 'app_contact_remove', methods: ['POST'])]
    public function remove(Request $request, ContactRepository $contactRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (empty($data)) {
            return new JsonResponse(['error' => 'No IDs listed'], JsonResponse::HTTP_NOT_FOUND);
        }
        if (!array_key_exists('ids', $data)) {
            return new JsonResponse(['error' => 'No IDs listed'], JsonResponse::HTTP_NOT_FOUND);
        }

        if (empty($data['ids'])) {
            return new JsonResponse(['error' => 'No IDs listed'], JsonResponse::HTTP_NOT_FOUND);
        }
        $contacts = $contactRepository->findBy(['id' => $data['ids']]);

        foreach ($contacts as $contact) {
            $entityManager->remove($contact);
        }
        $entityManager->flush();
        return new JsonResponse(['status' => 'success'], JsonResponse::HTTP_OK);
    }
}
