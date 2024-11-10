<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', ChoiceType::class, [
                'choices' => [
                    Contact::CATEGORY_FAMILY => Contact::CATEGORY_FAMILY,
                    Contact::CATEGORY_WORK => Contact::CATEGORY_WORK,
                    Contact::CATEGORY_FRIENDS => Contact::CATEGORY_FRIENDS,
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'Name',
            ])
            ->add('birthday', null, [
                'widget' => 'single_text',
            ])
            ->add('contactEmails', CollectionType::class, [
                'entry_type' => ContactEmailFormType::class,
                'entry_options' => ['label' => false],
                'prototype' => true,
                'prototype_name' => '__contact_email__',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'required' => true,
            ])
            ->add('contactPhones', CollectionType::class, [
                'entry_type' => ContactPhoneFormType::class,
                'entry_options' => ['label' => false],
                'prototype' => true,
                'prototype_name' => '__contact_phone__',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
            'constraints' => [
                new Callback(function (Contact $contact, ExecutionContextInterface $context) {
                    if ($contact->getContactEmails()->isEmpty()) {
                        $context->buildViolation('Required Email')
                            ->atPath('contactEmails')
                            ->addViolation();
                    }
                })
            ]
        ]);
    }
}
