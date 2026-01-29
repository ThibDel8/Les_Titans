<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260201105026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Ajout du module Publications';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE post_comments (id BINARY(16) NOT NULL, text LONGTEXT NOT NULL, created_at DATETIME NOT NULL, post_id BINARY(16) NOT NULL, author_id BINARY(16) DEFAULT NULL, INDEX IDX_E0731F8B4B89032C (post_id), INDEX IDX_E0731F8BF675F31B (author_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE posts (id BINARY(16) NOT NULL, text LONGTEXT NOT NULL, attachments JSON NOT NULL, link_preview JSON NOT NULL, created_at DATETIME NOT NULL, author_id BINARY(16) DEFAULT NULL, INDEX IDX_885DBAFAF675F31B (author_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE post_comments ADD CONSTRAINT FK_E0731F8B4B89032C FOREIGN KEY (post_id) REFERENCES posts (id)');
        $this->addSql('ALTER TABLE post_comments ADD CONSTRAINT FK_E0731F8BF675F31B FOREIGN KEY (author_id) REFERENCES users (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE posts ADD CONSTRAINT FK_885DBAFAF675F31B FOREIGN KEY (author_id) REFERENCES users (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_comments DROP FOREIGN KEY FK_E0731F8B4B89032C');
        $this->addSql('ALTER TABLE post_comments DROP FOREIGN KEY FK_E0731F8BF675F31B');
        $this->addSql('ALTER TABLE posts DROP FOREIGN KEY FK_885DBAFAF675F31B');
        $this->addSql('DROP TABLE post_comments');
        $this->addSql('DROP TABLE posts');
    }
}
