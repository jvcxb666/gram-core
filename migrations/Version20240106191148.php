<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240106191148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create admin user [admin,pass]';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
        INSERT IGNORE INTO `user` (`name`, `email`, `password`, `date_entered`, `image`) VALUES
        ("admin", "admin@admin.ru", "$argon2id$v=19$m=65536,t=4,p=1$ge2IXl8vVS6DEw+C0RRJRA$2ROpWjZF6oXRyyQwRT7xlP+M3cQzkfIVlXJZ9rf233I", "2024-01-01 00:00:00", NULL);
        ');

    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM `user` WHERE `id` = 1");
    }
}
