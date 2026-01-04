<?php

declare(strict_types=1);

namespace App\Form\Member;

use App\Enum\Membership\Gender;
use Symfony\Component\Form\AbstractType;
use App\DTO\Request\Member\MemberRequest;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class UpdateMemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'required' => true,
                'row_attr' => [
                    'class' => 'form-row',
                ],
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'required' => true,
                'row_attr' => [
                    'class' => 'form-row',
                ],
            ])
            ->add('birthdate', DateType::class, [
                'label' => 'Date de naissance',
                'widget' => 'single_text',
                'required' => true,
                'row_attr' => [
                    'class' => 'form-row',
                ],
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Sexe',
                'choices' => [
                    'Homme' => Gender::Male,
                    'Femme' => Gender::Female,
                    'Autre' => Gender::Other,
                ],
                'choice_value' => fn (?Gender $gender) => $gender?->value,
                'required' => true,
                'placeholder' => 'Sélectionnez le sexe',
                'row_attr' => [
                    'class' => 'form-row',
                ],
            ])
            ->add('phone', TextType::class, [
                'label' => 'Téléphone',
                'required' => true,
                'row_attr' => [
                    'class' => 'form-row',
                ],
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'required' => true,
                'row_attr' => [
                    'class' => 'form-row',
                ],
            ])
            ->add('postalcode', TextType::class, [
                'label' => 'Code postal',
                'required' => true,
                'row_attr' => [
                    'class' => 'form-row',
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'required' => true,
                'row_attr' => [
                    'class' => 'form-row',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'required' => true,
                'row_attr' => [
                    'class' => 'form-row',
                ],
            ])
            ->add('profileImage', FileType::class, [
                'label' => 'Photo de profil',
                'required' => false,
                'attr' => [
                    'accept' => '.jpeg,.jpg,.png,.gif,.bmp,.webp,.wbmp',
                ],
                'row_attr' => [
                    'class' => 'form-row',
                ],
            ])
            ->add('tutorLastname', TextType::class, [
                'label' => 'Nom du tuteur légal',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-row',
                ],
            ])
            ->add('tutorFirstname', TextType::class, [
                'label' => 'Prénom du tuteur légal',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-row',
                ],
            ])
            ->add('tutorPhone', TextType::class, [
                'label' => 'Téléphone du tuteur légal',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-row',
                ],
            ])
            ->add('tutorEmail', EmailType::class, [
                'label' => 'Email du tuteur légal',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-row',
                ],
            ])
            ->add('tutorAddress', TextType::class, [
                'label' => 'Adresse du tuteur légal',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-row',
                ],
            ])
            ->add('tutorPostalcode', TextType::class, [
                'label' => 'Code postal du tuteur légal',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-row',
                ],
            ])
            ->add('tutorCity', TextType::class, [
                'label' => 'Ville du tuteur légal',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-row',
                ],
            ])
            ->add('medicalCertificateExpiry', DateType::class, [
                'label' => 'Date d\'expiration du certificat médical',
                'required' => false,
                'widget' => 'single_text',
                'row_attr' => [
                    'class' => 'form-row',
                ],
            ])
            ->add('accessBadgeDeposit', IntegerType::class, [
                'label' => 'Caution donnée par l\'adhérent pour le badge',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-row',
                ],
            ])
            ->add('annualMembershipFee', IntegerType::class, [
                'label' => 'Cotisation donnée par l\'adhérent pour l\'année',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-row',
                ],
            ])
            ->add('accessBadgeNumber', TextType::class, [
                'label' => 'Numéro du badge',
                'required' => false,
                'row_attr' => [
                    'class' => 'form-row',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => [
                'autocomplete' => 'off',
            ],
            'data_class' => MemberRequest::class,
        ]);
    }
}
