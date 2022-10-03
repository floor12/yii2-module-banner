<?php

use yii\db\Migration;

/**
 * Class m221003_182519_add_subtitle_to_banner
 */
class m221003_182519_add_subtitle_to_banner extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('ads_banner', 'subtitle', $this->text()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('ads_banner', 'subtitle');
    }
}