<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230224204242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE priorite_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE priorite (id INT NOT NULL, niveau_priorite VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE status (id INT NOT NULL, statue_tache VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE tache ADD status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tache ADD priorite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_938720756BF700BD FOREIGN KEY (status_id) REFERENCES status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_9387207553B4F1DE FOREIGN KEY (priorite_id) REFERENCES priorite (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_938720756BF700BD ON tache (status_id)');
        $this->addSql('CREATE INDEX IDX_9387207553B4F1DE ON tache (priorite_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE tache DROP CONSTRAINT FK_9387207553B4F1DE');
        $this->addSql('ALTER TABLE tache DROP CONSTRAINT FK_938720756BF700BD');
        $this->addSql('DROP SEQUENCE priorite_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE status_id_seq CASCADE');
        $this->addSql('DROP TABLE priorite');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP INDEX IDX_938720756BF700BD');
        $this->addSql('DROP INDEX IDX_9387207553B4F1DE');
        $this->addSql('ALTER TABLE tache DROP status_id');
        $this->addSql('ALTER TABLE tache DROP priorite_id');
    }
}
