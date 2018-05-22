<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180522123116 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE configuracion (id INT AUTO_INCREMENT NOT NULL, creado_por_id INT DEFAULT NULL, actualizado_por_id INT DEFAULT NULL, nombre_union VARCHAR(255) NOT NULL, siglas VARCHAR(255) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, activo TINYINT(1) NOT NULL, fecha_creacion DATETIME NOT NULL, fecha_actualizacion DATETIME NOT NULL, INDEX IDX_682CCAF1FE35D8C4 (creado_por_id), INDEX IDX_682CCAF1F6167A1C (actualizado_por_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE configuracion ADD CONSTRAINT FK_682CCAF1FE35D8C4 FOREIGN KEY (creado_por_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE configuracion ADD CONSTRAINT FK_682CCAF1F6167A1C FOREIGN KEY (actualizado_por_id) REFERENCES fos_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE configuracion');
    }
}
