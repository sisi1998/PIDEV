<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230218075859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE performance_c (id INT AUTO_INCREMENT NOT NULL, joueur_p_id INT DEFAULT NULL, competition_p_id INT DEFAULT NULL, apps VARCHAR(255) DEFAULT NULL, mins VARCHAR(255) DEFAULT NULL, buts VARCHAR(255) DEFAULT NULL, points_decisives VARCHAR(255) DEFAULT NULL, jaune VARCHAR(255) DEFAULT NULL, rouge VARCHAR(255) DEFAULT NULL, tp_m VARCHAR(255) DEFAULT NULL, pr VARCHAR(255) DEFAULT NULL, aeriens_g VARCHAR(255) DEFAULT NULL, hd_m VARCHAR(255) DEFAULT NULL, note VARCHAR(255) DEFAULT NULL, INDEX IDX_93B57E2A6BE9BF0A (joueur_p_id), INDEX IDX_93B57E2ADD38FDB0 (competition_p_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE performance_c ADD CONSTRAINT FK_93B57E2A6BE9BF0A FOREIGN KEY (joueur_p_id) REFERENCES joueur (id)');
        $this->addSql('ALTER TABLE performance_c ADD CONSTRAINT FK_93B57E2ADD38FDB0 FOREIGN KEY (competition_p_id) REFERENCES competition (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE performance_c DROP FOREIGN KEY FK_93B57E2A6BE9BF0A');
        $this->addSql('ALTER TABLE performance_c DROP FOREIGN KEY FK_93B57E2ADD38FDB0');
        $this->addSql('DROP TABLE performance_c');
    }
}
