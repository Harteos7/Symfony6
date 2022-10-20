<?php

namespace App\Controller\Admin;

use App\Entity\Utilisateur;
use App\Entity\User;// pour afficher la table User il faut l'appeler
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UtilisateurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class; // donne la table User à la vue
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
