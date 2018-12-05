<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181107172431 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, numero INT NOT NULL, extension VARCHAR(255) NOT NULL, adprecision VARCHAR(255) NOT NULL, typevoie VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, complement VARCHAR(255) NOT NULL, lieudit VARCHAR(255) NOT NULL, codepostal VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, boitepostale VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ancientitulaire (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, raisonsociale VARCHAR(255) NOT NULL, nomprenom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cartegrise (id INT AUTO_INCREMENT NOT NULL, typevehicule VARCHAR(255) NOT NULL, cgdepartement VARCHAR(255) NOT NULL, modele VARCHAR(255) NOT NULL, energie VARCHAR(255) NOT NULL, cv INT NOT NULL, datecirculation DATE NOT NULL, co2 INT NOT NULL, ptac INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, client_compte_id INT DEFAULT NULL, client_contact_id INT DEFAULT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(200) NOT NULL, genre VARCHAR(255) NOT NULL, nomusage VARCHAR(255) NOT NULL, datenaissance DATE NOT NULL, lieunaissance VARCHAR(255) NOT NULL, dptnaissance VARCHAR(255) NOT NULL, paysnaissance VARCHAR(200) NOT NULL, UNIQUE INDEX UNIQ_C744045519E5B62F (client_compte_id), UNIQUE INDEX UNIQ_C744045577F5180B (client_contact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte (id INT AUTO_INCREMENT NOT NULL, mail VARCHAR(255) NOT NULL, pass VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, telmobile VARCHAR(255) NOT NULL, telfixe VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande (id INT AUTO_INCREMENT NOT NULL, demande_client_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, oppose VARCHAR(1) NOT NULL, statut VARCHAR(255) NOT NULL, paiement TINYINT(1) NOT NULL, parameters VARCHAR(255) DEFAULT NULL, INDEX IDX_2694D7A56CC793F4 (demande_client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicule (id INT AUTO_INCREMENT NOT NULL, vehicule_ancientitulaire_id INT DEFAULT NULL, vehicule_adresse_id INT DEFAULT NULL, vehicule_cartegrise_id INT DEFAULT NULL, vehicule_demande_id INT DEFAULT NULL, vehicule_client_id INT DEFAULT NULL, cgpresent VARCHAR(255) NOT NULL, immatriculation VARCHAR(255) NOT NULL, vin VARCHAR(255) NOT NULL, numformule INT NOT NULL, datecg DATE NOT NULL, UNIQUE INDEX UNIQ_292FFF1D688CB924 (vehicule_ancientitulaire_id), UNIQUE INDEX UNIQ_292FFF1D11F846F3 (vehicule_adresse_id), UNIQUE INDEX UNIQ_292FFF1D31881814 (vehicule_cartegrise_id), UNIQUE INDEX UNIQ_292FFF1DDCF6C4B7 (vehicule_demande_id), INDEX IDX_292FFF1DB51BC29A (vehicule_client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C744045519E5B62F FOREIGN KEY (client_compte_id) REFERENCES compte (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C744045577F5180B FOREIGN KEY (client_contact_id) REFERENCES contact (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A56CC793F4 FOREIGN KEY (demande_client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D688CB924 FOREIGN KEY (vehicule_ancientitulaire_id) REFERENCES ancientitulaire (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D11F846F3 FOREIGN KEY (vehicule_adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D31881814 FOREIGN KEY (vehicule_cartegrise_id) REFERENCES cartegrise (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1DDCF6C4B7 FOREIGN KEY (vehicule_demande_id) REFERENCES demande (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1DB51BC29A FOREIGN KEY (vehicule_client_id) REFERENCES client (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D11F846F3');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D688CB924');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D31881814');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A56CC793F4');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1DB51BC29A');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C744045519E5B62F');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C744045577F5180B');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1DDCF6C4B7');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE ancientitulaire');
        $this->addSql('DROP TABLE cartegrise');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE vehicule');
    }
}
