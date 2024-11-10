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

class ContactApiController extends AbstractController
{
    #[Route('/api/contacts', name: 'app_contact_api', methods: ['GET'])]
    public function getAllContacts(ContactRepository $contactRepository): JsonResponse
    {
        $contacts = $contactRepository->findAll();
        $data = array();
        foreach ($contacts as $key => $contact) {
            $data[$key]['id'] = $contact->getId();
            $data[$key]['name'] = $contact->getName();
            $data[$key]['birthday'] = $contact->getBirthday()->format('d-m-Y');
            foreach ($contact->getContactPhones() as $key1 => $phone) {
                $data[$key]['phone numbers'][$key1] = $phone->getPhone();
            }
        }

        return $this->json($data);
    }
}
