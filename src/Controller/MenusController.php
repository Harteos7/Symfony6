<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment; 
use App\Entity\Catalogue;
use App\Entity\Menu;
use App\Repository\CatalogueRepository;
use App\Repository\MenuRepository; //pour pouvoir appeler la base de donnée Menu

class MenusController extends AbstractController
{
    #[Route('/menus', name: 'app_menus')]
    public function index(Environment $twig, MenuRepository $MenuRepository): Response
    {
        return $this->render('utilisateur/carte.html.twig', [
            'controller_name' => 'MenusController',           
            'menus' => $MenuRepository->findAll(), // on envoie toutes les menus (findAll) à la vue
        ]);
    }
}
