<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190213080234 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fichier DROP FOREIGN KEY FK_9B76551FC54C8C93');
        $this->addSql('ALTER TABLE fichier ADD CONSTRAINT FK_9B76551FC54C8C93 FOREIGN KEY (type_id) REFERENCES documents (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fichier DROP FOREIGN KEY FK_9B76551FC54C8C93');
        $this->addSql('ALTER TABLE fichier ADD CONSTRAINT FK_9B76551FC54C8C93 FOREIGN KEY (type_id) REFERENCES type_fichier (id)');
    }
}
