<?php

declare(strict_types=1);

namespace App\Form\Security;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\DTO\Request\Membership\MembershipCreationRequest;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PasswordSetupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Nouveau mot de passe',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank(),
                    new Length(min: 8),
                ],
                'row_attr' => [
                    'class' => 'form-row',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MembershipCreationRequest::class,
        ]);
    }
}
