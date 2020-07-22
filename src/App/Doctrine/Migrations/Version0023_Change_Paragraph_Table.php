<?php

declare(strict_types=1);

namespace App\App\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version0023_Change_Paragraph_Table extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE paragraph ADD level INT DEFAULT NULL, CHANGE section_id section_id VARCHAR(36) NOT NULL, CHANGE title title VARCHAR(500) DEFAULT NULL, CHANGE filter_id paragraph_filter_id VARCHAR(36) DEFAULT NULL');
        $this->addSql('ALTER TABLE paragraph ADD CONSTRAINT FK_7DD39862D823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('ALTER TABLE paragraph ADD CONSTRAINT FK_7DD39862727ACA70 FOREIGN KEY (parent_id) REFERENCES paragraph (id)');
        $this->addSql('ALTER TABLE paragraph ADD CONSTRAINT FK_7DD3986294A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id)');
        $this->addSql('ALTER TABLE paragraph ADD CONSTRAINT FK_7DD3986210FE5A77 FOREIGN KEY (style_template_id) REFERENCES style_template (id)');
        $this->addSql('ALTER TABLE paragraph ADD CONSTRAINT FK_7DD398623F7BE73C FOREIGN KEY (paragraph_filter_id) REFERENCES paragraph_filter (id)');
        $this->addSql('ALTER TABLE paragraph ADD created_by_id INT DEFAULT NULL, ADD modified_by_id INT DEFAULT NULL, CHANGE level level INT DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE paragraph ADD CONSTRAINT FK_7DD39862B03A8386 FOREIGN KEY (created_by_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE paragraph ADD CONSTRAINT FK_7DD3986299049ECE FOREIGN KEY (modified_by_id) REFERENCES fos_user (id)');
        $this->addSql('CREATE INDEX IDX_7DD39862D823E37A ON paragraph (section_id)');
        $this->addSql('CREATE INDEX IDX_7DD39862727ACA70 ON paragraph (parent_id)');
        $this->addSql('CREATE INDEX IDX_7DD3986294A4C7D4 ON paragraph (device_id)');
        $this->addSql('CREATE INDEX IDX_7DD3986210FE5A77 ON paragraph (style_template_id)');
        $this->addSql('CREATE INDEX IDX_7DD398623F7BE73C ON paragraph (paragraph_filter_id)');
        $this->addSql('CREATE INDEX IDX_7DD39862B03A8386 ON paragraph (created_by_id)');
        $this->addSql('CREATE INDEX IDX_7DD3986299049ECE ON paragraph (modified_by_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE paragraph DROP FOREIGN KEY FK_7DD39862D823E37A');
        $this->addSql('ALTER TABLE paragraph DROP FOREIGN KEY FK_7DD39862727ACA70');
        $this->addSql('ALTER TABLE paragraph DROP FOREIGN KEY FK_7DD3986294A4C7D4');
        $this->addSql('ALTER TABLE paragraph DROP FOREIGN KEY FK_7DD3986210FE5A77');
        $this->addSql('ALTER TABLE paragraph DROP FOREIGN KEY FK_7DD398623F7BE73C');
        $this->addSql('ALTER TABLE paragraph DROP FOREIGN KEY FK_7DD39862B03A8386');
        $this->addSql('ALTER TABLE paragraph DROP FOREIGN KEY FK_7DD3986299049ECE');
        $this->addSql('DROP INDEX IDX_7DD39862D823E37A ON paragraph');
        $this->addSql('DROP INDEX IDX_7DD39862727ACA70 ON paragraph');
        $this->addSql('DROP INDEX IDX_7DD3986294A4C7D4 ON paragraph');
        $this->addSql('DROP INDEX IDX_7DD3986210FE5A77 ON paragraph');
        $this->addSql('DROP INDEX IDX_7DD398623F7BE73C ON paragraph');
        $this->addSql('DROP INDEX IDX_7DD39862B03A8386 ON paragraph');
        $this->addSql('DROP INDEX IDX_7DD3986299049ECE ON paragraph');
        $this->addSql('ALTER TABLE paragraph DROP level, CHANGE section_id section_id VARCHAR(36) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE title title VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE paragraph_filter_id filter_id VARCHAR(36) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE paragraph DROP created_by_id, DROP modified_by_id');
    }
}
