<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241214183742 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actual_level (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, level_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_B5C5B2D1CB944F1A (student_id), INDEX IDX_B5C5B2D15FB14BA7 (level_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE amount (id INT AUTO_INCREMENT NOT NULL, programme_id INT NOT NULL, year_academic_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, max_number_installment INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, generate TINYINT(1) NOT NULL, INDEX IDX_8EA1704262BB7AEE (programme_id), INDEX IDX_8EA17042E7EC8C0F (year_academic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE checker (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, number_phone VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_59D70FD2FF061415 (number_phone), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, subject LONGTEXT NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE department (id INT AUTO_INCREMENT NOT NULL, faculty_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, alias VARCHAR(20) NOT NULL, INDEX IDX_CD1DE18A680CAB68 (faculty_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expense_control (id INT AUTO_INCREMENT NOT NULL, start_at DATE NOT NULL, end_at DATE NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expense_control_year_academic (expense_control_id INT NOT NULL, year_academic_id INT NOT NULL, INDEX IDX_E56ADEF982AAF807 (expense_control_id), INDEX IDX_E56ADEF9E7EC8C0F (year_academic_id), PRIMARY KEY(expense_control_id, year_academic_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faculty (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_179660435E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE installment (id INT AUTO_INCREMENT NOT NULL, amount_id INT NOT NULL, price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, priority INT NOT NULL, INDEX IDX_4B778ACD9BB17698 (amount_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE level (id INT AUTO_INCREMENT NOT NULL, programme_id INT NOT NULL, sector_id INT NOT NULL, year_academic_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_9AEACC1362BB7AEE (programme_id), INDEX IDX_9AEACC13DE95C867 (sector_id), INDEX IDX_9AEACC13E7EC8C0F (year_academic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, priority INT NOT NULL, to_route VARCHAR(255) NOT NULL, eye TINYINT(1) NOT NULL, eye_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_BF5476CAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paid (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, level_id INT NOT NULL, state VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, file_path VARCHAR(255) DEFAULT NULL, token VARCHAR(255) NOT NULL, INDEX IDX_FD8EAB38CB944F1A (student_id), INDEX IDX_FD8EAB385FB14BA7 (level_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, student_id INT NOT NULL, amount_id INT NOT NULL, installment_id INT DEFAULT NULL, level_id INT DEFAULT NULL, payment_at DATETIME DEFAULT NULL, paid TINYINT(1) NOT NULL, INDEX IDX_6D28840DCB944F1A (student_id), INDEX IDX_6D28840D9BB17698 (amount_id), INDEX IDX_6D28840DF03B5436 (installment_id), INDEX IDX_6D28840D5FB14BA7 (level_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE programme (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, alias VARCHAR(20) NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_3DDCB9FF5E237E06 (name), UNIQUE INDEX UNIQ_3DDCB9FFE16C6B94 (alias), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz (id INT AUTO_INCREMENT NOT NULL, request LONGTEXT NOT NULL, response LONGTEXT NOT NULL, featured TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_A412FA923B978F9F (request), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sector (id INT AUTO_INCREMENT NOT NULL, department_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, alias VARCHAR(20) NOT NULL, INDEX IDX_4BA3D9E8AE80F5DF (department_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) DEFAULT NULL, gender VARCHAR(255) NOT NULL, happy DATE NOT NULL, number_phone VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, identificator_path VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B723AF33FF061415 (number_phone), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE student_level (student_id INT NOT NULL, level_id INT NOT NULL, INDEX IDX_12DDB58ECB944F1A (student_id), INDEX IDX_12DDB58E5FB14BA7 (level_id), PRIMARY KEY(student_id, level_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, student_id INT DEFAULT NULL, checker_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, file_path VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649CB944F1A (student_id), UNIQUE INDEX UNIQ_8D93D64977637F8F (checker_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE year_academic (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, closed TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, closed_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_699FFD6D5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actual_level ADD CONSTRAINT FK_B5C5B2D1CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE actual_level ADD CONSTRAINT FK_B5C5B2D15FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE amount ADD CONSTRAINT FK_8EA1704262BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('ALTER TABLE amount ADD CONSTRAINT FK_8EA17042E7EC8C0F FOREIGN KEY (year_academic_id) REFERENCES year_academic (id)');
        $this->addSql('ALTER TABLE department ADD CONSTRAINT FK_CD1DE18A680CAB68 FOREIGN KEY (faculty_id) REFERENCES faculty (id)');
        $this->addSql('ALTER TABLE expense_control_year_academic ADD CONSTRAINT FK_E56ADEF982AAF807 FOREIGN KEY (expense_control_id) REFERENCES expense_control (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE expense_control_year_academic ADD CONSTRAINT FK_E56ADEF9E7EC8C0F FOREIGN KEY (year_academic_id) REFERENCES year_academic (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE installment ADD CONSTRAINT FK_4B778ACD9BB17698 FOREIGN KEY (amount_id) REFERENCES amount (id)');
        $this->addSql('ALTER TABLE level ADD CONSTRAINT FK_9AEACC1362BB7AEE FOREIGN KEY (programme_id) REFERENCES programme (id)');
        $this->addSql('ALTER TABLE level ADD CONSTRAINT FK_9AEACC13DE95C867 FOREIGN KEY (sector_id) REFERENCES sector (id)');
        $this->addSql('ALTER TABLE level ADD CONSTRAINT FK_9AEACC13E7EC8C0F FOREIGN KEY (year_academic_id) REFERENCES year_academic (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE paid ADD CONSTRAINT FK_FD8EAB38CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE paid ADD CONSTRAINT FK_FD8EAB385FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DCB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D9BB17698 FOREIGN KEY (amount_id) REFERENCES amount (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840DF03B5436 FOREIGN KEY (installment_id) REFERENCES installment (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D5FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sector ADD CONSTRAINT FK_4BA3D9E8AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE student_level ADD CONSTRAINT FK_12DDB58ECB944F1A FOREIGN KEY (student_id) REFERENCES student (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE student_level ADD CONSTRAINT FK_12DDB58E5FB14BA7 FOREIGN KEY (level_id) REFERENCES level (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649CB944F1A FOREIGN KEY (student_id) REFERENCES student (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64977637F8F FOREIGN KEY (checker_id) REFERENCES checker (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actual_level DROP FOREIGN KEY FK_B5C5B2D1CB944F1A');
        $this->addSql('ALTER TABLE actual_level DROP FOREIGN KEY FK_B5C5B2D15FB14BA7');
        $this->addSql('ALTER TABLE amount DROP FOREIGN KEY FK_8EA1704262BB7AEE');
        $this->addSql('ALTER TABLE amount DROP FOREIGN KEY FK_8EA17042E7EC8C0F');
        $this->addSql('ALTER TABLE department DROP FOREIGN KEY FK_CD1DE18A680CAB68');
        $this->addSql('ALTER TABLE expense_control_year_academic DROP FOREIGN KEY FK_E56ADEF982AAF807');
        $this->addSql('ALTER TABLE expense_control_year_academic DROP FOREIGN KEY FK_E56ADEF9E7EC8C0F');
        $this->addSql('ALTER TABLE installment DROP FOREIGN KEY FK_4B778ACD9BB17698');
        $this->addSql('ALTER TABLE level DROP FOREIGN KEY FK_9AEACC1362BB7AEE');
        $this->addSql('ALTER TABLE level DROP FOREIGN KEY FK_9AEACC13DE95C867');
        $this->addSql('ALTER TABLE level DROP FOREIGN KEY FK_9AEACC13E7EC8C0F');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAA76ED395');
        $this->addSql('ALTER TABLE paid DROP FOREIGN KEY FK_FD8EAB38CB944F1A');
        $this->addSql('ALTER TABLE paid DROP FOREIGN KEY FK_FD8EAB385FB14BA7');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DCB944F1A');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D9BB17698');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DF03B5436');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D5FB14BA7');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE sector DROP FOREIGN KEY FK_4BA3D9E8AE80F5DF');
        $this->addSql('ALTER TABLE student_level DROP FOREIGN KEY FK_12DDB58ECB944F1A');
        $this->addSql('ALTER TABLE student_level DROP FOREIGN KEY FK_12DDB58E5FB14BA7');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649CB944F1A');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64977637F8F');
        $this->addSql('DROP TABLE actual_level');
        $this->addSql('DROP TABLE amount');
        $this->addSql('DROP TABLE checker');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE expense_control');
        $this->addSql('DROP TABLE expense_control_year_academic');
        $this->addSql('DROP TABLE faculty');
        $this->addSql('DROP TABLE installment');
        $this->addSql('DROP TABLE level');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE paid');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE programme');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE sector');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE student_level');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE year_academic');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
