<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "qa_question".
 *
 * @property int $id
 * @property string|null $question
 * @property string|null $user_id
 * @property string|null $user_name
 * @property string $date_create
 * @property int|null $category_id
 * @property int|null $nums_user_answer
 * @property int|null $status 1 : publish / 2 : Unpublish / 3 : delete
 * @property string|null $ip
 * @property string|null $description Chi tiet noi dung cau hoi
 * @property string|null $user_interest
 * @property int|null $is_faq Co phai bo cau hoi faq hay khong : 1 : YES / 0 : NO 
 * @property int|null $viewed So luot xem cau hoi
 * @property int|null $status_syun_elastic
 * @property int|null $product_id
 */
class QaQuestion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'qa_question';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question', 'user_id', 'description', 'user_interest'], 'string'],
            [['date_create'], 'safe'],
            [['category_id', 'nums_user_answer', 'status', 'is_faq', 'viewed', 'status_syun_elastic', 'product_id'], 'integer'],
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
            'question' => 'Question',
            'user_id' => 'User ID',
            'user_name' => 'User Name',
            'date_create' => 'Date Create',
            'category_id' => 'Category ID',
            'nums_user_answer' => 'Nums User Answer',
            'status' => 'Status',
            'ip' => 'Ip',
            'description' => 'Description',
            'user_interest' => 'User Interest',
            'is_faq' => 'Is Faq',
            'viewed' => 'Viewed',
            'status_syun_elastic' => 'Status Syun Elastic',
            'product_id' => 'Product ID',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\QaQuestionQuery the active query used by this AR class.
     */
    // public static function find()
    // {
    //     return new \common\models\query\QaQuestionQuery(get_called_class());
    // }
}
