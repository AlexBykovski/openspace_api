<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TelephoneField::new('phone', 'Phone')
            ->onlyOnIndex();
        yield TextField::new('username', 'Имя')
            ->onlyOnIndex();
        yield TextField::new('country', 'Страна')
            ->onlyOnIndex();
        yield ArrayField::new('roles', 'Роли');
        yield ArrayField::new('isWriter', 'Райт')
            ->setTemplatePath('/admin/user/role/is_has_role.html.twig')
            ->onlyOnIndex();
        yield ArrayField::new('isVip', 'Vip')
            ->setTemplatePath('/admin/user/role/is_has_role.html.twig')
            ->onlyOnIndex();
        yield ArrayField::new('isNoAds', 'No Ads')
            ->setTemplatePath('/admin/user/role/is_has_role.html.twig')
            ->onlyOnIndex();
        yield ArrayField::new('isAdmin', 'Admin')
            ->setTemplatePath('/admin/user/role/is_has_role.html.twig')
            ->onlyOnIndex();
    }
}
