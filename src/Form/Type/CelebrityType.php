<?php

namespace ICS\CelebrityBundle\Form\Type;

use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use ICS\MediaBundle\Form\Type\MediaCollectionType;
use ICS\MediaBundle\Entity\MediaFile;
use ICS\CelebrityBundle\Service\CelebrityMediaDownloader;
use ICS\CelebrityBundle\Entity\Occupation;
use ICS\CelebrityBundle\Entity\Celebrity;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class CelebrityType extends AbstractType
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

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

            if($builder->getData()->getName() != "")
            {
                $outputdir = 'celebrity/'.$this->slugger->slug($builder->getData()->getName()).'/gallery';
                $builder->add('gallery',MediaCollectionType::class,['outputdir' => $outputdir]);
            }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Celebrity::class,
        ]);
    }
}
