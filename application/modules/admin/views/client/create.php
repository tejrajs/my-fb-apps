<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\oauth2\models\OauthClients */

$this->title = Yii::t('app', 'Create Oauth Clients');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Oauth Clients'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="oauth-clients-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
