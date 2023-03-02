<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230214185230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE arena (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, addresse VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competition (id INT AUTO_INCREMENT NOT NULL, arena_id INT NOT NULL, winner_id INT DEFAULT NULL, date VARCHAR(255) NOT NULL, etat VARCHAR(255) NOT NULL, INDEX IDX_B50A2CB1663565CF (arena_id), UNIQUE INDEX UNIQ_B50A2CB15DFCD4B8 (winner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE competition_equipe (competition_id INT NOT NULL, equipe_id INT NOT NULL, INDEX IDX_4B0A7AC67B39D312 (competition_id), INDEX IDX_4B0A7AC66D861B89 (equipe_id), PRIMARY KEY(competition_id, equipe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE joueur (id INT AUTO_INCREMENT NOT NULL, equipe_j_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naissance VARCHAR(255) NOT NULL, INDEX IDX_FD71A9C5E59645A7 (equipe_j_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB1663565CF FOREIGN KEY (arena_id) REFERENCES arena (id)');
        $this->addSql('ALTER TABLE competition ADD CONSTRAINT FK_B50A2CB15DFCD4B8 FOREIGN KEY (winner_id) REFERENCES equipe (id)');
        $this->addSql('ALTER TABLE competition_equipe ADD CONSTRAINT FK_4B0A7AC67B39D312 FOREIGN KEY (competition_id) REFERENCES competition (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE competition_equipe ADD CONSTRAINT FK_4B0A7AC66D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE joueur ADD CONSTRAINT FK_FD71A9C5E59645A7 FOREIGN KEY (equipe_j_id) REFERENCES equipe (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competition DROP FOREIGN KEY FK_B50A2CB1663565CF');
        $this->addSql('ALTER TABLE competition DROP FOREIGN KEY FK_B50A2CB15DFCD4B8');
        $this->addSql('ALTER TABLE competition_equipe DROP FOREIGN KEY FK_4B0A7AC67B39D312');
        $this->addSql('ALTER TABLE competition_equipe DROP FOREIGN KEY FK_4B0A7AC66D861B89');
        $this->addSql('ALTER TABLE joueur DROP FOREIGN KEY FK_FD71A9C5E59645A7');
        $this->addSql('DROP TABLE arena');
        $this->addSql('DROP TABLE competition');
        $this->addSql('DROP TABLE competition_equipe');
        $this->addSql('DROP TABLE equipe');
        $this->addSql('DROP TABLE joueur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
