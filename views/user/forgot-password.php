<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Url;

$this->title = Yii::t('app','Forgot Password');

$fieldOptions1 = [
  'options' => ['class' => 'form-group has-feedback'],
  'inputTemplate' => "{input}<span class='fa fa-envelope form-control-feedback'></span>"
];
?>
<div class="login-box">
  <!-- <div class="login-logo">
    <img src="<?= Url::base(true) ?>/images/logo-dark.png" class="img img-responsive">
  </div> -->
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"><?= Yii::t('app', 'Enter your registered email address'); ?></p>
    <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>
    <?= $form
      ->field($model, 'email', $fieldOptions1)
      ->label(false)
      ->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>

    
    <div class="row">
      <div class="col-xs-8">
        
      </div>
      <div class="col-xs-4">
        <?= Html::submitButton(Yii::t('app','Submit'), ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
      </div>
      
    </div>
    <?php ActiveForm::end(); ?>

  </div>
  <!-- /.login-box-body -->
</div><!-- /.login-box -->