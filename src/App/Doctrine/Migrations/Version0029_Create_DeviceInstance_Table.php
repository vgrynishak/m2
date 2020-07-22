<?php

declare(strict_types=1);

namespace App\App\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version0029_Create_DeviceInstance_Table extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE device_instance (id VARCHAR(36) NOT NULL, device_id VARCHAR(36) NOT NULL, facility_id VARCHAR(36) NOT NULL, parent_id VARCHAR(36) DEFAULT NULL, created_by_id INT DEFAULT NULL, modified_by_id INT DEFAULT NULL, created_at INT NOT NULL COMMENT \'(DC2Type:timestamp)\', updated_at INT NOT NULL COMMENT \'(DC2Type:timestamp)\', INDEX IDX_CC04E8FE94A4C7D4 (device_id), INDEX IDX_CC04E8FEA7014910 (facility_id), INDEX IDX_CC04E8FE727ACA70 (parent_id), INDEX IDX_CC04E8FEB03A8386 (created_by_id), INDEX IDX_CC04E8FE99049ECE (modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE device_instance ADD CONSTRAINT FK_CC04E8FE94A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id)');
        $this->addSql('ALTER TABLE device_instance ADD CONSTRAINT FK_CC04E8FEA7014910 FOREIGN KEY (facility_id) REFERENCES facility (id)');
        $this->addSql('ALTER TABLE device_instance ADD CONSTRAINT FK_CC04E8FE727ACA70 FOREIGN KEY (parent_id) REFERENCES device_instance (id)');
        $this->addSql('ALTER TABLE device_instance ADD CONSTRAINT FK_CC04E8FEB03A8386 FOREIGN KEY (created_by_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE device_instance ADD CONSTRAINT FK_CC04E8FE99049ECE FOREIGN KEY (modified_by_id) REFERENCES fos_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE device_instance DROP FOREIGN KEY FK_CC04E8FE727ACA70');
        $this->addSql('DROP TABLE device_instance');
    }
}
