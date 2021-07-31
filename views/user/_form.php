<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\helpers\Url;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="card">
  <div class="card-content">
    <div class="clearfix">
      
      <?php $form = ActiveForm::begin(['options' => ['autocomplete' => 'off']]); ?>

      <div class="clearfix">
        <div class="col-md-4">
          <?= $form->field($model, 'name') ?>
        </div>

        <div class="col-md-4">
          <?= $form->field($model, 'username') ?>
        </div>
        <div class="col-md-4">
          <?= $form->field($model, 'email') ?>
        </div>
      </div>
      <div class="clearfix">
        <div class="col-md-4">
          <?= $form->field($model, 'password')->passwordInput() ?>
        </div>
        <div class="col-md-4">
          <?= $form->field($model, 'retypePassword')->passwordInput() ?>
        </div>
        <div class="col-md-4">
          <?= $form->field($model, 'status')->dropDownList(['1' => 'Active', '0' => 'Inactive']); ?>
        </div>
      </div>
      <div class="clearfix">
        <?php if($model->isNewRecord): ?>
          <div class="col-md-4">
            <?= $form->field($model, 'roleName')->widget(Select2::classname(), [
              'data'          => $model->getListRoles(),
              'options'       => ['placeholder' => 'Find Access Privilege...'],
              'pluginOptions' => [
                'allowClear' => true,
              ],
            ]); ?>
          </div>
        <?php endif; ?>
        <div class="col-md-4">
          <?php
          $basePluginOptions = [
              'showCaption'           => false,
              'showRemove'            => false,
              'showUpload'            => false,
              'browseClass'           => 'btn btn-primary btn-block',
              'browseIcon'            => '<i class="fa fa-camera" aria-hidden="true"></i>&nbsp;&nbsp;',
              'browseLabel'           =>  'Select Image',
              'allowedFileExtensions' => ['png', 'jpg', 'jpeg', 'gif'],
              'overwriteInitial'      => true,
              'previewFileType'       => 'image'
          ];
          if ($model->isNewRecord) {
              $pluginOptions = $basePluginOptions;
          } else {
              $thumbnailsConfig = [
                  'initial_preview'        => [],
                  'initial_preview_config' => [
                      'url' => false,
                  ],
              ];
              $filePath = $model->image;
              if (file_exists($filePath)) {
                  $thumbnailsConfig['initial_preview'][] = Url::base(true) . '/' . $model->image;
              }
              $pluginOptions = array_merge($basePluginOptions, [
                  'initialPreview'       => $thumbnailsConfig['initial_preview'],
                  'initialPreviewAsData' => true,
                  'initialPreviewConfig' => $thumbnailsConfig['initial_preview_config'],
              ]);
          };
          echo $form->field($model, 'imageFile')->widget(FileInput::classname(), [
              'options' => ['multiple' => false, 'accept' => 'image/*'],
              'pluginOptions' => $pluginOptions,
          ]); ?>
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <?= Html::submitButton('Save', ['class' => 'btn btn-success pull-left']) ?>
    </div>

    <?php ActiveForm::end(); ?>
  </div>
</div>
</div>