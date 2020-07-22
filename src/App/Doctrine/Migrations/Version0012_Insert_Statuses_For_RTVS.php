<?php

declare(strict_types=1);

namespace App\App\Doctrine\Migrations;

use App\App\Component\UUID\UUID;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version0012_Insert_Statuses_For_RTVS extends AbstractMigration
{

    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $uuid = (new UUID())->getValue();
        $this->addSql("INSERT INTO report_template_version_status (`id`, `name`, `description`) VALUES ('draft','Draft', '')");
        $uuid = (new UUID())->getValue();
        $this->addSql("INSERT INTO report_template_version_status (`id`, `name`, `description`) VALUES ('published','Published', '')");
        $uuid = (new UUID())->getValue();
        $this->addSql("INSERT INTO report_template_version_status (`id`, `name`, `description`) VALUES ('archived','Archived', '')");
        $uuid = (new UUID())->getValue();
        $this->addSql("INSERT INTO report_template_version_status (`id`, `name`, `description`) VALUES ('deleted','Deleted', '')");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("DELETE FROM report_template_version_status WHERE name = 'Draft'");
        $this->addSql("DELETE FROM report_template_version_status WHERE name = 'Published'");
        $this->addSql("DELETE FROM report_template_version_status WHERE name = 'Archived'");
        $this->addSql("DELETE FROM report_template_version_status WHERE name = 'Deleted'");
    }
}
