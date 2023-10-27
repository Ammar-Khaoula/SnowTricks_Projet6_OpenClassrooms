<?php

namespace App\DataFixtures;

use App\Entity\VideoUrls;
use EsperoSoft\Faker\Faker;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class VideosFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private SluggerInterface $slugger){}
    public function load(ObjectManager $manager): void
    {
        $faker = new Faker();

        for($i = 1; $i <=10; $i++){
            $videoUrl = new VideoUrls();
            $videoUrl->setName($faker->video());
            $trick = $this->getReference('prod-'.rand(1, 10));
            $videoUrl->setTricks($trick);

            $manager->persist($videoUrl);
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
