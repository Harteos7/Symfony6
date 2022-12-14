<?php

namespace App\Controller;

use App\Entity\Catalogue;
use App\Repository\PanierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;  // pour la pagination
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment; 
use App\Entity\Panier;
use App\Entity\User;
use App\Entity\Menu;
use App\Form\NewPasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use App\Repository\CatalogueRepository; //pour pouvoir appeler la base de donnée Catalogue
use App\Repository\MenuRepository; //pour pouvoir appeler la base de donnée Menu
use App\Repository\UserRepository; //pour pouvoir appeler la base de donnée user

class UtilisateurController extends AbstractController
{
    #[Route('/', name: 'app_utilisateur')]
    public function index(): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }

    #[Route('/out', name: 'app_out')]
    public function out(): Response
    {
        return $this->render('utilisateur/out.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }

    #[Route('/menus/{id}', name: 'app_cartechoix')]
    public function show(Request $request, Environment $twig, Menu $menu, CatalogueRepository $CatalogueRepository,): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $paginator = $CatalogueRepository->getCataloguePaginator($menu, $offset);

        return new Response($twig->render('utilisateur/cartechoix.html.twig', [
            'controller_name' => 'UtilisateurController',
            'catalogues' => $paginator,
            'menu' => $menu,
            'previous' => $offset - CatalogueRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + CatalogueRepository::PAGINATOR_PER_PAGE),
        ]));
    }

    #[Route('/forgot', name: 'app_forgot')]
    public function forgot(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(NewPasswordFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword( // on hassher le passeword : plainPassword
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush(); //envoie du nouveau password

        }

        return $this->render('utilisateur/forgot.html.twig', [
            'NewPassword' => $form->createView(),
        ]);
    }

     #[Route(path: '/setp', name: 'app_setp')]
    public function getp(User $user, Catalogue $catalogue, PanierRepository $panier, EntityManagerInterface $entityManager): Response
    {
        $panier = new Panier();
        $user = $this->getUser();

        $panier->setUserId($user);
        $panier->setCatalogueId($catalogue);

        $entityManager->persist($panier);
        $entityManager->flush();

        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }
}
