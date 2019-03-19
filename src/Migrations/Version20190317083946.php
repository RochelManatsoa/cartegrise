<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190317083946 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE commande_client (commande_id INT NOT NULL, client_id INT NOT NULL, INDEX IDX_C510FF8082EA2E54 (commande_id), INDEX IDX_C510FF8019EB6921 (client_id), PRIMARY KEY(commande_id, client_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande_client ADD CONSTRAINT FK_C510FF8082EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_client ADD CONSTRAINT FK_C510FF8019EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taxes ADD CONSTRAINT FK_C28EA7F882EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE tarifs_prestations ADD CONSTRAINT FK_D863AC2D82EA2E54 FOREIGN KEY (commande_id) REFERENCES type_demande (id)');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D19EB6921');
        $this->addSql('DROP INDEX IDX_6EEAA67D19EB6921 ON commande');
        $this->addSql('ALTER TABLE commande DROP client_id');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D688CB924 FOREIGN KEY (vehicule_ancientitulaire_id) REFERENCES ancientitulaire (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D31881814 FOREIGN KEY (vehicule_cartegrise_id) REFERENCES cartegrise (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1DDCF6C4B7 FOREIGN KEY (vehicule_demande_id) REFERENCES demande (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1DB51BC29A FOREIGN KEY (vehicule_client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D7F1824A4 FOREIGN KEY (infosup_id) REFERENCES info_sup_veh (id)');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1DA10273AA FOREIGN KEY (titulaire_id) REFERENCES new_titulaire (id)');
        $this->addSql('ALTER TABLE fichier ADD CONSTRAINT FK_9B76551F80E95E18 FOREIGN KEY (demande_id) REFERENCES demande (id)');
        $this->addSql('ALTER TABLE fichier ADD CONSTRAINT FK_9B76551F19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE fichier ADD CONSTRAINT FK_9B76551FC54C8C93 FOREIGN KEY (type_id) REFERENCES documents (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE commande_client');
        $this->addSql('ALTER TABLE commande ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D19EB6921 ON commande (client_id)');
        $this->addSql('ALTER TABLE fichier DROP FOREIGN KEY FK_9B76551F80E95E18');
        $this->addSql('ALTER TABLE fichier DROP FOREIGN KEY FK_9B76551F19EB6921');
        $this->addSql('ALTER TABLE fichier DROP FOREIGN KEY FK_9B76551FC54C8C93');
        $this->addSql('ALTER TABLE tarifs_prestations DROP FOREIGN KEY FK_D863AC2D82EA2E54');
        $this->addSql('ALTER TABLE taxes DROP FOREIGN KEY FK_C28EA7F882EA2E54');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D688CB924');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D31881814');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1DDCF6C4B7');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1DB51BC29A');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D19EB6921');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D7F1824A4');
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1DA10273AA');
    }
}
