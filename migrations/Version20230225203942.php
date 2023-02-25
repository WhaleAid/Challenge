<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230225203942 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE equipe_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE priorite_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "tableau_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE tache_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE topic_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE comment (id INT NOT NULL, commenter_id INT NOT NULL, tache_id INT NOT NULL, content VARCHAR(255) NOT NULL, is_resolved BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9474526CB4D5A9E2 ON comment (commenter_id)');
        $this->addSql('CREATE INDEX IDX_9474526CD2235D39 ON comment (tache_id)');
        $this->addSql('CREATE TABLE dev (id INT NOT NULL, equipe_id INT DEFAULT NULL, tableau_id INT DEFAULT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, is_verified BOOLEAN NOT NULL, firstname VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1173F105E7927C74 ON dev (email)');
        $this->addSql('CREATE INDEX IDX_1173F1056D861B89 ON dev (equipe_id)');
        $this->addSql('CREATE INDEX IDX_1173F105B062D5BC ON dev (tableau_id)');
        $this->addSql('CREATE TABLE equipe (id INT NOT NULL, tableau_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2449BA15B062D5BC ON equipe (tableau_id)');
        $this->addSql('CREATE TABLE lead (id INT NOT NULL, equipe_id INT DEFAULT NULL, tableau_id INT DEFAULT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, is_verified BOOLEAN NOT NULL, firstname VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_289161CBE7927C74 ON lead (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_289161CB6D861B89 ON lead (equipe_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_289161CBB062D5BC ON lead (tableau_id)');
        $this->addSql('CREATE TABLE manager (id INT NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, is_verified BOOLEAN NOT NULL, firstname VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_FA2425B9E7927C74 ON manager (email)');
        $this->addSql('CREATE TABLE priorite (id INT NOT NULL, niveau_priorite VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE status (id INT NOT NULL, statue_tache VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "tableau" (id INT NOT NULL, manager_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C6744DB1783E3463 ON "tableau" (manager_id)');
        $this->addSql('CREATE TABLE tache (id INT NOT NULL, status_id INT DEFAULT NULL, priorite_id INT DEFAULT NULL, tableau_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_938720756BF700BD ON tache (status_id)');
        $this->addSql('CREATE INDEX IDX_9387207553B4F1DE ON tache (priorite_id)');
        $this->addSql('CREATE INDEX IDX_93872075B062D5BC ON tache (tableau_id)');
        $this->addSql('CREATE TABLE topic (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE topic_tache (topic_id INT NOT NULL, tache_id INT NOT NULL, PRIMARY KEY(topic_id, tache_id))');
        $this->addSql('CREATE INDEX IDX_28B48C171F55203D ON topic_tache (topic_id)');
        $this->addSql('CREATE INDEX IDX_28B48C17D2235D39 ON topic_tache (tache_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, is_verified BOOLEAN NOT NULL, firstname VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CB4D5A9E2 FOREIGN KEY (commenter_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CD2235D39 FOREIGN KEY (tache_id) REFERENCES tache (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dev ADD CONSTRAINT FK_1173F1056D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dev ADD CONSTRAINT FK_1173F105B062D5BC FOREIGN KEY (tableau_id) REFERENCES "tableau" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA15B062D5BC FOREIGN KEY (tableau_id) REFERENCES "tableau" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lead ADD CONSTRAINT FK_289161CB6D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lead ADD CONSTRAINT FK_289161CBB062D5BC FOREIGN KEY (tableau_id) REFERENCES "tableau" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "tableau" ADD CONSTRAINT FK_C6744DB1783E3463 FOREIGN KEY (manager_id) REFERENCES manager (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_938720756BF700BD FOREIGN KEY (status_id) REFERENCES status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_9387207553B4F1DE FOREIGN KEY (priorite_id) REFERENCES priorite (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT FK_93872075B062D5BC FOREIGN KEY (tableau_id) REFERENCES "tableau" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE topic_tache ADD CONSTRAINT FK_28B48C171F55203D FOREIGN KEY (topic_id) REFERENCES topic (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE topic_tache ADD CONSTRAINT FK_28B48C17D2235D39 FOREIGN KEY (tache_id) REFERENCES tache (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE comment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE equipe_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE priorite_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE status_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "tableau_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE tache_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE topic_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526CB4D5A9E2');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526CD2235D39');
        $this->addSql('ALTER TABLE dev DROP CONSTRAINT FK_1173F1056D861B89');
        $this->addSql('ALTER TABLE dev DROP CONSTRAINT FK_1173F105B062D5BC');
        $this->addSql('ALTER TABLE equipe DROP CONSTRAINT FK_2449BA15B062D5BC');
        $this->addSql('ALTER TABLE lead DROP CONSTRAINT FK_289161CB6D861B89');
        $this->addSql('ALTER TABLE lead DROP CONSTRAINT FK_289161CBB062D5BC');
        $this->addSql('ALTER TABLE "tableau" DROP CONSTRAINT FK_C6744DB1783E3463');
        $this->addSql('ALTER TABLE tache DROP CONSTRAINT FK_938720756BF700BD');
        $this->addSql('ALTER TABLE tache DROP CONSTRAINT FK_9387207553B4F1DE');
        $this->addSql('ALTER TABLE tache DROP CONSTRAINT FK_93872075B062D5BC');
        $this->addSql('ALTER TABLE topic_tache DROP CONSTRAINT FK_28B48C171F55203D');
        $this->addSql('ALTER TABLE topic_tache DROP CONSTRAINT FK_28B48C17D2235D39');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE dev');
        $this->addSql('DROP TABLE equipe');
        $this->addSql('DROP TABLE lead');
        $this->addSql('DROP TABLE manager');
        $this->addSql('DROP TABLE priorite');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE "tableau"');
        $this->addSql('DROP TABLE tache');
        $this->addSql('DROP TABLE topic');
        $this->addSql('DROP TABLE topic_tache');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
