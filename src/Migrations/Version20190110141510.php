<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190110141510 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contenu_fichier (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, carte_grise TINYINT(1) NOT NULL, demand_imm TINYINT(1) NOT NULL, mandat TINYINT(1) NOT NULL, quitus_fisc TINYINT(1) NOT NULL, cert_conformite TINYINT(1) NOT NULL, piece_identite TINYINT(1) NOT NULL, justif_domicile TINYINT(1) NOT NULL, pv_controle_tech TINYINT(1) NOT NULL, declar_achat TINYINT(1) NOT NULL, permis_cond TINYINT(1) NOT NULL, attest_assur TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE contenu_fichier');
    }
}
