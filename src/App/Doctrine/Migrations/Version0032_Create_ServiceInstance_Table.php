<?php

declare(strict_types=1);

namespace App\App\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version0032_Create_ServiceInstance_Table extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE service_instance (id VARCHAR(36) NOT NULL, service_id VARCHAR(36) NOT NULL, facility_id VARCHAR(36) NOT NULL, created_by_id INT DEFAULT NULL, modified_by_id INT DEFAULT NULL, created_at INT NOT NULL COMMENT \'(DC2Type:timestamp)\', updated_at INT NOT NULL COMMENT \'(DC2Type:timestamp)\', INDEX IDX_BB46EAE3ED5CA9E6 (service_id), INDEX IDX_BB46EAE3A7014910 (facility_id), INDEX IDX_BB46EAE3B03A8386 (created_by_id), INDEX IDX_BB46EAE399049ECE (modified_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service_instance ADD CONSTRAINT FK_BB46EAE3ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE service_instance ADD CONSTRAINT FK_BB46EAE3A7014910 FOREIGN KEY (facility_id) REFERENCES facility (id)');
        $this->addSql('ALTER TABLE service_instance ADD CONSTRAINT FK_BB46EAE3B03A8386 FOREIGN KEY (created_by_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE service_instance ADD CONSTRAINT FK_BB46EAE399049ECE FOREIGN KEY (modified_by_id) REFERENCES fos_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE service_instance');
    }
}
