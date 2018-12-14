<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public const USER_ADMIN = 'user-admin';

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();

        $password = $this->encoder->encodePassword($user, 'coucou');
        $user
            ->setUsername('michael1108@hotmail.fr')
            ->setPassword($password)
            ->setFirstname('Mickael')
            ->setLastname('Pegnin')
            ->setRoles(['ROLE_ADMIN'])
        ;

        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::USER_ADMIN, $user);
    }
}
