<?php

namespace tests\Functionnal;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BookingApiTest extends WebTestCase
{
    public function testUserCanBookASession(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/bookings', [], [], [
            'CONTENT_TYPE' => 'application/json'
        ], json_encode([
            'email' => 'rappeur@studio.com',
            'start' => '2025-06-12T14:00:00',
            'end' => '2025-06-12T15:00:00',
        ]));
        $this->assertTrue($client->getResponse()->isSuccessful());
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);
    }
}
