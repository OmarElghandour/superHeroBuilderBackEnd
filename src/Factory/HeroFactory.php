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
        $hero->setHeroName($params['hero_name']);
        $hero->setPublisher($params['publisher']);
        $hero->setFirstAppearance($params['first_appearance']);
        $hero->setAbilities($params['abilities']);
        $hero->setTeamAffiliations($params['team_affiliations']);

        return $hero;
    }
}