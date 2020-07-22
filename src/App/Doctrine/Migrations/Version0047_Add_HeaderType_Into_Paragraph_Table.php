<?php

declare(strict_types=1);

namespace App\App\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version0047_Add_HeaderType_Into_Paragraph_Table extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE paragraph ADD header_type_id VARCHAR(36) DEFAULT NULL');
        $this->addSql('ALTER TABLE paragraph ADD CONSTRAINT FK_7DD3986213A4D2A8 FOREIGN KEY (header_type_id) REFERENCES header_type (id)');
        $this->addSql('CREATE INDEX IDX_7DD3986213A4D2A8 ON paragraph (header_type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE paragraph DROP FOREIGN KEY FK_7DD3986213A4D2A8');
        $this->addSql('DROP INDEX IDX_7DD3986213A4D2A8 ON paragraph');
        $this->addSql('ALTER TABLE paragraph DROP header_type_id');
    }
}
