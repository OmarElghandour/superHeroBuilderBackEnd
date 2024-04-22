<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\HeroRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: HeroRepository::class)]
class Hero {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255 , nullable: true)]
    private $name;

    #[Assert\Type('string')]
    #[Assert\NotBlank , Assert\Length(min: 3)]
    #[ORM\Column(length: 255 , nullable: true)]
    private $heroName;

    #[Assert\Type('string')]
    #[Assert\NotBlank]
    #[ORM\Column(length: 255 , nullable: true)]
    private $publisher;

    #[ORM\Column(length: 255 , nullable: true)]
    private $firstAppearance;

    #[Assert\Type('array')]
    #[ORM\Column(type: 'array')]
    private $abilities;
    
    #[Assert\Type('array')]
    #[ORM\Column(type: 'array')]
    private $teamAffiliations;

    #[Assert\Type('array')]
    #[ORM\Column(type: 'array')]
    private $powers;


    public function getId() : int {

        return $this->id;
    }


    public function setName($name) {

       $this->name = $name;
       return $this;
    }

    public function getName() : string {
        return $this->name;
    }


   public function setHeroName($heroName) : Hero {
        $this->heroName = $heroName;
        return $this;
    }

    public function getHeroName() : string {
        return $this->heroName;
    }

    public function setPublisher($publisher) : Hero {
        $this->publisher = $publisher;
        return $this;
    }

    public function getPublisher() : string {
        return $this->publisher;
    }

    public function setFirstAppearance($firstAppearance) {
        $this->firstAppearance = $firstAppearance;
        return $this;
    }

    public function getFirstAppearance() : string {
        return $this->firstAppearance;
    }

    public function setAbilities($abilities) : Hero {
        $allAbilities = [];

        foreach ($abilities as $ability) {
            $allAbilities[] = $ability;
        }

        $this->abilities = $allAbilities;

        return $this;
    }

    public function getAbilities() : array {
        return $this->abilities;
    }

    public function getTeamAffiliations() : array {
        return $this->teamAffiliations;
    }

    public function setTeamAffiliations($teamAffiliations) : Hero {
        $this->teamAffiliations = $teamAffiliations;
        return $this;
    }

    public function getPowers() : array {
        return $this->powers;
    }

    public function setPowers($powers) : Hero {
        $this->powers = $powers;
        return $this;
    }


}