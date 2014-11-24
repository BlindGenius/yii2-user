<?php

use yii\db\Schema;
use yii\db\Migration;
use yii\base\Security;

class m141124_033214_create_admin_user extends Migration
{
    public function up()
    {
        // Add super-administrator
        $this->execute($this->getUserSql());
        $this->execute($this->getProfileSql());

    }

    public function down()
    {



        return false;
    }

        /**
     * @return string SQL to insert first user
     */
    private function getUserSql()
    {
        $time = time();
        $password_hash = Yii::$app->security->generatePasswordHash('admin12345',10);
        $auth_key = Yii::$app->security->generateRandomString();
        return "INSERT INTO {{%user}} (`username`, `email`, `password_hash`, `auth_key`, `role`, `confirmed_at`, `created_at`, `updated_at`, `registration_ip`) VALUES ('admin', 'admin@demo.com', '$password_hash', '$auth_key', 'superadmin', $time, $time, $time, '2130706433')";
    }

    /**
     * @return string SQL to insert first profile
     */
    private function getProfileSql()
    {
        return "INSERT INTO {{%profile}} (`user_id`, `name`) VALUES (1, 'Administrator')";
    }

}
