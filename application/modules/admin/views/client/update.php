<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\oauth2\models\OauthClients */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Oauth Clients',
]) . ' ' . $model->client_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Oauth Clients'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->client_id, 'url' => ['view', 'id' => $model->client_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="oauth-clients-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
