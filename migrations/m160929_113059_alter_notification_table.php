<?php

use yii\db\Migration;

class m160929_113059_alter_notification_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%notification}}', 'send_email', $this->smallInteger(1)->defaultValue(0));
        $this->addColumn('{{%notification}}', 'email_sent', $this->timestamp()->null());
        $this->addColumn('{{%notification}}', 'date_due',   $this->timestamp()->null());
    }

    public function down()
    {
        $this->dropColumn('{{%notification}}', 'send_email');
        $this->dropColumn('{{%notification}}', 'email_sent');
        $this->dropColumn('{{%notification}}', 'date_due');
    }

}
