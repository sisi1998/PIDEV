<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230306160016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE joueur (id INT AUTO_INCREMENT NOT NULL, equipe_j_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, date_naissance VARCHAR(255) NOT NULL, INDEX IDX_FD71A9C5E59645A7 (equipe_j_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE joueur ADD CONSTRAINT FK_FD71A9C5E59645A7 FOREIGN KEY (equipe_j_id) REFERENCES equipe (id)');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE performance_c ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE performance_c ADD CONSTRAINT FK_93B57E2AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_93B57E2AA76ED395 ON performance_c (user_id)');
        $this->addSql('ALTER TABLE user ADD equipe_j_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649E59645A7 FOREIGN KEY (equipe_j_id) REFERENCES equipe (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649E59645A7 ON user (equipe_j_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, headers LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, queue_name VARCHAR(190) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE joueur DROP FOREIGN KEY FK_FD71A9C5E59645A7');
        $this->addSql('DROP TABLE joueur');
        $this->addSql('ALTER TABLE performance_c DROP FOREIGN KEY FK_93B57E2AA76ED395');
        $this->addSql('DROP INDEX IDX_93B57E2AA76ED395 ON performance_c');
        $this->addSql('ALTER TABLE performance_c DROP user_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649E59645A7');
        $this->addSql('DROP INDEX IDX_8D93D649E59645A7 ON user');
        $this->addSql('ALTER TABLE user DROP equipe_j_id');
    }
}
