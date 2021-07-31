<?php

use kartik\grid\GridView as GridGridView;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Admin Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1 class="title"><?= $this->title ?></h1>
<p>
    <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i> <span>Add new admin user</span>', ['signup'], ['class' => 'btn btn-success']) ?>
</p>
<div class="card">
  <div class="card-content">
    <div class="clearfix">
      
      <?= GridGridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            ['class' => 'yii\grid\SerialColumn'],
            [
              'attribute' => 'id',
              'contentOptions' => ['style'=>'width: 50px;']
            ],
            'name',
            'username',
            'email',
            [
            'attribute' => 'status',
            'contentOptions' => ['width' => '12%'],
            'format'    => 'raw',
            'value'     => function($model){
              $result = '<div class="material-switch pull-right">';
              $inputId = 'input-change-status-'.$model->id;
              if ($model->status) {
                $checked = true;
                $labelText = 'Active';

              }else{
                $checked = false;
                $labelText = 'Inactive';
              }
              $result .= $labelText.' '.Html::checkbox('status', $checked, [
                'class'   => 'checkbox-update-status-user',
                'data-id' => $model->id,
                'id'      => $inputId,
              ]);
              $result .= '<label for="'.$inputId.'" class="label-success"></label></div>';
              return $result;
            },
            'filter'=> ['1'=>'Active','0'=>'Inactive'],
          ],

            [
              'attribute' => 'created_at',
              'contentOptions' => ['width' => '17%']
            ],
            [
              'attribute' => 'role',
              'format' => 'raw',
              'value' => function($model){
                return $model->getRoleName();
              },
              'filter'=> $searchModel->getListRoles(),
            ],

            [
              'header' => 'Actions',
              'format' => 'raw',
              'value' => function($model){
                if ($model->status == $model::DELETED) {
                  return '<span class="label bg-danger">DELETED</span>';;
                }
                $result = '';
                $result .= ' '.Html::a('<i class="fa fa-eye"></i>', ['view','id' => $model->id], [
                  'class'       => 'bt btn-sm btn-default',
                  'data-toggle' => 'tooltip',
                  'title'       => 'View User',
                ]);
                $result .= ' '.Html::a('<i class="fa fa-edit"></i>', ['update','id' => $model->id], [
                  'class'       => 'bt btn-sm btn-info',
                  'data-toggle' => 'tooltip',
                  'title'       => 'Edit User',
                ]);
                $result .= ' '.Html::a('<i class="fa fa-universal-access" aria-hidden="true"></i> <span>Role</span>', ['assign-role','id'=>$model->id],
                  [
                  'class'       => 'btn btn-xs btn-primary',
                  'data-toggle' => 'tooltip',
                  'title'       => 'Assignment Role',
                  ]
                );
                $result .= ' '.Html::a('<i class="fa fa-trash"></i>', ['delete','id' => $model->id], [
                  'class'       => 'bt btn-sm btn-danger',
                  'data-toggle' => 'tooltip',
                  'title'       => 'Delete User',
                  'data' => [
                    'method' => 'post',
                    'confirm' => 'Are you Sure to Delete This User?'
                  ]
                ]);
                return $result;
              }
            ],
        ],
      ]); ?>
    </div>
  </div>
</div>

<?php 

$this->registerJs('
$(".checkbox-update-status-user").on("change",function(){
  var newStatus;
  if ($(this).is(":checked")){
    newStatus = "1";
  } else {
    newStatus = "0";
  }
  $.ajax({
    url : "'.Url::to(['/user/update-status']).'?id="+$(this).data("id"),
    type: "POST",
    data: {
      status : newStatus
    },
    success: function(data){
      location.reload();
    },
    error: function(data){
      location.reload();
    }
  });
});
  ', \yii\web\View::POS_READY);

?>
