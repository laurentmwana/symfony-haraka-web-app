<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241004115436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE assignment (id INT AUTO_INCREMENT NOT NULL, faculty_id INT NOT NULL, expense_control_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_30C544BA680CAB68 (faculty_id), INDEX IDX_30C544BA82AAF807 (expense_control_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assignment_checker (assignment_id INT NOT NULL, checker_id INT NOT NULL, INDEX IDX_3AE9422BD19302F8 (assignment_id), INDEX IDX_3AE9422B77637F8F (checker_id), PRIMARY KEY(assignment_id, checker_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BA680CAB68 FOREIGN KEY (faculty_id) REFERENCES faculty (id)');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BA82AAF807 FOREIGN KEY (expense_control_id) REFERENCES expense_control (id)');
        $this->addSql('ALTER TABLE assignment_checker ADD CONSTRAINT FK_3AE9422BD19302F8 FOREIGN KEY (assignment_id) REFERENCES assignment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assignment_checker ADD CONSTRAINT FK_3AE9422B77637F8F FOREIGN KEY (checker_id) REFERENCES checker (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BA680CAB68');
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BA82AAF807');
        $this->addSql('ALTER TABLE assignment_checker DROP FOREIGN KEY FK_3AE9422BD19302F8');
        $this->addSql('ALTER TABLE assignment_checker DROP FOREIGN KEY FK_3AE9422B77637F8F');
        $this->addSql('DROP TABLE assignment');
        $this->addSql('DROP TABLE assignment_checker');
    }
}
