<?php

namespace floor12\banner\models;

use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ads_popup_place".
 *
 * @property int $id
 * @property string $title Название площадки
 * @property int $status Выключить
 *
 * @property AdsPopup[] $popups Сязанные баннеры
 * @property AdsPopup[] $popupsActive Активные связанные баннеры
 */
class AdsPopupPlace extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ads_popup_place';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['status'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название площадки',
            'status' => 'Выключить',
        ];
    }

    /** Активные баннеры.
     *  Проверяем, активен ли баннер, есть если у него выставлены даты - сравниваем с текущей датой
     * @return AdsPopupQuery
     * @throws InvalidConfigException
     */
    public function getPopupsActive(): AdsPopupQuery
    {
        $orderByString = 'RAND()';
        if (\Yii::$app->db->getDriverName() == 'pgsql')
            $orderByString = 'random()';
        return $this->getPopups()->orderBy($orderByString)->active();
    }

    /** Связь площадки с баннерами
     * @return AdsPopupQuery|ActiveQuery
     * @throws InvalidConfigException
     */
    public function getPopups()
    {
        return $this
            ->hasMany(AdsPopup::class, ['id' => 'popup_id'])
            ->viaTable('ads_popup_place_popup', ['place_id' => 'id']);
    }

}
