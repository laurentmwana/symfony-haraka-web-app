<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241012231044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE choice_method_payment_faculty (choice_method_payment_id INT NOT NULL, faculty_id INT NOT NULL, INDEX IDX_E0CE0F18CBCC68E3 (choice_method_payment_id), INDEX IDX_E0CE0F18680CAB68 (faculty_id), PRIMARY KEY(choice_method_payment_id, faculty_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE choice_method_payment_faculty ADD CONSTRAINT FK_E0CE0F18CBCC68E3 FOREIGN KEY (choice_method_payment_id) REFERENCES choice_method_payment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE choice_method_payment_faculty ADD CONSTRAINT FK_E0CE0F18680CAB68 FOREIGN KEY (faculty_id) REFERENCES faculty (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE choice_method_payment DROP FOREIGN KEY FK_DDC0C090680CAB68');
        $this->addSql('DROP INDEX IDX_DDC0C090680CAB68 ON choice_method_payment');
        $this->addSql('ALTER TABLE choice_method_payment DROP faculty_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE choice_method_payment_faculty DROP FOREIGN KEY FK_E0CE0F18CBCC68E3');
        $this->addSql('ALTER TABLE choice_method_payment_faculty DROP FOREIGN KEY FK_E0CE0F18680CAB68');
        $this->addSql('DROP TABLE choice_method_payment_faculty');
        $this->addSql('ALTER TABLE choice_method_payment ADD faculty_id INT NOT NULL');
        $this->addSql('ALTER TABLE choice_method_payment ADD CONSTRAINT FK_DDC0C090680CAB68 FOREIGN KEY (faculty_id) REFERENCES faculty (id)');
        $this->addSql('CREATE INDEX IDX_DDC0C090680CAB68 ON choice_method_payment (faculty_id)');
    }
}
