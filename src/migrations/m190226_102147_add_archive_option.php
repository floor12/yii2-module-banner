<?php

use yii\db\Migration;

/**
 * Class m190226_102147_add_archive_option
 */
class m190226_102147_add_archive_option extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{ads_banner}}', 'archive', $this->boolean()->defaultValue(false)->comment('Архивный'));
        $this->addColumn('{{ads_popup}}', 'archive', $this->boolean()->defaultValue(false)->comment('Архивный'));

        $this->createIndex('idx-ads_banner-archive', '{{ads_banner}}', 'archive');
        $this->createIndex('idx-ads_popup-archive', '{{ads_banner}}', 'archive');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{ads_banner}}', 'archive');
        $this->dropColumn('{{ads_popup}}', 'archive');
    }

}
