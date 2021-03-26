<?php

namespace ICS\CelebrityBundle\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use ICS\CelebrityBundle\Entity\Celebrity;

class CelebrityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Celebrity::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('fullname'),
            TextField::new('name'),
            TextField::new('surname'),
            DateField::new('birthday'),
            DateField::new('deathday'),
            TextEditorField::new('biography'),
            CountryField::new('nationality'),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('fullname')
            ->add('name')
            ->add('surname');
    }
}
