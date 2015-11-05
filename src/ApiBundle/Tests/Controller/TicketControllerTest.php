<?php

namespace ApiBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase as WebTestCase;

class TicketControllerTest extends WebTestCase
{
    public function testJsonGetPageAction()
    {
        $this->loadFixtures(['ApiBundle\Tests\Fixture\TicketFixture']);

        $client = static::createClient();
        $route = $this->getUrl('api_1_get_page', ['id' => '1', '_format' => 'json']);

        $client->request('GET', $route, ['ACCEPT' => 'application/json']);
        $response = $client->getResponse();

        $decoded = json_decode($response->getContent(), true);
        $this->assertTrue(isset($decoded['id']));
    }
}
