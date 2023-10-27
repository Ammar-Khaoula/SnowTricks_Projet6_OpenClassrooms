<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class UsersFixtures extends Fixture
{
    
    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder,
        private SluggerInterface $slugger)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for($i = 1; $i <=5; $i++){
            $user = new Users();
            $user->setName($faker->name);
            $user->setEmail($faker->email);
            $user->setAvatar($faker->image());
            $user->setPassword(
                $this->passwordEncoder->hashPassword($user, '123456')
            );
            $manager->persist($user);

            $this->setReference('cat-'.$i, $user);
            $manager->persist($user);
        }
      

        $manager->flush();
    }
}
