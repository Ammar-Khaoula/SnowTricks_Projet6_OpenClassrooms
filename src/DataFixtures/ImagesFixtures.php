<?php

namespace App\DataFixtures;

use App\Entity\ImageUrls;
use EsperoSoft\Faker\Faker;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class ImagesFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private SluggerInterface $slugger){}
    public function load(ObjectManager $manager): void
    {
        $faker = new Faker();

        for($i = 1; $i <=10; $i++){
            $imageUrl = new ImageUrls();
            $imageUrl->setName($faker->image());
            
            $trick = $this->getReference('prod-'.rand(1, 10));
            $imageUrl->setTricks($trick);

            $manager->persist($imageUrl);
         
        }

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return[
            TricksFixtures::class
        ];
    }
}
