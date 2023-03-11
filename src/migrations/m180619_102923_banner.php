<?php

use yii\db\Migration;

/**
 * Class m180619_102923_banner
 */
class m180619_102923_banner extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        // Баннеры
        $this->createTable("{{%ads_banner}}", [
            'id' => $this->primaryKey(),
            'status' => $this->boolean()->notNull()->defaultValue(false)->comment('Выключить'),
            'title' => $this->string(255)->notNull()->comment('Название баннера'),
            'show_start' => $this->date()->null()->comment('Начало показа'),
            'show_end' => $this->date()->null()->comment('Окончание показа'),
            'href' => $this->string()->null()->comment('Ссылка'),
            'views' => $this->integer()->notNull()->defaultValue(0)->comment('Показы'),
            'clicks' => $this->integer()->notNull()->defaultValue(0)->comment('Клики'),
        ], $tableOptions);

        $this->createIndex("idx-ads_banner-show_start", "{{%ads_banner}}", "show_start");
        $this->createIndex("idx-ads_banner-show_end", "{{%ads_banner}}", "show_end");
        $this->createIndex("idx-ads_banner-status", "{{%ads_banner}}", "status");

        // Площадки для баннеров
        $this->createTable("{{%ads_place}}", [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull()->comment('Название площадки'),
            'desktop_width' => $this->integer()->notNull()->comment('Ширина (дексктоп)'),
            'desktop_height' => $this->integer()->notNull()->comment('Высота (дексктоп)'),
            'mobile_width' => $this->integer()->null()->comment('Ширина (мобильный)'),
            'mobile_height' => $this->integer()->null()->comment('Высота (мобильный)'),
            'status' => $this->boolean()->notNull()->defaultValue(false)->comment('Выключить'),
            'slider' => $this->boolean()->notNull()->defaultValue(false)->comment('Активировать слайдер на этой площадке'),
        ], $tableOptions);

        $this->createIndex("idx-ads_place-status", "{{%ads_place}}", "status");

        // Связь баннеров и площадок
        $this->createTable("{{%ads_place_banner}}", [
            'banner_id' => $this->integer()->notNull(),
            'place_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex("idx-ads_place_banner", "{{%ads_place_banner}}", ['banner_id', 'place_id']);
        $this->addForeignKey("fk-ads-banner", "{{%ads_place_banner}}", "banner_id", "{{%ads_banner}}", "id", "CASCADE", "CASCADE");
        $this->addForeignKey("fk-ads-place", "{{%ads_place_banner}}", "place_id", "{{%ads_place}}", "id", "CASCADE", "CASCADE");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey("fk-ads-banner", "{{%ads_place_banner}}");
        $this->dropForeignKey("fk-ads-place", "{{%ads_place_banner}}");

        $this->dropTable("{{%ads_place_banner}}");
        $this->dropTable("{{%ads_banner}}");
        $this->dropTable("{{%ads_place}}");
    }


}
