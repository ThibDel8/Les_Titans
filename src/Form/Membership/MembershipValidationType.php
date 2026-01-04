<?php

declare(strict_types=1);

namespace App\Form\Membership;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use App\DTO\Request\Membership\MembershipValidationRequest;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class MembershipValidationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => [
                'autocomplete' => 'off',
            ],
            'data_class' => MembershipValidationRequest::class,
        ]);
    }
}
