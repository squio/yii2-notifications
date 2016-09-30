<?php

use yii\db\Migration;

class m160930_122435_alter_notification_table extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%notification}}', 'date_due', $this->date()->null());
        $this->createIndex('idx_user_key', '{{%notification}}', ['user_id', 'key', 'key_id'], false);
        $this->createIndex('idx_date_due', '{{%notification}}', 'date_due', false);
    }

    public function down()
    {
        $this->alterColumn('{{%notification}}', 'date_due', $this->timestamp()->null());
        $this->dropIndex('idx_user_key', '{{%notification}}');
        $this->dropIndex('idx_date_due', '{{%notification}}');
    }
}
