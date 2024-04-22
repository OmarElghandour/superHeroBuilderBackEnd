<?php

use App\DataFixtures\AppFixtures;
use App\Entity\Hero;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;

class HeroControllerTest extends WebTestCase
{
  private $client;

  public function setup(): void
  {
    parent::setUp();
    $this->loadFixtures([AppFixtures::class]);
  }


  private function loadFixtures(array $fixtureClasses): void
  {
    $this->client = static::createClient();
    $entityManager = $this->client->getContainer()->get('doctrine')->getManager();
    $loader = new \Doctrine\Common\DataFixtures\Loader();

    foreach ($fixtureClasses as $fixtureClass) {
      $fixture = new $fixtureClass();
      $loader->addFixture($fixture);
    }

    $purger = new ORMPurger($entityManager);
    $executor = new ORMExecutor($entityManager, $purger);
    $executor->execute($loader->getFixtures());
  }



  public function testGetAllHeroes()
  {
    // Positive scenario
    $this->client->request('GET', '/api/heroes');
    $usres = json_decode($this->client->getResponse()->getContent(), true);
    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    $this->assertJson($this->client->getResponse()->getContent());
    $this->assertGreaterThan(0, count($usres));
    $this->assertEquals(3, count($usres));
  }


  public function testCreateHero()
  {
    // Positive scenario
    $this->client->request('POST', '/api/hero', [], [], [], json_encode([
      'name' => 'Test Name',
      'heroName' => 'Test Hero Name',
      'publisher' => 'Test Publisher',
      'firstAppearanceDate' => '2022-01-01',
      'abilities' => ['Test Ability 1', 'Test Ability 2'],
      'teamAffiliations' => ['Team A', 'Team B'],
      'powers' => ['Power A', 'Power B']
    ]));

    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    $this->assertJson($this->client->getResponse()->getContent());

    $entityManager = self::getContainer()->get('doctrine')->getManager();

    $insertedHero = $entityManager->getRepository(Hero::class)->findOneBy([
      'name' => 'Test Name',
    ]);

    $this->assertNotNull($insertedHero);

    $this->assertEquals('Test Name', $insertedHero->getName());
    $this->assertEquals('Test Hero Name', $insertedHero->getHeroName());
    $this->assertEquals('Test Publisher', $insertedHero->getPublisher());
    $this->assertEquals(['Test Ability 1', 'Test Ability 2'], $insertedHero->getAbilities());
    $this->assertEquals(['Team A', 'Team B'], $insertedHero->getTeamAffiliations());
    $this->assertEquals(['Power A', 'Power B'], $insertedHero->getPowers());



    // Negative scenario - missing required fields
    $this->client->request('POST', '/api/hero', [], [], [], json_encode([
      'name' => 'Test Name',
    ]));

    $this->assertEquals(400, $this->client->getResponse()->getStatusCode());
    $this->assertJson($this->client->getResponse()->getContent());
  }

  public function testUpdateHero()
  {
    $entityManager = self::getContainer()->get('doctrine')->getManager();

    $hero = $entityManager->getRepository(Hero::class)->findOneBy([
      'name' => 'Superman',
    ]);

    // Positive scenario
    $this->client->request('PUT', '/api/hero/' . $hero->getId(), [], [], [], json_encode([
      'payload' => [
        'name' => 'Updated Test Name',
        'heroName' => 'Updated Test Hero Name',
        'publisher' => 'Updated Test Publisher',
        'firstAppearanceDate' => '2023-01-01',
        'abilities' => ['Updated Test Ability 1', 'Updated Test Ability 2'],
        'teamAffiliations' => ['Updated Team A', 'Updated Team B'],
        'powers' => ['Updated Power A', 'Updated Power B']
      ]
    ]));

    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    $this->assertJson($this->client->getResponse()->getContent());
    $this->assertEquals('Updated Test Name', $hero->getName());
    $this->assertEquals('Updated Test Hero Name', $hero->getHeroName());
    $this->assertEquals('Updated Test Publisher', $hero->getPublisher());
    $this->assertEquals(['Updated Test Ability 1', 'Updated Test Ability 2'], $hero->getAbilities());
    $this->assertEquals(['Updated Team A', 'Updated Team B'], $hero->getTeamAffiliations());
    $this->assertEquals(['Updated Power A', 'Updated Power B'], $hero->getPowers());
  }



  public function testUpdateUserInvalidId()
  {
    $invalidId = 'invalid-id';
    $this->client->request('PUT', '/api/hero/' . $invalidId, [], [], [], json_encode([
      'payload' => [
        'name' => 'Updated Test Name',
        'heroName' => 'Updated Test Hero Name',
        'publisher' => 'Updated Test Publisher',
        'firstAppearanceDate' => '2023-01-01',
        'abilities' => ['Updated Test Ability 1', 'Updated Test Ability 2'],
        'teamAffiliations' => ['Updated Team A', 'Updated Team B'],
        'powers' => ['Updated Power A', 'Updated Power B']
      ]
    ]));

    $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    $this->assertJson($this->client->getResponse()->getContent());
  }

  public function testDeleteHero()
  {
    $entityManager = self::getContainer()->get('doctrine')->getManager();

    $hero = $entityManager->getRepository(Hero::class)->findOneBy([
      'name' => 'Batman',
    ]);

    // Positive scenario
    $this->client->request('DELETE', '/api/hero/' . $hero->getId());

    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    $this->assertJson($this->client->getResponse()->getContent());

    $deletedHero = $entityManager->getRepository(Hero::class)->findOneBy([
      'name' => 'Batman',
    ]);

    $this->assertNull($deletedHero);
  }

  public function testGetOneHero()
  {
    $entityManager = self::getContainer()->get('doctrine')->getManager();

    $hero = $entityManager->getRepository(Hero::class)->findOneBy([
      'name' => 'Superman',
    ]);

    // Positive scenario
    $this->client->request('GET', '/api/hero/' . $hero->getId());

    $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    $this->assertJson($this->client->getResponse()->getContent());

    // Negative scenario - getting non-existent hero
    $this->client->request('GET', '/api/hero/999');

    $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    $this->assertJson($this->client->getResponse()->getContent());
  }
}
