<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211009101219 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE service_stages (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE services (id INT AUTO_INCREMENT NOT NULL, service_type_id INT NOT NULL, client_id INT NOT NULL, service_stage_id INT NOT NULL, folio VARCHAR(18) NOT NULL, details LONGTEXT DEFAULT NULL, is_billable TINYINT(1) NOT NULL, is_served TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', served_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7332E169AC8DE0F (service_type_id), INDEX IDX_7332E16919EB6921 (client_id), INDEX IDX_7332E169DBEE8AAE (service_stage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E169AC8DE0F FOREIGN KEY (service_type_id) REFERENCES service_types (id)');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E16919EB6921 FOREIGN KEY (client_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE services ADD CONSTRAINT FK_7332E169DBEE8AAE FOREIGN KEY (service_stage_id) REFERENCES service_stages (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE services DROP FOREIGN KEY FK_7332E169DBEE8AAE');
        $this->addSql('DROP TABLE service_stages');
        $this->addSql('DROP TABLE services');
    }
}
