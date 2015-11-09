<?php

namespace ApiV1Bundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase as WebTestCase;

/**
 * Functional tests covering controller.
 */
class TicketControllerTest extends WebTestCase
{
    /** @var \Doctrine\Common\DataFixtures\ReferenceRepository */
    private $fixtures;

    /**
     * Prepares environment for executing tests.
     */
    public function setUp()
    {
        /** @var \Doctrine\Common\DataFixtures\Executor\AbstractExecutor $executor */
        $executor = $this->loadFixtures(
            [
                'ApiV1Bundle\DataFixtures\ORM\TicketFixture'
            ]
        );

        $this->fixtures = $executor->getReferenceRepository();
    }

    /**
     * Checks resource request using the GET method.
     */
    public function testGetTicketAction()
    {
        $client = static::createClient();

        $id = $this->fixtures->getReference('ticket1')->getId();
        $route = $this->getUrl('apiv1_get_ticket', ['id' => $id]);

        $client->request('GET', $route, [], [], ['HTTP_ACCEPT' => 'application/json']);
        $response = $client->getResponse();
        $data = json_decode($response->getContent(), true);

        $this->assertJson($response->getContent());
        $this->assertEquals('ticket1', $data['title']);
    }
}
