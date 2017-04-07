<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170407171423 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE body_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_D95AEB4B5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE color (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_665648E95E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, brand INT DEFAULT NULL, model INT DEFAULT NULL, country INT DEFAULT NULL, city INT DEFAULT NULL, body_type INT DEFAULT NULL, fuel_type INT DEFAULT NULL, color INT DEFAULT NULL, provider_id INT NOT NULL, provider VARCHAR(255) NOT NULL, price INT NOT NULL, year INT NOT NULL, engine_size INT NOT NULL, power INT NOT NULL, doors_number INT NOT NULL, seats_number INT NOT NULL, drive_type VARCHAR(255) NOT NULL, transmission VARCHAR(255) NOT NULL, climate_control VARCHAR(255) NOT NULL, defects VARCHAR(255) NOT NULL, steering_wheel INT NOT NULL, wheels_diameter INT NOT NULL, weight INT NOT NULL, mileage INT NOT NULL, INDEX IDX_1F1B251E1C52F958 (brand), INDEX IDX_1F1B251ED79572D9 (model), INDEX IDX_1F1B251E5373C966 (country), INDEX IDX_1F1B251E2D5B0234 (city), INDEX IDX_1F1B251ED95AEB4B (body_type), INDEX IDX_1F1B251E9CA10F38 (fuel_type), INDEX IDX_1F1B251E665648E9 (color), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1C52F9585E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5373C9665E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fuel_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_9CA10F385E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE model (id INT AUTO_INCREMENT NOT NULL, brand INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_D79572D91C52F958 (brand), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E1C52F958 FOREIGN KEY (brand) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251ED79572D9 FOREIGN KEY (model) REFERENCES model (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E5373C966 FOREIGN KEY (country) REFERENCES country (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E2D5B0234 FOREIGN KEY (city) REFERENCES city (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251ED95AEB4B FOREIGN KEY (body_type) REFERENCES body_type (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E9CA10F38 FOREIGN KEY (fuel_type) REFERENCES fuel_type (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E665648E9 FOREIGN KEY (color) REFERENCES color (id)');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D91C52F958 FOREIGN KEY (brand) REFERENCES brand (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251ED95AEB4B');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E665648E9');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E2D5B0234');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E1C52F958');
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D91C52F958');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E5373C966');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E9CA10F38');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251ED79572D9');
        $this->addSql('DROP TABLE body_type');
        $this->addSql('DROP TABLE color');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE fuel_type');
        $this->addSql('DROP TABLE model');
    }
}
