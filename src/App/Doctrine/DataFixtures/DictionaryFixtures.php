<?php

namespace App\App\Doctrine\DataFixtures;

use App\App\Doctrine\Entity\Item\Dictionary;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DictionaryFixtures extends Fixture
{
    public const DICTIONARY_TEST_1 = 'dictionary-test-1';
    public const DICTIONARY_TEST_2 = 'dictionary_test-2';
    public const DICTIONARY_TEST_3 = 'dictionary_test-3';
    public const DICTIONARY_TEST_4 = 'dictionary_test-4';
    public const DICTIONARY_TEST_5 = 'dictionary_test-5';
    public const DICTIONARY_TEST_6 = 'dictionary_test-6';
    public const DICTIONARY_TEST_7 = 'dictionary_test-7';
    public const DICTIONARY_TEST_8 = 'dictionary_test-8';
    public const DICTIONARY_TEST_9 = 'dictionary_test-9';
    public const DICTIONARY_TEST_10 = 'dictionary-test-10';
    public const DICTIONARY_TEST_11 = 'dictionary-test-11';
    public const DICTIONARY_TEST_12 = 'dictionary-test-12';
    public const DICTIONARY_TEST_13 = 'dictionary-test-13';
    public const DICTIONARY_TEST_14 = 'dictionary-test-14';
    public const DICTIONARY_TEST_15 = 'dictionary-test-15';
    public const DICTIONARY_TEST_16 = 'dictionary-test-16';
    public const DICTIONARY_TEST_17 = 'dictionary-test-17';
    public const DICTIONARY_TEST_18 = 'dictionary-test-18';
    public const DICTIONARY_TEST_19 = 'dictionary-test-19';
    public const DICTIONARY_TEST_20 = 'dictionary-test-20';
    public const DICTIONARY_TEST_21 = 'dictionary-test-21';
    public const DICTIONARY_TEST_22 = 'dictionary-test-22';
    public const DICTIONARY_TEST_23 = 'dictionary-test-23';
    public const DICTIONARY_TEST_24 = 'dictionary-test-24';
    public const DICTIONARY_TEST_25 = 'dictionary-test-25';
    public const DICTIONARY_TEST_26 = 'dictionary-test-26';
    public const DICTIONARY_TEST_27 = 'dictionary-test-27';
    public const DICTIONARY_TEST_28 = 'dictionary-test-28';
    public const DICTIONARY_TEST_29 = 'dictionary-test-29';
    public const DICTIONARY_TEST_30 = 'dictionary-test-30';
    public const DICTIONARY_TEST_31 = 'dictionary-test-31';
    public const DICTIONARY_TEST_32 = 'dictionary-test-32';
    public const DICTIONARY_TEST_33 = 'dictionary-test-33';
    public const DICTIONARY_TEST_34 = 'dictionary-test-34';
    public const DICTIONARY_TEST_35 = 'dictionary-test-35';
    public const DICTIONARY_TEST_36 = 'dictionary-test-36';
    public const DICTIONARY_TEST_37 = 'dictionary-test-37';
    public const DICTIONARY_TEST_38 = 'dictionary-test-38';

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $dictionary34 = (new Dictionary())
            ->setId("63bea125-46f1-4d59-b6ec-65000d13ac1f")
            ->setName("Sprinkler dictionary");
        $manager->persist($dictionary34);
        $this->addReference(self::DICTIONARY_TEST_1, $dictionary34);

        $dictionary2 = (new Dictionary())
            ->setId("16621514-7ef0-4b1f-92d2-bd020de59551")
            ->setName("Lift Station dictionary");
        $manager->persist($dictionary2);
        $this->addReference(self::DICTIONARY_TEST_2, $dictionary2);

        $dictionary34 = (new Dictionary())
            ->setId("cdc6b2fc-3e53-46da-a98b-fe9006c568e1")
            ->setName("Water Heater dictionary");
        $manager->persist($dictionary34);
        $this->addReference(self::DICTIONARY_TEST_3, $dictionary34);

        $dictionary4 = (new Dictionary())
            ->setId("69b4d80d-1223-4fad-8ca2-012b2bbaafd1")
            ->setName("Fire Sprinkler System dictionary");
        $manager->persist($dictionary4);
        $this->addReference(self::DICTIONARY_TEST_4, $dictionary4);


        $dictionary5 = (new Dictionary())
            ->setId("1fede5a0-9150-4cfa-b30e-b2cb539873e0")
            ->setName("Fire Pump dictionary");
        $manager->persist($dictionary5);
        $this->addReference(self::DICTIONARY_TEST_5, $dictionary5);

        $dictionary6 = (new Dictionary())
            ->setId("081a5bbd-d5fe-4838-867e-5b7e3af7bf91")
            ->setName("Backflow Device dictionary");
        $manager->persist($dictionary6);
        $this->addReference(self::DICTIONARY_TEST_6, $dictionary6);

        $dictionary7 = (new Dictionary())
            ->setId("130c932a-2201-4c61-bb54-fb984de34762")
            ->setName("Fire Extinguisher(s) dictionary");
        $manager->persist($dictionary7);
        $this->addReference(self::DICTIONARY_TEST_7, $dictionary7);

        $dictionary8 = (new Dictionary())
            ->setId("4645c4aa-26c3-49cf-a4fe-9c720c73f6d9")
            ->setName("Antifreeze System dictionary");
        $manager->persist($dictionary8);
        $this->addReference(self::DICTIONARY_TEST_8, $dictionary8);

        $dictionary9 = (new Dictionary())
            ->setId("a1bfa48f-29c8-4b7f-aa0a-f1a8ffce8015")
            ->setName("Fire Extinguisher dictionary");
        $manager->persist($dictionary9);
        $this->addReference(self::DICTIONARY_TEST_9, $dictionary9);

        $dictionary10 = new Dictionary();
        $dictionary10->setId('ff951ac5-8360-487c-b975-3a896da4c1cc');
        $dictionary10->setName("Deluge System");
        $manager->persist($dictionary10);
        $this->addReference(self::DICTIONARY_TEST_10, $dictionary10);

        $dictionary11 = new Dictionary();
        $dictionary11->setId('def2e2a0-8bd4-484b-a62c-ff070b144c0c');
        $dictionary11->setName("Dry Valve System");
        $manager->persist($dictionary11);
        $this->addReference(self::DICTIONARY_TEST_11, $dictionary11);

        $dictionary12 = new Dictionary();
        $dictionary12->setId('7e928bcb-de19-47fb-8f61-5e2def79f6ad');
        $dictionary12->setName("FDC Check Valve");
        $manager->persist($dictionary12);
        $this->addReference(self::DICTIONARY_TEST_12, $dictionary12);

        $dictionary13 = new Dictionary();
        $dictionary13->setId('0456cf66-177f-4186-8978-d332102b31ff');
        $dictionary13->setName("Fire Alarm Control Panel (FACP)");
        $manager->persist($dictionary13);
        $this->addReference(self::DICTIONARY_TEST_13, $dictionary13);

        $dictionary14 = new Dictionary();
        $dictionary14->setId('90824efb-214c-4885-a344-b3d998a1db1e');
        $dictionary14->setName("Standpipe System");
        $manager->persist($dictionary14);
        $this->addReference(self::DICTIONARY_TEST_14, $dictionary14);

        $dictionary15 = new Dictionary();
        $dictionary15->setId('c74a4333-5932-43d9-b907-b008909b78ab');
        $dictionary15->setName("Pre-Action System");
        $manager->persist($dictionary15);
        $this->addReference(self::DICTIONARY_TEST_15, $dictionary15);

        $dictionary16 = new Dictionary();
        $dictionary16->setId('23c23f47-bc7c-4b53-b502-1f4299783ded');
        $dictionary16->setName("Pre-Engineered Fire Suppression System");
        $manager->persist($dictionary16);
        $this->addReference(self::DICTIONARY_TEST_16, $dictionary16);

        $dictionary17 = new Dictionary();
        $dictionary17->setId('182e62ef-f7ac-4854-b575-0023a8732cff');
        $dictionary17->setName("Riser");
        $manager->persist($dictionary17);
        $this->addReference(self::DICTIONARY_TEST_17, $dictionary17);

        $dictionary18 = new Dictionary();
        $dictionary18->setId('cb501c23-cb8a-4fc7-977e-a953c86f3069');
        $dictionary18->setName("Section");
        $manager->persist($dictionary18);
        $this->addReference(self::DICTIONARY_TEST_18, $dictionary18);

        $dictionary19 = new Dictionary();
        $dictionary19->setId('c93de04c-f545-4d54-8d73-0a8482325f87');
        $dictionary19->setName("Low Point");
        $manager->persist($dictionary19);
        $this->addReference(self::DICTIONARY_TEST_19, $dictionary19);

        $dictionary20 = new Dictionary();
        $dictionary20->setId('ffc1efbe-940c-4b8e-a47a-616c659d4d39');
        $dictionary20->setName("Air Compressor");
        $manager->persist($dictionary20);
        $this->addReference(self::DICTIONARY_TEST_20, $dictionary20);

        $dictionary21 = new Dictionary();
        $dictionary21->setId('39234673-c21f-4126-9f73-b6e3f368cabb');
        $dictionary21->setName("EM Light(s)");
        $this->addReference(self::DICTIONARY_TEST_21, $dictionary21);

        $dictionary22 = new Dictionary();
        $dictionary22->setId('a5dd8123-d6bf-45bb-8330-7636d2e1185d');
        $dictionary22->setName("EM Light");
        $manager->persist($dictionary22);
        $this->addReference(self::DICTIONARY_TEST_22, $dictionary22);

        $dictionary23 = new Dictionary();
        $dictionary23->setId('0eb808c7-e54a-4883-94ad-55ca3fe97a67');
        $dictionary23->setName("General Plumbing");
        $manager->persist($dictionary23);
        $this->addReference(self::DICTIONARY_TEST_23, $dictionary23);

        $dictionary24 = new Dictionary();
        $dictionary24->setId('bb14b073-46df-4a36-a4fe-5b9d3a27dc86');
        $dictionary24->setName("Exit Light(s)");
        $manager->persist($dictionary24);
        $this->addReference(self::DICTIONARY_TEST_24, $dictionary24);

        $dictionary25 = new Dictionary();
        $dictionary25->setId('04eeff15-d30b-4a28-9c6c-52697c56d161');
        $dictionary25->setName("Exit Light");
        $manager->persist($dictionary25);
        $this->addReference(self::DICTIONARY_TEST_25, $dictionary25);

        $dictionary26 = new Dictionary();
        $dictionary26->setId('ae3253ab-272e-4ad4-b409-37b892a5462e');
        $dictionary26->setName("Jockey Pump");
        $manager->persist($dictionary26);
        $this->addReference(self::DICTIONARY_TEST_26, $dictionary26);

        $dictionary27 = new Dictionary();
        $dictionary27->setId('53bf1a97-00cd-4218-906f-5621c667c257');
        $dictionary27->setName("Fire Hydrant(s)");
        $manager->persist($dictionary27);
        $this->addReference(self::DICTIONARY_TEST_27, $dictionary27);

        $dictionary28 = new Dictionary();
        $dictionary28->setId('5402b824-bcdf-4592-93d9-580edf4c09bf');
        $dictionary28->setName("Fire Hydrant");
        $manager->persist($dictionary28);
        $this->addReference(self::DICTIONARY_TEST_28, $dictionary28);

        $dictionary29 = new Dictionary();
        $dictionary29->setId('8c8eace7-1320-4564-993c-41d8e96e15d5');
        $dictionary29->setName("Standpipe System");
        $manager->persist($dictionary29);
        $this->addReference(self::DICTIONARY_TEST_29, $dictionary29);

        $dictionary30 = new Dictionary();
        $dictionary30->setId('5d14219b-b7b3-443a-87b9-46aa7cefedee');
        $dictionary30->setName("Grease Trap");
        $manager->persist($dictionary30);
        $this->addReference(self::DICTIONARY_TEST_30, $dictionary30);

        $dictionary31 = new Dictionary();
        $dictionary31->setId('37529689-8728-4f7b-b79a-431cf872daaa');
        $dictionary31->setName("Radio Transceiver");
        $manager->persist($dictionary31);
        $this->addReference(self::DICTIONARY_TEST_31, $dictionary31);

        $dictionary32 = new Dictionary();
        $dictionary32->setId('29462c70-7057-4a24-bfe4-3488f40ec505');
        $dictionary32->setName("Hydraulic Placard");
        $manager->persist($dictionary32);
        $this->addReference(self::DICTIONARY_TEST_32, $dictionary32);

        $dictionary33 = new Dictionary();
        $dictionary33->setId('c2f46b81-3832-4301-b7c3-1319f9c2d8be');
        $dictionary33->setName("Engineered Fire Suppression System");
        $manager->persist($dictionary33);
        $this->addReference(self::DICTIONARY_TEST_33, $dictionary33);

        $dictionary34 = new Dictionary();
        $dictionary34->setId('90d412cc-6100-49cc-874b-e9adcbe53cfc');
        $dictionary34->setName("Kitchen Exhaust System");
        $manager->persist($dictionary34);
        $this->addReference(self::DICTIONARY_TEST_34, $dictionary34);

        $dictionary35 = new Dictionary();
        $dictionary35->setId('96f3b5e6-c98c-45bd-9f6e-05d6ff3577fe');
        $dictionary35->setName("Foam System");
        $manager->persist($dictionary35);
        $this->addReference(self::DICTIONARY_TEST_35, $dictionary35);

        $dictionary36 = new Dictionary();
        $dictionary36->setId('912b2e1a-b075-48c8-a8a0-bd2162a3bc0f');
        $dictionary36->setName("Fire Door");
        $manager->persist($dictionary36);
        $this->addReference(self::DICTIONARY_TEST_36, $dictionary36);

        $dictionary37 = new Dictionary();
        $dictionary37->setId('5fd72329-2e8b-4822-905a-be9a84125a83');
        $dictionary37->setName("Fire Door");
        $manager->persist($dictionary37);
        $this->addReference(self::DICTIONARY_TEST_37, $dictionary37);

        $dictionary38 = new Dictionary();
        $dictionary38->setId('misc_information');
        $dictionary38->setName("Misc Information");
        $manager->persist($dictionary38);
        $this->addReference(self::DICTIONARY_TEST_38, $dictionary38);

        $manager->flush();


        $manager->flush();
    }
}
