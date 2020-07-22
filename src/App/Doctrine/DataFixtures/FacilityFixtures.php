<?php

namespace App\App\Doctrine\DataFixtures;

use App\App\Doctrine\Entity\Facility;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;

class FacilityFixtures extends Fixture
{
    public const FACILITY_TEST_REFERENCE = 'facility-test';

    /**
     * @param ObjectManager $manager
     * @throws Exception
     */
    public function load(ObjectManager $manager)
    {
        $facility = new Facility();
        $facility->setId('b0930100-cde5-4318-8d65-0313bae92aa9');
        $facility->setName('Test Account 7');
        $facility->setCreatedAt(new DateTime("@1574085977"));
        $facility->setUpdatedAt(new DateTime("@1574085977"));

        $manager->persist($facility);
        $manager->flush();
        $this->addReference(self::FACILITY_TEST_REFERENCE, $facility);
    }
}
