<?php

declare( strict_types=1 );

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210608233409 extends AbstractMigration {
	public function getDescription(): string {
		return '';
	}

	public function up( Schema $schema ): void {
		// this up() migration is auto-generated, please modify it to your needs
		$this->addSql( 'CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB' );
		$this->addSql( 'ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES fos_user (id)' );
		$this->addSql( 'DROP TABLE migration_versions' );
		$this->addSql( 'DROP INDEX UNIQ_957A6479A0D96FBF ON fos_user' );
		$this->addSql( 'DROP INDEX UNIQ_957A647992FC23A8 ON fos_user' );
		$this->addSql( 'DROP INDEX UNIQ_957A6479C05FB297 ON fos_user' );
		$this->addSql( 'ALTER TABLE fos_user DROP username_canonical, DROP email_canonical, DROP salt, DROP last_login, DROP confirmation_token, DROP password_requested_at, DROP roles' );
//		$this->addSql( 'ALTER TABLE fos_user ADD roles JSON DEFAULT NULL' );
		$this->addSql( 'ALTER TABLE fos_user ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'' );
		$this->addSql( 'CREATE UNIQUE INDEX UNIQ_957A6479F85E0677 ON fos_user (username)' );
		$this->addSql( 'CREATE UNIQUE INDEX UNIQ_957A6479E7927C74 ON fos_user (email)' );

	}

	public function down( Schema $schema ): void {
		// this down() migration is auto-generated, please modify it to your needs
		$this->addSql( 'CREATE TABLE migration_versions (version VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, PRIMARY KEY(version)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ' );
		$this->addSql( 'DROP TABLE reset_password_request' );
		$this->addSql( 'DROP INDEX UNIQ_957A6479F85E0677 ON fos_user' );
		$this->addSql( 'DROP INDEX UNIQ_957A6479E7927C74 ON fos_user' );
		$this->addSql( 'ALTER TABLE fos_user ADD username_canonical VARCHAR(180) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, ADD email_canonical VARCHAR(180) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`, ADD salt VARCHAR(255) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, ADD last_login DATETIME DEFAULT NULL, ADD confirmation_token VARCHAR(180) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_unicode_ci`, ADD password_requested_at DATETIME DEFAULT NULL, CHANGE roles roles LONGTEXT CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci` COMMENT \'(DC2Type:array)\'' );
		$this->addSql( 'CREATE UNIQUE INDEX UNIQ_957A6479A0D96FBF ON fos_user (email_canonical)' );
		$this->addSql( 'CREATE UNIQUE INDEX UNIQ_957A647992FC23A8 ON fos_user (username_canonical)' );
		$this->addSql( 'CREATE UNIQUE INDEX UNIQ_957A6479C05FB297 ON fos_user (confirmation_token)' );
	}
}
