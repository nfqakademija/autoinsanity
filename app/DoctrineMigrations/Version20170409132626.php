<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170409132626 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE vehicle ADD link VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE vehicle RENAME INDEX idx_1f1b251e1c52f958 TO IDX_1B80E4861C52F958');
        $this->addSql('ALTER TABLE vehicle RENAME INDEX idx_1f1b251ed79572d9 TO IDX_1B80E486D79572D9');
        $this->addSql('ALTER TABLE vehicle RENAME INDEX idx_1f1b251e5373c966 TO IDX_1B80E4865373C966');
        $this->addSql('ALTER TABLE vehicle RENAME INDEX idx_1f1b251e2d5b0234 TO IDX_1B80E4862D5B0234');
        $this->addSql('ALTER TABLE vehicle RENAME INDEX idx_1f1b251ed95aeb4b TO IDX_1B80E486D95AEB4B');
        $this->addSql('ALTER TABLE vehicle RENAME INDEX idx_1f1b251e9ca10f38 TO IDX_1B80E4869CA10F38');
        $this->addSql('ALTER TABLE vehicle RENAME INDEX idx_1f1b251e665648e9 TO IDX_1B80E486665648E9');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE vehicle DROP link');
        $this->addSql('ALTER TABLE vehicle RENAME INDEX idx_1b80e4861c52f958 TO IDX_1F1B251E1C52F958');
        $this->addSql('ALTER TABLE vehicle RENAME INDEX idx_1b80e486d79572d9 TO IDX_1F1B251ED79572D9');
        $this->addSql('ALTER TABLE vehicle RENAME INDEX idx_1b80e4865373c966 TO IDX_1F1B251E5373C966');
        $this->addSql('ALTER TABLE vehicle RENAME INDEX idx_1b80e4862d5b0234 TO IDX_1F1B251E2D5B0234');
        $this->addSql('ALTER TABLE vehicle RENAME INDEX idx_1b80e486d95aeb4b TO IDX_1F1B251ED95AEB4B');
        $this->addSql('ALTER TABLE vehicle RENAME INDEX idx_1b80e4869ca10f38 TO IDX_1F1B251E9CA10F38');
        $this->addSql('ALTER TABLE vehicle RENAME INDEX idx_1b80e486665648e9 TO IDX_1F1B251E665648E9');
    }
}
