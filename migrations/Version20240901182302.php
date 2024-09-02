<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240901182302 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipment CHANGE status status VARCHAR(50) DEFAULT \'draft\' NOT NULL');
        $this->addSql('ALTER TABLE rent ADD transport TINYINT(1) DEFAULT 0 NOT NULL, ADD cleaning TINYINT(1) DEFAULT 0 NOT NULL, CHANGE discount discount INT DEFAULT 0');
        $this->addSql('ALTER TABLE repair CHANGE created_at created_at DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipment CHANGE status status VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE repair CHANGE created_at created_at DATE DEFAULT \'2000-01-01\' NOT NULL');
        $this->addSql('ALTER TABLE rent DROP transport, DROP cleaning, CHANGE discount discount INT DEFAULT NULL');
    }
}
