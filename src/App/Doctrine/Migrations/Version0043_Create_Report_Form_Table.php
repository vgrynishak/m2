<?php

declare(strict_types=1);

namespace App\App\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version0043_Create_Report_Form_Table extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE report_form (id VARCHAR(36) NOT NULL, report_tempalate_id VARCHAR(36) NOT NULL, facility_id VARCHAR(36) NOT NULL, service_instance_id VARCHAR(36) NOT NULL, device_instance_id VARCHAR(36) NOT NULL, report_form_status_id VARCHAR(36) NOT NULL, created_by INT NOT NULL, modified_by INT NOT NULL, created_at INT NOT NULL COMMENT \'(DC2Type:timestamp)\', modified_at INT NOT NULL COMMENT \'(DC2Type:timestamp)\', INDEX IDX_21A410B4AD9F9D45 (report_tempalate_id), INDEX IDX_21A410B4A7014910 (facility_id), INDEX IDX_21A410B4F6CB54B1 (service_instance_id), INDEX IDX_21A410B448D126DB (device_instance_id), INDEX IDX_21A410B44A7B13CC (report_form_status_id), INDEX IDX_21A410B4DE12AB56 (created_by), INDEX IDX_21A410B425F94802 (modified_by), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE report_form ADD CONSTRAINT FK_21A410B4AD9F9D45 FOREIGN KEY (report_tempalate_id) REFERENCES report_template (id)');
        $this->addSql('ALTER TABLE report_form ADD CONSTRAINT FK_21A410B4A7014910 FOREIGN KEY (facility_id) REFERENCES facility (id)');
        $this->addSql('ALTER TABLE report_form ADD CONSTRAINT FK_21A410B4F6CB54B1 FOREIGN KEY (service_instance_id) REFERENCES service_instance (id)');
        $this->addSql('ALTER TABLE report_form ADD CONSTRAINT FK_21A410B448D126DB FOREIGN KEY (device_instance_id) REFERENCES device_instance (id)');
        $this->addSql('ALTER TABLE report_form ADD CONSTRAINT FK_21A410B44A7B13CC FOREIGN KEY (report_form_status_id) REFERENCES report_form_status (id)');
        $this->addSql('ALTER TABLE report_form ADD CONSTRAINT FK_21A410B4DE12AB56 FOREIGN KEY (created_by) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE report_form ADD CONSTRAINT FK_21A410B425F94802 FOREIGN KEY (modified_by) REFERENCES fos_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE report_form');
    }
}
