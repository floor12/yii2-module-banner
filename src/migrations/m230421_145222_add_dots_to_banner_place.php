<?php

use yii\db\Migration;

/**
 * Class m230421_145222_add_dots_to_banner_place
 */
class m230421_145222_add_dots_to_banner_place extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('ads_place', 'slider_dots', $this->boolean()->null()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('ads_place', 'slider_dots');
    }
}
