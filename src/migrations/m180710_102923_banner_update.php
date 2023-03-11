<?php

use yii\db\Migration;
use floor12\banner\models\AdsPlace;

/**
 * Class m180710_102923_banner_update
 */
class m180710_102923_banner_update extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn("{{%ads_place}}", "slider_direction", $this->integer()->notNull()->comment('Направление слайдера'));
        $this->addColumn("{{%ads_place}}", "slider_time", $this->integer()->notNull()->defaultValue(3000)->comment('Длительность слайда'));
        $this->addColumn("{{%ads_place}}", "slider_arrows", $this->integer()->defaultValue(AdsPlace::SLIDER_ARROWS_SHOW)->null()->comment('Показывать стрелки'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("{{%ads_place}}", "slider_arrows");
        $this->dropColumn("{{%ads_place}}", "slider_time");
        $this->dropColumn("{{%ads_place}}", "slider_direction");
    }


}
