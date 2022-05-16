<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220509214102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE product ADD datapro DATETIME NOT NULL, CHANGE price price NUMERIC(1, 2) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE product DROP datapro, CHANGE price price NUMERIC(10, 2) NOT NULL');
    }
}
