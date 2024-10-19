<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241019112007 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE member (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, watch_box_id INTEGER DEFAULT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, CONSTRAINT FK_70E4FA789F5787A3 FOREIGN KEY (watch_box_id) REFERENCES watch_box (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_70E4FA789F5787A3 ON member (watch_box_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON member (email)');
        $this->addSql('CREATE TABLE showcase (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, créateur_id INTEGER NOT NULL, description VARCHAR(255) NOT NULL, publiée BOOLEAN NOT NULL, CONSTRAINT FK_14B88CD06C83C3CE FOREIGN KEY (créateur_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_14B88CD06C83C3CE ON showcase (créateur_id)');
        $this->addSql('CREATE TABLE showcase_watch (showcase_id INTEGER NOT NULL, watch_id INTEGER NOT NULL, PRIMARY KEY(showcase_id, watch_id), CONSTRAINT FK_7FF28ADFB9441CED FOREIGN KEY (showcase_id) REFERENCES showcase (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_7FF28ADFC7C58135 FOREIGN KEY (watch_id) REFERENCES watch (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_7FF28ADFB9441CED ON showcase_watch (showcase_id)');
        $this->addSql('CREATE INDEX IDX_7FF28ADFC7C58135 ON showcase_watch (watch_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE showcase');
        $this->addSql('DROP TABLE showcase_watch');
    }
}
