<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220423022036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rating_rec (id_rating INT AUTO_INCREMENT NOT NULL, id_reclamation INT DEFAULT NULL, ratingrec DOUBLE PRECISION NOT NULL, INDEX IDX_7DDCF7D5D672A9F3 (id_reclamation), PRIMARY KEY(id_rating)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rating_rec ADD CONSTRAINT FK_7DDCF7D5D672A9F3 FOREIGN KEY (id_reclamation) REFERENCES reclamation (idReclamation)');
        $this->addSql('DROP TABLE rating');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rating (id_rating INT AUTO_INCREMENT NOT NULL, id_reclamation INT DEFAULT NULL, ratingrec DOUBLE PRECISION NOT NULL, INDEX IDX_D8892622D672A9F3 (id_reclamation), PRIMARY KEY(id_rating)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE rating_rec');
    }
}
