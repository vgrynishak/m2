<?php

declare(strict_types=1);

namespace App\App\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version0009_Create_Item_Category_Table extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE item_category (id VARCHAR(36) NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, position INT NOT NULL, UNIQUE INDEX uuid_idx (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql("INSERT INTO item_category (`id`, `name`, `description`, `position`) VALUES ('static','Static', 'static items', 3)");
        $this->addSql("INSERT INTO item_category (`id`, `name`, `description`, `position`) VALUES ('information','Information', 'information items', 2)");
        $this->addSql("INSERT INTO item_category (`id`, `name`, `description`, `position`) VALUES ('question','Question', 'question items', 1)");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE item_category');
    }
}
