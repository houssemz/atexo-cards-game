<?php

declare(strict_types=1);

namespace Application;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

final class CardControllerTest extends WebTestCase
{
    public function testGetRandomHandWithCards(): void
    {
        $client = self::createClient();

        // default case (10 cards)
        $client->request('GET', '/api/hand');

        $this->assertResponseIsSuccessful();
        $this->assertResponseFormatSame('json');

        $this->assertCount(10, json_decode($client->getResponse()->getContent(), true));

        // 7 cards
        $client->request('GET', '/api/hand/7');

        $this->assertResponseIsSuccessful();
        $this->assertResponseFormatSame('json');

        $this->assertCount(7, json_decode($client->getResponse()->getContent(), true));
    }

    public function testSortCards(): void
    {
        $client = self::createClient();

        // Good Request
        $json = <<<JSON
            [ { "color": "Pique", "value": "Dame" }, { "color": "Trefle", "value": "As" }, { "color": "Coeur", "value": "Roi" }, { "color": "Pique", "value": "5" }, { "color": "Carreaux", "value": "8" }, { "color": "Trefle", "value": "Roi" }, { "color": "Coeur", "value": "5" }, { "color": "Coeur", "value": "8" }, { "color": "Carreaux", "value": "9" }, { "color": "Coeur", "value": "6" } ]
            JSON;

        $client->request(method: 'GET', uri: '/api/sort', parameters: ['hand' => $json]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $expected = <<<JSON
              [ { "color": "Carreaux", "value": "8" }, { "color": "Carreaux", "value": "9" }, { "color": "Coeur", "value": "5" }, { "color": "Coeur", "value": "6" }, { "color": "Coeur", "value": "8" }, { "color": "Coeur", "value": "Roi" }, { "color": "Pique", "value": "5" }, { "color": "Pique", "value": "Dame" }, { "color": "Trefle", "value": "As" }, { "color": "Trefle", "value": "Roi" } ]
            JSON;

        $this->assertJsonStringEqualsJsonString($expected, $client->getResponse()->getContent());

        // Bad request with empty hand to sort
        $client->request('GET', '/api/sort');
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('You can not sort an empty hand!', $client->getResponse()->getContent());
    }
}
