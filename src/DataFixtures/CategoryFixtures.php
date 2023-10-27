<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use phpDocumentor\Reflection\DocBlock\Description;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryFixtures extends Fixture
{
    private $counter = 1;
    public function __construct(private SluggerInterface $slugger)
    {
    }
    public function load(ObjectManager $manager): void
    {
        $this->createCategory('Grabs', $manager);
        $this->createCategory('Flips',  $manager);
        $this->createCategory('Slides',  $manager);
        
        $manager->flush();
    }
    public function createCategory(string $name,  ObjectManager $manager)
    {       
        $category = new Category();
        $category->setName($name);
        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $manager->persist($category);

        $this->addReference('cat-'.$this->counter, $category);
        $this->counter++;
        return $category;
    }
}
