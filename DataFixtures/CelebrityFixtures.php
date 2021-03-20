<?php

namespace ICS\CelebrityBundle\DataFixtures;

use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use ICS\CelebrityBundle\Entity\Celebrity;

class CelebrityFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager)
    {
        $celebrity = new Celebrity();

        $celebrity->setName('Bullock');
        $celebrity->setSurname('Sandra');
        $celebrity->setFullname('Sandra Bullock');
        $celebrity->setBiography("Sandra Bullock [ˈsændɹə ˈbʊlək] est une actrice et productrice américaine, née le 26 juillet 1964 à Arlington en Virginie. Sa carrière décolle en 1994 grâce au succès du film d'action Speed, dans lequel elle donne la réplique à Keanu Reeves.");
        $celebrity->setBirthDay(DateTime::createFromFormat('d/m/Y', '26/07/1964'));

        $manager->persist($celebrity);
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['celebrity'];
    }
}
