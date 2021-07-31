<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m210731_141448_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
			$sql = "
			CREATE TABLE `user` (
				`id` bigint(20) UNSIGNED NOT NULL,
				`username` varchar(255) NOT NULL,
				`name` varchar(100) DEFAULT NULL,
				`image` varchar(255) DEFAULT NULL,
				`auth_key` varchar(255) NOT NULL,
				`email` varchar(255) NOT NULL,
				`password_hash` varchar(255) NOT NULL,
				`password_reset_token` varchar(255) DEFAULT NULL,
				`expired_reset_token` int(11) DEFAULT NULL,
				`status` int(11) NOT NULL,
				`create_at` int(11) NOT NULL,
				`update_at` int(11) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;

			ALTER TABLE `user`
				ADD PRIMARY KEY (`id`);

			ALTER TABLE `user`
				MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
			";
			$this->db->createCommand($sql)->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
