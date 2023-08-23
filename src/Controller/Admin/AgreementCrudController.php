<?php

namespace App\Controller\Admin;

use App\Entity\Agreement;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

class AgreementCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Agreement::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
//            ->disable(Crud::PAGE_INDEX)
//            ->
//            ->add(Crud::PAGE_DETAIL)
            ->remove(Crud::PAGE_DETAIL, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('headline', 'Заголовок');
        yield TextEditorField::class::new('content', 'Текст соглашения');
    }
}
