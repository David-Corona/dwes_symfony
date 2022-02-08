<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220208110335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A7BB061517713E5A ON producto (titulo)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_A7BB061517713E5A ON producto');
        $this->addSql('ALTER TABLE producto CHANGE titulo titulo VARCHAR(255) NOT NULL COLLATE `utf8_spanish_ci`, CHANGE subtitulo subtitulo VARCHAR(255) NOT NULL COLLATE `utf8_spanish_ci`, CHANGE descripcion descripcion LONGTEXT NOT NULL COLLATE `utf8_spanish_ci`, CHANGE imagen imagen VARCHAR(255) NOT NULL COLLATE `utf8_spanish_ci`');
    }
}
