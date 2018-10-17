<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\datecontrol\DateControl;
use yii\helpers\Url;

/**
* @var yii\web\View $this
* @var lispa\amos\videoconference\models\Videoconf $model
*/

$this->title = $model;
$this->params['breadcrumbs'][] = ['label' => Yii::t('cruds', 'Videoconferenza'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="videoconf-view col-xs-12">

    <?= DetailView::widget([
    'model' => $model,    
    'attributes' => [
            'id_room_videoconference',
            'title',
            'description:html',
            [
                'label' => 'Num. Partecipanti',
                'value' => function ($model){
                    return count($model->videoconfUsersMms);
                }

            ],
            /*[
                'attribute'=>'begin_date_hour',
                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],                
            ],*/
    ],
    ]) ?>

    <div class="btnViewContainer pull-right">
        <?= Html::a(Yii::t('amoscore', 'Chiudi'), Url::previous(), ['class' => 'btn btn-secondary']); ?>    </div>

</div>
