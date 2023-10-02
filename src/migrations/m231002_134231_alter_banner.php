<?php

use yii\db\Migration;

/**
 * Class m231002_134231_alter_banner
 */
class m231002_134231_alter_banner extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('ads_banner', 'show_caption', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropColumn('ads_banner', 'show_caption');
    }
}