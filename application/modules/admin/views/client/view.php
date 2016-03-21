<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\oauth2\models\OauthClients */

$this->title = $model->client_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Oauth Clients'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oauth-clients-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->client_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->client_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'client_id',
            'client_secret',
            'app_name',
            'app_desc:ntext',
            'redirect_uri',
            'grant_types',
            'scope',
            'user_id',
            'created',
            'updated',
        ],
    ]) ?>

</div>
