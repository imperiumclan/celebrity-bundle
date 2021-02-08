<?php

namespace ICS\CelebrityBundle\Form\Type;

use ICS\CelebrityBundle\Entity\Celebrity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class CelebrityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullname', TextType::class, [
                'required' => true
            ])
            ->add('name', TextType::class, [
                'required' => false
            ])
            ->add('surname', TextType::class, [
                'required' => false
            ])
            ->add('birthDay', BirthdayType::class, [
                'required' => false
            ])
            ->add('deathDay', BirthdayType::class, [
                'required' => false
            ])
            ->add('biography', CKEditorType::class, [
                'required' => false
            ])
            ->add("submit", SubmitType::class, [
                'label' => 'Record',
                'attr' => [
                    'class' => 'btn-primary'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Celebrity::class,
        ]);
    }
}
