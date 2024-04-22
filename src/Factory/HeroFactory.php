<?php

namespace App\Factory;
use App\Entity\Hero;

class HeroFactory
{
    public static function createHero($params)
    {   
        /** @var Hero $hero */
        $hero = new Hero();

        $hero->setName($params['name']);
        $hero->setHeroName($params['heroName']);
        $hero->setPublisher($params['publisher']);
        $hero->setFirstAppearance($params['firstAppearanceDate']);
        $hero->setAbilities($params['abilities']);
        $hero->setTeamAffiliations($params['teamAffiliations']);
        $hero->setPowers($params['powers']);

        return $hero;
    }
}