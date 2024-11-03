<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241031070009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE choice_method_payment DROP FOREIGN KEY FK_DDC0C090E7EC8C0F');
        $this->addSql('ALTER TABLE choice_method_payment DROP FOREIGN KEY FK_DDC0C0905AA1164F');
        $this->addSql('ALTER TABLE choice_method_payment_faculty DROP FOREIGN KEY FK_E0CE0F18CBCC68E3');
        $this->addSql('ALTER TABLE choice_method_payment_faculty DROP FOREIGN KEY FK_E0CE0F18680CAB68');
        $this->addSql('DROP TABLE choice_method_payment');
        $this->addSql('DROP TABLE choice_method_payment_faculty');
        $this->addSql('DROP TABLE payment_method');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE choice_method_payment (id INT AUTO_INCREMENT NOT NULL, payment_method_id INT NOT NULL, year_academic_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_DDC0C0905AA1164F (payment_method_id), INDEX IDX_DDC0C090E7EC8C0F (year_academic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE choice_method_payment_faculty (choice_method_payment_id INT NOT NULL, faculty_id INT NOT NULL, INDEX IDX_E0CE0F18CBCC68E3 (choice_method_payment_id), INDEX IDX_E0CE0F18680CAB68 (faculty_id), PRIMARY KEY(choice_method_payment_id, faculty_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE payment_method (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, number_account VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, file_path VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_7B61A1F6AA46231 (number_account), UNIQUE INDEX UNIQ_7B61A1F65E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE choice_method_payment ADD CONSTRAINT FK_DDC0C090E7EC8C0F FOREIGN KEY (year_academic_id) REFERENCES year_academic (id)');
        $this->addSql('ALTER TABLE choice_method_payment ADD CONSTRAINT FK_DDC0C0905AA1164F FOREIGN KEY (payment_method_id) REFERENCES payment_method (id)');
        $this->addSql('ALTER TABLE choice_method_payment_faculty ADD CONSTRAINT FK_E0CE0F18CBCC68E3 FOREIGN KEY (choice_method_payment_id) REFERENCES choice_method_payment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE choice_method_payment_faculty ADD CONSTRAINT FK_E0CE0F18680CAB68 FOREIGN KEY (faculty_id) REFERENCES faculty (id) ON DELETE CASCADE');
    }
}
