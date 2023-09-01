<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    protected $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {

        $categories_name = ['La manière de rider', 'Les grabs', 'Les rotations', 'Les flips', 'Les rotations désaxées', 'Les slides', 'Les one foot tricks', 'Old school'];
        foreach ($categories_name as $category) {
            $categoryClass = new Category;
            $categoryClass->setName($category);

            $manager->persist($categoryClass);
        }

        $user = new User;
        $hash = $this->encoder->hashPassword($user, '123456');
        $user
            ->setName('Steven')
            ->setUsername('steven')
            ->setPassword($hash)
            ->setEmail('steven@oyer.fr')
            ->setValidate(true)
            ->setCreatedAt(new DateTime('now'));

        $manager->persist($user);

        $manager->flush();
    }
}
