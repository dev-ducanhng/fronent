<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property int|null $phone
 * @property string|null $avatar
 * @property string|null $post_author
 * @property string|null $post_title
 * @property string|null $post_description
 * @property string|null $post_content
 * @property string|null $image
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Post extends \yii\db\ActiveRecord
{   
 
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'post';
    }
   
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array(
			// array('post_content, post_title', 'required', 'message'=>'{attribute} không được trống'),
			// array('post_type, category,tag', 'required', 'message'=>'Chọn {attribute}'),
			// array('post_author, post_type, comment_count, post_promotion, provider_id, viewed', 'numerical', 'integerOnly'=>true),
			// array('post_status,status_list, comment_status', 'length', 'max'=>20),
			// array('post_name', 'length', 'max'=>200),
			// array('avatar', 'length', 'max'=>255),
			// array('timer_articles,post_content, post_title, post_excerpt, seo_title_tag, seo_meta_descript', 'safe'),
			// // The following rule is used by search().
			// // @todo Please remove those attributes that should not be searched.
			// array('id, post_author,status_list, post_content, post_title, post_excerpt, post_status, comment_status, post_name, post_type, comment_count, avatar, post_promotion, category, tag, seo_title_tag, seo_meta_descript, provider_id, post_date, viewed', 'safe', 'on'=>'search'),
		);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array(
			'id' => 'ID',
			'post_author' => 'Tác giả',
			'post_content' => 'Nội dung bài viết',
			'post_title' => 'Tiêu đề bài viết',
			'post_excerpt' => 'Mô tả ngắn gọn',
			'post_status' => 'Trạng thái bài viết',
			// 'comment_status' => 'Comment Status',
			// 'post_name' => 'Post Name',
			// 'post_type' => 'Loại bài viết',
			// 'comment_count' => 'Comment Count',
			'avatar' => 'Ảnh đại diện',
			// 'post_promotion' => 'Loại bài viết điểm ưu đãi',
			// 'category' => 'Chuyên mục',
			// 'tag' => 'Tags',
			// 'seo_title_tag' => 'Tiêu đề SEO',
			// 'seo_meta_descript' => 'Nội dung SEO',
			// 'provider_id' => 'Nhà cung cấp',
			// 'post_date' => 'Ngày đăng',
			// 'viewed'    => 'Lượt xem',
            // 'status_list'			=> 'Ẩn hiện mục lục'
        );
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\PostQuery(get_called_class());
    }
}
