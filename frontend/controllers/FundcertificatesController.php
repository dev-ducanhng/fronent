<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

use yii\mongodb\Query;

class FundcertificatesController extends Controller
{
    public function actionIndex(){
    //    if(!empty($_GET)) {
//         echo '<pre>';
    //     print_r($_GET);
    //     echo '</pre>';
    //     die;
    //    }
        $condition = [];
        $conditions = [];
        if(!empty($_GET['company'])) {
            $condition['company_id'] = ['$in' => $_GET['company']];

            $conditions = [
                'company_id' => ['$in' => $_GET['company']]
            ];       
        }
        if(!empty($_GET['fund'])) {
            $arr_int_id = [];
			foreach ($_GET['fund'] as $key => $value) {
				$arr_int_id[$key] = (int)$value;
			}
            $condition['id'] = ['$in' => $arr_int_id];
        }
        if (!empty($_GET['type_fund'])) {
			$condition['type_fund_id'] = $_GET['type_fund'];
		}
        // echo '<pre>';
        // print_r($condition);
        // echo '</pre>';
        // die;
        $arr_sort['limit'] = 10;
        if (!empty($_GET['orderby'])) {
            $order = $_GET['order'];
            $orderby = $_GET['orderby'];

            if($order == 'asc')
                $sort = 1;
            else 
                $sort = -1;
            $arr_sort['sort'] = [$orderby => $sort];
		}
        // echo '<pre>';
        // print_r($arr_sort);
        // echo '</pre>';
        // die;
        
        
        $result = iterator_to_array(Yii::$app->mongodb->getCollection('fund_certificates')->find($condition,[],$arr_sort));
        $count_result = Yii::$app->mongodb->getCollection('fund_certificates')->count($condition,[]);
        $result_2 = iterator_to_array(Yii::$app->mongodb->getCollection('fund_certificates')->find($conditions,[],['sort' => ['order' => 1]]));

        // echo '<pre>';
        // print_r($count_result);
        // echo '</pre>';
        // die;

        $list_company_fund = [];
        $list_certificates_name = [];
        $i = 1;
        if(!empty($result_2)) {
            foreach ($result_2 as $key => $value) {
                $i++;
                $list_company_fund[$value['company_id']] = $value['company_name'];
                $list_id[$i] = $value['company_id'];
                $list_certificates_name[$value['id']] = $value['certificates_name_cut'];
            }
            $new_list = array_unique($list_id);
        }
        // echo '<pre>';
        // print_r($list_certificates_name);
        // echo '</pre>';
        // die;
        
        $sql = (new \yii\db\Query());
        $list_company_tag = $sql
            ->select('id, long_name, short_name,logo')
            ->from('company')
            ->where('type = 4')
            // ->andwhere(array('in', 'id', $new_list))
            ->all();
        
        $list_short_name_and_logo = array();
        foreach ($list_company_tag as $key => $value) {
            $list_short_name_and_logo[$value['id']] = array($value['logo'],$value['short_name']);
        }
        // echo '<pre>';
        // print_r($list_company_tag);
        // echo '</pre>';
        // die;
        

        //get faq
        $result_faq = iterator_to_array(Yii::$app->mongodb->getCollection('faqrequest')->find(['service_id' => 25, 'is_show' => 0],['description'=>1,'id'=>1,'question'=>1,'answer'=>1],[],['sort' => ['number' => 1]]));
        
		$arr_faq = [];
		if(!empty($result_faq))
		{
			$arr_faq['description'] = '';
			foreach($result_faq as $doc)
			{
				$arr_faq['tittle']                  = $doc['description'];
				$arr_faq['list_faq'][$doc['id']]    = array(
					'question'                      => $doc['question'],
					'answer'                        => $doc['answer']
				);
			}
		}
        $type_fund = [
            '1' => 'Quỹ đóng',
            '2' => 'Quỹ mở',
            '3' => 'Quỹ thành viên',
            '4' => 'Quỹ ETF',
        ];
        return $this->render('index', [
            'result'                    => $result,
            'list_short_name_and_logo'  => $list_short_name_and_logo,
            'list_company_tag'          => $list_company_tag,
            'list_certificates_name'    => $list_certificates_name,
            'list_company_fund'         => $list_company_fund,
            'count_result'              => $count_result,
            'arr_faq'                   => $arr_faq,
            'type_fund'                 => $type_fund
        ]);
    }

    public function actionGetDataFund() {
        if(isset($_POST['page'])) {

            $condition = [];
            if(!empty($_POST['company'])) {
                $company = explode(" ",$_POST['company']);
                $condition['company_id'] = ['$in' => $company];
            }
            if(!empty($_POST['fund'])) {
                $arr_int_id = [];
                $exp_fund = explode(" ",$_POST['fund']);

                foreach ($exp_fund as $key => $value) {
                    $arr_int_id[$key] = (int)$value;
                }
                $condition['id'] = ['$in' => $arr_int_id];
            }
            if (!empty($_POST['type_fund'])) {
                $condition['type_fund_id'] = $_POST['type_fund'];
            }

            // echo '<pre>';
            // print_r($condition);
            // echo '</pre>';
            // die;
            
            $skip = $_POST['page'] * 10;
            $result = iterator_to_array(Yii::$app->mongodb->getCollection('fund_certificates')->find($condition,[],['limit' => 10,'skip' => $skip]));

            
            // echo '<pre>';
            // print_r($result);
            // echo '</pre>';
            // die;
            
            $list_company_fund = [];
            $list_certificates_name = [];
            $i = 1;

            $arr_data = [];
            $list_id = [];
            $data_char = [];


            $sql = (new \yii\db\Query());
            $list_company_tag = $sql
                ->select('id, long_name, short_name,logo')
                ->from('company')
                ->where('')
                ->all();
    
            $list_short_name_and_logo = array();
            foreach ($list_company_tag as $key => $value) {
                $list_short_name_and_logo[$value['id']] = array($value['logo'],$value['short_name']);
            }        
            foreach ($result as $key => $value) {
                $i++;
                $list_company_fund[$value['company_id']] = $value['company_name'];
                $list_id[$i] = $value['company_id'];
                $list_certificates_name[$value['id']] = $value['certificates_name_cut'];

                $chartjs_name = !empty($value['chart_name']) ? $value['chart_name'] : '';
                $chartjs_value = $value['chart_value'];
                 
                $data_char = '';
                if(!empty($chartjs_name)) {
                    foreach($chartjs_name as $key => $val_char) {
                        $chart_val = (int)str_replace('.','', $chartjs_value[$key]);
    
                        $data_char .=  '{"date": "' . $val_char . '","value": "'. $chart_val .'"},';
                    }
                }
                // echo '<pre>';
                // print_r($data_char);
                // echo '</pre>';
                // die;
                $data_sub = substr($data_char, 0, -1);
                $data_char = '[' . $data_sub . ']';
                // echo '<pre>';
                // print_r($data_char);
                // echo '</pre>';
                // die;
                
                
                
                // $data_char = '[{"date":"2019-07-31","value": "14654"},{"date":"2019-06-30","value": "14339"}]';
                // $data_char = '[{"date":"2018-01-04","value":"10000"},{"date":"2018-01-25","value":"10168"},{"date":"2018-02-22","value":"9932"},{"date":"2018-03-30","value":"10372"},{"date":"2018-04-27","value":"9312"},{"date":"2018-05-31","value":"8980"},{"date":"2018-06-28","value":"8845"},{"date":"2018-07-26","value":"8471"},{"date":"2018-08-30","value":"9287"},{"date":"2018-09-27","value":"10436"},{"date":"2018-10-25","value":"9129"},{"date":"2018-11-30","value":"9391"},{"date":"2018-12-28","value":"9309"},{"date":"2019-01-31","value":"9347"},{"date":"2019-02-28","value":"9854"},{"date":"2019-03-28","value":"9824"},{"date":"2019-04-25","value":"9810"},{"date":"2019-05-30","value":"9585"},{"date":"2019-06-27","value":"9273"},{"date":"2019-07-18","value":"9577"}]'; 

                
                $script_chart = "<script type='text/javascript'>
                        var data_". $value['id'] ." = [];  	
                        var myChart_". $value['id'] ." = new Chart('line-chart". $value['id'] ."', {
                            type: 'line',
                            data: {
                                datasets: [{
                                label: 'Giá',
                                data:$data_char,
                                borderColor: 'rgb(51, 102, 204)',
                                backgroundColor: 'rgb(51, 102, 204)'
                                }]
                            },
                            options: {
                                parsing: {
                                    xAxisKey: 'date',
                                    yAxisKey: 'value'
                                },
                        
                                plugins: {
                                    tooltip: {
                                        mode: 'nearest',
                                        intersect: false
                                    }
                                }					
                            },			
                        });		
                        $('.btnChart_". $value['id'] ."').click(function(){
                            $('.btnChart_". $value['id'] ."').removeClass('active');
                            $(this).addClass('active');
            
                            var month = $(this).attr('date');
                            if(month == 'all') {
                                month = 100000;
                            }
            
                            var startDate = new Date();
                            var endDate = new Date();
                            startDate.setMonth(startDate.getMonth()-month);	 		
                            var data_new=   $data_char.filter(function (d, i) {
                                var date_new = new Date(d.date);
                                return date_new >= startDate && date_new <= endDate;
                            })	
                            // console.log(data_new);
                            if(data_new != '') {
                                myChart_". $value['id'] .".data = {
                                    datasets: [{
                                    label: 'Giá',
                                    data:data_new,
                                    borderColor: 'rgb(51, 102, 204)',
                                    backgroundColor: 'rgb(51, 102, 204)'
                                    }]
                                },
                                myChart_". $value['id'] .".update();
                            }
                            // console.log('data_new: ' + JSON.stringify(data_new));
                        });		
                        
                        function filterData(id, data, myChart) {
                            // console.log('id' + id);
                            var dateStart = new Date($('#startdate_' + id).val());
                            var dateEnd = new Date($('#enddate_' + id).val());
                            if(dateEnd == 'Invalid Date') {
                                dateEnd = new Date();
                            }
                            var data_filter =   data.filter(function (d, i) {
                                var date_new = new Date(d.date);
                                return date_new >= dateStart && date_new <= dateEnd;
                            });
                            if(data_filter != '') {
                                myChart.data = {
                                    datasets: [{
                                    label: 'Giá',
                                    data:data_filter,
                                    borderColor: 'rgb(51, 102, 204)',
                                    backgroundColor: 'rgb(51, 102, 204)'
                                    }]
                                },
                                myChart.update();
                            }				
                        }
                        $('.active').trigger('click');
            
                        
                </script>";

                $arr_distribution = explode(',', $value['distribution_agent']); 
                $count = count($arr_distribution);
                $arr_run_foreach = [];
                $html = '';
                $htmls = '';
                for($i = 0;$i < $count; $i++) {
                        $arr_run_foreach[$i] = $arr_distribution[$i];
                     if (count($arr_run_foreach) == 4){
                        $html .= '<tr>';
                            foreach ($arr_run_foreach as $key => $val) {
                            $html .= '<td class="text-center"> '. $val .'</td>';
                            unset($arr_distribution[$key]);
                        }
                        $html .= '</tr>';
                        $arr_run_foreach = [];
                    }
                }
                if (!empty($arr_distribution)) {
                    $htmls = '<tr>';
                    foreach ($arr_distribution as $k => $v) {
                        $htmls .= '<td class="text-center">'. $v .'</td>';
                    } 
                    $htmls .= '</tr>';
                }      
                // echo '<pre>';
                // print_r($html);
                // echo '</pre>';
                // die;
                       
                $arr_data[] = [
                    'company_id'    => $value['company_id'],
                    'certificates_name_cut'    => $value['certificates_name_cut'],
                    'type_fund_name'    => $value['type_fund_name'],
                    'released_fee_percent'    => !empty($value['released_fee_percent'])?$value['released_fee_percent'].'%':'-',
                    'released_fee_money'    => !empty($value['released_fee_money'])?$value['released_fee_money'].' Triệu':'',
                    'repurchare_fee_percent'    => !empty($value['repurchare_fee_percent']) ? $value['repurchare_fee_percent'] . '%' : '-',
                    'convert_fee_percent'    => !empty($value['convert_fee_percent']) ? $value['convert_fee_percent'] . '%' : '-',
                    'manage_fund_fee'    => $value['manage_fund_fee'],
                    'nav_ccq'    => $value['nav_ccq'],
                    'id'    => $value['id'],
                    'script_chart'  => $script_chart,
                    'data_char'     => $data_char,
                    'certificates_name' => $value['certificates_name'],
                    'investment_objectives' => $value['investment_objectives'],
                    'investment_strategy' => $value['investment_strategy'],
                    'html'  => $html,
                    'htmls'  => $htmls,
                    'bonds' => !empty($value['type_investment']['bonds'])?$value['type_investment']['bonds'].'%':'-',
                    'share' => !empty($value['type_investment']['share'])?$value['type_investment']['share'].'%':'-',
                    'currency' => !empty($value['type_investment']['currency'])?$value['type_investment']['currency'].'%':'-',
                    'avatar'    => 'http://thebank.vn/' . $list_short_name_and_logo[$value['company_id']][0],
                ];
            }
            echo json_encode($arr_data);
            exit;
        }
    }
    public function actionAjax_get_quydautu(){
		if (isset($_POST)) {
            // echo '<pre>';
            // print_r($_POST);
            // echo '</pre>';
            // die;
            
			$arr_id = $_POST['arr_company_id'];
			if (!empty($_POST['arr_company_id'])) {
				$conditions = [
					'company_id' => ['$in' => $arr_id]
				];
			}else{
				$conditions = array();
			}
           
            $result = iterator_to_array(Yii::$app->mongodb->getCollection('fund_certificates')->find($conditions,['id','certificates_name','certificates_name_cut']));
            // echo '<pre>';
            // print_r($result);
            // echo '</pre>';
            // die;
            
			$html = '';
			foreach ($result as $key => $value) {
				$html.= '<option value="'.$value['id'].'">'. $value['certificates_name_cut'] .'</option>';
			}
			// echo $html; exit;
			$data = array(
				'html' => $html,
			);
            // echo '<pre>';
            // print_r($data);
            // echo '</pre>';
            // die;
            
			echo json_encode($data);
		}
	}
}