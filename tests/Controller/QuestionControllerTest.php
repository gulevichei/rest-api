<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class QuestionControllerTest
 *
 * @package App\Tests\Controller
 */
class QuestionControllerTest extends WebTestCase
{
    public function testGetQuestion()
    {
        $client = static::createClient();
        $client->request('GET', '/v1/questions/get/en');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertNotEmpty($client->getResponse()->getContent());
    }

    public function testPostQuestion()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/v1/questions/post',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"text": "What is the capital of Luxembourg111?", "createdAt": "2019-06-01 00:00:00","choices": [{"text": "Luxembourg"},{"text": "Paris"},{"text": "Berlin"}]}'
        );

        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());
        $this->assertEquals('[]', $client->getResponse()->getContent());
    }


    public function testPostQuestionWith2Choices()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/v1/questions/post',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"text": "What is the capital of Luxembourg111?", "createdAt": "2019-06-01 00:00:00","choices": [{"text": "Luxembourg"},{"text": "Paris"}]}'
        );

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }
}
