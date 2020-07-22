<?php

declare(strict_types=1);

namespace App\App\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version0019_Change_Device_Table_With_Relations extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX uuid_idx ON device');
        $this->addSql('ALTER TABLE device ADD division_id VARCHAR(36) NOT NULL, ADD description VARCHAR(500) DEFAULT NULL, ADD level INT NOT NULL, CHANGE name name VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE device ADD CONSTRAINT FK_92FB68E727ACA70 FOREIGN KEY (parent_id) REFERENCES device (id)');
        $this->addSql('ALTER TABLE device ADD CONSTRAINT FK_92FB68E41859289 FOREIGN KEY (division_id) REFERENCES division (id)');
        $this->addSql('CREATE INDEX IDX_92FB68E727ACA70 ON device (parent_id)');
        $this->addSql('CREATE INDEX IDX_92FB68E41859289 ON device (division_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE device DROP FOREIGN KEY FK_92FB68E727ACA70');
        $this->addSql('ALTER TABLE device DROP FOREIGN KEY FK_92FB68E41859289');
        $this->addSql('DROP INDEX IDX_92FB68E727ACA70 ON device');
        $this->addSql('DROP INDEX IDX_92FB68E41859289 ON device');
        $this->addSql('ALTER TABLE device DROP division_id, DROP description, DROP level, CHANGE name name VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX uuid_idx ON device (id)');
    }
}
