<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230304170323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours ADD arenna_id INT NOT NULL');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C948C5FA4 FOREIGN KEY (arenna_id) REFERENCES arena (id)');
        $this->addSql('CREATE INDEX IDX_FDCA8C9C948C5FA4 ON cours (arenna_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C948C5FA4');
        $this->addSql('DROP INDEX IDX_FDCA8C9C948C5FA4 ON cours');
        $this->addSql('ALTER TABLE cours DROP arenna_id');
    }
}
