<?php

declare(strict_types=1);

namespace App\PublicApp\Contact\Http\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\PublicApp\Contact\Domain\DTO\Request\MessageCreationRequest;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'required' => true,
                'row_attr' => [
                    'class' => 'form-row',
                ],
            ])
            ->add('subject', TextType::class, [
                'label' => 'Sujet',
                'required' => true,
                'row_attr' => [
                    'class' => 'form-row',
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'required' => true,
                'attr' => [
                    'rows' => 8,
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
            'attr' => [
                'autocomplete' => 'off',
            ],
            'data_class' => MessageCreationRequest::class,
        ]);
    }
}
