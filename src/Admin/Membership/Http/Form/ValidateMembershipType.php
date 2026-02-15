<?php

declare(strict_types=1);

namespace App\Admin\Membership\Http\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
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
                'label' => \sprintf('Caution pour le badge de %d €', $options['badge_deposit']),
                'attr' => ['class' => 'form-check-input'],
                'required' => false,
                'row_attr' => [
                    'class' => 'form-row',
                ],
            ])
            ->add('annualMembershipFee', CheckboxType::class, [
                'label' => \sprintf('Cotisation annuelle de %d €', $options['annual_fee']),
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
        $resolver->setRequired([
            'annual_fee',
            'badge_deposit',
        ]);

        $resolver->setDefaults([
            'attr' => [
                'autocomplete' => 'off',
            ],
            'data_class' => ValidateMembershipRequest::class,
        ]);
    }
}
