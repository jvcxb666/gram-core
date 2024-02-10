<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240102131854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create users table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE IF NOT EXISTS `user` (
            `id` int NOT NULL,
            `name` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `password` varchar(255) NOT NULL,
            `date_entered` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `image` varchar(255) DEFAULT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
       
        ALTER TABLE `user` ADD PRIMARY KEY (`id`);
        ALTER TABLE `user` MODIFY `id` int NOT NULL AUTO_INCREMENT; COMMIT;");
    }

    public function down(Schema $schema): void
    {
       $this->addSql("DROP TABLE `user`");
    }
}
