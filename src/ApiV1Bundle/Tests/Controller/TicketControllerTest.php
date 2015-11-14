<?php

namespace ApiV1Bundle\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Client;
use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * Functional tests covering controller.
 */
class TicketControllerTest extends WebTestCase
{
    /** @var Client */
    private $client;

    /**
     * Creates new instance of client, which will be shared between tests.
     */
    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * Checks single resource retrieval using the GET method.
     */
    public function testGetTicketAction()
    {
        $route = $this->getUrl('apiv1_get_ticket', ['id' => 1]);
        $this->client->request('GET', $route, [], [], ['HTTP_ACCEPT' => 'application/json']);

        $response = $this->client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertEquals('ticket1', $data['title']);
    }

    /**
     * Checks single resource retrieval using the GET method, when resource doesn't exist.
     */
    public function testGetNonexistentTicketAction()
    {
        $route = $this->getUrl('apiv1_get_ticket', ['id' => 6]);
        $this->client->request('GET', $route, [], [], ['HTTP_ACCEPT' => 'application/json']);

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    /**
     * Checks resource creation using the POST method.
     */
    public function testPostTicketAction()
    {
        $route = $this->getUrl('apiv1_post_ticket');
        $this->client->request(
            'POST',
            $route,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"title":"ticket6", "content":"lorem ipsum ticket6 dolor sit amet"}'
        );

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_CREATED, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    /**
     * Checks resource creation using the POST method, when data is invalid.
     */
    public function testPostInvalidTicketAction()
    {
        $route = $this->getUrl('apiv1_post_ticket');
        $this->client->request(
            'POST',
            $route,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"metal":"raptor"}'
        );

        $response = $this->client->getResponse();

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }
}
