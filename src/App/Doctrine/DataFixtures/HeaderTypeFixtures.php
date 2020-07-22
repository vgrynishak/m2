<?php

namespace App\App\Doctrine\DataFixtures;

use App\App\Doctrine\Entity\HeaderType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class HeaderTypeFixtures extends Fixture
{
    public const HEADER_TYPE_CUSTOM = 'header-type-custom';
    public const HEADER_TYPE_DEVICE_CARD = 'header-type-device-card';
    public const HEADER_TYPE_NO_HEADER = 'header-type-no-header';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $ht1 = new HeaderType();
        $ht1->setId('custom_title');
        $ht1->setName('Custom title');
        $ht1->setName('Custom title');
        $manager->persist($ht1);
        $this->addReference(self::HEADER_TYPE_CUSTOM, $ht1);

        $ht2 = new HeaderType();
        $ht2->setId('device_card');
        $ht2->setName('Device card');
        $ht2->setName('Device card');
        $manager->persist($ht2);
        $this->addReference(self::HEADER_TYPE_DEVICE_CARD, $ht2);

        $ht3 = new HeaderType();
        $ht3->setId('no_header');
        $ht3->setName('No header');
        $ht3->setName('No header');
        $manager->persist($ht3);
        $this->addReference(self::HEADER_TYPE_NO_HEADER, $ht3);

        $manager->flush();
    }
}
