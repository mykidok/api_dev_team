<?php

namespace App\DataFixtures;

use App\Entity\Chronicle;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ChronicleFixtures extends Fixture
{
    public const DEMBOUZ_CHRONICLE = 'dembouz-chronicle';

    public function load(ObjectManager $manager)
    {
        $chronicle = new Chronicle();

        $chronicle
            ->setName("Dembouz, le talent à l'état pur")
        ;

        $manager->persist($chronicle);
        $manager->flush();

        $this->addReference(self::DEMBOUZ_CHRONICLE, $chronicle);
    }
}
