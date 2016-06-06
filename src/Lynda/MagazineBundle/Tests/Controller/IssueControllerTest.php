<?php

namespace Lynda\MagazineBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IssueControllerTest extends WebTestCase
{
    
    public function testCompleteScenario()
    {
        // Create a new client to browse the application
        $client = static::createClient();

        // Create a new entry in the database
        $crawler = $client->request('GET', '/issue/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /issue/");
        $crawler = $client->click($crawler->selectLink('New Issue')->link());

        // Fill in the form and submit it
        $form = $crawler->selectButton('Create')->form(array(
            'issue[number]' => 1,
            'issue[datePublication][month]' => '3',
            'issue[datePublication][day]' => '12',
            'issue[datePublication][year]' => '2011',
            'issue[file]' => 'xxx.png',
            'issue[publication]' => 1,
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check data in the show view
        $this->assertGreaterThan(0, $crawler->filter('td:contains("2011")')->count(), 'Missing element td:contains("2011")');

        // Edit the entity
        $crawler = $client->click($crawler->selectLink('Edit')->link());

        $form = $crawler->selectButton('Edit')->form(array(
            'issue[number]'  => 20,
            // ... other fields to fill
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();

        // Check the element contains an attribute with value equals "20"
        $this->assertGreaterThan(0, $crawler->filter('[value="20"]')->count(), 'Missing element [value="20"]');

        // Delete the entity
        $client->submit($crawler->selectButton('Delete')->form());
        $crawler = $client->followRedirect();

        // Check the entity has been delete on the list
        $this->assertNotRegExp('/#20/', $client->getResponse()->getContent());
    }
 
}
