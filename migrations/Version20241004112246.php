<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241004112246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE expense_control (id INT AUTO_INCREMENT NOT NULL, start_at DATE NOT NULL, end_at DATE NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expense_control_year_academic (expense_control_id INT NOT NULL, year_academic_id INT NOT NULL, INDEX IDX_E56ADEF982AAF807 (expense_control_id), INDEX IDX_E56ADEF9E7EC8C0F (year_academic_id), PRIMARY KEY(expense_control_id, year_academic_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE expense_control_year_academic ADD CONSTRAINT FK_E56ADEF982AAF807 FOREIGN KEY (expense_control_id) REFERENCES expense_control (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE expense_control_year_academic ADD CONSTRAINT FK_E56ADEF9E7EC8C0F FOREIGN KEY (year_academic_id) REFERENCES year_academic (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE expense_control_year_academic DROP FOREIGN KEY FK_E56ADEF982AAF807');
        $this->addSql('ALTER TABLE expense_control_year_academic DROP FOREIGN KEY FK_E56ADEF9E7EC8C0F');
        $this->addSql('DROP TABLE expense_control');
        $this->addSql('DROP TABLE expense_control_year_academic');
    }
}
