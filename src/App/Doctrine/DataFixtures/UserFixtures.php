<?php

namespace App\App\Doctrine\DataFixtures;

use App\App\Doctrine\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class UserFixtures
 *
 * @package App\DataFixtures
 */
class UserFixtures extends Fixture
{
    public const USER_ADMIN_TEST_REFERENCE = 'user-admin-test';
    public const USER_MANAGER_TEST_REFERENCE = 'user-manager-test';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $adminUser = new User();
        $adminUser->setEmail("admin@test.com");
        $adminUser->setFirstName("admin");
        $adminUser->setLastName("admin");
        $adminUser->setPlainPassword("qwerty");
        $adminUser->setUsername("admin@test.com");
        $adminUser->setRoles(["ROLE_SUPER_ADMIN"]);
        $adminUser->setEnabled(1);
        $manager->persist($adminUser);
        $this->addReference(self::USER_ADMIN_TEST_REFERENCE, $adminUser);


        $managerUser = new User();
        $managerUser->setEmail("manager@gmail.com");
        $managerUser->setPlainPassword("11111");
        $managerUser->setUsername("manager");
        $managerUser->setFirstName("manager");
        $managerUser->setLastName("manager");
        $managerUser->setRoles(["ROLE_USER"]);
        $managerUser->setEnabled(1);
        $manager->persist($managerUser);
        $this->addReference(self::USER_MANAGER_TEST_REFERENCE, $managerUser);

        $manager->flush();
    }
}
