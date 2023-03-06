<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230304230112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours ADD equipex_id INT NOT NULL');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C948C5FA4 FOREIGN KEY (arenna_id) REFERENCES arena (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CA47987BB FOREIGN KEY (equipex_id) REFERENCES equipe (id)');
        $this->addSql('CREATE INDEX IDX_FDCA8C9C948C5FA4 ON cours (arenna_id)');
        $this->addSql('CREATE INDEX IDX_FDCA8C9CA47987BB ON cours (equipex_id)');
        $this->addSql('ALTER TABLE equipe ADD ax_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA1555FB3DB1 FOREIGN KEY (ax_id) REFERENCES arena (id)');
        $this->addSql('CREATE INDEX IDX_2449BA1555FB3DB1 ON equipe (ax_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C948C5FA4');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9CA47987BB');
        $this->addSql('DROP INDEX IDX_FDCA8C9C948C5FA4 ON cours');
        $this->addSql('DROP INDEX IDX_FDCA8C9CA47987BB ON cours');
        $this->addSql('ALTER TABLE cours DROP equipex_id');
        $this->addSql('ALTER TABLE equipe DROP FOREIGN KEY FK_2449BA1555FB3DB1');
        $this->addSql('DROP INDEX IDX_2449BA1555FB3DB1 ON equipe');
        $this->addSql('ALTER TABLE equipe DROP ax_id');
    }
}
