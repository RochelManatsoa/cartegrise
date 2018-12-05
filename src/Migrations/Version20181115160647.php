<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181115160647 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client ADD client_nom VARCHAR(255) NOT NULL, ADD client_prenom VARCHAR(255) NOT NULL, ADD client_genre VARCHAR(255) NOT NULL, ADD client_nom_usage VARCHAR(255) NOT NULL, ADD client_lieu_naissance VARCHAR(255) NOT NULL, ADD client_dpt_naissance VARCHAR(255) NOT NULL, ADD client_pays_naissance VARCHAR(255) NOT NULL, DROP nom, DROP prenom, DROP genre, DROP nomusage, DROP lieunaissance, DROP dptnaissance, DROP paysnaissance, CHANGE datenaissance client_date_naissance DATE NOT NULL');
        $this->addSql('ALTER TABLE contact CHANGE telmobile contact_telmobile VARCHAR(255) NOT NULL, CHANGE telfixe contact_telfixe VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE demande ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A519EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_2694D7A519EB6921 ON demande (client_id)');
        $this->addSql('ALTER TABLE vehicule ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_292FFF1D19EB6921 ON vehicule (client_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client ADD nom VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, ADD prenom VARCHAR(200) NOT NULL COLLATE utf8mb4_unicode_ci, ADD genre VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD nomusage VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD lieunaissance VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD dptnaissance VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD paysnaissance VARCHAR(200) NOT NULL COLLATE utf8mb4_unicode_ci, DROP client_nom, DROP client_prenom, DROP client_genre, DROP client_nom_usage, DROP client_lieu_naissance, DROP client_dpt_naissance, DROP client_pays_naissance, CHANGE client_date_naissance datenaissance DATE NOT NULL');
        $this->addSql('ALTER TABLE contact CHANGE contact_telmobile telmobile VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE contact_telfixe telfixe VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A519EB6921');
        $this->addSql('DROP INDEX IDX_2694D7A519EB6921 ON demande');
        $this->addSql('ALTER TABLE demande DROP client_id');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D19EB6921');
        $this->addSql('DROP INDEX IDX_292FFF1D19EB6921 ON vehicule');
        $this->addSql('ALTER TABLE vehicule DROP client_id');
    }
}
