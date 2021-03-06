<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('country', TextType::class, ['required' => true, 'constraints' => [new NotBlank(), new NotNull()]])
            ->add('city', TextType::class, ['required' => true, 'constraints' => [new NotBlank(), new NotNull()]])
            ->add('postCode', TextType::class, ['required' => true, 'constraints' => [new NotBlank(), new NotNull()]])
            ->add('complement', TextareaType::class, ['required' => true, 'constraints' => [new NotBlank(), new NotNull()]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
