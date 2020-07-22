<?php
namespace App\App\Doctrine\DataFixtures;

use App\App\Doctrine\Entity\Device;
use App\App\Doctrine\Entity\Division;
use App\App\Doctrine\Repository\DivisionRepository;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class DeviceFixtures
 * @package App\App\Doctrine\DataFixtures
 */
class DeviceFixtures extends Fixture implements DependentFixtureInterface
{
    public const DEVICE_TEST_REFERENCE = 'device-test';
    public const DEVICE_TEST_2 = 'device-test-2';
    public const DEVICE_TEST_3 = 'device-test-3';
    public const DEVICE_TEST_4 = 'device-test-4';
    public const DEVICE_TEST_5 = 'device-test-5';
    public const DEVICE_TEST_6 = 'device-test-6';
    public const DEVICE_TEST_7 = 'device-test-7';
    public const DEVICE_TEST_8 = 'device-test-8';
    public const DEVICE_TEST_9 = 'device-test-9';
    public const DEVICE_TEST_10 = 'device-test-10';
    public const DEVICE_TEST_11 = 'device-test-11';
    public const DEVICE_TEST_12 = 'device-test-12';
    public const DEVICE_TEST_13 = 'device-test-13';
    public const DEVICE_TEST_14 = 'device-test-14';
    public const DEVICE_TEST_15 = 'device-test-15';
    public const DEVICE_TEST_16 = 'device-test-16';
    public const DEVICE_TEST_17 = 'device-test-17';
    public const DEVICE_TEST_18 = 'device-test-18';
    public const DEVICE_TEST_19 = 'device-test-19';
    public const DEVICE_TEST_20 = 'device-test-20';
    public const DEVICE_TEST_21 = 'device-test-21';
    public const DEVICE_TEST_22 = 'device-test-22';
    public const DEVICE_TEST_23 = 'device-test-23';
    public const DEVICE_TEST_24 = 'device-test-24';
    public const DEVICE_TEST_25 = 'device-test-25';
    public const DEVICE_TEST_26 = 'device-test-26';
    public const DEVICE_TEST_27 = 'device-test-27';
    public const DEVICE_TEST_28 = 'device-test-28';
    public const DEVICE_TEST_29 = 'device-test-29';
    public const DEVICE_TEST_30 = 'device-test-30';
    public const DEVICE_TEST_31 = 'device-test-31';
    public const DEVICE_TEST_32 = 'device-test-32';
    public const DEVICE_TEST_33 = 'device-test-33';
    public const DEVICE_TEST_34 = 'device-test-34';
    public const DEVICE_TEST_35 = 'device-test-35';
    public const DEVICE_TEST_36 = 'device-test-36';
    public const DEVICE_TEST_37 = 'device-test-37';

    /**
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        /** @var DivisionRepository $divisionRepository */
        $divisionRepository = $manager->getRepository("App:Division");
        /** @var Division $id1backflow */
        $id1backflow = $divisionRepository->findOneBy(["alias" => "backflow"]);
        /** @var Division $id2fire */
        $id2fire = $divisionRepository->findOneBy(["alias" => "fire"]);
        /** @var Division $id3plumbing */
        $id3plumbing = $divisionRepository->findOneBy(["alias" => "plumbing"]);
        /** @var Division $id4alarmDivision */
        $id4alarmDivision = $divisionRepository->findOneBy(["alias" => "alarm"]);

        $device = new Device();
        $device->setId("63bea125-46f1-4d59-b6ec-65000d13ac1f");
        $device->setName("Sprinkler");
        $device->setAlias('test_alias');
        $device->setCreatedAt(new DateTime("@1573833585"));
        $device->setUpdatedAt(new DateTime("@1573833585"));
        $device->setDivision($id4alarmDivision);
        $device->setDescription("test description");
        $device->setLevel(1);
        $device->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($device);
        $this->addReference(self::DEVICE_TEST_REFERENCE, $device);

        $device2 = new Device();
        $device2->setId('16621514-7ef0-4b1f-92d2-bd020de59551');
        $device2->setDivision($id3plumbing);
        $device2->setName("Lift Station");
        $device2->setAlias("lift_station");
        $device2->setLevel(0);
        $device2->setUpdatedAt(new DateTime());
        $device2->setCreatedAt(new DateTime());
        $device2->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device2->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($device2);
        $this->addReference(self::DEVICE_TEST_2, $device2);

        $device3 = new Device();
        $device3->setId('cdc6b2fc-3e53-46da-a98b-fe9006c568e1');
        $device3->setDivision($id3plumbing);
        $device3->setName("Water Heater");
        $device3->setAlias("water_heater");
        $device3->setLevel(0);
        $device3->setUpdatedAt(new DateTime());
        $device3->setCreatedAt(new DateTime());
        $device3->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device3->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($device3);
        $this->addReference(self::DEVICE_TEST_3, $device3);

        $device4 = new Device();
        $device4->setId('69b4d80d-1223-4fad-8ca2-012b2bbaafd1');
        $device4->setDivision($id2fire);
        $device4->setName("Fire Sprinkler System");
        $device4->setAlias("fire_sprinkler_system");
        $device4->setLevel(0);
        $device4->setUpdatedAt(new DateTime());
        $device4->setCreatedAt(new DateTime());
        $device4->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device4->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($device4);
        $this->addReference(self::DEVICE_TEST_4, $device4);

        $device5 = new Device();
        $device5->setId('1fede5a0-9150-4cfa-b30e-b2cb539873e0');
        $device5->setDivision($id2fire);
        $device5->setName("Fire Pump");
        $device5->setAlias("fire_pump");
        $device5->setLevel(0);
        $device5->setUpdatedAt(new DateTime());
        $device5->setCreatedAt(new DateTime());
        $device5->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device5->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($device5);
        $this->addReference(self::DEVICE_TEST_5, $device5);

        $device6 = new Device();
        $device6->setId('081a5bbd-d5fe-4838-867e-5b7e3af7bf91');
        $device6->setDivision($id1backflow);
        $device6->setName("Backflow Device");
        $device6->setAlias("backflow_device");
        $device6->setLevel(0);
        $device6->setUpdatedAt(new DateTime());
        $device6->setCreatedAt(new DateTime());
        $device6->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device6->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($device6);
        $this->addReference(self::DEVICE_TEST_6, $device6);

        $device7 = new Device();
        $device7->setId('130c932a-2201-4c61-bb54-fb984de34762');
        $device7->setDivision($id2fire);
        $device7->setName("Fire Extinguisher(s)");
        $device7->setAlias("fire_extinguishers");
        $device7->setLevel(0);
        $device7->setUpdatedAt(new DateTime());
        $device7->setCreatedAt(new DateTime());
        $device7->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device7->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($device7);
        $this->addReference(self::DEVICE_TEST_7, $device7);

        $device8 = new Device();
        $device8->setId('4645c4aa-26c3-49cf-a4fe-9c720c73f6d9');
        $device8->setDivision($id2fire);
        $device8->setName("Antifreeze System");
        $device8->setAlias("anti_freeze_system");
        $device8->setLevel(1);
        $device8->setUpdatedAt(new DateTime());
        $device8->setCreatedAt(new DateTime());
        $device8->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device8->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device8->setParent($device4);
        $manager->persist($device8);
        $this->addReference(self::DEVICE_TEST_8, $device8);

        $device9 = new Device();
        $device9->setId('a1bfa48f-29c8-4b7f-aa0a-f1a8ffce8015');
        $device9->setDivision($id2fire);
        $device9->setName("Fire Extinguisher");
        $device9->setAlias("fire_extinguisher");
        $device9->setLevel(0);
        $device9->setUpdatedAt(new DateTime());
        $device9->setCreatedAt(new DateTime());
        $device9->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device9->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device9->setParent($device7);
        $manager->persist($device9);
        $this->addReference(self::DEVICE_TEST_9, $device9);

        $device10 = new Device();
        $device10->setId('ff951ac5-8360-487c-b975-3a896da4c1cc');
        $device10->setDivision($id2fire);
        $device10->setName("Deluge System");
        $device10->setAlias("deluge_system");
        $device10->setLevel(1);
        $device10->setUpdatedAt(new DateTime());
        $device10->setCreatedAt(new DateTime());
        $device10->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device10->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device10->setParent($device4);
        $manager->persist($device10);
        $this->addReference(self::DEVICE_TEST_10, $device10);

        $device11 = new Device();
        $device11->setId('def2e2a0-8bd4-484b-a62c-ff070b144c0c');
        $device11->setDivision($id2fire);
        $device11->setName("Dry Valve System");
        $device11->setAlias("dry_valve_system");
        $device11->setLevel(1);
        $device11->setUpdatedAt(new DateTime());
        $device11->setCreatedAt(new DateTime());
        $device11->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device11->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device11->setParent($device4);
        $manager->persist($device11);
        $this->addReference(self::DEVICE_TEST_11, $device11);

        $device12 = new Device();
        $device12->setId('7e928bcb-de19-47fb-8f61-5e2def79f6ad');
        $device12->setDivision($id2fire);
        $device12->setName("FDC Check Valve");
        $device12->setAlias("fdc_check_valve");
        $device12->setLevel(1);
        $device12->setUpdatedAt(new DateTime());
        $device12->setCreatedAt(new DateTime());
        $device12->setParent($device4);
        $device12->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device12->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($device12);
        $this->addReference(self::DEVICE_TEST_12, $device12);

        $device13 = new Device();
        $device13->setId('0456cf66-177f-4186-8978-d332102b31ff');
        $device13->setDivision($id2fire);
        $device13->setName("Fire Alarm Control Panel (FACP)");
        $device13->setAlias("fire_alarm_control_panel");
        $device13->setLevel(0);
        $device13->setUpdatedAt(new DateTime());
        $device13->setCreatedAt(new DateTime());
        $device13->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device13->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($device13);
        $this->addReference(self::DEVICE_TEST_13, $device13);

        $device14 = new Device();
        $device14->setId('90824efb-214c-4885-a344-b3d998a1db1e');
        $device14->setDivision($id2fire);
        $device14->setName("Standpipe System");
        $device14->setAlias("standpipe_system");
        $device14->setLevel(1);
        $device14->setUpdatedAt(new DateTime());
        $device14->setCreatedAt(new DateTime());
        $device14->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device14->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device14->setParent($device4);
        $manager->persist($device14);
        $this->addReference(self::DEVICE_TEST_14, $device14);

        $device15 = new Device();
        $device15->setId('c74a4333-5932-43d9-b907-b008909b78ab');
        $device15->setDivision($id2fire);
        $device15->setName("Pre-Action System");
        $device15->setAlias("pre_action_system");
        $device15->setLevel(1);
        $device15->setUpdatedAt(new DateTime());
        $device15->setCreatedAt(new DateTime());
        $device15->setParent($device4);
        $device15->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device15->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($device15);
        $this->addReference(self::DEVICE_TEST_15, $device15);

        $device16 = new Device();
        $device16->setId('23c23f47-bc7c-4b53-b502-1f4299783ded');
        $device16->setDivision($id2fire);
        $device16->setName("Pre-Engineered Fire Suppression System");
        $device16->setAlias("pre_engineered_fire_suppression_system");
        $device16->setLevel(0);
        $device16->setUpdatedAt(new DateTime());
        $device16->setCreatedAt(new DateTime());
        $device16->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device16->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($device16);
        $this->addReference(self::DEVICE_TEST_16, $device16);

        $device17 = new Device();
        $device17->setId('182e62ef-f7ac-4854-b575-0023a8732cff');
        $device17->setDivision($id2fire);
        $device17->setName("Riser");
        $device17->setAlias("riser");
        $device17->setLevel(1);
        $device17->setUpdatedAt(new DateTime());
        $device17->setCreatedAt(new DateTime());
        $device17->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device17->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device17->setParent($device4);
        $manager->persist($device17);
        $this->addReference(self::DEVICE_TEST_17, $device17);

        $device18 = new Device();
        $device18->setId('cb501c23-cb8a-4fc7-977e-a953c86f3069');
        $device18->setDivision($id2fire);
        $device18->setName("Section");
        $device18->setAlias("section");
        $device18->setLevel(1);
        $device18->setUpdatedAt(new DateTime());
        $device18->setCreatedAt(new DateTime());
        $device18->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device18->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device18->setParent($device4);
        $manager->persist($device18);
        $this->addReference(self::DEVICE_TEST_18, $device18);

        $device19 = new Device();
        $device19->setId('c93de04c-f545-4d54-8d73-0a8482325f87');
        $device19->setDivision($id2fire);
        $device19->setName("Low Point");
        $device19->setAlias("low_point");
        $device19->setLevel(2);
        $device19->setUpdatedAt(new DateTime());
        $device19->setCreatedAt(new DateTime());
        $device19->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device19->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device19->setParent($device11);
        $manager->persist($device19);
        $this->addReference(self::DEVICE_TEST_19, $device19);

        $device20 = new Device();
        $device20->setId('ffc1efbe-940c-4b8e-a47a-616c659d4d39');
        $device20->setDivision($id2fire);
        $device20->setName("Air Compressor");
        $device20->setAlias("air_compressor");
        $device20->setLevel(2);
        $device20->setUpdatedAt(new DateTime());
        $device20->setCreatedAt(new DateTime());
        $device20->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device20->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device20->setParent($device11);
        $manager->persist($device20);
        $this->addReference(self::DEVICE_TEST_20, $device20);

        $device21 = new Device();
        $device21->setId('39234673-c21f-4126-9f73-b6e3f368cabb');
        $device21->setDivision($id2fire);
        $device21->setName("EM Light(s)");
        $device21->setAlias("em_lights");
        $device21->setLevel(0);
        $device21->setUpdatedAt(new DateTime());
        $device21->setCreatedAt(new DateTime());
        $device21->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device21->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($device21);
        $this->addReference(self::DEVICE_TEST_21, $device21);

        $device22 = new Device();
        $device22->setId('a5dd8123-d6bf-45bb-8330-7636d2e1185d');
        $device22->setDivision($id2fire);
        $device22->setName("EM Light");
        $device22->setAlias("em_light");
        $device22->setLevel(1);
        $device22->setUpdatedAt(new DateTime());
        $device22->setCreatedAt(new DateTime());
        $device22->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device22->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device22->setParent($device21);
        $manager->persist($device22);
        $this->addReference(self::DEVICE_TEST_22, $device22);

        $device23 = new Device();
        $device23->setId('0eb808c7-e54a-4883-94ad-55ca3fe97a67');
        $device23->setDivision($id3plumbing);
        $device23->setName("General Plumbing");
        $device23->setAlias("general_plumbing");
        $device23->setLevel(0);
        $device23->setUpdatedAt(new DateTime());
        $device23->setCreatedAt(new DateTime());
        $device23->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device23->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($device23);
        $this->addReference(self::DEVICE_TEST_23, $device23);

        $device24 = new Device();
        $device24->setId('bb14b073-46df-4a36-a4fe-5b9d3a27dc86');
        $device24->setDivision($id2fire);
        $device24->setName("Exit Light(s)");
        $device24->setAlias("exit_light_s");
        $device24->setLevel(0);
        $device24->setUpdatedAt(new DateTime());
        $device24->setCreatedAt(new DateTime());
        $device24->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device24->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($device24);
        $this->addReference(self::DEVICE_TEST_24, $device24);

        $device25 = new Device();
        $device25->setId('04eeff15-d30b-4a28-9c6c-52697c56d161');
        $device25->setDivision($id2fire);
        $device25->setName("Exit Light");
        $device25->setAlias("exit_light");
        $device25->setLevel(1);
        $device25->setUpdatedAt(new DateTime());
        $device25->setCreatedAt(new DateTime());
        $device25->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device25->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device25->setParent($device24);
        $manager->persist($device25);
        $this->addReference(self::DEVICE_TEST_25, $device25);

        $device26 = new Device();
        $device26->setId('ae3253ab-272e-4ad4-b409-37b892a5462e');
        $device26->setDivision($id2fire);
        $device26->setName("Jockey Pump");
        $device26->setAlias("jockey_pump");
        $device26->setLevel(1);
        $device26->setUpdatedAt(new DateTime());
        $device26->setCreatedAt(new DateTime());
        $device26->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device26->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device26->setParent($device5);
        $manager->persist($device26);
        $this->addReference(self::DEVICE_TEST_26, $device26);

        $device27 = new Device();
        $device27->setId('53bf1a97-00cd-4218-906f-5621c667c257');
        $device27->setDivision($id2fire);
        $device27->setName("Fire Hydrant(s)");
        $device27->setAlias("fire_hydrant_s");
        $device27->setLevel(0);
        $device27->setUpdatedAt(new DateTime());
        $device27->setCreatedAt(new DateTime());
        $device27->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device27->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($device27);
        $this->addReference(self::DEVICE_TEST_27, $device27);

        $device28 = new Device();
        $device28->setId('5402b824-bcdf-4592-93d9-580edf4c09bf');
        $device28->setDivision($id2fire);
        $device28->setName("Fire Hydrant");
        $device28->setAlias("fire_hydrant");
        $device28->setLevel(1);
        $device28->setUpdatedAt(new DateTime());
        $device28->setCreatedAt(new DateTime());
        $device28->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device28->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device28->setParent($device27);
        $manager->persist($device28);
        $this->addReference(self::DEVICE_TEST_28, $device28);

        $device29 = new Device();
        $device29->setId('8c8eace7-1320-4564-993c-41d8e96e15d5');
        $device29->setDivision($id2fire);
        $device29->setName("Standpipe System");
        $device29->setAlias("standpipe_system");
        $device29->setLevel(0);
        $device29->setUpdatedAt(new DateTime());
        $device29->setCreatedAt(new DateTime());
        $device29->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device29->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($device29);
        $this->addReference(self::DEVICE_TEST_29, $device29);

        $device30 = new Device();
        $device30->setId('5d14219b-b7b3-443a-87b9-46aa7cefedee');
        $device30->setDivision($id3plumbing);
        $device30->setName("Grease Trap");
        $device30->setAlias("grease_trap");
        $device30->setLevel(0);
        $device30->setUpdatedAt(new DateTime());
        $device30->setCreatedAt(new DateTime());
        $device30->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device30->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($device30);
        $this->addReference(self::DEVICE_TEST_30, $device30);

        $device31 = new Device();
        $device31->setId('37529689-8728-4f7b-b79a-431cf872daaa');
        $device31->setDivision($id2fire);
        $device31->setName("Radio Transceiver");
        $device31->setAlias("radio_transceiver");
        $device31->setLevel(1);
        $device31->setUpdatedAt(new DateTime());
        $device31->setCreatedAt(new DateTime());
        $device31->setParent($device13);
        $device31->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device31->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($device31);
        $this->addReference(self::DEVICE_TEST_31, $device31);

        $device32 = new Device();
        $device32->setId('29462c70-7057-4a24-bfe4-3488f40ec505');
        $device32->setDivision($id2fire);
        $device32->setName("Hydraulic Placard");
        $device32->setAlias("hydraulic_placard");
        $device32->setLevel(1);
        $device32->setUpdatedAt(new DateTime());
        $device32->setCreatedAt(new DateTime());
        $device32->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device32->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device32->setParent($device4);
        $manager->persist($device32);
        $this->addReference(self::DEVICE_TEST_32, $device32);

        $device33 = new Device();
        $device33->setId('c2f46b81-3832-4301-b7c3-1319f9c2d8be');
        $device33->setDivision($id2fire);
        $device33->setName("Engineered Fire Suppression System");
        $device33->setAlias("engineered_fire_suppression_system");
        $device33->setLevel(0);
        $device33->setUpdatedAt(new DateTime());
        $device33->setCreatedAt(new DateTime());
        $device33->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device33->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($device33);
        $this->addReference(self::DEVICE_TEST_33, $device33);

        $device34 = new Device();
        $device34->setId('90d412cc-6100-49cc-874b-e9adcbe53cfc');
        $device34->setDivision($id2fire);
        $device34->setName("Kitchen Exhaust System");
        $device34->setAlias("kitchen_exhaust_system");
        $device34->setLevel(1);
        $device34->setUpdatedAt(new DateTime());
        $device34->setCreatedAt(new DateTime());
        $device34->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device34->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device34->setParent($device16);
        $manager->persist($device34);
        $this->addReference(self::DEVICE_TEST_34, $device34);

        $device35 = new Device();
        $device35->setId('96f3b5e6-c98c-45bd-9f6e-05d6ff3577fe');
        $device35->setDivision($id2fire);
        $device35->setName("Foam System");
        $device35->setAlias("foam_system");
        $device35->setLevel(1);
        $device35->setUpdatedAt(new DateTime());
        $device35->setCreatedAt(new DateTime());
        $device35->setParent($device4);
        $device35->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device35->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($device35);
        $this->addReference(self::DEVICE_TEST_35, $device35);

        $device36 = new Device();
        $device36->setId('912b2e1a-b075-48c8-a8a0-bd2162a3bc0f');
        $device36->setDivision($id2fire);
        $device36->setName("Fire Door");
        $device36->setAlias("fire_door");
        $device36->setLevel(0);
        $device36->setUpdatedAt(new DateTime());
        $device36->setCreatedAt(new DateTime());
        $device36->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device36->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $manager->persist($device36);
        $this->addReference(self::DEVICE_TEST_36, $device36);

        $device37 = new Device();
        $device37->setId('5fd72329-2e8b-4822-905a-be9a84125a83');
        $device37->setDivision($id2fire);
        $device37->setName("NAC Panel");
        $device37->setAlias("nac_panel");
        $device37->setLevel(1);
        $device37->setUpdatedAt(new DateTime());
        $device37->setCreatedAt(new DateTime());
        $device37->setCreatedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device37->setModifiedBy($this->getReference(UserFixtures::USER_MANAGER_TEST_REFERENCE));
        $device37->setParent($device13);
        $manager->persist($device37);
        $this->addReference(self::DEVICE_TEST_37, $device37);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class
        );
    }
}
