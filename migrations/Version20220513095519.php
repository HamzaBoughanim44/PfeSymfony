<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220513095519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transport (id INT AUTO_INCREMENT NOT NULL, name_transport VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price_transport DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE price price NUMERIC(1, 2) NOT NULL, CHANGE datapro datapro DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE transport');
        $this->addSql('ALTER TABLE contact CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE price price NUMERIC(10, 2) NOT NULL, CHANGE datapro datapro TIME NOT NULL');
    }
}
