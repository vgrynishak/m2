<?php

declare(strict_types=1);

namespace App\App\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version0013_Service_Device_Reference_Into_ReportTemplate_Entity extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE report_template DROP service_id, DROP device_id');
        $this->addSql('ALTER TABLE report_template ADD service_id VARCHAR(36) DEFAULT NULL, ADD device_id VARCHAR(36) DEFAULT NULL');
        $this->addSql('ALTER TABLE report_template ADD CONSTRAINT FK_970086FEED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE report_template ADD CONSTRAINT FK_970086FE94A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id)');
        $this->addSql('CREATE INDEX IDX_970086FEED5CA9E6 ON report_template (service_id)');
        $this->addSql('CREATE INDEX IDX_970086FE94A4C7D4 ON report_template (device_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE report_template DROP FOREIGN KEY FK_970086FEED5CA9E6');
        $this->addSql('ALTER TABLE report_template DROP FOREIGN KEY FK_970086FE94A4C7D4');
        $this->addSql('DROP INDEX IDX_970086FEED5CA9E6 ON report_template');
        $this->addSql('DROP INDEX IDX_970086FE94A4C7D4 ON report_template');
        $this->addSql('ALTER TABLE report_template DROP service_id, DROP device_id');
    }
}
