<?php

namespace App\Form;

use App\Entity\ContactEmail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;

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
            ->add('email', EmailType::class, [
                'label' => 'Email Address',
                'required' => true,
                'constraints' => [
                    new Email([
                        'message' => 'Enter a valid email address',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'example@domain.com'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactEmail::class,
        ]);
    }
}
