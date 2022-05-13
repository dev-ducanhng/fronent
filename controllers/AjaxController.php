<?php
namespace frontend\controllers;
use yii\web\Controller;
use yii\mongodb\Query;
use Yii;
use frontend\controllers\BuyerController;


class AjaxController extends Controller
{
    public function actionFilterSupplier()
    {
		$sql = (new \yii\db\Query());
		$service_data = iterator_to_array(Yii::$app->mongodb->getCollection('financial_service')->find(['service_parent'=>['$gt'=>0]],['id'=>1,'service_name'=>1]));


        $list_service = iterator_to_array(Yii::$app->mongodb->getCollection('financial_service')->find(['service_parent'=>['$gt'=>0]],['_id'=>0,'id'=>1,'service_name'=>1]));
        $list_province = $sql->select(['id','province_name'])->from('province')->all();
		$list_company = $sql->select(['id','short_name','logo','type','type_insurance'])->from('company')->where('type in (1,2) and is_show = 1')->all();
		$service_data = iterator_to_array(Yii::$app->mongodb->getCollection('financial_service')->find(['service_parent'=>['$gt'=>0]],['id'=>1,'service_name'=>1]));
        
		$list_service = [];
		foreach($service_data as $val) {
			$list_service[$val['id']] = $val['service_name'];
		}
        if(isset($_POST['page']))
        {
            $sort          = $_POST['sort'];
            $input         = isset($_POST['input']) ? strip_tags($_POST['input']) : '';
            $level         = isset($_POST['level']) ? $_POST['level'] : 0;
            $province      = isset($_POST['province']) ? $_POST['province'] : 0;
            $district      = isset($_POST['district']) ? $_POST['district'] : 0;
            $year          = isset($_POST['year']) ? $_POST['year'] : '';
            $service       = isset($_POST['service']) ? $_POST['service'] : 0;
            $company       = isset($_POST['company']) ? (int)$_POST['company'] : 0;
            $status        = isset($_POST['status']) ? $_POST['status'] : '';
            $order         = array('point_rank'=>-1);
            $action        = isset($_POST['action']) ? $_POST['action'] : 'index';
            $type          = isset($_POST['type']) ? $_POST['type'] : '';
            switch($sort)
            {
                case 'top_sp' :
                    break;
                case 'rated' :
                    $order = array('point_rating'=>-1);
                    break;
                case 'exp' :
                    $order = array('verify'=>-1,'year_experience'=>-1);
                    break;
                case 'news' :
                    $order = array('user_registered'=>-1,'verify'=>-1);
                    break;
            }
            // $condition     = array('is_banned' => 0,'partner_create' => 0 );
            $condition			= ['is_partners' => 0,'is_banned' => 0,'acc_type' => 1, 'is_tba' => ['$ne' => 1]];
           
            if( $type == 2 )
                $condition['is_partners'] = 1;
            else
                $condition['is_partners'] = 0;

            if( $service > 0 )
            {
                $condition['service_type'] = ['$regex' => ';'. $service .';'];
            }
            if( $level > 0 )
                $condition['level_rank_id'] = (int)$level;
            if( is_array($province) && count($province) > 0 )
                $condition['province_id']['$in'] =  array_map('intval',$province);
            else if( $province > 0 )
                $condition['province_id']   = (int)$province;
            if( $district > 0 )
            {
                $condition['district_id'] =  (int)$district;
            }
            if($company > 0)
            {
                if($company == 53)
                {
                    $condition['company_id']    = ['$ne' => 53];
                }else{
                    $condition['company_id'] =  (int)$company;
                }
            }
            if( $input != '' )
                $condition['display_name'] = ['$regex' =>  $input];

            if( $year != '' )
            {
                $data_year = explode(';', $year);
                if( count($data_year) == 2 )
                    $condition['year_experience'] = array('$gte'=> (int)$data_year[0],'$lte'=> (int)$data_year[1]);
            }
            if($status != '')
            {
                if(intval($status) == 0)
                    $condition['status_online'] = 0;
                else if(intval($status) == 1)
                    $condition['status_online'] = 1;
            }
           
            // var_dump($condition);die;
            $service_insurance = array();
            $args          = array(
                'condition'=> $condition,
                'order'    => $order,
                'all_col'  => true,
                'page'     => $_POST['page'],
                'service_insurance' => $service_insurance,
                'service_id'    => (int)$service,
                'company_id'    => $company,
                'province_id'   => $province,
                'district_id'   => $district,
            );
            $limit = 10;
            $page			= $_POST['page'];
            $see_more = false;
            if ($page > 1)
            {
                $skip = ($page - 1) * $limit;
            }
            else
                $skip = 0;

            if($page > 1)
                $see_more = true;

            // var_dump($skip);die;
			$option = [
				'limit'  => $limit,
				'offset' => 0,
				'sort'   => $order,
				'action' => 'index',
                'skip'   => $skip,
			];
            $option_ofset = [
				'limit'  => 1,
				'offset' => 0,
				'sort'   => $order,
				'action' => 'index',
                'skip'   => $skip + 11,
			];
            $db = Yii::$app->mongodb->getCollection('users');
          
			$results_ob     = iterator_to_array($db->find($args['condition'],[],$option));
            $count_results_ob     = $db->count($args['condition']);

            //set title
            $list_company_tit = [];
            foreach($list_company as $item) {
                $list_company_tit[$item['id']] = $item['short_name'];
            }
            
            if($company != '')
            {		
                $title = 'Chuyên viên tư vấn ' . $list_company_tit[$company] . ' (' . $count_results_ob . ')';		
            }
            if($service != ''){
                    
                $title = 'Chuyên viên tư vấn ' . $list_service[$service] . ' (' . $count_results_ob . ')';			
            }	
            if($service == '' && $company == ''){
                $title = 'Chuyên gia tư vấn tài chính ngân hàng và bảo hiểm'. ' (' . $count_results_ob . ')';		
            }
            if($service != '' && $company != ''){
                $title = 'Chuyên viên tư vấn ' . $list_service[$service] . ' - ' . $list_company_tit[$company] . ' (' . $count_results_ob . ')';			
            }
            //end set title	            
            // var_dump($results_ob);die;
            $list_result_data = [];
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
                        $html_star 	= BuyerController::generateStarSupplier($rows['level_rank_star'],$rows['level_rank_name']);

                        //get name service
                        $service_name   = '';
                        $arr_service_id = array_filter(explode(';', $rows['service_type']));
                        foreach( $arr_service_id as $s )
                        {
                            if( $s != "" && isset($list_service[$s]) ){
                                $sv_name 	= explode('(', $list_service[$s]);
                                $service_name .= $sv_name[0] . ', ';
                            }
                        }
                        $service_name	= substr($service_name,0,-2);	   
                        if($rows['avatar'] != '')
                            $avatar_supplier	= BuyerController::rewriteUrlImage($rows['avatar'],150,150);
                        else
                            $avatar_supplier	= '/static/2/150/150/90/avatar_default.png';
                        $list_result_data['data'][] = [
                            'count_comment' 	=> $count_comment,
                            'id'				=> $rows['id'],
                            'avatar'			=> 'https://thebank.vn/' . $avatar_supplier,
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
                            'html_star'         => $html_star,
                            'service_name'      => $service_name . ' tại ' . $rows['province_name'],
                            'see_more'          => $see_more,
                            'status_online'		=> ($rows['status_online'] == 1) ? 'active' : '',
                        ];
                        $list_result_data['ofset'] = $results_ofset;
                }
            }
            $list_result_data['title'] = $title;
            echo json_encode($list_result_data);
            exit;
        }
    }
}