<?php

declare(strict_types=1);

namespace App\App\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version0044_Create_Screen_Table extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE screen (id VARCHAR(36) NOT NULL, section_id VARCHAR(36) NOT NULL, report_form_id VARCHAR(36) NOT NULL, created_at INT NOT NULL COMMENT \'(DC2Type:timestamp)\', modified_at INT NOT NULL COMMENT \'(DC2Type:timestamp)\', INDEX IDX_DF4C6130D823E37A (section_id), INDEX IDX_DF4C61303F6FE67D (report_form_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE screen ADD CONSTRAINT FK_DF4C6130D823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('ALTER TABLE screen ADD CONSTRAINT FK_DF4C61303F6FE67D FOREIGN KEY (report_form_id) REFERENCES report_form (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE screen');
    }
}
