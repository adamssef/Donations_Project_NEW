<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       $categories = [
           1 =>'ubrania',
           2 =>'jedzenie',
           3 =>'środki czystości i kosmetyki',
           4 =>'artykuły AGD',
           5 =>'sprzęt elektroniczny',
           6 =>'leki',
           7 =>'zabawki',
       ];

        foreach ($categories as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
        }
        $manager->flush();
    }
}
