<?php

declare(strict_types=1);

namespace App\App\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version0050_Create_InfoSource_Table_And_Update_Item_Table extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE info_source (id VARCHAR(125) NOT NULL, dictionary_id VARCHAR(36) NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_92572025AF5E5B3C (dictionary_id), UNIQUE INDEX uuid_idx (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE info_source ADD CONSTRAINT FK_92572025AF5E5B3C FOREIGN KEY (dictionary_id) REFERENCES dictionary (id)');
        $this->addSql('ALTER TABLE item CHANGE info_source info_source_id VARCHAR(36) DEFAULT NULL');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E384CA15C FOREIGN KEY (info_source_id) REFERENCES info_source (id)');
        $this->addSql('CREATE INDEX IDX_1F1B251E384CA15C ON item (info_source_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE info_source');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E384CA15C');
        $this->addSql('DROP INDEX IDX_1F1B251E384CA15C ON item');
        $this->addSql('ALTER TABLE item CHANGE info_source_id info_source VARCHAR(36) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
