<?php

declare(strict_types=1);

namespace App\App\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version0020_Fill_Division_Table extends AbstractMigration
{

    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql("INSERT INTO division (`id`, `name`, `alias`) VALUES ('6a38e866-e068-42f8-b21f-e5000389b6fd','Backflow', 'backflow')");
        $this->addSql("INSERT INTO division (`id`, `name`, `alias`) VALUES ('95f79e37-b4f3-4402-a946-64a33fe509b3','Fire', 'fire')");
        $this->addSql("INSERT INTO division (`id`, `name`, `alias`) VALUES ('d2be305f-dba6-42e9-a786-cea951e3446d','Plumbing', 'plumbing')");
        $this->addSql("INSERT INTO division (`id`, `name`, `alias`) VALUES ('37032816-e587-44cd-9a46-50819f2996b9','Alarm', 'alarm')");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("DELETE FROM division WHERE alias = 'backflow'");
        $this->addSql("DELETE FROM division WHERE alias = 'fire'");
        $this->addSql("DELETE FROM division WHERE alias = 'plumbing'");
        $this->addSql("DELETE FROM division WHERE alias = 'alarm'");
    }
}
