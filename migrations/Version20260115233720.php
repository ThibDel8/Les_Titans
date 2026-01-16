<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260115233720 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact_messages (id BINARY(16) NOT NULL, email VARCHAR(255) NOT NULL, subject VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, is_unread TINYINT DEFAULT 1 NOT NULL, created_at DATETIME NOT NULL, answer_by VARCHAR(255) DEFAULT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE memberships (id BINARY(16) NOT NULL, profile_image VARCHAR(255) DEFAULT NULL, lastname VARCHAR(100) NOT NULL, firstname VARCHAR(100) NOT NULL, birthdate DATE NOT NULL, gender VARCHAR(10) NOT NULL, phone VARCHAR(20) NOT NULL, address VARCHAR(255) NOT NULL, postalcode VARCHAR(10) NOT NULL, city VARCHAR(100) NOT NULL, email VARCHAR(180) NOT NULL, tutor_lastname VARCHAR(100) DEFAULT NULL, tutor_firstname VARCHAR(100) DEFAULT NULL, tutor_phone VARCHAR(20) DEFAULT NULL, tutor_email VARCHAR(180) DEFAULT NULL, tutor_address VARCHAR(255) DEFAULT NULL, tutor_postalcode VARCHAR(10) DEFAULT NULL, tutor_city VARCHAR(100) DEFAULT NULL, medical_certificate_expiry DATE DEFAULT NULL, access_badge_deposit INT DEFAULT NULL, annual_membership_fee INT DEFAULT NULL, created_at DATETIME NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE users (id BINARY(16) NOT NULL, profile_image VARCHAR(255) DEFAULT NULL, lastname VARCHAR(100) NOT NULL, firstname VARCHAR(100) NOT NULL, birthdate DATE NOT NULL, gender VARCHAR(10) NOT NULL, phone VARCHAR(20) NOT NULL, address VARCHAR(255) NOT NULL, postalcode VARCHAR(10) NOT NULL, city VARCHAR(100) NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) DEFAULT NULL, roles JSON NOT NULL, tutor_lastname VARCHAR(100) DEFAULT NULL, tutor_firstname VARCHAR(100) DEFAULT NULL, tutor_phone VARCHAR(20) DEFAULT NULL, tutor_email VARCHAR(180) DEFAULT NULL, tutor_address VARCHAR(255) DEFAULT NULL, tutor_postalcode VARCHAR(10) DEFAULT NULL, tutor_city VARCHAR(100) DEFAULT NULL, medical_certificate_expiry DATE DEFAULT NULL, access_badge_deposit INT DEFAULT NULL, annual_membership_fee INT DEFAULT NULL, access_badge_number VARCHAR(10) DEFAULT NULL, password_setup_token VARCHAR(64) DEFAULT NULL, password_setup_token_expires_at DATETIME DEFAULT NULL, created_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), UNIQUE INDEX UNIQ_1483A5E978602453 (access_badge_number), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE contact_messages');
        $this->addSql('DROP TABLE memberships');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
