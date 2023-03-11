<?php

namespace floor12\banner\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Author]].
 *
 * @see Author
 */
class AdsPopupQuery extends ActiveQuery
{

    public function byId(int $id)
    {
        return $this->andWhere(['id' => $id]);
    }

    public function hasLink()
    {
        return $this->andWhere(['!=', 'href', '']);
    }

    public function active()
    {
        $today = date('Y-m-d');
        return $this
            ->andWhere(['status' => AdsPopup::STATUS_ACTIVE])
            ->andWhere(['OR', ['IS', 'show_start', NULL], ['<=', 'show_start', $today]])
            ->andWhere(['OR', ['IS', 'show_end', NULL], ['>=', 'show_end', $today]]);
    }

    /**
     * {@inheritdoc}
     * @return AdsPopup[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AdsPopup|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
