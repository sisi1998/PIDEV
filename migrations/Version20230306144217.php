<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230306144217 extends AbstractMigration
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
        $this->addSql('ALTER TABLE performance_c DROP nom');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_FD71A9C5E59645A7');
        $this->addSql('DROP INDEX IDX_FD71A9C5E59645A7 ON user');
        $this->addSql('ALTER TABLE user ADD mdp VARCHAR(255) NOT NULL, ADD role VARCHAR(255) NOT NULL, ADD date_birth DATE NOT NULL, ADD is_blocked TINYINT(1) NOT NULL, ADD image VARCHAR(255) DEFAULT NULL, ADD reset_token VARCHAR(255) NOT NULL, DROP equipe_j_id, CHANGE date_naissance email VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE joueur DROP FOREIGN KEY FK_FD71A9C5E59645A7');
        $this->addSql('DROP TABLE joueur');
        $this->addSql('ALTER TABLE performance_c ADD nom VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD equipe_j_id INT NOT NULL, ADD date_naissance VARCHAR(255) NOT NULL, DROP email, DROP mdp, DROP role, DROP date_birth, DROP is_blocked, DROP image, DROP reset_token');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_FD71A9C5E59645A7 FOREIGN KEY (equipe_j_id) REFERENCES equipe (id)');
        $this->addSql('CREATE INDEX IDX_FD71A9C5E59645A7 ON user (equipe_j_id)');
    }
}
