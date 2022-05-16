<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220516003735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment ADD product_id INT DEFAULT NULL, ADD productid_id INT NOT NULL, CHANGE datecomment datecomment DATETIME NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CAF89CCED FOREIGN KEY (productid_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_9474526C4584665A ON comment (product_id)');
        $this->addSql('CREATE INDEX IDX_9474526CAF89CCED ON comment (productid_id)');
        $this->addSql('ALTER TABLE contact CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE price price NUMERIC(1, 2) NOT NULL, CHANGE datapro datapro DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C4584665A');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CAF89CCED');
        $this->addSql('DROP INDEX IDX_9474526C4584665A ON comment');
        $this->addSql('DROP INDEX IDX_9474526CAF89CCED ON comment');
        $this->addSql('ALTER TABLE comment DROP product_id, DROP productid_id, CHANGE datecomment datecomment DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE contact CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE price price NUMERIC(10, 2) NOT NULL, CHANGE datapro datapro TIME NOT NULL');
    }
}
