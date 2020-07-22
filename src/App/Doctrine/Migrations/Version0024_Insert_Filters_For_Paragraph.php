<?php

declare(strict_types=1);

namespace App\App\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version0024_Insert_Filters_For_Paragraph extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql("INSERT INTO paragraph_filter (`id`, `name`, `description`) VALUES ('inspection','Related to an inspected device', '')");
        $this->addSql("INSERT INTO paragraph_filter (`id`, `name`, `description`) VALUES ('on_site','Every on site', '')");
        $this->addSql("INSERT INTO paragraph_filter (`id`, `name`, `description`) VALUES ('by_ancestor','By ancestor', '')");
        $this->addSql("INSERT INTO paragraph_filter (`id`, `name`, `description`) VALUES ('same_as_parent','Same as parent', '')");

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("DELETE FROM paragraph_filter WHERE id = 'inspection'");
        $this->addSql("DELETE FROM paragraph_filter WHERE id = 'on_site'");
        $this->addSql("DELETE FROM paragraph_filter WHERE id = 'by_ancestor'");
        $this->addSql("DELETE FROM paragraph_filter WHERE id = 'same_as_parent'");
    }
}
