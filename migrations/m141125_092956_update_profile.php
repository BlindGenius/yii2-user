<?php

use yii\db\Schema;
use yii\db\Migration;

class m141125_092956_update_profile extends Migration
{
    public function up()
    {
      $this->renameColumn('{{%profile}}', 'name', 'firstname');
      $this->renameColumn('{{%profile}}', 'public_email', 'lastname');
      $this->renameColumn('{{%profile}}', 'location', 'alias');
      $this->renameColumn('{{%profile}}', 'website', 'mobile');
      $this->dropColumn('{{%profile}}', 'gravatar_id');
      $this->addColumn('{{%profile}}', 'gender_id', Schema::TYPE_SMALLINT);



    }

    public function down()
    {
        echo "m141125_092956_update_profile cannot be reverted.\n";

        return false;
    }
}
