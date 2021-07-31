<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Sign In';

$fieldOptions1 = [
  'options' => ['class' => 'form-group has-feedback'],
  'inputTemplate' => "{input}<span class='fa fa-user form-control-feedback'></span>"
];

$fieldOptions2 = [
  'options' => ['class' => 'form-group has-feedback'],
  'inputTemplate' => "{input}<span class='fa fa-lock form-control-feedback'></span>"
];
?>
<div class="login-box">
  <div class="login-logo">
    <?= Html::img('@web/IMG/logo.png', ['alt'=>Yii::$app->name, 'style'=>'max-height: 150px;']) ?>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"><?= Yii::t('app', 'Welcome back!'); ?></p>
    <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>
    <?= $form
      ->field($model, 'username', $fieldOptions1)
      ->label(false)
      ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

    <?= $form
      ->field($model, 'password', $fieldOptions2)
      ->label(false)
      ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
    <div class="row">
      <div class="col-xs-8">
        <?= $form->field($model, 'rememberMe')->checkbox() ?>
      </div>
      <div class="col-xs-4">
        <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
      </div>
      <div class="col-xs-12">
        <?= Html::a(Yii::t('app', 'I forgot my pasword'), ['forgot-password'], ['class' => 'pull-right']) ?>
      </div>
    </div>
    <?php ActiveForm::end(); ?>

  </div>
  <!-- /.login-box-body -->
</div><!-- /.login-box -->