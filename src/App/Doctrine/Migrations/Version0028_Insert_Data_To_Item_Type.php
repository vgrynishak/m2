<?php

declare(strict_types=1);

namespace App\App\Doctrine\Migrations;

use App\App\Doctrine\Entity\Group;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version0028_Insert_Data_To_Item_Type extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO item_type (`id`, `name`, `description`, `item_category_id`, `position`) VALUES ('static_text','Static text', 'Static text item', 'static', 2)");
        $this->addSql("INSERT INTO item_type (`id`, `name`, `description`, `item_category_id`, `position`) VALUES ('static_key_value','Custom key-value', 'Static key-value item', 'static', 3)");
        $this->addSql("INSERT INTO item_type (`id`, `name`, `description`, `item_category_id`, `position`) VALUES ('subtitle','Subtitle', 'Subtitle item', 'static', 1)");
        $this->addSql("INSERT INTO item_type (`id`, `name`, `description`, `item_category_id`, `position`) VALUES ('separator','Empty line', 'Empty separator item', 'static', 4)");
        $this->addSql("INSERT INTO item_type (`id`, `name`, `description`, `item_category_id`, `position`) VALUES ('information_device_related','Device information', 'Information Device Related item', 'information', 1)");
        $this->addSql("INSERT INTO item_type (`id`, `name`, `description`, `item_category_id`, `position`) VALUES ('information_facility','Misc. information', 'Misc.information', 'information', 2)");
        $this->addSql("INSERT INTO item_type (`id`, `name`, `description`, `item_category_id`, `position`) VALUES ('short_text_input','Text input', 'Short text input item', 'question', 3)");
        $this->addSql("INSERT INTO item_type (`id`, `name`, `description`, `item_category_id`, `position`) VALUES ('numeric_input','Number input', 'Number input item', 'question', 6)");
        $this->addSql("INSERT INTO item_type (`id`, `name`, `description`, `item_category_id`, `position`) VALUES ('long_text_input','Long text Input', 'Text area item', 'question', 5)");
        $this->addSql("INSERT INTO item_type (`id`, `name`, `description`, `item_category_id`, `position`) VALUES ('quick_select','Quick select', 'Quick select(segment control) item', 'question', 1)");
        $this->addSql("INSERT INTO item_type (`id`, `name`, `description`, `item_category_id`, `position`) VALUES ('single_selection_list','Dropdown', 'Single selection list (dropdown) item', 'question', 2)");
        $this->addSql("INSERT INTO item_type (`id`, `name`, `description`, `item_category_id`, `position`) VALUES ('specific_date','Full date', 'Specific date item', 'question', 7)");
        $this->addSql("INSERT INTO item_type (`id`, `name`, `description`, `item_category_id`, `position`) VALUES ('month_year_date','Month-year', 'Month-year item', 'question', 8)");
        $this->addSql("INSERT INTO item_type (`id`, `name`, `description`, `item_category_id`, `position`) VALUES ('specific_time','Specific time', 'Specific time item', 'question', 9)");
        $this->addSql("INSERT INTO item_type (`id`, `name`, `description`, `item_category_id`, `position`) VALUES ('time_interval','Time interval', 'Time interval (duration) item', 'question', 10)");
        $this->addSql("INSERT INTO item_type (`id`, `name`, `description`, `item_category_id`, `position`) VALUES ('photo','Photo', 'Photo item', 'question', 11)");
        $this->addSql("INSERT INTO item_type (`id`, `name`, `description`, `item_category_id`, `position`) VALUES ('signature','Signature', 'Signature item', 'question', 12)");
        $this->addSql("INSERT INTO item_type (`id`, `name`, `description`, `item_category_id`, `position`) VALUES ('comments_with_deficiency','Comments (with deficiencies bar)', 'Comments(with deficiencies bar) item', 'question', 13)");
        $this->addSql("INSERT INTO item_type (`id`, `name`, `description`, `item_category_id`, `position`) VALUES ('prefilled_text_input','Prefilled text input', 'Prefilled text input', 'question', 4)");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("DELETE FROM item_type WHERE id = 'static_text'");
        $this->addSql("DELETE FROM item_type WHERE id = 'static_key_value'");
        $this->addSql("DELETE FROM item_type WHERE id = 'subtitle'");
        $this->addSql("DELETE FROM item_type WHERE id = 'separator'");
        $this->addSql("DELETE FROM item_type WHERE id = 'information_device_related'");
        $this->addSql("DELETE FROM item_type WHERE id = 'device_name'");
        $this->addSql("DELETE FROM item_type WHERE id = 'device_location'");
        $this->addSql("DELETE FROM item_type WHERE id = 'device_photo'");
        $this->addSql("DELETE FROM item_type WHERE id = 'short_text_input'");
        $this->addSql("DELETE FROM item_type WHERE id = 'numeric_input'");
        $this->addSql("DELETE FROM item_type WHERE id = 'long_text_input'");
        $this->addSql("DELETE FROM item_type WHERE id = 'quick_select'");
        $this->addSql("DELETE FROM item_type WHERE id = 'single_selection_list'");
        $this->addSql("DELETE FROM item_type WHERE id = 'specific_date'");
        $this->addSql("DELETE FROM item_type WHERE id = 'month_year_date'");
        $this->addSql("DELETE FROM item_type WHERE id = 'specific_time'");
        $this->addSql("DELETE FROM item_type WHERE id = 'time_interval'");
        $this->addSql("DELETE FROM item_type WHERE id = 'photo'");
        $this->addSql("DELETE FROM item_type WHERE id = 'signature'");
        $this->addSql("DELETE FROM item_type WHERE id = 'comments_with_deficiency'");
    }
}
