<?php

declare(strict_types=1);

namespace App\App\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version0015_Add_Device_Facility_Relations_Into_Service_Entity extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE service DROP facility_id, DROP device_id');
        $this->addSql('ALTER TABLE service ADD facility_id VARCHAR(36) DEFAULT NULL, ADD device_id VARCHAR(36) DEFAULT NULL');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD294A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2A7014910 FOREIGN KEY (facility_id) REFERENCES facility (id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD294A4C7D4 ON service (device_id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD2A7014910 ON service (facility_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD294A4C7D4');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2A7014910');
        $this->addSql('DROP INDEX IDX_E19D9AD294A4C7D4 ON service');
        $this->addSql('DROP INDEX IDX_E19D9AD2A7014910 ON service');
    }
}
