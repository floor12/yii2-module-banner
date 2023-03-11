<?php

use yii\db\Migration;

/**
 * Class m190802_161902_change_blog_banner_link_string_field_size
 */
class m200217_000000_add_max_width extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%ads_place}}', 'desktop_width_max', $this->boolean()->defaultValue(false)->null());
        $this->alterColumn('{{%ads_place}}', 'desktop_width_max', $this->boolean()->defaultValue(false)->notNull());

        $this->addColumn('{{%ads_place}}', 'mobile_width_max', $this->boolean()->defaultValue(false)->null());
        $this->alterColumn('{{%ads_place}}', 'mobile_width_max', $this->boolean()->defaultValue(false)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%ads_place}}', 'desktop_width_max', $this->string(255));
        $this->dropColumn('{{%ads_place}}', 'mobile_width_max', $this->string(255));
    }
}
