<?php
namespace App\DataFixtures;

use App\Entity\Watch;
use App\Entity\WatchBox;
use App\Entity\Showcase;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    private const LUXURY_BOX = 'luxury_box';
    private const SPORT_BOX = 'sport_box';

    private const SHOWCASE_LUXURY = 'showcase_luxury';
    private const SHOWCASE_SPORT = 'showcase_sport';

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }

    public function load(ObjectManager $manager)
    {
        // Create WatchBoxes and assign them to members
        foreach ($this->watchBoxDataGenerator() as [$name, $description, $memberReference, $boxReference]) {
            $watchBox = new WatchBox();
            $watchBox->setName($name);
            $watchBox->setDescription($description);
            $watchBox->setMember($this->getReference($memberReference));
            
            $manager->persist($watchBox);
            $this->addReference($boxReference, $watchBox);
        }

        // Create Watches and associate them with WatchBoxes
        foreach ($this->watchesDataGenerator() as [$boxReference, $brand, $model, $price, $description, $imagePath]) {
    $watchBox = $this->getReference($boxReference);
    $watch = new Watch();
    $watch->setBrand($brand);
    $watch->setModel($model);
    $watch->setPrice($price);
    $watch->setDescription($description);
    $watch->setWatchBox($watchBox);

    $watch->setImageName($imagePath);

    $manager->persist($watch);
    $this->addReference($brand . '_' . $model, $watch);
}

        // Create Showcases and link them to specific watches
        foreach ($this->showcaseDataGenerator() as [$description, $isPublic, $memberReference, $watches, $showcaseReference]) {
            $showcase = new Showcase();
            $showcase->setDescription($description);
            $showcase->setPubliee($isPublic);
            $showcase->setCreateur($this->getReference($memberReference));
            
            foreach ($watches as $watchReference) {
                $watch = $this->getReference($watchReference);
                $showcase->addWatch($watch);
            }

            $manager->persist($showcase);
            $this->addReference($showcaseReference, $showcase);
        }

        $manager->flush();
    }

    private function watchBoxDataGenerator()
    {
        yield ['Luxury Collection', 'A box for luxury watches.', UserFixtures::MEMBER_CYRINE, self::LUXURY_BOX];
        yield ['Sport Collection', 'A box for sport watches.', UserFixtures::MEMBER_OLIVIER, self::SPORT_BOX];
    }

    private function watchesDataGenerator()
    {
        yield [self::LUXURY_BOX, 'Rolex', 'Submariner', 8000, 'A luxury dive watch.', 'rolex1.png'];
        yield [self::LUXURY_BOX, 'Patek Philippe', 'Nautilus', 35000, 'A luxury sports watch.', 'patek.png'];
        yield [self::SPORT_BOX, 'Tag Heuer', 'Carrera', 5000, 'A chronograph for race enthusiasts.', 'carrera.png'];
        yield [self::SPORT_BOX, 'Casio', 'G-Shock', 200, 'A durable sports watch.', 'casio1.png'];
        yield [self::LUXURY_BOX, 'Omega', 'Seamaster', 7000, 'A classic diver watch.', 'omegasea1.png'];
        yield [self::SPORT_BOX, 'Breitling', 'Navitimer', 6000, 'A pilot watch with a rich history.', 'navitimer.png'];
        yield [self::LUXURY_BOX, 'Omega', 'Speedmaster', 9000, 'The moonwatch worn by astronauts.', 'omega1.png'];
        yield [self::SPORT_BOX, 'Panerai', 'Luminor', 7000, 'A diver watch with Italian heritage.', 'luminor.png'];
    }


    private function showcaseDataGenerator()
    {
        yield [
            'Luxury Showcase', 
            true, 
            UserFixtures::MEMBER_CYRINE, 
            ['Rolex_Submariner', 'Patek Philippe_Nautilus'], 
            self::SHOWCASE_LUXURY
        ];
        yield [
            'Sport Showcase', 
            true, 
            UserFixtures::MEMBER_OLIVIER, 
            ['Tag Heuer_Carrera', 'Casio_G-Shock'], 
            self::SHOWCASE_SPORT
        ];
    }
}