<?php

namespace App\Controller;

use App\Entity\Hero;
use App\Factory\HeroFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class HeroController extends AbstractController
{
    #[Route('/api/hero', name: 'get_hero' , methods: ['POST'])]
    public function create(Request $request, ValidatorInterface  $validator, EntityManagerInterface $entityManager)
    {
        $parameters = json_decode($request->getContent(), true);        
        $hero = HeroFactory::createHero($parameters);

        $errors = $validator->validate($hero);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;

            return new Response($errorsString , 400);
        }

        $entityManager->persist($hero);
        $entityManager->flush();
        return new Response('hero created' , 200);
    }


    #[Route('/api/hero/{id}', name: 'update_hero' , methods: ['PUT'])]
    public function update(Request $request, EntityManagerInterface $entityManager , ValidatorInterface $validator)
    {
        $parameters = json_decode($request->getContent(), true);
        $payload = $parameters['payload'];

        $hero = $entityManager->getRepository(Hero::class)->find($parameters['id']);
        $hero->setName($payload['name']);
        $hero->setHeroName($payload['heroName']);
        $hero->setPublisher($payload['publisher']);
        $hero->setFirstAppearance($payload['firstAppearance']);
        $hero->setAbilities($payload['abilities']);
        $hero->setTeamAffiliations($payload['teamAffiliations']);

        $errors = $validator->validate($hero);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;

            return new Response($errorsString , 400);
        }

        $entityManager->persist($hero);
        $entityManager->flush();
        return new Response('hero updated' , 200);
    }


    #[Route('/api/hero/{id}', name: 'delete_hero' , methods: ['DELETE'])]
    public function delete(Request $request, EntityManagerInterface $entityManager)
    {
        $parameters = json_decode($request->getContent(), true);        

        $hero = $entityManager->getRepository(Hero::class)->find($parameters['id']);
        $entityManager->remove($hero);
        $entityManager->flush();
        return new Response('hero deleted' , 200);
    }

    #[Route('/api/heros', name: 'get_heroes' , methods: ['GET'])]
    public function get(EntityManagerInterface $entityManager)
    {
        // Fetch heroes from the database
        $heroes = $entityManager->getRepository(Hero::class)->findAll();

        // Transform fetched heroes into an array
        $heroesArray = [];
        foreach ($heroes as $hero) {
            $heroesArray[] = [
                'id' => $hero->getId(),
                'name' => $hero->getName(),
                'heroName' => $hero->getHeroName(),
                'publisher' => $hero->getPublisher(),
                'firstAppearance' => $hero->getFirstAppearance(),
                'abilities' => $hero->getAbilities(),
                'teamAffiliations' => $hero->getTeamAffiliations(),
            ];
        }      
          
        return new JsonResponse(json_encode($heroesArray), 200, [], true);
    }
}