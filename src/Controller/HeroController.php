<?php

namespace App\Controller;

use App\Entity\Hero;
use App\Factory\HeroFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class HeroController extends AbstractController
{
    #[Route('/api/hero', name: 'create_hero' , methods: ['POST'])]
    public function create(Request $request, ValidatorInterface  $validator, EntityManagerInterface $entityManager)
    {
        $parameters = json_decode($request->getContent(), true);        
        $hero = HeroFactory::createHero($parameters);

        $errors = $validator->validate($hero);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;

            return new JsonResponse(['message' => $errorsString] , 400);
        }

        $entityManager->persist($hero);
        $entityManager->flush();
        return new JsonResponse(['message' =>'hero created successfully' ], 200);
    }


    #[Route('/api/hero/{id}', name: 'update_hero' , methods: ['PUT'])]
    public function update(Request $request, EntityManagerInterface $entityManager , ValidatorInterface $validator)
    {
        $id = $request->attributes->get('id');

        $parameters = json_decode($request->getContent(), true);
        $payload = $parameters['payload'];

        $hero = $entityManager->getRepository(Hero::class)->find($id);

        if(!$hero) {
            return new JsonResponse(['message' => 'hero with id ' . $id . ' not found'] , 404);
        }

        $hero->setName($payload['name']);
        $hero->setHeroName($payload['heroName']);
        $hero->setPublisher($payload['publisher']);
        $hero->setFirstAppearance($payload['firstAppearanceDate']);
        $hero->setAbilities($payload['abilities']);
        $hero->setTeamAffiliations($payload['teamAffiliations']);
        $hero->setPowers($payload['powers']);
        $errors = $validator->validate($hero);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;

            return new JsonResponse(['message' => $errorsString] , 400);
        }

        $entityManager->persist($hero);
        $entityManager->flush();
        return new JsonResponse(['message' => 'hero with id ' . $id . ' updated successfully'] , 200);
    }


    #[Route('/api/hero/{id}', name: 'delete_hero' , methods: ['DELETE'])]
    public function delete(Request $request, EntityManagerInterface $entityManager)
    {
        $id = $request->attributes->get('id');

        $hero = $entityManager->getRepository(Hero::class)->find($id);

        if(!$hero) {
            return new JsonResponse(['message' => 'hero with id ' . $id . ' not found'] , 404);
        }
        
        $entityManager->remove($hero);
        $entityManager->flush();
        return new JsonResponse(['message' => 'hero deleted'] , 200);
    }


    #[Route('/api/hero/{id}', name: 'get_hero' , methods: ['GET'])]
    public function getOne(EntityManagerInterface $entityManager, $id)
    {
        $hero = $entityManager->getRepository(Hero::class)->find($id);

        if(!$hero) {
            return new JsonResponse(['message' => 'hero with id ' . $id . ' not found'] , 404);
        }

        $heroArray = [
            'id' => $hero->getId(),
            'name' => $hero->getName(),
            'heroName' => $hero->getHeroName(),
            'publisher' => $hero->getPublisher(),
            'firstAppearance' => $hero->getFirstAppearance(),
            'abilities' => $hero->getAbilities(),
            'teamAffiliations' => $hero->getTeamAffiliations(),
            'powers' => $hero->getPowers()
        ];
        return new JsonResponse(json_encode($heroArray), 200, [], true);
    }

    #[Route('/api/heroes', name: 'get_heroes' , methods: ['GET'])]
    public function getAll(EntityManagerInterface $entityManager)
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
                'powers' => $hero->getPowers()
            ];
        }      
          
        return new JsonResponse(json_encode($heroesArray), 200, [], true);
    }
}