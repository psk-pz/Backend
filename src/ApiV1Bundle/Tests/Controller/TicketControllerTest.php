<?php

namespace ApiV1Bundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * Functional tests covering controller.
 */
class TicketControllerTest extends WebTestCase
{
    /**
     * Checks single resource retrieval using the GET method.
     */
    public function testGetTicketAction()
    {
        $client = static::createClient();

        $route = $this->getUrl('apiv1_get_ticket', ['id' => 1]);
        $client->request('GET', $route, [], [], ['HTTP_ACCEPT' => 'application/json']);

        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertJson($response->getContent());
        $this->assertEquals('ticket1', $data['title']);
    }
}
