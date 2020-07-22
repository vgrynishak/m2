<?php

namespace App\App\Doctrine\DataFixtures;

use App\App\Doctrine\Entity\ServiceInstance;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;

class ServiceInstanceFixtures extends Fixture implements DependentFixtureInterface
{
    public const SERVICE_INSTANCE_TEST_ONE = 'service-instance-test-one';

    /**
     * @param ObjectManager $manager
     * @throws Exception
     */
    public function load(ObjectManager $manager)
    {
        $serviceInstanceTestOne = new ServiceInstance();
        $serviceInstanceTestOne->setId('6c614218-3ead-11ea-b77f-2e728ce88125');
        $serviceInstanceTestOne->setService($this->getReference(ServiceFixtures::SERVICE_TEST_REFERENCE));
        $serviceInstanceTestOne->setFacility($this->getReference(FacilityFixtures::FACILITY_TEST_REFERENCE));
        $serviceInstanceTestOne->setCreatedAt(new DateTime("@1574085977"));
        $serviceInstanceTestOne->setUpdatedAt(new DateTime("@1574085977"));
        $serviceInstanceTestOne->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $serviceInstanceTestOne->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($serviceInstanceTestOne);
        $this->addReference(self::SERVICE_INSTANCE_TEST_ONE, $serviceInstanceTestOne);

        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return array(
            FacilityFixtures::class,
            ServiceFixtures::class,
            UserFixtures::class
        );
    }
}
