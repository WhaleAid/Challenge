<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230207223603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs

        //$this->addSql('CREATE TABLE projet (id INT NOT NULL, tableau_id INT DEFAULT NULL, id_chef SMALLINT NOT NULL, id_tableau SMALLINT NOT NULL, PRIMARY KEY(id))');
        //$this->addSql('CREATE UNIQUE INDEX UNIQ_50159CA9B062D5BC ON projet (tableau_id)');
        //$this->addSql('CREATE TABLE role (id INT NOT NULL, role VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tableau (id INT NOT NULL, PRIMARY KEY(id))');
        //$this->addSql('CREATE TABLE tache (id INT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        //$this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9B062D5BC FOREIGN KEY (tableau_id) REFERENCES tableau (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        //$this->addSql('ALTER TABLE "user" ADD role_id INT DEFAULT NULL');
        //$this->addSql('ALTER TABLE "user" DROP role');
        //$this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        //$this->addSql('CREATE INDEX IDX_8D93D649D60322AC ON "user" (role_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649D60322AC');
        $this->addSql('DROP SEQUENCE projet_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE role_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tableau_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE tache_id_seq CASCADE');
        $this->addSql('ALTER TABLE projet DROP CONSTRAINT FK_50159CA9B062D5BC');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE tableau');
        $this->addSql('DROP TABLE tache');
        $this->addSql('DROP INDEX IDX_8D93D649D60322AC');
        $this->addSql('ALTER TABLE "user" ADD role VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE "user" DROP role_id');
    }
}
