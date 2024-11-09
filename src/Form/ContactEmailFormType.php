<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\ContactEmail;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactEmailFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', ChoiceType::class, [
                'choices' => [
                    ContactEmail::LABEL_OFFICE => ContactEmail::LABEL_OFFICE,
                    ContactEmail::LABEL_PERSONAL => ContactEmail::LABEL_PERSONAL,
                    ContactEmail::LABEL_SCHOOL  => ContactEmail::LABEL_SCHOOL,
                    ContactEmail::LABEL_OTHER => ContactEmail::LABEL_OTHER,
                ]
            ])
            ->add('email')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactEmail::class,
        ]);
    }
}
