<?php

declare(strict_types=1);

namespace App\App\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version0014_Add_Relations_In_ReportTemplateVersion_Entity extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE report_template_version DROP report_template_id, DROP created_by_id, DROP modified_by_id, DROP report_template_version_status_id');
        $this->addSql('ALTER TABLE report_template_version ADD report_template_id VARCHAR(36) DEFAULT NULL, ADD created_by_id INT DEFAULT NULL, ADD modified_by_id INT DEFAULT NULL, ADD report_template_version_status_id VARCHAR(36) DEFAULT NULL');
        $this->addSql('ALTER TABLE report_template_version ADD CONSTRAINT FK_A955100EB4C2A4B0 FOREIGN KEY (report_template_id) REFERENCES report_template (id)');
        $this->addSql('ALTER TABLE report_template_version ADD CONSTRAINT FK_A955100EB03A8386 FOREIGN KEY (created_by_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE report_template_version ADD CONSTRAINT FK_A955100E99049ECE FOREIGN KEY (modified_by_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE report_template_version ADD CONSTRAINT FK_A955100E5B97B87D FOREIGN KEY (report_template_version_status_id) REFERENCES report_template_version_status (id)');
        $this->addSql('CREATE INDEX IDX_A955100EB4C2A4B0 ON report_template_version (report_template_id)');
        $this->addSql('CREATE INDEX IDX_A955100EB03A8386 ON report_template_version (created_by_id)');
        $this->addSql('CREATE INDEX IDX_A955100E99049ECE ON report_template_version (modified_by_id)');
        $this->addSql('CREATE INDEX IDX_A955100E5B97B87D ON report_template_version (report_template_version_status_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE report_template_version DROP FOREIGN KEY FK_A955100EB4C2A4B0');
        $this->addSql('ALTER TABLE report_template_version DROP FOREIGN KEY FK_A955100EB03A8386');
        $this->addSql('ALTER TABLE report_template_version DROP FOREIGN KEY FK_A955100E99049ECE');
        $this->addSql('ALTER TABLE report_template_version DROP FOREIGN KEY FK_A955100E5B97B87D');
        $this->addSql('DROP INDEX IDX_A955100EB4C2A4B0 ON report_template_version');
        $this->addSql('DROP INDEX IDX_A955100EB03A8386 ON report_template_version');
        $this->addSql('DROP INDEX IDX_A955100E99049ECE ON report_template_version');
        $this->addSql('DROP INDEX IDX_A955100E5B97B87D ON report_template_version');
        $this->addSql('ALTER TABLE report_template_version DROP report_template_id, DROP created_by_id, DROP modified_by_id, DROP report_template_version_status_id');
        $this->addSql('ALTER TABLE report_template_version ADD report_template_id VARCHAR(36) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD created_by_id VARCHAR(36) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD modified_by_id VARCHAR(36) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD report_template_version_status_id VARCHAR(36) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
