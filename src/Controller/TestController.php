<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestController extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/'); // pour simuler un navigateur

        $client->clickLink('Connexion'); // dit à la simulation du serveur de cliqué sur le lien nommé Connexion

        //$this->assertResponseIsSuccessful();
        //$this->assertSelectorTextContains('title', 'Log in!'); // vérifie que un champ title contien le mot 'Log in!' (vérifie qu'on est sur la page login)

        $client->submitForm('Login', [
            'email' => 'johndoe@example.com',
            'password' => 'Apassword1!234',
        ]);
        $this->assertResponseRedirects();
        $client->followRedirect();

        $this->assertSelectorTextContains('h1', 'Johndoe'); // vérifie que un champ title contien le mot 'Miam chez moi'
    }
}
