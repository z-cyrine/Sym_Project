<?php
namespace App\DataFixtures;

use App\Entity\Watch;
use App\Entity\WatchBox;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Créer plusieurs WatchBox (collections)
        $luxuryBox = new WatchBox();
        $luxuryBox->setName('Luxury Collection');
        $luxuryBox->setDescription('A box for luxury watches.');
        $manager->persist($luxuryBox);

        $sportBox = new WatchBox();
        $sportBox->setName('Sport Collection');
        $sportBox->setDescription('A box for sport watches.');
        $manager->persist($sportBox);

        $vintageBox = new WatchBox();
        $vintageBox->setName('Vintage Collection');
        $vintageBox->setDescription('A collection for vintage watches.');
        $manager->persist($vintageBox);

        $diverBox = new WatchBox();
        $diverBox->setName('Diver Collection');
        $diverBox->setDescription('A collection for diving watches.');
        $manager->persist($diverBox);

        // Créer plusieurs Watch associées aux WatchBox
        $watch1 = new Watch();
        $watch1->setBrand('Rolex');
        $watch1->setModel('Submariner');
        $watch1->setPrice(8000);
        $watch1->setDescription('A luxury dive watch.');
        $watch1->setWatchBox($luxuryBox); // Associer à la Luxury Box
        $manager->persist($watch1);

        $watch2 = new Watch();
        $watch2->setBrand('Tag Heuer');
        $watch2->setModel('Carrera');
        $watch2->setPrice(5000);
        $watch2->setDescription('A chronograph for race enthusiasts.');
        $watch2->setWatchBox($sportBox); // Associer à la Sport Box
        $manager->persist($watch2);

        $watch3 = new Watch();
        $watch3->setBrand('Omega');
        $watch3->setModel('Seamaster');
        $watch3->setPrice(7000);
        $watch3->setDescription('A classic diver watch.');
        $watch3->setWatchBox($diverBox); // Associer à la Diver Box
        $manager->persist($watch3);

        $watch4 = new Watch();
        $watch4->setBrand('Patek Philippe');
        $watch4->setModel('Nautilus');
        $watch4->setPrice(35000);
        $watch4->setDescription('A luxury sports watch.');
        $watch4->setWatchBox($luxuryBox); // Associer à la Luxury Box
        $manager->persist($watch4);

        $watch5 = new Watch();
        $watch5->setBrand('Breitling');
        $watch5->setModel('Navitimer');
        $watch5->setPrice(6000);
        $watch5->setDescription('A pilot watch with a rich history.');
        $watch5->setWatchBox($vintageBox); // Associer à la Vintage Box
        $manager->persist($watch5);

        $watch6 = new Watch();
        $watch6->setBrand('Casio');
        $watch6->setModel('G-Shock');
        $watch6->setPrice(200);
        $watch6->setDescription('A durable sports watch.');
        $watch6->setWatchBox($sportBox); // Associer à la Sport Box
        $manager->persist($watch6);

        // Ajouter quelques montres supplémentaires
        $watch7 = new Watch();
        $watch7->setBrand('Omega');
        $watch7->setModel('Speedmaster');
        $watch7->setPrice(9000);
        $watch7->setDescription('The moonwatch worn by astronauts.');
        $watch7->setWatchBox($vintageBox); // Associer à la Vintage Box
        $manager->persist($watch7);

        $watch8 = new Watch();
        $watch8->setBrand('Panerai');
        $watch8->setModel('Luminor');
        $watch8->setPrice(7000);
        $watch8->setDescription('A diver watch with Italian heritage.');
        $watch8->setWatchBox($diverBox); // Associer à la Diver Box
        $manager->persist($watch8);

        $manager->flush();
    }
}

?>
