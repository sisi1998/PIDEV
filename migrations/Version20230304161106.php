<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230304161106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipe ADD arena_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA15663565CF FOREIGN KEY (arena_id) REFERENCES arena (id)');
        $this->addSql('CREATE INDEX IDX_2449BA15663565CF ON equipe (arena_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA15663565CF');
        $this->addSql('DROP INDEX IDX_2449BA15663565CF ON equipe');
        $this->addSql('ALTER TABLE equipe DROP arena_id');
    }
}
