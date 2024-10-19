<?php
namespace App\DataFixtures;

use App\Entity\Watch;
use App\Entity\WatchBox;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Member;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    /**
     * Generates initialization data for members :
     *  [email, plain text password]
     * @return \\Generator
     */
    private function membersGenerator()
    {
        yield ['olivier@localhost', '123456'];
        yield ['slash@localhost', '123456'];
    }

    public function load(ObjectManager $manager)
    {
        // Créer des WatchBox
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

        // Créer des Watch associées aux WatchBox
        $watch1 = new Watch();
        $watch1->setBrand('Rolex');
        $watch1->setModel('Submariner');
        $watch1->setPrice(8000);
        $watch1->setDescription('A luxury dive watch.');
        $watch1->setImage('rolex1.png');
        $watch1->setWatchBox($luxuryBox); // Associer à la Luxury Box
        $manager->persist($watch1);

        $watch2 = new Watch();
        $watch2->setBrand('Tag Heuer');
        $watch2->setModel('Carrera');
        $watch2->setPrice(5000);
        $watch2->setDescription('A chronograph for race enthusiasts.');
        $watch2->setImage('carrera.png');
        $watch2->setWatchBox($sportBox);
        $manager->persist($watch2);

        $watch3 = new Watch();
        $watch3->setBrand('Omega');
        $watch3->setModel('Seamaster');
        $watch3->setPrice(7000);
        $watch3->setDescription('A classic diver watch.');
        $watch3->setImage('omegasea1.png');
        $watch3->setWatchBox($diverBox);
        $manager->persist($watch3);

        $watch4 = new Watch();
        $watch4->setBrand('Patek Philippe');
        $watch4->setModel('Nautilus');
        $watch4->setPrice(35000);
        $watch4->setDescription('A luxury sports watch.');
        $watch4->setImage('patek.png');
        $watch4->setWatchBox($luxuryBox); // Associer à la Luxury Box
        $manager->persist($watch4);

        $watch5 = new Watch();
        $watch5->setBrand('Breitling');
        $watch5->setModel('Navitimer');
        $watch5->setPrice(6000);
        $watch5->setDescription('A pilot watch with a rich history.');
        $watch5->setImage('navitimer.png');
        $watch5->setWatchBox($vintageBox);
        $manager->persist($watch5);

        $watch6 = new Watch();
        $watch6->setBrand('Casio');
        $watch6->setModel('G-Shock');
        $watch6->setPrice(200);
        $watch6->setDescription('A durable sports watch.');
        $watch6->setImage('casio1.png');
        $watch6->setWatchBox($sportBox);
        $manager->persist($watch6);

        $watch7 = new Watch();
        $watch7->setBrand('Omega');
        $watch7->setModel('Speedmaster');
        $watch7->setPrice(9000);
        $watch7->setDescription('The moonwatch worn by astronauts.');
        $watch7->setImage('omega1.png');
        $watch7->setWatchBox($vintageBox);
        $manager->persist($watch7);

        $watch8 = new Watch();
        $watch8->setBrand('Panerai');
        $watch8->setModel('Luminor');
        $watch8->setPrice(7000);
        $watch8->setDescription('A diver watch with Italian heritage.');
        $watch8->setImage('luminor.png');
        $watch8->setWatchBox($diverBox);
        $manager->persist($watch8);

        // Génération des données de test pour les Membres
        foreach ($this->membersGenerator() as [$email, $plainPassword]) {
            $user = new Member();
            $password = $this->hasher->hashPassword($user, $plainPassword);
            $user->setEmail($email);
            $user->setPassword($password);

            $manager->persist($user);
        }

        // Sauvegarder toutes les entités dans la base de données
        $manager->flush();
    }
}
