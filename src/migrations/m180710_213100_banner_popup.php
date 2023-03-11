<?php

use yii\db\Migration;

/**
 * Class m180710_213100_banner_popup
 */
class m180710_213100_banner_popup extends Migration
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

        $this->createTable("{{%ads_popup}}", [
            'id' => $this->primaryKey(),
            'status' => $this->boolean()->notNull()->defaultValue(false)->comment('Выключить'),
            'title' => $this->string(255)->notNull()->comment('Название баннера'),
            'show_start' => $this->date()->null()->comment('Начало показа'),
            'show_end' => $this->date()->null()->comment('Окончание показа'),
            'href' => $this->string()->null()->comment('Ссылка'),
            'views' => $this->integer()->notNull()->defaultValue(0)->comment('Показы'),
            'clicks' => $this->integer()->notNull()->defaultValue(0)->comment('Клики'),
            'repeat_period'=>$this->integer()->notNull()->defaultValue(0)->comment('Период повторного показа'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable("{{%ads_popup}}");
    }


}
