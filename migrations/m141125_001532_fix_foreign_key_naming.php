<?php

use yii\db\Schema;
use yii\db\Migration;

class m141125_001532_fix_foreign_key_naming extends Migration
{
    public function up()
    {
      $this->dropForeignKey('fk_user_profile','{{%profile}}');
      $this->dropForeignKey('fk_user_token','{{%token}}');
      $this->dropForeignKey('fk_user_account','{{%social_account}}');
      $this->addForeignKey('fk_profile_user_id', '{{%profile}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
      $this->addForeignKey('fk_token_user_id', '{{%token}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
      $this->addForeignKey('fk_social_account_user_id', '{{%social_account}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        echo "m141125_001532_fix_foreign_key_naming cannot be reverted.\n";

        return false;
    }
}
