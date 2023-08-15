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
        yield ArrayField::new(User::ROLE_ARTICLE_WRITER, 'Райт')
            ->setTemplatePath('/admin/user/role/is_role.html.twig')
            ->onlyOnIndex();
        yield ArrayField::new(User::ROLE_VIP, 'Vip')
            ->setTemplatePath('/admin/user/role/is_role.html.twig')
            ->onlyOnIndex();
        yield ArrayField::new(User::ROLE_NO_ADS, 'No Ads')
            ->setTemplatePath('/admin/user/role/is_role.html.twig')
            ->onlyOnIndex();
        yield ArrayField::new(User::ROLE_ADMIN, 'Admin')
            ->setTemplatePath('/admin/user/role/is_role.html.twig')
            ->onlyOnIndex();
    }
}
