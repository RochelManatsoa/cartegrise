<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190118133716 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE documents (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, rectoverso TINYINT(1) NOT NULL, nb_doc INT NOT NULL, texte LONGTEXT DEFAULT NULL, info LONGTEXT DEFAULT NULL, obligation TINYINT(1) NOT NULL, duree_validite VARCHAR(255) NOT NULL COMMENT \'(DC2Type:dateinterval)\', date_heure DATETIME NOT NULL, image_en_bd VARCHAR(255) NOT NULL, repertoire VARCHAR(255) NOT NULL, fichier VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_A2B07288C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B07288C54C8C93 FOREIGN KEY (type_id) REFERENCES type_demande (id)');
        $this->addSql('ALTER TABLE fichier ADD envoye_le DATETIME NOT NULL, ADD valide_le DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE documents');
        $this->addSql('ALTER TABLE fichier DROP envoye_le, DROP valide_le');
    }
}
