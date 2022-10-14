<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;  // pour la pagination
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment; 
use App\Entity\Catalogue;
use App\Entity\Menu;
use App\Entity\User;
use App\Form\NewPasswordFormType;
use App\Security\LoginAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
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
    public function forgot(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, LoginAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(NewPasswordFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $this->$user->setPassword(
                $userPasswordHasher->hashPassword(
                    $this->$user,
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
}