<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\select2\Select2;
$this->title = 'Assign Access Privilege';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="clearfix">
	<?php $form = ActiveForm::begin(); ?>
	<div class="col-md-12">
		<div class="alert bg-gray">
			Current Access Privilege: <b><?= $model->getRoleName(); ?></b>
		</div>
		<?= $form->field($model, 'roleName')->widget(Select2::classname(), [
		'data'          => $model->getListRoles(),
		'options'       => ['placeholder' => 'Find Access Privilege...'],
		'pluginOptions' => [
      'allowClear' => true,
    ],
  ]); ?>
	</div>
	<div class="col-md-12">
    <?= Html::submitButton('Save', ['class' => 'btn btn-success pull-left']) ?>
  </div>

    <?php ActiveForm::end(); ?>
</div>