<?php

namespace App\App\Doctrine\DataFixtures;

use App\App\Doctrine\Entity\DeviceInstance;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;

class DeviceInstanceFixtures extends Fixture implements DependentFixtureInterface
{
    public const DEVICE_INSTANCE_TEST_ONE = 'device-instance-test-one';
    public const DEVICE_INSTANCE_TEST_TWO = 'device-instance-test-two';

    /**
     * @param ObjectManager $manager
     * @throws Exception
     */
    public function load(ObjectManager $manager)
    {
        $deviceInstanceTestOne = new DeviceInstance();
        $deviceInstanceTestOne->setId('d6306c0a-3b9c-11ea-b77f-2e728ce88125');
        $deviceInstanceTestOne->setDevice($this->getReference(DeviceFixtures::DEVICE_TEST_REFERENCE));
        $deviceInstanceTestOne->setFacility($this->getReference(FacilityFixtures::FACILITY_TEST_REFERENCE));
        $deviceInstanceTestOne->setCreatedAt(new DateTime("@1574085977"));
        $deviceInstanceTestOne->setUpdatedAt(new DateTime("@1574085977"));
        $deviceInstanceTestOne->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $deviceInstanceTestOne->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($deviceInstanceTestOne);
        $this->addReference(self::DEVICE_INSTANCE_TEST_ONE, $deviceInstanceTestOne);

        $deviceInstanceTestTwo = new DeviceInstance();
        $deviceInstanceTestTwo->setId('f1d144f4-3c30-11ea-b77f-2e728ce88125');
        $deviceInstanceTestTwo->setDevice($this->getReference(DeviceFixtures::DEVICE_TEST_REFERENCE));
        $deviceInstanceTestTwo->setFacility($this->getReference(FacilityFixtures::FACILITY_TEST_REFERENCE));
        $deviceInstanceTestTwo->setCreatedAt(new DateTime("@1574085977"));
        $deviceInstanceTestTwo->setUpdatedAt(new DateTime("@1574085977"));
        $deviceInstanceTestTwo->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $deviceInstanceTestTwo->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $deviceInstanceTestTwo->setParent($deviceInstanceTestOne);
        $manager->persist($deviceInstanceTestTwo);
        $this->addReference(self::DEVICE_INSTANCE_TEST_TWO, $deviceInstanceTestTwo);


        $manager->flush();
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return array(
            FacilityFixtures::class,
            DeviceFixtures::class,
            UserFixtures::class
        );
    }
}
