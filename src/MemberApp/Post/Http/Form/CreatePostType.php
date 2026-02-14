<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Http\Form;

use App\MemberApp\Post\Domain\DTO\Request\CreatePostRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreatePostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('text', TextareaType::class, [
                'label' => 'Votre message',
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
            'data_class' => CreatePostRequest::class,
        ]);
    }
}
