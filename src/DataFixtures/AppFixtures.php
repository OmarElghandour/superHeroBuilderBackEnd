<?php

namespace App\DataFixtures;

use App\Entity\Hero;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $hero = new Hero();
        $hero->setName('Superman');
        $hero->setHeroName('Clark Kent');
        $hero->setPublisher('DC Comics');
        $hero->setFirstAppearance('12-05-1938');
        $hero->setAbilities(['Flight', 'Super Strength']);
        $hero->setTeamAffiliations(['DC', 'Superman']);
        $hero->setPowers(['Super Strength', 'Flight' , 'Super Speed']);
        $manager->persist($hero);


        $hero2 = new Hero();
        $hero2->setName('Batman');
        $hero2->setHeroName('Bruce Wayne');
        $hero2->setPublisher('DC Comics');
        $hero2->setFirstAppearance('01-03-1939');
        $hero2->setAbilities(['Rich', 'Super Strength']);
        $hero2->setTeamAffiliations(['DC', 'Batman']);
        $hero2->setPowers(['Rich', 'Super Strength', 'Super Speed']);
        $manager->persist($hero2);


        $hero3 = new Hero();
        $hero3->setName('Spiderman');
        $hero3->setHeroName('Peter Parker');
        $hero3->setPublisher('Sony Comics');
        $hero3->setFirstAppearance('01-02-1962');
        $hero3->setAbilities(['Spider', 'Super Strength']);
        $hero3->setTeamAffiliations(['Sony', 'Spiderman']);
        $hero3->setPowers(['Spider', 'Super Strength', 'Super Speed']);
        $manager->persist($hero3);

        $manager->flush();
    }
}
