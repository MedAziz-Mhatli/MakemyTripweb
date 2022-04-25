<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220421153657 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE users_clubs (user_id INT NOT NULL, offre_id INT NOT NULL, INDEX IDX_42CA956AA76ED395 (user_id), INDEX IDX_42CA956A4CC8505A (offre_id), PRIMARY KEY(user_id, offre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_clubs ADD CONSTRAINT FK_42CA956AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE users_clubs ADD CONSTRAINT FK_42CA956A4CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE admin ADD email VARCHAR(60) NOT NULL, ADD password VARCHAR(64) NOT NULL, ADD is_active TINYINT(1) NOT NULL, ADD name VARCHAR(255) DEFAULT NULL, ADD token VARCHAR(255) DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, ADD activated_at DATETIME DEFAULT NULL, DROP nom, DROP prenom, DROP motdepasse, DROP adresse');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_49CF2272E7927C74 ON admin (email)');
        $this->addSql('ALTER TABLE user DROP phone_Number, CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE token token VARCHAR(255) DEFAULT NULL, CHANGE activated_at activated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE users_clubs');
        $this->addSql('DROP INDEX UNIQ_49CF2272E7927C74 ON `Admin`');
        $this->addSql('ALTER TABLE `Admin` ADD nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD motdepasse VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD adresse VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP email, DROP password, DROP is_active, DROP name, DROP token, DROP created_at, DROP updated_at, DROP activated_at');
        $this->addSql('ALTER TABLE user ADD phone_Number INT NOT NULL, CHANGE name name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE token token VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE activated_at activated_at DATETIME DEFAULT \'NULL\'');
    }
}
