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
            ->setContent("Ousmane Demele, futur quintuple ballon d'or, vient de sauver la France de la 
                        famine après avoir trouver un vaccin contre le SIDA. Celui qui deviendra 
                        fort probablement un jour Président de la République française -il serait crédité
                        du score record de 99,99%, son seul detracteur étant un homme des cavernes
                        vivant dans un petit village gaulois nommé Langeais- s'exprimera ce samedi devant
                        la France au JT de 20h de TF1.")
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
