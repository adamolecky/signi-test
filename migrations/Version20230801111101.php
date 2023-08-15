<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230801111101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE car_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE colour_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE car (id INT NOT NULL, make VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, build_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN car.build_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE car_colours (car_id INT NOT NULL, colour_id INT NOT NULL, PRIMARY KEY(car_id, colour_id))');
        $this->addSql('CREATE INDEX IDX_34832305C3C6F69F ON car_colours (car_id)');
        $this->addSql('CREATE INDEX IDX_34832305569C9B4C ON car_colours (colour_id)');
        $this->addSql('CREATE TABLE colour (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE car_colours ADD CONSTRAINT FK_34832305C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE car_colours ADD CONSTRAINT FK_34832305569C9B4C FOREIGN KEY (colour_id) REFERENCES colour (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE car_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE colour_id_seq CASCADE');
        $this->addSql('ALTER TABLE car_colours DROP CONSTRAINT FK_34832305C3C6F69F');
        $this->addSql('ALTER TABLE car_colours DROP CONSTRAINT FK_34832305569C9B4C');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE car_colours');
        $this->addSql('DROP TABLE colour');
    }
}
