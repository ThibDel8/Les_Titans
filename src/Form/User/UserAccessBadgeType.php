<?php

declare(strict_types=1);

namespace App\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\DTO\Request\User\UserAccessBadgeRequest;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserAccessBadgeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('accessBadgeNumber', TextType::class, [
                'label' => 'Numéro du badge',
                'required' => true,
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
            'data_class' => UserAccessBadgeRequest::class,
        ]);
    }
}
