<?php

namespace App\Form;

use App\Entity\Restaurant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class RestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [new NotBlank()],
                'empty_data' => ''
            ])
            ->add('status', TextType::class, [
                'constraints' => [new NotBlank()],
                'empty_data' => ''
            ])
            ->add('address')
            ->add('phone', TextType::class, [
                'constraints' => [new NotBlank()],
                'empty_data' => ''
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Restaurant::class,
            'csrf_protection' => false,
        ]);
    }
}
