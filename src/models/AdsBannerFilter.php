<?php
/**
 * Created by PhpStorm.
 * User: floor12
 * Date: 19.06.2018
 * Time: 13:16
 */

namespace floor12\banner\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;

class AdsBannerFilter extends Model
{
    public $filter;
    public $status;
    public $archive = 0;

    /**@inheritdoc
     * @return array
     */
    public function rules(): array
    {
        return [
            ['filter', 'string', 'max' => 255],
            [['status', 'archive'], 'integer'],
        ];
    }

    /**
     * @return ActiveDataProvider
     * @throws BadRequestHttpException
     */
    public function dataProvider(): ActiveDataProvider
    {
        if (!$this->validate())
            throw new BadRequestHttpException('Model validation error');

        $quiery = AdsBanner::find()
            ->andFilterWhere(['LIKE', 'title', $this->filter])
            ->andFilterWhere(['=', 'status', $this->status])
            ->andFilterWhere(['=', 'archive', $this->archive]);

        return new ActiveDataProvider([
            'query' => $quiery,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);
    }
}
