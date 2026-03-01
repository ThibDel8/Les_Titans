<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260301160042 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE audit_log (id BINARY(16) NOT NULL, occurred_at DATETIME NOT NULL, author_id VARCHAR(36) NOT NULL, author_fullname VARCHAR(100) NOT NULL, author_email VARCHAR(180) NOT NULL, action VARCHAR(255) NOT NULL, entity_type VARCHAR(255) NOT NULL, entity_id VARCHAR(36) NOT NULL, message LONGTEXT DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE contact_message (id BINARY(16) NOT NULL, email VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, body LONGTEXT NOT NULL, status VARCHAR(255) NOT NULL, answer LONGTEXT DEFAULT NULL, answered_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, assigned_to_id BINARY(16) DEFAULT NULL, answered_by_id BINARY(16) DEFAULT NULL, INDEX IDX_2C9211FEF4BD7827 (assigned_to_id), INDEX IDX_2C9211FE2FC55A77 (answered_by_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE membership (id BINARY(16) NOT NULL, profile_image VARCHAR(255) DEFAULT NULL, lastname VARCHAR(100) NOT NULL, firstname VARCHAR(100) NOT NULL, birthdate DATE NOT NULL, gender VARCHAR(10) NOT NULL, phone VARCHAR(20) NOT NULL, address VARCHAR(255) NOT NULL, postalcode VARCHAR(10) NOT NULL, city VARCHAR(100) NOT NULL, email VARCHAR(180) NOT NULL, tutor_lastname VARCHAR(100) DEFAULT NULL, tutor_firstname VARCHAR(100) DEFAULT NULL, tutor_phone VARCHAR(20) DEFAULT NULL, tutor_email VARCHAR(180) DEFAULT NULL, tutor_address VARCHAR(255) DEFAULT NULL, tutor_postalcode VARCHAR(10) DEFAULT NULL, tutor_city VARCHAR(100) DEFAULT NULL, medical_certificate_expiry DATE DEFAULT NULL, access_badge_deposit INT DEFAULT NULL, annual_membership_fee INT DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE post (id BINARY(16) NOT NULL, text LONGTEXT NOT NULL, attachments JSON NOT NULL, link_preview JSON NOT NULL, created_at DATETIME NOT NULL, author_id BINARY(16) DEFAULT NULL, INDEX IDX_5A8A6C8DF675F31B (author_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE post_comment (id BINARY(16) NOT NULL, text LONGTEXT NOT NULL, created_at DATETIME NOT NULL, post_id BINARY(16) NOT NULL, author_id BINARY(16) DEFAULT NULL, INDEX IDX_A99CE55F4B89032C (post_id), INDEX IDX_A99CE55FF675F31B (author_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL, expires_at DATETIME NOT NULL, user_id BINARY(16) NOT NULL, INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id BINARY(16) NOT NULL, profile_image VARCHAR(255) DEFAULT NULL, lastname VARCHAR(100) NOT NULL, firstname VARCHAR(100) NOT NULL, birthdate DATE NOT NULL, gender VARCHAR(10) NOT NULL, phone VARCHAR(20) NOT NULL, address VARCHAR(255) NOT NULL, postalcode VARCHAR(10) NOT NULL, city VARCHAR(100) NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) DEFAULT NULL, roles JSON NOT NULL, tutor_lastname VARCHAR(100) DEFAULT NULL, tutor_firstname VARCHAR(100) DEFAULT NULL, tutor_phone VARCHAR(20) DEFAULT NULL, tutor_email VARCHAR(180) DEFAULT NULL, tutor_address VARCHAR(255) DEFAULT NULL, tutor_postalcode VARCHAR(10) DEFAULT NULL, tutor_city VARCHAR(100) DEFAULT NULL, medical_certificate_expiry DATE DEFAULT NULL, access_badge_deposit INT DEFAULT NULL, annual_membership_fee INT DEFAULT NULL, access_badge_number VARCHAR(10) DEFAULT NULL, password_setup_token VARCHAR(64) DEFAULT NULL, password_setup_token_expires_at DATETIME DEFAULT NULL, created_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D64978602453 (access_badge_number), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE contact_message ADD CONSTRAINT FK_2C9211FEF4BD7827 FOREIGN KEY (assigned_to_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE contact_message ADD CONSTRAINT FK_2C9211FE2FC55A77 FOREIGN KEY (answered_by_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DF675F31B FOREIGN KEY (author_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE post_comment ADD CONSTRAINT FK_A99CE55F4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE post_comment ADD CONSTRAINT FK_A99CE55FF675F31B FOREIGN KEY (author_id) REFERENCES user (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact_message DROP FOREIGN KEY FK_2C9211FEF4BD7827');
        $this->addSql('ALTER TABLE contact_message DROP FOREIGN KEY FK_2C9211FE2FC55A77');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DF675F31B');
        $this->addSql('ALTER TABLE post_comment DROP FOREIGN KEY FK_A99CE55F4B89032C');
        $this->addSql('ALTER TABLE post_comment DROP FOREIGN KEY FK_A99CE55FF675F31B');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE audit_log');
        $this->addSql('DROP TABLE contact_message');
        $this->addSql('DROP TABLE membership');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE post_comment');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
