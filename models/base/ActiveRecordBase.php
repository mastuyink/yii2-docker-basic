<?php

namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;

class ActiveRecordBase extends \yii\db\ActiveRecord
{
	public function behaviors()
  {
    return [
      [
        'class' => TimestampBehavior::class,
        'createdAtAttribute' => 'create_at',
        'updatedAtAttribute' => 'update_at',
      ],
    ];
  }
}