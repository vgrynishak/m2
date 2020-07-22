<?php

declare(strict_types=1);

namespace App\App\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version0017_Add_Relations_For_ReportTemplateVersionStatus_Entity extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX uuid_idx ON report_template_version_status');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEF3D1C5FB9 FOREIGN KEY (report_template_version_id) REFERENCES report_template_version (id)');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEFB03A8386 FOREIGN KEY (created_by_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEF99049ECE FOREIGN KEY (modified_by_id) REFERENCES fos_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE UNIQUE INDEX uuid_idx ON report_template_version_status (id)');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEF3D1C5FB9');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEFB03A8386');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEF99049ECE');
    }
}
