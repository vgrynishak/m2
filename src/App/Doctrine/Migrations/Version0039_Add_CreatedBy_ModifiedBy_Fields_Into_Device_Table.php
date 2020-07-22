<?php

declare(strict_types=1);

namespace App\App\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version0039_Add_CreatedBy_ModifiedBy_Fields_Into_Device_Table extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE device ADD created_by_id INT DEFAULT NULL, ADD modified_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE device ADD CONSTRAINT FK_92FB68EB03A8386 FOREIGN KEY (created_by_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE device ADD CONSTRAINT FK_92FB68E99049ECE FOREIGN KEY (modified_by_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_92FB68EB03A8386 ON device (created_by_id)');
        $this->addSql('CREATE INDEX IDX_92FB68E99049ECE ON device (modified_by_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE device DROP FOREIGN KEY FK_92FB68EB03A8386');
        $this->addSql('ALTER TABLE device DROP FOREIGN KEY FK_92FB68E99049ECE');
        $this->addSql('DROP INDEX IDX_92FB68EB03A8386 ON device');
        $this->addSql('DROP INDEX IDX_92FB68E99049ECE ON device');
        $this->addSql('ALTER TABLE device DROP created_by_id, DROP modified_by_id');
    }
}
