<?php

namespace tests\Functionnal;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthTest extends WebTestCase
{
    public function testUserCanLogInWithCorrectCredentials(): void
    {
        $client = static::createClient();

        // Simuler un utilisateur déjà en base (fixture ou setup en mémoire à venir)
        // Ici, on imagine qu'un user existe avec email + password

        $client->request('POST', '/api/login', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'email' => 'rappeur@test.com',
            'password' => 'studio123',
        ]));
        $this->assertResponseIsSuccessful(); // 200
        $this->assertJson($client->getResponse()->getContent());
    }

    public function testLoginFailsWithBadPassword(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/login', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'email' => 'rappeur@test.com',
            'password' => 'mauvaismotdepasse',
        ]));

        $this->assertResponseStatusCodeSame(401);
    }

    public function testUserCanRegisterSuccessfully(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/register', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'email' => 'newuser@test.com',
            'password' => 'studio123',
        ]));

        $this->assertResponseStatusCodeSame(201);
    }

}
