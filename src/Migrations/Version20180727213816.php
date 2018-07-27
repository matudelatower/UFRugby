<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180727213816 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE historial_seleccion (id INT AUTO_INCREMENT NOT NULL, seleccion_id INT NOT NULL, jugador_id INT NOT NULL, creado_por_id INT DEFAULT NULL, actualizado_por_id INT DEFAULT NULL, fecha DATE NOT NULL, torneo VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, fecha_creacion DATETIME NOT NULL, fecha_actualizacion DATETIME NOT NULL, INDEX IDX_13015B2046F75C38 (seleccion_id), INDEX IDX_13015B20B8A54D43 (jugador_id), INDEX IDX_13015B20FE35D8C4 (creado_por_id), INDEX IDX_13015B20F6167A1C (actualizado_por_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipo_seleccion (id INT AUTO_INCREMENT NOT NULL, creado_por_id INT DEFAULT NULL, actualizado_por_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, fecha_creacion DATETIME NOT NULL, fecha_actualizacion DATETIME NOT NULL, INDEX IDX_B905DCBFFE35D8C4 (creado_por_id), INDEX IDX_B905DCBFF6167A1C (actualizado_por_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE historial_seleccion ADD CONSTRAINT FK_13015B2046F75C38 FOREIGN KEY (seleccion_id) REFERENCES tipo_seleccion (id)');
        $this->addSql('ALTER TABLE historial_seleccion ADD CONSTRAINT FK_13015B20B8A54D43 FOREIGN KEY (jugador_id) REFERENCES jugador (id)');
        $this->addSql('ALTER TABLE historial_seleccion ADD CONSTRAINT FK_13015B20FE35D8C4 FOREIGN KEY (creado_por_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE historial_seleccion ADD CONSTRAINT FK_13015B20F6167A1C FOREIGN KEY (actualizado_por_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE tipo_seleccion ADD CONSTRAINT FK_B905DCBFFE35D8C4 FOREIGN KEY (creado_por_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE tipo_seleccion ADD CONSTRAINT FK_B905DCBFF6167A1C FOREIGN KEY (actualizado_por_id) REFERENCES fos_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE historial_seleccion DROP FOREIGN KEY FK_13015B2046F75C38');
        $this->addSql('DROP TABLE historial_seleccion');
        $this->addSql('DROP TABLE tipo_seleccion');
    }
}
