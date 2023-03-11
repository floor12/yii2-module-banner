<?php

use yii\db\Migration;

/**
 * Class m180802_000000_banner_update
 */
class m180802_000000_banner_update extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("{{%ads_banner}}", "weight", $this->integer()->notNull()->defaultValue(0)->comment('Вес баннера'));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("{{%ads_banner}}", "weight");
    }


}
