<?php

use app\models\Request;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\RequestSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Мои заявки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="request-my">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'surname',
            'patronymic',
            'description:ntext',
            [
              'attribute' => 'Цена',
                'value' => 'service.price',

            ],
            [
                'attribute' => 'Статус',
                'value' => function ($model) {
                    return $model->getStatus();
                }
            ],
            //'service_id',
            //'user_id',
            //'accept_date',
            //'status',
        ],
    ]); ?>


</div>
