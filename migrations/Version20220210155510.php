<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220210155510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE producto ADD usuario_id INT NOT NULL');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB0615DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('CREATE INDEX IDX_A7BB0615DB38439E ON producto (usuario_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categoria CHANGE nombre nombre VARCHAR(255) NOT NULL COLLATE `utf8_spanish_ci`');
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB0615DB38439E');
        $this->addSql('DROP INDEX IDX_A7BB0615DB38439E ON producto');
        $this->addSql('ALTER TABLE producto DROP usuario_id, CHANGE titulo titulo VARCHAR(255) NOT NULL COLLATE `utf8_spanish_ci`, CHANGE subtitulo subtitulo VARCHAR(255) NOT NULL COLLATE `utf8_spanish_ci`, CHANGE descripcion descripcion LONGTEXT NOT NULL COLLATE `utf8_spanish_ci`, CHANGE imagen imagen VARCHAR(255) NOT NULL COLLATE `utf8_spanish_ci`');
        $this->addSql('ALTER TABLE usuario CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8_spanish_ci`, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8_spanish_ci` COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8_spanish_ci`, CHANGE nombre nombre VARCHAR(255) DEFAULT NULL COLLATE `utf8_spanish_ci`, CHANGE apellido1 apellido1 VARCHAR(255) DEFAULT NULL COLLATE `utf8_spanish_ci`, CHANGE apellido2 apellido2 VARCHAR(255) DEFAULT NULL COLLATE `utf8_spanish_ci`');
    }
}
