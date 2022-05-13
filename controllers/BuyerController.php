<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;

use yii\mongodb\Query;

class BuyerController extends Controller
{
    //trang chuyen gia tai chinh
    public function actionIndexSupplier($page = 1, $service = '', $company_id = '', $alias = null, $sl_company = null, $sl_province = null, $sl_district = null)
    {
		$this->view->title = "Chuyên gia tư vấn tài chính ngân hàng và bảo hiểm";
        Yii::$app->params['og_description']['content'] = 'TheBank quy tụ hơn 2000 chuyên gia tư vấn tài chính của tất cả các ngân hàng và công ty bảo hiểm trên toàn quốc với nhiều năm kinh nghiệm tư vấn về vay vốn, mở thẻ và bảo hiểm.';

		$sort = 'top_sp';
		if(!empty($_GET['service']))
        {
            $service = (int)preg_replace('/[^0-9]/', '', $_GET['service']);
        }
	    if(!empty($_GET['company']))
        {
            $company_id = (int)preg_replace('/[^0-9]/', '', $_GET['company']);
        }
	    if(!empty($_GET['province']))
        {
            $sl_province = (int)preg_replace('/[^0-9]/', '', $_GET['province']);
        }
	    if(!empty($_GET['district']))
        {
            $sl_district = (int)preg_replace('/[^0-9]/', '', $_GET['district']);
        }
		$data_supplier = $this->_getListSupplier($page, $sort, $action = 'indexs', $service , $company_id,$sl_province, $sl_district);
	
		// var_dump($data_supplier['selectedOptionsService'][2]);die;
        return $this->render('index_supplier', [
            'list_service'          => $data_supplier['list_service'],
            'list_province'         => $data_supplier['list_province'],
            'list_company'          => $data_supplier['list_company'],
            'title'          		=> $data_supplier['title'],
			'data_supplier'			=> $data_supplier
        ]);
    }
    private function _getListSupplier( $page, $sort, $action, $service, $company_id,$sl_province,$sl_district )
	{
		$sql = (new \yii\db\Query());
		$list_service = iterator_to_array(Yii::$app->mongodb->getCollection('financial_service')->find(['service_parent'=>['$gt'=>0]],['_id'=>0,'id'=>1,'service_name'=>1]));
        $list_province = $sql->select(['id','province_name'])->from('province')->all();
		$list_company = $sql->select(['id','short_name','logo','type','type_insurance'])->from('company')->where('type in (1,2) and is_show = 1')->all();
		$list_service_title = [];
		foreach($list_service as $val) {
			$list_service_title[$val['id']] = $val['service_name'];
		}
		// echo '<pre>';
		// print_r($list_service);
		// echo '<pre>';
		// die;
		$order				= ['point_rank'=>-1];
		$service_insurance 	= [];
		$service_default	= '' ;
		$province_id		= 0 ;
		$model_service		= '';
		$condition_service_type	= [];
		$selectedOptionsService	= [];
		$selectedOptionsProvince= [];
        $selectedOptionsDistrict= [];
		$selectedOptionsCompany	= [];
		$condition			= ['is_partners' => 0,'is_banned' => 0,'acc_type' => 1];
		$list_user_favourite= array();
		$flag_continute 	= true;

		if($service != '' || $company_id != 0)
		{
            $add_favourite_sup		= 'check_login';
			if(is_array($service))
			{
				foreach($service as $service_id)
				{
					$condition_sv[]							= ['$regex' => ''. $service_id .''];
					$selectedOptionsService[$service_id]	= array('selected'=>'selected');
				}
				$condition['service_type']							=	array('$in' => $condition_sv);
			}
			else
			{
				if(intval($service) > 0)
				{
					// $condition['service_type']						= new MongoRegex('/;' . $service . ';/');
					$condition['service_type']						= ['$regex' => ';'. $service .';'];
					$selectedOptionsService[$service]	= array('selected'=>'selected');
				}
			}
			if($company_id != '' && $company_id != 0)
			{
				$condition['company_id']			= (int)$company_id;
				$selectedOptionsCompany[$company_id]	= array('selected'=>'selected');
			}
//			var_dump($selectedOptionsDistrict);die;
		}
        if($sl_province != '' && $sl_province != 0)
        {
            $condition['province_id']			= (int)$sl_province;
            $selectedOptionsProvince[$sl_province]	= array('selected'=>'selected');
        }
        if($sl_district != '' && $sl_district != 0)
        {
            $condition['district_id']			= (int)$sl_district;
            $selectedOptionsDistrict[$sl_district]	= array('selected'=>'selected');
        }
		switch($sort)
		{
			case 'top_sp' : 
				break;
			case 'rated' : 
				$order	= array('point_rating' => -1);
				break;
			case 'exp' : 
				$order	= array('year_experience' => -1);
				break;
			case 'news' :
				$order	= array('user_registered' => -1);
				break;
		}
		$condition['is_tba'] = [
			'$ne' => 1
		];
		// var_dump($condition);die;
		if( $flag_continute ){
			$args				= array(
				'condition'			=> $condition,
				'order'    			=> $order,
				'all_col'  			=> true,
				'page'     			=> $page,
				'service_insurance' => $service_insurance,
				'action'			=> $action
			);

			$option = [
				'limit'  => 10,
				'offset' => 0,
				'sort'   => $order,
				'action' => 'index',
			];
			$option_ofset = [
				'limit'  => 1,
				'offset' => 0,
				'sort'   => $order,
				'action' => 'index',
                'skip'   => 11,
			];
			$db = Yii::$app->mongodb->getCollection('users');
			$results_ob     = iterator_to_array($db->find($args['condition'],[],$option));
			$count_results_ob     = $db->count($args['condition']);
			// echo '<pre>';
			// print_r($results_ob);
			// echo '</pre>';
			// die;
		}
		else
			$results_ob				= [];

		//set title
		$list_service_tit = [];
		foreach($list_service as $item) {
			$list_service_tit[$item['id']] = $item['service_name'];
		}
		$list_company_tit = [];
		foreach($list_company as $item) {
			$list_company_tit[$item['id']] = $item['short_name'];
		}
		
		if($company_id != '')
		{		
			$title = 'Chuyên viên tư vấn ' . $list_company_tit[$company_id] . ' (' . $count_results_ob . ')';		
		}
		if($service != ''){
				
			$title = 'Chuyên viên tư vấn ' . $list_service_tit[$service] . ' (' . $count_results_ob . ')';			 
		}	
		if($service == '' && $company_id == ''){
			$title = 'Chuyên gia tư vấn tài chính ngân hàng và bảo hiểm'. ' (' . $count_results_ob . ')';		
		}
		if($service != '' && $company_id != ''){
			$title = 'Chuyên viên tư vấn ' . $list_service_tit[$service] . ' - ' . $list_company_tit[$company_id] . ' (' . $count_results_ob . ')';			
		}
		//end set title			

		$list_result_data = [];
		$result_data_ofset = [];
		if(!empty($results_ob)) {
			$results_ofset  = iterator_to_array($db->find($args['condition'],[],$option_ofset));
			$company_partner = [];
			foreach($results_ob as $rows) {
					$company_partner[] = $rows['company_id'];
					//count comment user
					$count_comment = $sql->select(['id_question'])
					->from('qa_answer')
					->where(['id_question' => $rows['id'], 'is_comment_user' => 1,'is_delete' => 0])
					->count();

					//get name service
					$service_name   = '';
					$arr_service_id = array_filter(explode(';', $rows['service_type']));
					foreach( $arr_service_id as $s )
					{
						if( $s != "" && isset($list_service_tit[$s]) ){
							$sv_name 	= explode('(', $list_service_tit[$s]);
							$service_name .= $sv_name[0] . ', ';
						}
					}
					$service_name	= substr($service_name,0,-2);			
					if($rows['avatar'] != '')
						$avatar_supplier	= $this->rewriteUrlImage($rows['avatar'],150,150);
					else
						$avatar_supplier	= '/static/2/150/150/90/avatar_default.png';
					$list_result_data[] = [
						'count_comment' 	=> $count_comment,
						'id'				=> $rows['id'],
						'avatar'			=> 'https://thebank.vn' . $avatar_supplier,
						'display_name'		=> $rows['display_name'],
						'level_rank_star'	=> $rows['level_rank_star'],
						'company_name'		=> $rows['company_name'],
						'year_experience'	=> $rows['year_experience'],
						'working_position'	=> $rows['working_position'],
						'user_registered'	=> date("Y-m-d", strtotime($rows['user_registered'])),
						'level_name'		=> !empty($rows['level_rank_name'] != '') ? $rows['level_rank_name'] : 'Tư vấn viên',
						'url_profile'		=> 'https://thebank.vn/chuyen-gia-tai-chinh/' . $rows['user_name'] . '.html',
						'url_profile_cm'	=> 'https://thebank.vn/chuyen-gia-tai-chinh/' . $rows['user_name'] . '.html#binhluan',
						'viewed'			=> isset($rows['viewed']) ? $rows['viewed'] : 0,
						'chat'				=> 'https://thebank.vn/chat/'. $rows['id'] .'.html',
						'service_name'		=> $service_name . ' tại ' . $rows['province_name'],
						'status_online'		=> $rows['status_online'],
					];
					$result_data_ofset = $results_ofset;
			}
		}
		// echo '<pre>';
		// print_r($list_result_data);
		// echo '<pre>';
		// die;

		$arr_data					= array(
			// 'list_service'			=> $list_service,
			// 'province'				=> $province,
			// 'company'				=> $company,
			'list_user_favourite'	=> $list_user_favourite,
			'selectedOptionsService'=> $selectedOptionsService,
			'selectedOptionsProvince'=> $selectedOptionsProvince,
			'selectedOptionsCompany'=> $selectedOptionsCompany,
			'results_ob'			=> $list_result_data,
			'sort'					=> $sort,
			'order'					=> $order,
			'result_data_ofset'		=> $result_data_ofset,
			'count_results_ob'		=> $count_results_ob,
			'list_service'			=> $list_service,
			'list_province'			=> $list_province,
			'list_company'			=> $list_company,
			'title'					=> $title
		);
		// echo '<pre>';
        // print_r($arr_data);
        // echo '</pre>';
        // die;
		return($arr_data);
	}    
	public static function generateStarSupplier($star = 0, $type = null)
	{

		$html_star = '';
		for($i = 1 ; $i <= 5;$i++)
		{
			if($type == 'Chuyên viên')
			{
				$class_type = 'star_cv';
			}else if($type == 'Chuyên gia'){
				$class_type = 'star_cg';
			}else {
				$class_type = 'star_tvv';
			}

			if( $i <= $star)
			$class = 'star_review active';
			else
			$class = 'star_review';

			$html_star .= '<i class="' . $class . ' ' . $class_type . ' tb-review"></i>';
		}
		return $html_star;
	}    
	public static function rewriteUrlImage($image='',$width=0,$height=0,$quality=90)
	{
		$url  			= '';
		$type			= 0;
		if( $image != '')
		{
			$path_image = $image;
			$data_image = array_filter(explode('/', $image));
			$image		= end($data_image);
			$list_year	= array();
			$year_curent= date('Y');

			for($i = $year_curent; $i >= 2013;$i-- )
			{
				$list_year[$i . '/'] = $i;
			}
			if( strpos($path_image,'posts/') !== false)
			{
				$type	= 1;
			}
			else if( strpos($path_image,'users/') !== false)
			{
				$type	= 2;
			}
			else if( strpos($path_image,'images/cards/') !== false)
			{
				$type	= 3;
				$data_image = array_slice($data_image, 0, -1);
				$image  = end($data_image) . '/' . $image;
			}
			else if( strpos($path_image,'images/bank/') !== false)
			{
				$type	= 4;
			}
			else if( strpos($path_image,'insurance/') !== false)
			{
				$type	= 5;
			}
			else
			{
				$type	= 6;
				$data_image = array_slice($data_image, 1);
				$data_image = array_slice($data_image, 0, -1);
				$image  = implode('/',$data_image) . '/' . $image;
			}
			$url 		= '/static/' . $type . '/' . $width . '/' . $height . '/' . $quality . '/' . $image;
		}

		$url 			= str_replace(array('/uploads/','thebank.vn/','/m.thebank.vn/'),array('/'),$url);
		return $url;
	}		
}
