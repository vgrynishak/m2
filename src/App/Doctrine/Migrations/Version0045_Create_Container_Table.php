<?php

declare(strict_types=1);

namespace App\App\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version0045_Create_Container_Table extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE container (id VARCHAR(36) NOT NULL, paragraph_id VARCHAR(36) NOT NULL, screen_id VARCHAR(36) NOT NULL, device_instance_id VARCHAR(36) DEFAULT NULL, parent VARCHAR(36) DEFAULT NULL, title VARCHAR(36) NOT NULL, position INT NOT NULL, level INT NOT NULL, created_at INT NOT NULL COMMENT \'(DC2Type:timestamp)\', modified_at INT NOT NULL COMMENT \'(DC2Type:timestamp)\', INDEX IDX_C7A2EC1B8B50597F (paragraph_id), INDEX IDX_C7A2EC1B41A67722 (screen_id), INDEX IDX_C7A2EC1B48D126DB (device_instance_id), INDEX IDX_C7A2EC1B3D8E604F (parent), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE container ADD CONSTRAINT FK_C7A2EC1B8B50597F FOREIGN KEY (paragraph_id) REFERENCES paragraph (id)');
        $this->addSql('ALTER TABLE container ADD CONSTRAINT FK_C7A2EC1B41A67722 FOREIGN KEY (screen_id) REFERENCES screen (id)');
        $this->addSql('ALTER TABLE container ADD CONSTRAINT FK_C7A2EC1B48D126DB FOREIGN KEY (device_instance_id) REFERENCES device_instance (id)');
        $this->addSql('ALTER TABLE container ADD CONSTRAINT FK_C7A2EC1B3D8E604F FOREIGN KEY (parent) REFERENCES container (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE container DROP FOREIGN KEY FK_C7A2EC1B3D8E604F');
        $this->addSql('DROP TABLE container');
    }
}
