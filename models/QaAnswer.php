<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "qa_answer".
 *
 * @property int $id
 * @property int|null $id_question
 * @property string|null $user_id
 * @property string|null $user_name
 * @property string|null $content_answer
 * @property string $date_create
 * @property string|null $like
 * @property string|null $spam
 * @property int|null $is_delete 0 : No / 1 : Delete
 * @property int|null $edit 0 : Chua chinh sua / 1 : Da chinh sua
 * @property string|null $ip
 * @property int|null $answer_id
 * @property int|null $answer_number
 * @property int|null $number_like Number user like answer
 * @property int|null $product_id Comment of card,loan,insurance
 * @property int|null $service_id Service id : 1: promotion / 2 : loan / 3 : insurance
 * @property int|null $is_post Comment of post
 * @property int|null $is_comment_user  1 : is comment user / 0 : not comment user
 * @property int|null $is_company Nhan xet ve doanh nghiep
 * @property int|null $is_hospital benh vien
 * @property int|null $is_author
 */
class QaAnswer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'qa_answer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_question', 'is_delete', 'edit', 'answer_id', 'answer_number', 'number_like', 'product_id', 'service_id', 'is_post', 'is_comment_user', 'is_company', 'is_hospital', 'is_author'], 'integer'],
            [['user_id', 'content_answer', 'like', 'spam'], 'string'],
            [['date_create'], 'safe'],
            [['user_name'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_question' => 'Id Question',
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'content_answer' => 'Content Answer',
            'date_create' => 'Date Create',
            'like' => 'Like',
            'spam' => 'Spam',
            'is_delete' => 'Is Delete',
            'edit' => 'Edit',
            'ip' => 'Ip',
            'answer_id' => 'Answer ID',
            'answer_number' => 'Answer Number',
            'number_like' => 'Number Like',
            'product_id' => 'Product ID',
            'service_id' => 'Service ID',
            'is_post' => 'Is Post',
            'is_comment_user' => 'Is Comment User',
            'is_company' => 'Is Company',
            'is_hospital' => 'Is Hospital',
            'is_author' => 'Is Author',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \frontend\models\query\QaAnswerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \frontend\models\query\QaAnswerQuery(get_called_class());
    }
}
