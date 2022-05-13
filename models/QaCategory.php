<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "qa_category".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $cat_parent
 * @property int|null $service 1 : promotion / 2 : loan / 3 : Insurance
 */
class QaCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'qa_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cat_parent', 'service'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'cat_parent' => 'Cat Parent',
            'service' => 'Service',
        ];
    }

    /**
     * {@inheritdoc}
     * @return \frontend\models\query\QaCategoryQuery the active query used by this AR class.
     */
    // public static function find()
    // {
    //     return new \frontend\models\query\QaCategoryQuery(get_called_class());
    // }

    public static function getListCategory($cat_parent=null)
	{
		$condition_service = ($cat_parent != null) ? ' WHERE qa_question.status = 1 AND qa_question.is_faq = 0 and qa_category.service = ' . $cat_parent : '';
		$condition_service = ($condition_service != '') ? $condition_service . ' AND qa_question.status = 1 AND qa_question.user_id > 0' : ' WHERE qa_question.status = 1 AND qa_question.is_faq = 0 AND qa_question.user_id > 0';
		$sql 			   = 'SELECT count(*) as count_question, name,qa_category.id as id,cat_parent,service FROM qa_category left join qa_question ON qa_category.id = qa_question.category_id ' . $condition_service . ' group by qa_question.category_id ORDER BY count_question DESC';
		return Yii::$app->db->createCommand($sql)->queryAll();
	}    
}
