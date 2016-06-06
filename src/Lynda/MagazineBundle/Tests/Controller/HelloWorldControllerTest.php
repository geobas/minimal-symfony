<?php

namespace Lynda\MagazineBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Lynda\MagazineBundle\Controller\HelloWorldController;
use Symfony\Component\DomCrawler\Crawler;

class HelloWorldControllerTest extends WebTestCase
{
	public function testindexAction()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/hello');
		$result = $crawler->filter('html:contains("Geobas")')->count();
		$expected = 0;
		$this->assertGreaterThan($expected, $result);
	}

	public function testIndex2Action()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/hello/George');
		$result = $crawler->filter('html:contains("George")')->count();
		$expected = 0;
		$this->assertGreaterThan($expected, $result);
	}

	public function testAssertions()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/hello');
		$var = 123;
		
		$this->assertCount(1, $crawler->filter('strong'));
		$this->assertNotEmpty(array('geo', 'john', 'lias'));
		$this->assertTrue($client->getResponse()->isSuccessful());
		$this->assertNotNull($var);
		$this->assertRegExp('/Geobas!/', $client->getResponse()->getContent());
		$this->assertTrue($client->getResponse()->headers->contains(
			'Content-Type',
			'text/html; charset=UTF-8')
		);
	}

	public function testTraversing()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/hello');

		$h1 = $crawler->filter('h1')->eq(0)->text();
		$this->assertEquals('Symfony2.8', $h1);

		$p1 = $crawler->filter('p')->first();
		$p1Text = $p1->text();
		$this->assertRegExp('/Hello Geobas!/', $p1Text);

		$ul = $p1->siblings()->eq(1);
		
		$l1 = $ul->children()->first()->text();
		$this->assertEquals('George', $l1);

		$l2 = $ul->children()->eq(1)->text();
		$this->assertEquals('John', $l2);

		$l3 = $ul->children()->last()->text();
		$this->assertEquals('Hlias', $l3);

		$p2 = $crawler->filterXpath('//p')->last()->text();
		$this->assertContains('framework', $p2);
	}	

	public function testAddingContent()
	{
		$crawler = new Crawler();
		$crawler->addHtmlContent('<p class="test">Added via crawler</p>');
		$p1 = $crawler->filter('p')->first()->text();
		$this->assertRegExp('/via/', $p1);

		$p1Class = $crawler->filter('p')->attr('class');
		$this->assertEquals('test', $p1Class);
	}

	public function testForm()
	{
		$client = static::createClient();
		$crawler = $client->request('GET', '/hello');

		$form = $crawler->selectButton('send')->form();

		$uri = $form->getUri();
		$this->assertRegExp('/localhost/', $uri);

		$method = $form->getMethod();
		$this->assertEquals('GET', $method);

		$form['fname'] = 'George';
		$crawler = $client->submit($form);
		$data = $form->getPhpValues();
		$expected = array('send'=>'Send', 'fname'=>'George');
		$this->assertEquals($expected, $data);	
	}
}