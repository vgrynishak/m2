<?php
namespace App\App\Doctrine\DataFixtures;

use App\App\Doctrine\Entity\Service;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class ServiceFixtures
 * @package App\App\Doctrine\DataFixtures
 */
class ServiceFixtures extends Fixture implements DependentFixtureInterface
{
    public const SERVICE_TEST_REFERENCE = 'service-test';

    /**
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $service = new Service();
        $service->setId("63bea125-46f1-4d59-b6ec-65000d13acc1");
        $service->setName("Sprinkler Service");
        $service->setComment("Test Comment");
        $service->setCreatedAt(new DateTime("@1573833636"));
        $service->setUpdatedAt(new DateTime("@1573833636"));
        $service->setCreatedBy($this->getReference(UserFixtures::USER_ADMIN_TEST_REFERENCE));
        $service->setModifiedBy($this->getReference(UserFixtures::USER_ADMIN_TEST_REFERENCE));
        $service->setDevice($this->getReference(DeviceFixtures::DEVICE_TEST_REFERENCE));
        $service->setFacility($this->getReference(FacilityFixtures::FACILITY_TEST_REFERENCE));
        $manager->persist($service);
        $manager->flush();
        $this->addReference(self::SERVICE_TEST_REFERENCE, $service);
    }

    /**
     * @return array
     */
    public function getDependencies()
    {
        return array(
            DeviceFixtures::class,
        );
    }
}
