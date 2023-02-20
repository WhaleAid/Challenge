<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230219143142 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE id_lead_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE id_lead (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE tableau ADD lead_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tableau ADD CONSTRAINT FK_C6744DB155458D FOREIGN KEY (lead_id) REFERENCES "personne" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C6744DB155458D ON tableau (lead_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE id_lead_id_seq CASCADE');
        $this->addSql('DROP TABLE id_lead');
        $this->addSql('ALTER TABLE tableau DROP CONSTRAINT FK_C6744DB155458D');
        $this->addSql('DROP INDEX IDX_C6744DB155458D');
        $this->addSql('ALTER TABLE tableau DROP lead_id');
    }
}
