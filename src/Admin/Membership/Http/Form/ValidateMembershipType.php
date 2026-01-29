<?php

declare(strict_types=1);

namespace App\Admin\Membership\Http\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use App\Admin\Membership\Domain\DTO\Request\ValidateMembershipRequest;

class ValidateMembershipType extends AbstractType
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
            ->add('accessBadgeDeposit', CheckboxType::class, [
                'label' => 'Caution pour le badge de 10 €',
                'attr' => ['class' => 'form-check-input'],
                'required' => false,
                'row_attr' => [
                    'class' => 'form-row',
                ],
            ])
            ->add('annualMembershipFee', CheckboxType::class, [
                'label' => 'Cotisation annuelle de 50 €',
                'attr' => ['class' => 'form-check-input'],
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
            'data_class' => ValidateMembershipRequest::class,
        ]);
    }
}
