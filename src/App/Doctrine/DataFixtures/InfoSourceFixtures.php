<?php

namespace App\App\Doctrine\DataFixtures;

use App\App\Doctrine\Entity\Item\InfoSource;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class InfoSourceFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $ddf1 = new InfoSource();
        $ddf1->setId('backflow_size');
        $ddf1->setName('Size');
        $ddf1->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_6));
        $manager->persist($ddf1);

        $ddf2 = new InfoSource();
        $ddf2->setId('backflow_make');
        $ddf2->setName('Make');
        $ddf2->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_6));
        $manager->persist($ddf2);

        $ddf3 = new InfoSource();
        $ddf3->setId('backflow_model');
        $ddf3->setName('Model');
        $ddf3->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_6));
        $manager->persist($ddf3);

        $ddf4 = new InfoSource();
        $ddf4->setId('backflow_type');
        $ddf4->setName('Type');
        $ddf4->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_6));
        $manager->persist($ddf4);

        $ddf5 = new InfoSource();
        $ddf5->setId('backflow_serial_number');
        $ddf5->setName('Serial Number');
        $ddf5->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_6));
        $manager->persist($ddf5);

        $ddf6 = new InfoSource();
        $ddf6->setId('backflow_hazard');
        $ddf6->setName('Hazard');
        $ddf6->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_6));
        $manager->persist($ddf6);

        $ddf7 = new InfoSource();
        $ddf7->setId('backflow_orientation');
        $ddf7->setName('Orientation');
        $ddf7->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_6));
        $manager->persist($ddf7);

        $ddf8 = new InfoSource();
        $ddf8->setId('backflow_shut_off_valve');
        $ddf8->setName('Shut Off Valve(s)');
        $ddf8->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_6));
        $manager->persist($ddf8);

        $ddf9 = new InfoSource();
        $ddf9->setId('backflow_approved_installation');
        $ddf9->setName('Approved Installation');
        $ddf9->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_6));
        $manager->persist($ddf9);

        $ddf10 = new InfoSource();
        $ddf10->setId('fire_sprinkler_system_size');
        $ddf10->setName('Size');
        $ddf10->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_4));
        $manager->persist($ddf10);

        $ddf11 = new InfoSource();
        $ddf11->setId('fire_sprinkler_system_number_of_risers');
        $ddf11->setName('Number of Risers');
        $ddf11->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_4));
        $manager->persist($ddf11);

        $ddf12 = new InfoSource();
        $ddf12->setId('fire_sprinkler_system_number_of_sections');
        $ddf12->setName('Number of Sections');
        $ddf12->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_4));
        $manager->persist($ddf12);

        $ddf13 = new InfoSource();
        $ddf13->setId('fire_sprinkler_system_water_supply_source');
        $ddf13->setName('Water Supply Source');
        $ddf13->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_4));
        $manager->persist($ddf13);

        $ddf14 = new InfoSource();
        $ddf14->setId('fire_sprinkler_system_number_of_heads');
        $ddf14->setName('Number of heads');
        $ddf14->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_4));
        $manager->persist($ddf14);

        $ddf15 = new InfoSource();
        $ddf15->setId('fire_pump_shaft');
        $ddf15->setName('Shaft');
        $ddf15->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_5));
        $manager->persist($ddf15);

        $ddf16 = new InfoSource();
        $ddf16->setId('fire_pump_make');
        $ddf16->setName('Make');
        $ddf16->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_5));
        $manager->persist($ddf16);

        $ddf17 = new InfoSource();
        $ddf17->setId('fire_pump_model');
        $ddf17->setName('Model');
        $ddf17->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_5));
        $manager->persist($ddf17);

        $ddf18 = new InfoSource();
        $ddf18->setId('fire_pump_serial_number');
        $ddf18->setName('Serial Number');
        $ddf18->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_5));
        $manager->persist($ddf18);

        $ddf19 = new InfoSource();
        $ddf19->setId('fire_pump_rated_gpm');
        $ddf19->setName('Rated GPM');
        $ddf19->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_5));
        $manager->persist($ddf19);

        $ddf20 = new InfoSource();
        $ddf20->setId('fire_pump_rated_psi');
        $ddf20->setName('Rated PSI');
        $ddf20->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_5));
        $manager->persist($ddf20);

        $ddf21 = new InfoSource();
        $ddf21->setId('fire_pump_listed');
        $ddf21->setName('Listed');
        $ddf21->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_5));
        $manager->persist($ddf21);

        $ddf22 = new InfoSource();
        $ddf22->setId('fire_pump_approved');
        $ddf22->setName('Approved');
        $ddf22->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_5));
        $manager->persist($ddf22);

        $ddf23 = new InfoSource();
        $ddf23->setId('fire_pump_suction');
        $ddf23->setName('Suction');
        $ddf23->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_5));
        $manager->persist($ddf23);

        $ddf24 = new InfoSource();
        $ddf24->setId('fire_pump_impeller_diameter');
        $ddf24->setName('Impeller Diameter');
        $ddf24->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_5));
        $manager->persist($ddf24);

        $ddf25 = new InfoSource();
        $ddf25->setId('fire_pump_discharge_pipe');
        $ddf25->setName('Discharge Pipe');
        $ddf25->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_5));
        $manager->persist($ddf25);

        $ddf26 = new InfoSource();
        $ddf26->setId('fire_pump_suction_pipe');
        $ddf26->setName('Suction Pipe');
        $ddf26->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_5));
        $manager->persist($ddf26);

        $ddf27 = new InfoSource();
        $ddf27->setId('fire_pump_rotation');
        $ddf27->setName('Rotation');
        $ddf27->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_5));
        $manager->persist($ddf27);

        $ddf28 = new InfoSource();
        $ddf28->setId('fire_pump_test_header_location');
        $ddf28->setName('Test Header Location');
        $ddf28->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_5));
        $manager->persist($ddf28);

        $ddf29 = new InfoSource();
        $ddf29->setId('fire_extinguishers_number_of_extinguishers');
        $ddf29->setName('Number of Extinguishers');
        $ddf29->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_7));
        $manager->persist($ddf29);

        $ddf30 = new InfoSource();
        $ddf30->setId('anti_freeze_size');
        $ddf30->setName('Size');
        $ddf30->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_8));
        $manager->persist($ddf30);

        $ddf31 = new InfoSource();
        $ddf31->setId('anti_freeze_system_type');
        $ddf31->setName('System Type');
        $ddf31->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_8));
        $manager->persist($ddf31);

        $ddf32 = new InfoSource();
        $ddf32->setId('anti_freeze_number_of_heads');
        $ddf32->setName('Number of Heads');
        $ddf32->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_8));
        $manager->persist($ddf32);

        $ddf33 = new InfoSource();
        $ddf33->setId('anti_freeze_water_supply_source');
        $ddf33->setName('Water Supply Source');
        $ddf33->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_8));
        $manager->persist($ddf33);

        $ddf34 = new InfoSource();
        $ddf34->setId('fire_extinguisher_size');
        $ddf34->setName('Size');
        $ddf34->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_9));
        $manager->persist($ddf34);

        $ddf35 = new InfoSource();
        $ddf35->setId('fire_extinguisher_type');
        $ddf35->setName('Type');
        $ddf35->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_9));
        $manager->persist($ddf35);

        $ddf36 = new InfoSource();
        $ddf36->setId('dry_valve_system_size');
        $ddf36->setName('Size');
        $ddf36->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_11));
        $manager->persist($ddf36);

        $ddf37 = new InfoSource();
        $ddf37->setId('dry_valve_system_make');
        $ddf37->setName('Make');
        $ddf37->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_11));
        $manager->persist($ddf37);

        $ddf38 = new InfoSource();
        $ddf38->setId('dry_valve_system_model');
        $ddf38->setName('Model');
        $ddf38->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_11));
        $manager->persist($ddf38);

        $ddf39 = new InfoSource();
        $ddf39->setId('dry_valve_system_serial_number');
        $ddf39->setName('Serial Number');
        $ddf39->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_11));
        $manager->persist($ddf39);

        $ddf40 = new InfoSource();
        $ddf40->setId('dry_valve_system_number_of_low_points');
        $ddf40->setName('Number of Low Points');
        $ddf40->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_11));
        $manager->persist($ddf40);

        $ddf41 = new InfoSource();
        $ddf41->setId('dry_valve_system_water_supply_source');
        $ddf41->setName('Water Supply Source');
        $ddf41->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_11));
        $manager->persist($ddf41);

        $ddf42 = new InfoSource();
        $ddf42->setId('dry_valve_system_itv_location');
        $ddf42->setName('ITV Location');
        $ddf42->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_11));
        $manager->persist($ddf42);

        $ddf43 = new InfoSource();
        $ddf43->setId('fdc_check_valve_size');
        $ddf43->setName('Size');
        $ddf43->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_12));
        $manager->persist($ddf43);

        $ddf44 = new InfoSource();
        $ddf44->setId('fdc_check_valve_make');
        $ddf44->setName('Make');
        $ddf44->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_12));
        $manager->persist($ddf44);

        $ddf45 = new InfoSource();
        $ddf45->setId('fdc_check_valve_connection');
        $ddf45->setName('Connection');
        $ddf45->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_12));
        $manager->persist($ddf45);

        $ddf46 = new InfoSource();
        $ddf46->setId('fdc_check_valve_drain_down');
        $ddf46->setName('Drain Down');
        $ddf46->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_12));
        $manager->persist($ddf46);

        $ddf47 = new InfoSource();
        $ddf47->setId('fire_alarm_control_panel_type');
        $ddf47->setName('Type');
        $ddf47->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_13));
        $manager->persist($ddf47);

        $ddf48 = new InfoSource();
        $ddf48->setId('fire_alarm_control_panel_make');
        $ddf48->setName('Make');
        $ddf48->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_13));
        $manager->persist($ddf48);

        $ddf49 = new InfoSource();
        $ddf49->setId('fire_alarm_control_panel_model');
        $ddf49->setName('Model');
        $ddf49->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_13));
        $manager->persist($ddf49);

        $ddf50 = new InfoSource();
        $ddf50->setId('fire_alarm_control_panel_monitoring_company');
        $ddf50->setName('Monitoring Company');
        $ddf50->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_13));
        $manager->persist($ddf50);

        $ddf51 = new InfoSource();
        $ddf51->setId('fire_alarm_control_panel_passcode');
        $ddf51->setName('Passcode');
        $ddf51->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_13));
        $manager->persist($ddf51);

        $ddf52 = new InfoSource();
        $ddf52->setId('fire_alarm_control_panel_position_number');
        $ddf52->setName('Position Number');
        $ddf52->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_13));
        $manager->persist($ddf52);

        $ddf53 = new InfoSource();
        $ddf53->setId('fire_alarm_control_panel_phone_number');
        $ddf53->setName('Phone Number');
        $ddf53->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_13));
        $manager->persist($ddf53);

        $ddf54 = new InfoSource();
        $ddf54->setId('riser_number');
        $ddf54->setName('Number');
        $ddf54->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_17));
        $manager->persist($ddf54);

        $ddf55 = new InfoSource();
        $ddf55->setId('riser_size');
        $ddf55->setName('Size');
        $ddf55->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_17));
        $manager->persist($ddf55);

        $ddf56 = new InfoSource();
        $ddf56->setId('riser_itv_location');
        $ddf56->setName('ITV Location');
        $ddf56->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_17));
        $manager->persist($ddf56);

        $ddf57 = new InfoSource();
        $ddf57->setId('riser_gauge_size_ips');
        $ddf57->setName('Gauge Size IPS');
        $ddf57->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_17));
        $manager->persist($ddf57);

        $ddf58 = new InfoSource();
        $ddf58->setId('section_number');
        $ddf58->setName('Number');
        $ddf58->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_18));
        $manager->persist($ddf58);

        $ddf59 = new InfoSource();
        $ddf59->setId('section_size');
        $ddf59->setName('Size');
        $ddf59->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_18));
        $manager->persist($ddf59);

        $ddf60 = new InfoSource();
        $ddf60->setId('section_itv_location');
        $ddf60->setName('ITV Location');
        $ddf60->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_18));
        $manager->persist($ddf60);

        $ddf61 = new InfoSource();
        $ddf61->setId('section_gauge_size_ips');
        $ddf61->setName('Gauge Size IPS');
        $ddf61->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_18));
        $manager->persist($ddf61);

        $ddf62 = new InfoSource();
        $ddf62->setId('air_compressor_make');
        $ddf62->setName('Make');
        $ddf62->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_20));
        $manager->persist($ddf62);

        $ddf63 = new InfoSource();
        $ddf63->setId('air_compressor_model');
        $ddf63->setName('Model');
        $ddf63->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_20));
        $manager->persist($ddf63);

        $ddf64 = new InfoSource();
        $ddf64->setId('air_compressor_serial_number');
        $ddf64->setName('Serial Number');
        $ddf64->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_20));
        $manager->persist($ddf64);

        $ddf65 = new InfoSource();
        $ddf65->setId('air_compressor_volts');
        $ddf65->setName('Volts');
        $ddf65->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_20));
        $manager->persist($ddf65);

        $ddf66 = new InfoSource();
        $ddf66->setId('fire_sprinkler_system_number_of_dry_valves');
        $ddf66->setName('Number of Dry Valves');
        $ddf66->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_4));
        $manager->persist($ddf66);

        $ddf67 = new InfoSource();
        $ddf67->setId('test_misc_first');
        $ddf67->setName('First misc');
        $ddf67->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_38));
        $manager->persist($ddf67);

        $ddf68 = new InfoSource();
        $ddf68->setId('test_misc_second');
        $ddf68->setName('Second misc');
        $ddf68->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_38));
        $manager->persist($ddf68);

        $ddf69 = new InfoSource();
        $ddf69->setId('test_misc_third');
        $ddf69->setName('Third Misc');
        $ddf69->setDictionary($this->getReference(DictionaryFixtures::DICTIONARY_TEST_38));
        $manager->persist($ddf69);


        $manager->flush();
    }


    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return array(
            DictionaryFixtures::class,
        );
    }
}
