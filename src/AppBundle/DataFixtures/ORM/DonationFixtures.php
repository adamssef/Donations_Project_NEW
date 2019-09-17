<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Donation;
use AppBundle\Entity\Category;
use AppBundle\Entity\Institution;
use DateTime;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Provider\pl_PL\Company as FakerCompany;
use Faker\Provider\pl_PL\Person as FakerPerson;
use Faker\Provider\pl_PL\Address as FakerAddress;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class DonationFixtures extends Fixture implements FixtureGroupInterface
{
    protected $faker;

    public static function getGroups(): array
    {
        return ['group1', 'group2'];
    }

    public function load(ObjectManager $manager)
    {
        $startDate = strToTime('2018-01-01');
        $startDateTime = new DateTime();
        $startDateTime->setTimestamp($startDate);
        $endDate = time();
        $endDateTime = new DateTime();
        $startDateTime->setTimestamp($endDate);

        $categories = $manager->getRepository(Category::class)->findAll();
        $institutions = $manager->getRepository(Institution::class)->findAll();
        var_dump($institutions);
        $this->faker = Factory::create();
        $this->faker->addProvider(new FakerAddress($this->faker));

        for ($i = 0; $i < 50; $i++) {
            $donation = new Donation();
            $donation->addCategory($categories[array_rand($categories)]);
            $randomInstitution = ($institutions[array_rand($institutions)]);
            
            $donation->setInstitution($randomInstitution);
            $donation->setQuantity(rand(1, 30));
            $donation->setStreet($this->faker->streetName . ' ' . $this->faker->buildingNumber);
            $donation->setCity($this->faker->city);
            $donation->setZipCode($this->faker->postcode);
            $donation->setPickUpDate(self::randomDateInRange($startDateTime, $endDateTime));
            $donation->setPickUpTime(self::randomDateInRange($startDateTime, $endDateTime));
            $donation->setPickUpComment($this->faker->text($maxNbChars = 100));
            $randomInstitution->addDonation($donation);
            $manager->persist($donation);
            $manager->persist($randomInstitution);
            $manager->flush();
        }

    }

    static function randomDateInRange(DateTime $start, DateTime $end)
    {
        $randomTimestamp = mt_rand($start->getTimestamp(), $end->getTimestamp());
        $randomDate = new DateTime();
        $randomDate->setTimestamp($randomTimestamp);
        return $randomDate;
    }
}
