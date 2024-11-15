<?php

namespace App\Form;

use App\Entity\ContactPhone;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class ContactPhoneFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('label', ChoiceType::class, [
                'choices' => [
                    ContactPhone::LABEL_OFFICE => ContactPhone::LABEL_OFFICE,
                    ContactPhone::LABEL_PERSONAL => ContactPhone::LABEL_PERSONAL,
                    ContactPhone::LABEL_SCHOOL  => ContactPhone::LABEL_SCHOOL,
                    ContactPhone::LABEL_OTHER => ContactPhone::LABEL_OTHER,
                ]
            ])
            ->add('phone', TextType::class, [
                'label' => 'Phone Number',
                'attr' => [
                    'maxlength' => 15,
                    'pattern' => '[0-9]*',
                ],
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\d+$/',
                        'message' => 'Please enter only numbers.'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactPhone::class,
        ]);
    }
}
