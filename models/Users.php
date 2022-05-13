<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for collection "users".
 *
 * @property \MongoDB\BSON\ObjectID|string $_id
 * @property mixed $id
 * @property mixed $user_name
 * @property mixed $user_email
 */
class Users extends \yii\mongodb\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function collectionName()
    {
        return ['thebank_db', 'users'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            'id',
			'user_pass',
			'user_email',
			'display_name',
			'province_id',
			'acc_type',
			'phone',
			'service_type',
			'year_experience',
			'company_name',
			'repeat_password',
			'is_active',
			'avatar',
			'currentPassword',
			'user_name',
			'verifyCode',
			'buyer_counseling_service',
			'is_user_backend',
			'working_position',
			'working_at',
			'introduction_user',
			'company_drafts',
			'service_type_drafts',
			'company_branch_drafts',
			'working_position_drafts',
			'company_branch_name',
			'verify',
			'level',
			'backend_added',
			'user_registered',
			'register_from',
			'district_id',
			'district_name',
			'note',
			'source',
			'company_id',
			'company_branch',
			'promos_code_in',
			'promos_code_out',
			'moved_money',
			'complete_distributing_email',
			'status_supplier',
			'ga_source',
			'ga_referer',
			'ga_campaign',
			'user_approved',
			'compensation',
			'total_customer_distributed',
			'information_classifieds',
			'branch_samo_id',
			'type_management',
			'branch_management',
			'is_banned',
			'is_partners',
			'is_branch_organzine',
			'date_drafts',
			'point_rank',
			'user_point',
			'partner_code',
			'source_id',
			'is_user_backend',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array(
			array('currentPassword,code_reset,display_name_drafts,phone_drafts,province_name_drafts,year_experience_drafts,introduction_complete,working_position_drafts, phone, user_pass, working_position, display_name, year_experience', 'required','message'=>'Nhập {attribute}'),
			array('user_email', 'required', 'message' => 'Nhập địa chỉ email'),
			array('repeat_password', 'required', 'message' => 'Nhập lại mật khẩu'),
			array('user_name', 'required','message'=>'{attribute} không được trống <i style="border: 1px solid; border-radius: 50%; width: 13px; height: 13px; text-align: center; background-color: #2695D2; color: #fff;" class="fa fa-info" title="Phải là tiếng việt không dấu, không chứa khoảng trắng.Ví dụ: davidnguyen"></i>'),
			array('verifyCode', 'required','message'=>'Nhập các ký tự trong ảnh trong ảnh.'),
			array('gender,province_id_drafts,district_id_drafts,acc_type,district_id,buyer_counseling_service,avatar,company_drafts,company_branch_drafts,service_type_drafts,company_branch, company_id, province_id','required', 'message'=> 'Chọn {attribute}'),
			array('service_type', 'required', 'message' => 'Chọn dịch vụ'),
			array('is_tba, province_id, acc_type, year_experience,phone,cmnd', 'numerical', 'integerOnly'=>true , 'message'=>'{attribute} phải là số'),
			array('agree', 'required', 'requiredValue' => 1, 'message' => 'Bạn chưa đồng ý với chúng tôi'),
			array('user_email', 'email', 'message' => 'Địa chỉ email không hợp lệ'),
			array('user_email,user_name,phone,phone_drafts,email_drafts', 'validateAttribute'),
			array('introduction_complete', 'validateSpace'),
			array('phone,phone_drafts', 'checkPhone'),
			array('code_reset', 'checkOTP'),
			array('birthday, ngaycap', 'checkBirthday'),
			array('year_experience,year_experience_drafts', 'checkYearEexperience'),
			array('currentPassword', 'checkChangePassword'),
			array('display_name, type_register,user_name,company_branch_name', 'length', 'max'=>255),
			array('phone,phone_drafts,birthday', 'length', 'max'=>20),
			array('branch_organzine_infomation,is_branch_organzine,facebook,twitter,linkedin,display_name_drafts,phone_drafts,province_id_drafts,province_name_drafts,district_id_drafts,district_name_drafts,year_experience_drafts,company_name,introduction_user_drafts,information_classifieds_drafts,electronic_signatures,partner_create,show_user,total_service_register,total_money,income,compare_product,promos_code_in,promos_code_out,sync_account,contact,chat,source,information_classifieds,district_name,district_id,buyer_counseling_service,complete_profile,register_from,list_user_send_email,backend_added,customer_interact,verify_update_info,user_point,user_rating,level,point_rating,send_customer_email,code_reset,date_reset_expire,view_customer_phone,certificate,is_organized,is_partners,currentPassword,social_id,verify,rating,introduction_user,working_position,province_name,company_branch_name,date_issued,place_issued', 'safe'),
			array('currentPassword', 'equalPasswords'),
			array('repeat_password', 'compare', 'compareAttribute'=>'user_pass', 'message'=>"Mật khẩu không giống nhau"),
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(),'message'=>'Mã bảo mật không đúng!'),
			array('user_name', 'length', 'min' => 6, 'max'=>20,
					'tooShort'=>Yii::t("translation", "{attribute} từ 6 - 20 ký tự."),
					'tooLong'=>Yii::t("translation", "{attribute} từ 6 - 20 ký tự.")),
			array(
				'user_name',
				'match', 'not' => true, 'pattern' => '/[^a-zA-Z0-9_]/',
				'message' => 'Không chứa ký tự có dấu hoặc ký tự đặc biệt.',
			),
			array('user_pass', 'length', 'min' => 6, 'max'=>30,
					'tooShort'=>Yii::t("translation", "{attribute} từ 6 - 30 ký tự."),
					'tooLong'=>Yii::t("translation", "{attribute} từ 6 - 30 ký tự.")),
			array('day,id, user_pass, user_email, user_registered, user_activation_key,buyer_counseling_service, user_status, display_name, role_id, type_register, social_id, province_id, acc_type, phone, service_type, year_experience, is_active', 'safe', 'on'=>'search'),

			array('phone', 'required', 'message' => 'Nhập số điện thoại', 'on' => 'create_buyer'),
			array('customer_everyday', 'default', 'value'=> 0),
		    array('point_distributary', 'default', 'value'=> 500),
		    array('display_everyday', 'default', 'value'=> 0),
		    array('point_prioritize', 'default', 'value'=> 10),
		    array('total_display', 'default', 'value'=> 0),
		);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
			'id' => 'ID',
			'user_name' => 'Tên đăng nhập',
			'user_email' => 'Email',
			'user_pass' => 'Mật khẩu',
			'repeat_password' => 'Nhập lại mật khẩu',
			'verifyCode' => 'Mã bảo mật',
			'user_registered' => 'Ngày đăng ký',
			'user_activation_key' => 'ma kich hoat tai khoan',
			'user_status' => 'User Status',
			'display_name' => 'Họ và tên',
			'display_name_drafts' => 'Họ và tên',
			'role_id' => 'Role',
			'type_register' => 'Register on social , website',
			'social_id' => 'id social of user',
			'province_id' => 'Thành phố',
			'province_id_drafts' => 'Thành phố',
			'province_name_drafts' => 'Thành phố',
			'acc_type' => 'Lĩnh vực',
			'phone' => 'Số điện thoại',
			'phone_drafts' => 'Số Điện thoại',
			'service_type' => 'Tư vấn dịch vụ',
			'service_type_drafts'=>'Tư vấn dịch vụ',
			'year_experience' => 'Số năm kinh nghiệm',
			'year_experience_drafts' => 'Số năm kinh nghiệm',
			'is_active' => 'tinh trang kich hoat tai khoan : 0 : chua / 1 : Da kich hoat',
			'avatar' => 'Ảnh đại diện',
			'rank' => 'diem tich luy',
			'company_id' => 'Tên doanh nghiệp',
			'company_name' => 'Tên doanh nghiệp',
			'company_branch' => 'Làm việc tại chi nhánh',
			'company_branch_drafts' => 'Làm việc tại chi nhánh',
			'verify' => 'Xac thuc tai khoan hay chua : 1 : Chua xac thuc / 2 : Da xac thuc',
			'company_drafts' => 'Tên doanh nghiệp',
			'is_change_drafts' => 'Is Change Drafts',
			'date_drafts' => 'Date Drafts',
			'is_superadmin' => 'Is Superadmin',
			'is_user_backend' => 'Co phai user trong backend khong?',
			'is_banned' => 'Banned user',
			'buyer_counseling_service' => 'Cần tư vấn dịch vụ',
			'rating' => 'diem danh gia nguoi dung a;b',
			'introduction_user' => 'Giới thiệu kỹ năng và kinh nghiệm làm việc',
			'introduction_complete' => 'Giới thiệu kỹ năng và kinh nghiệm làm việc',
			'working_position' => 'Vị trí công tác',
			'working_position_drafts'=>'Vị trí công tác',
			'currentPassword'=>'Mật khẩu cũ',
			'facebook'  => 'Tài khoản Facebook',
			'twitter'   => 'Tài khoản Twitter',
			'linkedin'  => 'Tài khoản LinkedIn',
			'certificate' => 'Bằng cấp & Chứng chỉ',
			'district_id'     => 'Quận/Huyện',
			'district_id_drafts'     => 'Quận/Huyện',
			'district_name'     => 'Quận/Huyện',
			'information_classifieds' => 'Giới thiệu sản phẩm đang tư vấn',
			'electronic_signatures'	  => 'Chữ ký',
			'birthday'	  => 'Ngày sinh',
			'gender'	  => 'Giới tính',
			'code_reset'  => 'Mã OTP',
			'email_draft' => 'Email',
			'cmnd'	=> 'CMND/Hộ chiếu',
			'place_issued' => 'Nơi cấp',
			'date_issued' => 'Ngày cấp'
        ];
    }
}
