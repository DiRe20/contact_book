<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use App\Entity\ContactEmail;
use App\Entity\ContactPhone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $contactPhone = new ContactPhone();
        $contactPhone->setPhone("0123456789");
        $contactPhone->setLabel(ContactPhone::LABEL_PERSONAL);

        $contactEmail = new ContactEmail();
        $contactEmail->setLabel(ContactPhone::LABEL_PERSONAL);
        $contactEmail->setEmail("johndoe@gmail.com");

        $contactEmailOffice = new ContactEmail();
        $contactEmailOffice->setLabel(ContactPhone::LABEL_OFFICE);
        $contactEmailOffice->setEmail("johndoeoffice@gmail.com");

        $contact = new Contact();
        $contact->setName("John Doe");
        $contact->setBirthday(new \DateTime("1971-01-01"));
        $contact->setCategory(Contact::CATEGORY_FRIENDS);
        $contact->addContactPhone($contactPhone);
        $contact->addContactEmail($contactEmail);
        $contact->addContactEmail($contactEmailOffice);
        $manager->persist($contact);
        $manager->flush();

        $contactPhone = new ContactPhone();
        $contactPhone->setPhone("1234567890");
        $contactPhone->setLabel(ContactPhone::LABEL_PERSONAL);

        $contactPhoneOffice = new ContactPhone();
        $contactPhoneOffice->setPhone("2345678901");
        $contactPhoneOffice->setLabel(ContactPhone::LABEL_OFFICE);

        $contactEmail = new ContactEmail();
        $contactEmail->setLabel(ContactPhone::LABEL_PERSONAL);
        $contactEmail->setEmail("janesmith@gmail.com");

        $contact = new Contact();
        $contact->setName("Jane Smith");
        $contact->setBirthday(new \DateTime("2002-02-02"));
        $contact->setCategory(Contact::CATEGORY_FAMILY);
        $contact->addContactPhone($contactPhone);
        $contact->addContactPhone($contactPhoneOffice);
        $contact->addContactEmail($contactEmail);
        $manager->persist($contact);
        $manager->flush();
    }
}
