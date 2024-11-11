<?php
namespace App\DataFixtures;

use App\Entity\Member;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public const MEMBER_OLIVIER = 'member_olivier';
    public const MEMBER_CYRINE = 'member_cyrine';

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    private function membersGenerator()
    {
        yield [self::MEMBER_OLIVIER, 'olivier@localhost', '123456'];
        yield [self::MEMBER_CYRINE, 'cyrine@localhost', '123456'];
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->membersGenerator() as [$reference, $email, $plainPassword]) {
            $member = new Member();
            $password = $this->hasher->hashPassword($member, $plainPassword);
            $member->setEmail($email);
            $member->setPassword($password);
            
            $this->addReference($reference, $member);
            $manager->persist($member);
        }

        $manager->flush();
    }
}
