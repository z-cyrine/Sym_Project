<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241009131915 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__watch AS SELECT id, watch_box_id, brand, model, price, description FROM watch');
        $this->addSql('DROP TABLE watch');
        $this->addSql('CREATE TABLE watch (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, watch_box_id INTEGER DEFAULT NULL, brand VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, price INTEGER NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_500B4A269F5787A3 FOREIGN KEY (watch_box_id) REFERENCES watch_box (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO watch (id, watch_box_id, brand, model, price, description) SELECT id, watch_box_id, brand, model, price, description FROM __temp__watch');
        $this->addSql('DROP TABLE __temp__watch');
        $this->addSql('CREATE INDEX IDX_500B4A269F5787A3 ON watch (watch_box_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__watch AS SELECT id, watch_box_id, brand, model, price, description FROM watch');
        $this->addSql('DROP TABLE watch');
        $this->addSql('CREATE TABLE watch (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, watch_box_id INTEGER DEFAULT NULL, brand VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, price INTEGER NOT NULL, description VARCHAR(255) NOT NULL, images CLOB DEFAULT NULL --(DC2Type:array)
        , CONSTRAINT FK_500B4A269F5787A3 FOREIGN KEY (watch_box_id) REFERENCES watch_box (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO watch (id, watch_box_id, brand, model, price, description) SELECT id, watch_box_id, brand, model, price, description FROM __temp__watch');
        $this->addSql('DROP TABLE __temp__watch');
        $this->addSql('CREATE INDEX IDX_500B4A269F5787A3 ON watch (watch_box_id)');
    }
}
