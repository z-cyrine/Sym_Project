<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240924162328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE watch_box ADD COLUMN name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE watch_box ADD COLUMN description VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__watch_box AS SELECT id FROM watch_box');
        $this->addSql('DROP TABLE watch_box');
        $this->addSql('CREATE TABLE watch_box (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('INSERT INTO watch_box (id) SELECT id FROM __temp__watch_box');
        $this->addSql('DROP TABLE __temp__watch_box');
    }
}
