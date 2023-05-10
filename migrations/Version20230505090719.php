<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230505090719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clients (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, telephone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipements (id INT AUTO_INCREMENT NOT NULL, modele VARCHAR(255) NOT NULL, magasin VARCHAR(255) NOT NULL, prix INT NOT NULL, details LONGTEXT DEFAULT NULL, public VARCHAR(255) DEFAULT NULL, informations LONGTEXT DEFAULT NULL, image LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservations (id INT AUTO_INCREMENT NOT NULL, client_id_id INT NOT NULL, equipement_id_id INT NOT NULL, date DATE NOT NULL, INDEX IDX_4DA239DC2902E0 (client_id_id), INDEX IDX_4DA23959727262 (equipement_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239DC2902E0 FOREIGN KEY (client_id_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA23959727262 FOREIGN KEY (equipement_id_id) REFERENCES equipements (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239DC2902E0');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA23959727262');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE equipements');
        $this->addSql('DROP TABLE reservations');
    }
}
