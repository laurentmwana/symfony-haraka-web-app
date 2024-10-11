<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241011214636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paid DROP FOREIGN KEY FK_FD8EAB389BB17698');
        $this->addSql('DROP INDEX IDX_FD8EAB389BB17698 ON paid');
        $this->addSql('ALTER TABLE paid DROP amount_id');
        $this->addSql('ALTER TABLE payment ADD student_id INT NOT NULL, ADD amount_id INT NOT NULL, ADD level_id INT NOT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DCB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D9BB17698 FOREIGN KEY (amount_id) REFERENCES amount (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D5FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('CREATE INDEX IDX_6D28840DCB944F1A ON payment (student_id)');
        $this->addSql('CREATE INDEX IDX_6D28840D9BB17698 ON payment (amount_id)');
        $this->addSql('CREATE INDEX IDX_6D28840D5FB14BA7 ON payment (level_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paid ADD amount_id INT NOT NULL');
        $this->addSql('ALTER TABLE paid ADD CONSTRAINT FK_FD8EAB389BB17698 FOREIGN KEY (amount_id) REFERENCES amount (id)');
        $this->addSql('CREATE INDEX IDX_FD8EAB389BB17698 ON paid (amount_id)');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DCB944F1A');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D9BB17698');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D5FB14BA7');
        $this->addSql('DROP INDEX IDX_6D28840DCB944F1A ON payment');
        $this->addSql('DROP INDEX IDX_6D28840D9BB17698 ON payment');
        $this->addSql('DROP INDEX IDX_6D28840D5FB14BA7 ON payment');
        $this->addSql('ALTER TABLE payment DROP student_id, DROP amount_id, DROP level_id');
    }
}
