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
    public const ADMIN_MEMBER = 'admin_member';

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    private function membersGenerator()
    {
        // Format : [reference, email, password, role]
        yield [self::MEMBER_OLIVIER, 'olivier@localhost', '123456', 'ROLE_USER'];
        yield [self::MEMBER_CYRINE, 'cyrine@localhost', '123456', 'ROLE_USER'];
        yield [self::ADMIN_MEMBER, 'admin@localhost', 'admin123', 'ROLE_ADMIN'];
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->membersGenerator() as [$reference, $email, $plainPassword, $role]) {
            $member = new Member();
            
            $password = $this->hasher->hashPassword($member, $plainPassword);
            $member->setEmail($email);
            $member->setPassword($password);

            $roles = array();
            $roles[] = $role;
            $member->setRoles($roles);

            $this->addReference($reference, $member);

            $manager->persist($member);
        }

        $manager->flush();
    }
}
