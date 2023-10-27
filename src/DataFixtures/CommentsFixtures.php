<?php

namespace App\DataFixtures;

use App\Entity\Comments;
use EsperoSoft\Faker\Faker;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentsFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private SluggerInterface $slugger){}
    public function load(ObjectManager $manager): void
    {
            $faker = new Faker();
            $comment = new Comments();

            $comment->setContent($faker->text());

            $trick = $this->getReference('prod-'.rand(1, 10));
            $comment->setTrick($trick);

            $user = $this->getReference('cat-'.rand(1, 5));
            $comment->setAuthor($user);


            $manager->persist($comment);


        $manager->flush();
    }
    public function getDependencies(): array
    {
        return[
            TricksFixtures::class,
            UsersFixtures::class
        ];
    }
}
