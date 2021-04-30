<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210428135831 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE media_article (media_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_63ED882FEA9FDD75 (media_id), INDEX IDX_63ED882F7294869C (article_id), PRIMARY KEY(media_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE media_article ADD CONSTRAINT FK_63ED882FEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE media_article ADD CONSTRAINT FK_63ED882F7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_media DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE article_media ADD PRIMARY KEY (media_id, article_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE media_article');
        $this->addSql('ALTER TABLE article_media DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE article_media ADD PRIMARY KEY (article_id, media_id)');
    }
}
