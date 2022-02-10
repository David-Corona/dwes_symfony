<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220210115943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE usuario ADD is_verified TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categoria CHANGE nombre nombre VARCHAR(255) NOT NULL COLLATE `utf8_spanish_ci`');
        $this->addSql('ALTER TABLE producto CHANGE titulo titulo VARCHAR(255) NOT NULL COLLATE `utf8_spanish_ci`, CHANGE subtitulo subtitulo VARCHAR(255) NOT NULL COLLATE `utf8_spanish_ci`, CHANGE descripcion descripcion LONGTEXT NOT NULL COLLATE `utf8_spanish_ci`, CHANGE imagen imagen VARCHAR(255) NOT NULL COLLATE `utf8_spanish_ci`');
        $this->addSql('ALTER TABLE usuario DROP is_verified, CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8_spanish_ci`, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8_spanish_ci` COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8_spanish_ci`, CHANGE nombre nombre VARCHAR(255) DEFAULT NULL COLLATE `utf8_spanish_ci`, CHANGE apellido1 apellido1 VARCHAR(255) DEFAULT NULL COLLATE `utf8_spanish_ci`, CHANGE apellido2 apellido2 VARCHAR(255) DEFAULT NULL COLLATE `utf8_spanish_ci`');
    }
}
