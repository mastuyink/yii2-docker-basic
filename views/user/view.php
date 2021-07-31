<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
              'attribute' => 'Image',
              'format' => 'raw',
              'value' => function($model){
                return Html::img([$model->image], ['class' => 'img img-responsive','style'=>'max-height: 150px;']);
              }
            ],
            'name',
            'username',
            [                      
                'attribute' => 'Password Reset Token',
                'format'    => 'raw',
                'value' => $model->password_reset_token." "
                            .$model->buttonForgotPassword()
                            ." <small id='link_password_message' class='green pull-right'></small>",
            ],
            'email:email',
            'status',
            // 'role',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>

<?php 

$this->registerJs('
    $("#link_password").on("click",function(){
        $("#link_password_message").html("loading...");
        $("#link_password").hide();
        var email = $(this).data("id");
        $.ajax({
        url : "'.Url::to(['/user/sendforgotlink']).'",
        type: "POST",
        data: {
            email : email
        },
        success: function(data){
            //  location.reload();
            $("#link_password_message").html(data["message"]);
            
        },
        error: function(data){
            // location.reload();
        }
        });
    });
  ', \yii\web\View::POS_READY);

?>