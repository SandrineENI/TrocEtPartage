<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251007122155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE edito (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, contenu LONGTEXT DEFAULT NULL, photo_principale VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE edito_image (id INT AUTO_INCREMENT NOT NULL, edito_id INT NOT NULL, fichier VARCHAR(255) NOT NULL, legende VARCHAR(255) DEFAULT NULL, INDEX IDX_C9EBF2655B3CFAAA (edito_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE edito_image ADD CONSTRAINT FK_C9EBF2655B3CFAAA FOREIGN KEY (edito_id) REFERENCES edito (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE edito_image DROP FOREIGN KEY FK_C9EBF2655B3CFAAA');
        $this->addSql('DROP TABLE edito');
        $this->addSql('DROP TABLE edito_image');
    }
}
