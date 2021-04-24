<?php

namespace ICS\CelebrityBundle\Form\Type;

use ICS\CelebrityBundle\Entity\Celebrity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use ICS\CelebrityBundle\Entity\Occupation;
use ICS\MediaBundle\Entity\MediaFile;
use ICS\MediaBundle\Form\Type\MediaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class CelebrityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false
            ])
            ->add('gender',ChoiceType::class,[
                'choices' => [
                    'male' => 'male',
                    'female' => 'female'
                ],
                'required' => false
            ])
            ->add('height', NumberType::class, [
                'required' => false
            ])
            ->add('nationality', CountryType::class, [
                'required' => false
            ])
            ->add('birthday', BirthdayType::class, [
                'required' => false
            ])
            ->add('deathday', BirthdayType::class, [
                'required' => false
            ])
            ->add('networth', NumberType::class, [
                'required' => false
            ])
            ->add('occupation',EntityType::class,[
                'class' => Occupation::class,
                'multiple' => true
            ])
            // ->add('representative',MediaType::class)
            ->add('biography', CKEditorType::class, [
                'required' => false
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Celebrity::class,
        ]);
    }
}
