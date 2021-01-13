<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TricksControllerTest extends WebTestCase
{
    public function testHomeSuccessful()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
    }

    public function testTricksSuccessful()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/tricks');
        $this->assertResponseIsSuccessful();
    }

    public function testTrick()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/trick/NOSE-GRAB');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Nose grab');
    }

    public function testShowMainImage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/trick/NOSE-GRAB');
        $this->assertResponseIsSuccessful();
        $this->assertSame(1, $crawler->filter('img#mainImage')->count());
    }

    public function testDelete()
    {

        $client = static::createClient();
        $id = 16;
        $crawler = $client->request('GET', '/trick/delete?id=' . $id);
        $this->assertTrue($client->getResponse()->isRedirect());
    }
}
