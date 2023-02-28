<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230228122900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tableau DROP CONSTRAINT fk_c6744db1783e3463');
        $this->addSql('DROP INDEX idx_c6744db1783e3463');
        $this->addSql('ALTER TABLE tableau RENAME COLUMN manager_id TO user_id');
        $this->addSql('ALTER TABLE tableau ADD CONSTRAINT FK_C6744DB1A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C6744DB1A76ED395 ON tableau (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "tableau" DROP CONSTRAINT FK_C6744DB1A76ED395');
        $this->addSql('DROP INDEX IDX_C6744DB1A76ED395');
        $this->addSql('ALTER TABLE "tableau" RENAME COLUMN user_id TO manager_id');
        $this->addSql('ALTER TABLE "tableau" ADD CONSTRAINT fk_c6744db1783e3463 FOREIGN KEY (manager_id) REFERENCES manager (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_c6744db1783e3463 ON "tableau" (manager_id)');
    }
}
