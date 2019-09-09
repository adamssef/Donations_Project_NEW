<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Institution;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class InstitutionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $names = [
            1 =>'Fundacja Dzieci Niczyje',
            2 =>'Fundacja Zdążyć z Pomocą',
            3 =>'Fundacja Wielkiej Orkiestry Świątecznej Pomocy',
            4 =>'Fundacja Ratujmy Drzewa Przed Wycinką',
        ];

        $descriptions = [
            1 =>'Zajmujemy się pomocą dzieciom pochodzących z rodzin dysfunkcyjnych.',
            2 =>'Zajmujemy się pomocą ludziom najbardziej potrzebującym.',
            3 =>'Celem Fundacji jest działalność w zakresie ochrony zdrowia, polegająca na ratowaniu życia chorych osób, w szczególności dzieci, i działanie na rzecz poprawy stanu ich zdrowia, jak również na działaniu na rzecz promocji zdrowia i profilaktyki zdrowotnej.',
            4 =>'Fundacja zajmuje się ochroną drzew przed nieuprawnioną i bezpodstawną wycinką.',
        ];

        for ($i = 1; $i <= 4; $i++) {
            $institution = new Institution();
            $institution->setName($names[$i]);
            $institution->setDescription($descriptions[$i]);
            $manager->persist($institution);
        }
        $manager->flush();
    }
}
