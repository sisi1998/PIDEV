<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230306180956 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipe ADD performance_e_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA157C474A32 FOREIGN KEY (performance_e_id) REFERENCES performance_equipe (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2449BA157C474A32 ON equipe (performance_e_id)');
        $this->addSql('ALTER TABLE performance_equipe DROP FOREIGN KEY FK_44A1947723E4EB30');
        $this->addSql('DROP INDEX UNIQ_44A1947723E4EB30 ON performance_equipe');
        $this->addSql('ALTER TABLE performance_equipe DROP equipe_responsable_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA157C474A32');
        $this->addSql('DROP INDEX UNIQ_2449BA157C474A32 ON equipe');
        $this->addSql('ALTER TABLE equipe DROP performance_e_id');
        $this->addSql('ALTER TABLE performance_equipe ADD equipe_responsable_id INT NOT NULL');
        $this->addSql('ALTER TABLE performance_equipe ADD CONSTRAINT FK_44A1947723E4EB30 FOREIGN KEY (equipe_responsable_id) REFERENCES equipe (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_44A1947723E4EB30 ON performance_equipe (equipe_responsable_id)');
    }
}
