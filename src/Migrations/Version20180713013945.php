<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180713013945 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE fecha_ronda (id INT AUTO_INCREMENT NOT NULL, ronda_id INT NOT NULL, creado_por_id INT DEFAULT NULL, actualizado_por_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, fecha_tentativa DATE NOT NULL, activo TINYINT(1) NOT NULL, fecha_creacion DATETIME NOT NULL, fecha_actualizacion DATETIME NOT NULL, INDEX IDX_CBEB9402B27F466B (ronda_id), INDEX IDX_CBEB9402FE35D8C4 (creado_por_id), INDEX IDX_CBEB9402F6167A1C (actualizado_por_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ronda_torneo (id INT AUTO_INCREMENT NOT NULL, torneo_id INT NOT NULL, creado_por_id INT DEFAULT NULL, actualizado_por_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, puntos_ganado INT NOT NULL, puntos_perdido INT NOT NULL, puntos_empatado INT NOT NULL, puntos_por_walkover INT NOT NULL, tantos_por_walkover INT NOT NULL, bonus_triunfo_cantidad_tries_mayor_a INT NOT NULL, bonus_triunfo_diferencia_tries_mayor_a INT NOT NULL, bonus_derrota_diferencia_puntos INT NOT NULL, activo TINYINT(1) NOT NULL, fecha_creacion DATETIME NOT NULL, fecha_actualizacion DATETIME NOT NULL, INDEX IDX_BADCA4B7A0139802 (torneo_id), INDEX IDX_BADCA4B7FE35D8C4 (creado_por_id), INDEX IDX_BADCA4B7F6167A1C (actualizado_por_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participante_torneo (id INT AUTO_INCREMENT NOT NULL, club_id INT NOT NULL, torneo_id INT NOT NULL, creado_por_id INT DEFAULT NULL, actualizado_por_id INT DEFAULT NULL, activo TINYINT(1) NOT NULL, fecha_creacion DATETIME NOT NULL, fecha_actualizacion DATETIME NOT NULL, INDEX IDX_BD804C061190A32 (club_id), INDEX IDX_BD804C0A0139802 (torneo_id), INDEX IDX_BD804C0FE35D8C4 (creado_por_id), INDEX IDX_BD804C0F6167A1C (actualizado_por_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE torneo (id INT AUTO_INCREMENT NOT NULL, club_organizador_id INT DEFAULT NULL, division_id INT NOT NULL, creado_por_id INT DEFAULT NULL, actualizado_por_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, maximo_titulares_por_equipo INT NOT NULL, maximo_suplentes_por_equipo INT NOT NULL, carga_incidencias VARCHAR(255) NOT NULL, sexo VARCHAR(255) NOT NULL, image_name VARCHAR(255) DEFAULT NULL, activo TINYINT(1) NOT NULL, fecha_creacion DATETIME NOT NULL, fecha_actualizacion DATETIME NOT NULL, INDEX IDX_7CEB63FE2FF5E7AB (club_organizador_id), INDEX IDX_7CEB63FE41859289 (division_id), INDEX IDX_7CEB63FEFE35D8C4 (creado_por_id), INDEX IDX_7CEB63FEF6167A1C (actualizado_por_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partido (id INT AUTO_INCREMENT NOT NULL, referee_id INT DEFAULT NULL, estado_id INT NOT NULL, fecha_ronda_id INT NOT NULL, creado_por_id INT DEFAULT NULL, actualizado_por_id INT DEFAULT NULL, fecha DATE NOT NULL, hora TIME NOT NULL, sede VARCHAR(255) DEFAULT NULL, observaciones LONGTEXT DEFAULT NULL, activo TINYINT(1) NOT NULL, fecha_creacion DATETIME NOT NULL, fecha_actualizacion DATETIME NOT NULL, INDEX IDX_4E79750B4A087CA2 (referee_id), INDEX IDX_4E79750B9F5A440B (estado_id), INDEX IDX_4E79750B4730657B (fecha_ronda_id), INDEX IDX_4E79750BFE35D8C4 (creado_por_id), INDEX IDX_4E79750BF6167A1C (actualizado_por_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tiempo_incidencia (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipo_partido (id INT AUTO_INCREMENT NOT NULL, equipo_id INT NOT NULL, partido_id INT NOT NULL, fecha_confirmacion DATETIME DEFAULT NULL, estado VARCHAR(255) DEFAULT NULL, local TINYINT(1) DEFAULT NULL, visitante TINYINT(1) DEFAULT NULL, INDEX IDX_357E32923BFBED (equipo_id), INDEX IDX_357E32911856EB4 (partido_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE incidencia (id INT AUTO_INCREMENT NOT NULL, tiempo_id INT NOT NULL, tipo_incidencia_id INT NOT NULL, jugador_id INT DEFAULT NULL, minuto INT DEFAULT NULL, observacion LONGTEXT DEFAULT NULL, INDEX IDX_C7C6728CEA915999 (tiempo_id), INDEX IDX_C7C6728CE1D308BC (tipo_incidencia_id), INDEX IDX_C7C6728CB8A54D43 (jugador_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE miembro_equipo_partido (id INT AUTO_INCREMENT NOT NULL, equipo_partido_id INT NOT NULL, jugador_id INT NOT NULL, titular TINYINT(1) NOT NULL, suplente TINYINT(1) NOT NULL, INDEX IDX_74DBB37FD181DC24 (equipo_partido_id), INDEX IDX_74DBB37FB8A54D43 (jugador_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tipo_incidencia (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, grupo VARCHAR(255) DEFAULT NULL, puntos INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estado_partido (id INT AUTO_INCREMENT NOT NULL, creado_por_id INT DEFAULT NULL, actualizado_por_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, activo TINYINT(1) NOT NULL, fecha_creacion DATETIME NOT NULL, fecha_actualizacion DATETIME NOT NULL, INDEX IDX_6C28DADAFE35D8C4 (creado_por_id), INDEX IDX_6C28DADAF6167A1C (actualizado_por_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fecha_ronda ADD CONSTRAINT FK_CBEB9402B27F466B FOREIGN KEY (ronda_id) REFERENCES ronda_torneo (id)');
        $this->addSql('ALTER TABLE fecha_ronda ADD CONSTRAINT FK_CBEB9402FE35D8C4 FOREIGN KEY (creado_por_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE fecha_ronda ADD CONSTRAINT FK_CBEB9402F6167A1C FOREIGN KEY (actualizado_por_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE ronda_torneo ADD CONSTRAINT FK_BADCA4B7A0139802 FOREIGN KEY (torneo_id) REFERENCES torneo (id)');
        $this->addSql('ALTER TABLE ronda_torneo ADD CONSTRAINT FK_BADCA4B7FE35D8C4 FOREIGN KEY (creado_por_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE ronda_torneo ADD CONSTRAINT FK_BADCA4B7F6167A1C FOREIGN KEY (actualizado_por_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE participante_torneo ADD CONSTRAINT FK_BD804C061190A32 FOREIGN KEY (club_id) REFERENCES club (id)');
        $this->addSql('ALTER TABLE participante_torneo ADD CONSTRAINT FK_BD804C0A0139802 FOREIGN KEY (torneo_id) REFERENCES torneo (id)');
        $this->addSql('ALTER TABLE participante_torneo ADD CONSTRAINT FK_BD804C0FE35D8C4 FOREIGN KEY (creado_por_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE participante_torneo ADD CONSTRAINT FK_BD804C0F6167A1C FOREIGN KEY (actualizado_por_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE torneo ADD CONSTRAINT FK_7CEB63FE2FF5E7AB FOREIGN KEY (club_organizador_id) REFERENCES club (id)');
        $this->addSql('ALTER TABLE torneo ADD CONSTRAINT FK_7CEB63FE41859289 FOREIGN KEY (division_id) REFERENCES division (id)');
        $this->addSql('ALTER TABLE torneo ADD CONSTRAINT FK_7CEB63FEFE35D8C4 FOREIGN KEY (creado_por_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE torneo ADD CONSTRAINT FK_7CEB63FEF6167A1C FOREIGN KEY (actualizado_por_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750B4A087CA2 FOREIGN KEY (referee_id) REFERENCES referee (id)');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750B9F5A440B FOREIGN KEY (estado_id) REFERENCES estado_partido (id)');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750B4730657B FOREIGN KEY (fecha_ronda_id) REFERENCES fecha_ronda (id)');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750BFE35D8C4 FOREIGN KEY (creado_por_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750BF6167A1C FOREIGN KEY (actualizado_por_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE equipo_partido ADD CONSTRAINT FK_357E32923BFBED FOREIGN KEY (equipo_id) REFERENCES participante_torneo (id)');
        $this->addSql('ALTER TABLE equipo_partido ADD CONSTRAINT FK_357E32911856EB4 FOREIGN KEY (partido_id) REFERENCES partido (id)');
        $this->addSql('ALTER TABLE incidencia ADD CONSTRAINT FK_C7C6728CEA915999 FOREIGN KEY (tiempo_id) REFERENCES tiempo_incidencia (id)');
        $this->addSql('ALTER TABLE incidencia ADD CONSTRAINT FK_C7C6728CE1D308BC FOREIGN KEY (tipo_incidencia_id) REFERENCES tipo_incidencia (id)');
        $this->addSql('ALTER TABLE incidencia ADD CONSTRAINT FK_C7C6728CB8A54D43 FOREIGN KEY (jugador_id) REFERENCES miembro_equipo_partido (id)');
        $this->addSql('ALTER TABLE miembro_equipo_partido ADD CONSTRAINT FK_74DBB37FD181DC24 FOREIGN KEY (equipo_partido_id) REFERENCES equipo_partido (id)');
        $this->addSql('ALTER TABLE miembro_equipo_partido ADD CONSTRAINT FK_74DBB37FB8A54D43 FOREIGN KEY (jugador_id) REFERENCES jugador (id)');
        $this->addSql('ALTER TABLE estado_partido ADD CONSTRAINT FK_6C28DADAFE35D8C4 FOREIGN KEY (creado_por_id) REFERENCES fos_user (id)');
        $this->addSql('ALTER TABLE estado_partido ADD CONSTRAINT FK_6C28DADAF6167A1C FOREIGN KEY (actualizado_por_id) REFERENCES fos_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE partido DROP FOREIGN KEY FK_4E79750B4730657B');
        $this->addSql('ALTER TABLE fecha_ronda DROP FOREIGN KEY FK_CBEB9402B27F466B');
        $this->addSql('ALTER TABLE equipo_partido DROP FOREIGN KEY FK_357E32923BFBED');
        $this->addSql('ALTER TABLE ronda_torneo DROP FOREIGN KEY FK_BADCA4B7A0139802');
        $this->addSql('ALTER TABLE participante_torneo DROP FOREIGN KEY FK_BD804C0A0139802');
        $this->addSql('ALTER TABLE equipo_partido DROP FOREIGN KEY FK_357E32911856EB4');
        $this->addSql('ALTER TABLE incidencia DROP FOREIGN KEY FK_C7C6728CEA915999');
        $this->addSql('ALTER TABLE miembro_equipo_partido DROP FOREIGN KEY FK_74DBB37FD181DC24');
        $this->addSql('ALTER TABLE incidencia DROP FOREIGN KEY FK_C7C6728CB8A54D43');
        $this->addSql('ALTER TABLE incidencia DROP FOREIGN KEY FK_C7C6728CE1D308BC');
        $this->addSql('ALTER TABLE partido DROP FOREIGN KEY FK_4E79750B9F5A440B');
        $this->addSql('DROP TABLE fecha_ronda');
        $this->addSql('DROP TABLE ronda_torneo');
        $this->addSql('DROP TABLE participante_torneo');
        $this->addSql('DROP TABLE torneo');
        $this->addSql('DROP TABLE partido');
        $this->addSql('DROP TABLE tiempo_incidencia');
        $this->addSql('DROP TABLE equipo_partido');
        $this->addSql('DROP TABLE incidencia');
        $this->addSql('DROP TABLE miembro_equipo_partido');
        $this->addSql('DROP TABLE tipo_incidencia');
        $this->addSql('DROP TABLE estado_partido');
    }
}
