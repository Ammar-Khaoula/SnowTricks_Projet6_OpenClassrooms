<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231106113848 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE video_urls DROP FOREIGN KEY FK_2D036A7D3B153154');
        $this->addSql('DROP INDEX IDX_2D036A7D3B153154 ON video_urls');
        $this->addSql('ALTER TABLE video_urls ADD url VARCHAR(255) NOT NULL, CHANGE tricks_id trick_id INT NOT NULL, CHANGE name title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE video_urls ADD CONSTRAINT FK_2D036A7DB281BE2E FOREIGN KEY (trick_id) REFERENCES tricks (id)');
        $this->addSql('CREATE INDEX IDX_2D036A7DB281BE2E ON video_urls (trick_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE video_urls DROP FOREIGN KEY FK_2D036A7DB281BE2E');
        $this->addSql('DROP INDEX IDX_2D036A7DB281BE2E ON video_urls');
        $this->addSql('ALTER TABLE video_urls ADD name VARCHAR(255) NOT NULL, DROP title, DROP url, CHANGE trick_id tricks_id INT NOT NULL');
        $this->addSql('ALTER TABLE video_urls ADD CONSTRAINT FK_2D036A7D3B153154 FOREIGN KEY (tricks_id) REFERENCES tricks (id)');
        $this->addSql('CREATE INDEX IDX_2D036A7D3B153154 ON video_urls (tricks_id)');
    }
}
