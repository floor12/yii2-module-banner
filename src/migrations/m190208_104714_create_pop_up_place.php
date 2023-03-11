<?php

use yii\db\Migration;

/**
 * Class m190208_104714_create_pop_up_place
 */
class m190208_104714_create_pop_up_place extends Migration
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

        // Площадки под popup-баннеры
        $this->createTable('{{ads_popup_place}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull()->comment('Название площадки'),
            'status' => $this->boolean()->notNull()->defaultValue(false)->comment('Выключить'),
        ], $tableOptions);

        $this->createIndex("idx-ads_popup_place-status", "{{%ads_popup_place}}", "status");


        // Связь popup-баннеров и площадок
        $this->createTable("{{%ads_popup_place_popup}}", [
            'popup_id' => $this->integer()->notNull(),
            'place_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex("idx-ads_popup_place_popup", "{{%ads_popup_place_popup}}", ['popup_id', 'place_id']);
        $this->addForeignKey("fk-ads-popup", "{{%ads_popup_place_popup}}", "popup_id", "{{%ads_popup}}", "id", "CASCADE", "CASCADE");
        $this->addForeignKey("fk-ads-popup_place", "{{%ads_popup_place_popup}}", "place_id", "{{%ads_popup_place}}", "id", "CASCADE", "CASCADE");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey("fk-ads-popup", "{{%ads_popup_place_popup}}");
        $this->dropForeignKey("fk-ads-popup_place", "{{%ads_popup_place_popup}}");
        $this->dropTable('"{{%ads_popup_place_popup}}"');
        $this->dropTable('"{{%ads_popup_place}}"');

    }

}
