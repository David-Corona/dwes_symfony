<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220209105000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categoria (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_spanish_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_2265B05DF85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_spanish_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE producto ADD categoria_id INT NOT NULL');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB06153397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
        $this->addSql('CREATE INDEX IDX_A7BB06153397707A ON producto (categoria_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB06153397707A');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE usuario');
        $this->addSql('DROP INDEX IDX_A7BB06153397707A ON producto');
        $this->addSql('ALTER TABLE producto DROP categoria_id, CHANGE titulo titulo VARCHAR(255) NOT NULL COLLATE `utf8_spanish_ci`, CHANGE subtitulo subtitulo VARCHAR(255) NOT NULL COLLATE `utf8_spanish_ci`, CHANGE descripcion descripcion LONGTEXT NOT NULL COLLATE `utf8_spanish_ci`, CHANGE imagen imagen VARCHAR(255) NOT NULL COLLATE `utf8_spanish_ci`');
    }
}
