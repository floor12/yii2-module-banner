<?php

use yii\db\Migration;

/**
 * Class m190802_161902_change_blog_banner_link_string_field_size
 */
class m190802_161902_change_banner_href_field_size extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%ads_banner}}', 'href', $this->string(2048)->null());
        $this->alterColumn('{{%ads_popup}}', 'href', $this->string(2048)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%ads_banner}}', 'href', $this->string(255));
        $this->alterColumn('{{%ads_popup}}', 'href', $this->string(255));
    }
}
