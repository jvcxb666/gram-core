<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231225134425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table for sessions';
    }

    public function up(Schema $schema): void
    {
       $this->addSql("
       CREATE TABLE `user_session` (
        `id` int NOT NULL,
        `name` varchar(255) DEFAULT NULL,
        `sessid` varchar(255) NOT NULL,
        `user_id` int NOT NULL,
        `date_entered` datetime(6) NOT NULL,
        `date_expired` datetime(6) NOT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
      
      ALTER TABLE `user_session`
      ADD PRIMARY KEY (`id`);

      ALTER TABLE `user_session`
        MODIFY `id` int NOT NULL AUTO_INCREMENT;
        COMMIT;

      ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE user_session");
    }
}
