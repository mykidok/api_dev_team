<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $article = new \App\Entity\Article();

        $article
            ->setIsValid(true)
            ->setTitle('Dembouz mon amour')
            ->setPoster($this->getReference(UserFixtures::USER_ADMIN))
            ->setDate(new \DateTime())
            ->setChronicle($this->getReference(ChronicleFixtures::DEMBOUZ_CHRONICLE))
        ;

        $manager->persist($article);

        $manager->flush();
    }


    /**
     * @inheritdoc
     */
    public function getDependencies()
    {
        return [
            UserFixtures::class,
            ChronicleFixtures::class,
        ];
    }
}
