<?php

declare(strict_types=1);

namespace App\App\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version0007_Create_Section_Table extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE section (id VARCHAR(36) NOT NULL, report_template_version_id VARCHAR(36) DEFAULT NULL, created_by_id INT DEFAULT NULL, modified_by_id INT DEFAULT NULL, title VARCHAR(500) DEFAULT NULL, position INT DEFAULT NULL, created_at INT NOT NULL COMMENT \'(DC2Type:timestamp)\', updated_at INT NOT NULL COMMENT \'(DC2Type:timestamp)\', printable TINYINT(1) NOT NULL, INDEX IDX_2D737AEF3D1C5FB9 (report_template_version_id), INDEX IDX_2D737AEFB03A8386 (created_by_id), INDEX IDX_2D737AEF99049ECE (modified_by_id), UNIQUE INDEX uuid_idx (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE section');
    }
}
