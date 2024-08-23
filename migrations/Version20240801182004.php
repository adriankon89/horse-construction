<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240801182004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rent (id INT AUTO_INCREMENT NOT NULL, equipment_id INT DEFAULT NULL, start_rent_date DATE NOT NULL, end_rate_date DATE NOT NULL, INDEX IDX_2784DCC517FE9FE (equipment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repair (id INT AUTO_INCREMENT NOT NULL, equipment_id INT NOT NULL, start_repair_date DATE NOT NULL, end_repair_date DATE DEFAULT NULL, actual_repair_date DATE DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, INDEX IDX_8EE43421517FE9FE (equipment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCC517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id)');
        $this->addSql('ALTER TABLE repair ADD CONSTRAINT FK_8EE43421517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rent DROP FOREIGN KEY FK_2784DCC517FE9FE');
        $this->addSql('ALTER TABLE repair DROP FOREIGN KEY FK_8EE43421517FE9FE');
        $this->addSql('DROP TABLE rent');
        $this->addSql('DROP TABLE repair');
    }
}
