<?php

namespace App\Factory;
use App\Entity\Hero;

class HeroFactory
{
    public static function createHero($params)
    {   
        /** @var Hero $hero */
        $hero = new Hero();

        if(isset($params['name'])) {
            $hero->setName($params['name']);
        }

        if(isset($params['heroName'])) {
            $hero->setHeroName($params['heroName']);
        }

        if(isset($params['publisher'])) {
            $hero->setPublisher($params['publisher']);
        }

        if(isset($params['firstAppearanceDate'])) {
            $hero->setFirstAppearance($params['firstAppearanceDate']);
        }

        if(isset($params['abilities'])) {
            $hero->setAbilities($params['abilities']);
        }

        if(isset($params['teamAffiliations'])) {
            $hero->setTeamAffiliations($params['teamAffiliations']);
        }

        if(isset($params['powers'])) {
            $hero->setPowers($params['powers']);
        }

        return $hero;
    }
}