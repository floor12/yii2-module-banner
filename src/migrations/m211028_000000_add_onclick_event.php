<?php

use yii\db\Migration;

/**
 * Class m190802_161902_change_blog_banner_link_string_field_size
 */
class m211028_000000_add_onclick_event extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%ads_banner}}', 'onclick', $this->string()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%ads_banner}}', 'onclick', $this->string(255));
    }
}
