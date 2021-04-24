<?php

namespace ICS\CelebrityBundle\Controller\Admin;

use ICS\CelebrityBundle\Entity\Occupation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OccupationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Occupation::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('code')->hideOnForm(),
            TextField::new('maleLib'),
            TextField::new('femaleLib'),
            AssociationField::new('celebrities'),
        ];
    }

}
