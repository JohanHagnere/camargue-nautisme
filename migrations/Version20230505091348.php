<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230505091348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA23959727262');
        $this->addSql('DROP INDEX IDX_4DA23959727262 ON reservations');
        $this->addSql('ALTER TABLE reservations CHANGE equipement_id_id equipement_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239806F0F5C FOREIGN KEY (equipement_id) REFERENCES equipements (id)');
        $this->addSql('CREATE INDEX IDX_4DA239806F0F5C ON reservations (equipement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239806F0F5C');
        $this->addSql('DROP INDEX IDX_4DA239806F0F5C ON reservations');
        $this->addSql('ALTER TABLE reservations CHANGE equipement_id equipement_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA23959727262 FOREIGN KEY (equipement_id_id) REFERENCES equipements (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_4DA23959727262 ON reservations (equipement_id_id)');
    }
}
