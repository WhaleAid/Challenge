<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230226195456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tableau_user (tableau_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(tableau_id, user_id))');
        $this->addSql('CREATE INDEX IDX_5A37B752B062D5BC ON tableau_user (tableau_id)');
        $this->addSql('CREATE INDEX IDX_5A37B752A76ED395 ON tableau_user (user_id)');
        $this->addSql('ALTER TABLE tableau_user ADD CONSTRAINT FK_5A37B752B062D5BC FOREIGN KEY (tableau_id) REFERENCES "tableau" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tableau_user ADD CONSTRAINT FK_5A37B752A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        // $this->addSql('ALTER TABLE topic ADD titre VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE tableau_user DROP CONSTRAINT FK_5A37B752B062D5BC');
        $this->addSql('ALTER TABLE tableau_user DROP CONSTRAINT FK_5A37B752A76ED395');
        $this->addSql('DROP TABLE tableau_user');
        $this->addSql('ALTER TABLE topic DROP titre');
    }
}
