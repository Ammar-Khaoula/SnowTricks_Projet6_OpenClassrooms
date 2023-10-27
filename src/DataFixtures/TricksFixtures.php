<?php

namespace App\DataFixtures;

use App\Entity\Tricks;
use EsperoSoft\Faker\Faker;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class TricksFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger){}
    public function load(ObjectManager $manager): void
    {
        $faker = new Faker();

        for($prod = 1; $prod <=10; $prod++){
            $Trick = new Tricks();
            $Trick->setName($faker->name(15));
            $Trick->setSlug($this->slugger->slug($Trick->getName())->lower());
            $Trick->setImage($faker->image());
            $Trick->setDiscription($faker->text());

            $category = $this->getReference('cat-'.rand(1, 3));
            $Trick->setCategories($category);

            $this->setReference('prod-'.$prod, $Trick);
            $manager->persist($Trick);
         
        }

        $manager->flush();
    }
}
