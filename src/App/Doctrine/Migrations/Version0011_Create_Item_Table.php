<?php

declare(strict_types=1);

namespace App\App\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version0011_Create_Item_Table extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE item (id VARCHAR(36) NOT NULL, paragraph_id VARCHAR(36) NOT NULL, item_type_id VARCHAR(36) NOT NULL, position INT NOT NULL, label VARCHAR(255) DEFAULT NULL, default_answer VARCHAR(36) DEFAULT NULL, info_source VARCHAR(36) DEFAULT NULL, remembered TINYINT(1) NOT NULL, placeholder VARCHAR(36) DEFAULT NULL, `required` TINYINT(1) NOT NULL, assessment VARCHAR(36) DEFAULT NULL, answer VARCHAR(36) DEFAULT NULL, nfpa_ref VARCHAR(36) DEFAULT NULL, created_at INT NOT NULL COMMENT \'(DC2Type:timestamp)\', updated_at INT NOT NULL COMMENT \'(DC2Type:timestamp)\', INDEX IDX_1F1B251E8B50597F (paragraph_id), INDEX IDX_1F1B251ECE11AAC7 (item_type_id), UNIQUE INDEX uuid_idx (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E8B50597F FOREIGN KEY (paragraph_id) REFERENCES paragraph (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251ECE11AAC7 FOREIGN KEY (item_type_id) REFERENCES item_type (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE item');
    }
}
