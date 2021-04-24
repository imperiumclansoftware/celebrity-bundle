<?php

namespace ICS\CelebrityBundle\Controller\Admin;

use ICS\CelebrityBundle\Entity\Celebrity;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CelebrityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Celebrity::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            FormField::addPanel('Identity')
            ->setIcon('fa fa-user')->addCssClass('optional')
            ->setHelp(''),
            TextField::new('name'),
            ChoiceField::new('gender')->setChoices(['male'=>'male','female'=>'female']),
            NumberField::new('height'),
            FormField::addPanel('Dates')
            ->setIcon('fa fa-calendar')->addCssClass('optional')
            ->setHelp(''),
            DateField::new('birthday'),
            DateField::new('deathday'),
            NumberField::new('age')->hideOnForm(),
            FormField::addPanel('Other')
            ->setIcon('fa fa-info-circle')->addCssClass('optional')
            ->setHelp(''),
            CountryField::new('nationality'),
            NumberField::new('netWorth'),
            FormField::addPanel('Occupation')
            ->setIcon('fas fa-hammer')->addCssClass('optional')
            ->setHelp(''),
            AssociationField::new('occupation')
        ];
    }

}
