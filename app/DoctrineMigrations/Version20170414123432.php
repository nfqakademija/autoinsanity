<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170414123432 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE city ADD country INT DEFAULT NULL');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B02345373C966 FOREIGN KEY (country) REFERENCES country (id)');
        $this->addSql('CREATE INDEX IDX_2D5B02345373C966 ON city (country)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B02345373C966');
        $this->addSql('DROP INDEX IDX_2D5B02345373C966 ON city');
        $this->addSql('ALTER TABLE city DROP country');
    }
}
