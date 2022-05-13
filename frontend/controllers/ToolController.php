<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Tool controller
 */

class ToolController extends Controller
{
    public function actionSavingsRate() {
        $this->view->title = "Công cụ tính lãi tiền gửi tiết kiệm có kỳ hạn tại các ngân hàng";
        Yii::$app->params['og_description']['content'] = 'Tính ngay được số tiền lãi nhận được khi gửi tiết kiệm có kỳ hạn tại ngân hàng với số tiền gốc, kỳ hạn gửi và lãi suất tại thời điểm gửi.';
        return $this->render('savings_rate');
    }
    public function actionTrungTamTroGiup(){
        
        // session_start();
        // if(isset($_SESSION)) {
        //   var_dump($_SESSION);
        //   die;
        // }
        Yii::$app->params['og_description']['content'] = 'Trung tâm hướng dẫn';
        $this->view->title = "Trung tâm hướng dẫn";
        return $this->render('support-center');
    }

    public function actionInternetBanking(){
        Yii::$app->params['og_description']['content'] = 'Kết nối đến hệ thống Internet Banking, eBanking của các Ngân hàng tại Việt Nam. Dịch vụ ngân hàng qua internet.';
        $this->view->title = "Hệ thống danh bạ truy cập Internet Banking, eBanking ngân hàng VN";

        $company = (new \yii\db\Query())
                ->select(['*'])
                ->from('company')
                ->where('type = 1 and id not in (117,116,115,55,119,134,133,118) and is_show = 1')
                ->all();
        
        $companies = [];
        foreach($company as $items){
            $companies[] = [
                'short_name'  =>$items['short_name'],
                'individual'  =>$items['individual'],
                'institutions'  =>$items ['institutions'],
            ];

        }
        return $this->render('internetBanking', [
            'company' => $company,
            'companies' => $companies,
        ]);

    }
    public function actionSubdomainInsurance(){
        Yii::$app->params['og_description']['content'] = 'Cập nhật tin tức, thông tin liên hệ, thông tin giao dịch, danh sách chi nhánh, mạng lưới cây ATM và sản phẩm tài chính các ngân hàng trên toàn quốc';
        $this->view->title = "Danh bạ các ngân hàng tại Việt Nam";

        $company = (new \yii\db\Query())
                ->select(['*'])
                ->from('company')
                ->where('type = 1 and id not in (117,116,115,55,119,134,133,118,143,132,43,122,19,32,34,37,48) and is_show = 1')
                ->all();
        
        $companies = [];
        foreach($company as $items){
            $companies[] = [
                'short_name'  =>$items['short_name'],
                'id'  =>$items['id'],
            ];

        }
        // echo '<pre>';
        // print_r($companies);
        // echo '<pre>';die;
        return $this->render('subdomain-insurance', [
            'company' => $company,
            'companies' => $companies,
        ]);

    }    

    public function actionTool(){
        Yii::$app->params['og_description']['content'] = 'Công cụ tài chính';
        $this->view->title = "Công cụ tài chính";
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://thebank.vn/api/apiCompany/getCacheTool',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
            'Cookie: PHPSESSID=vbva1d138jr891ekjfanapl372'
        ),
        ));     

        $response = curl_exec($curl);   
        $count = json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $response), true );
        curl_close($curl);
        return $this->render('tool',[
                'count' => $count
            ]
        );
    }    
    
    /**
     *
     * Trang tim chi nhanh cong ty bao hiem - Code by ngtaiduy
     *
     * @param
     * @return
     *
     */
    public function actionFindInsurance()
    {
        Yii::$app->params['og_description']['content'] = 'Danh sách Văn phòng, Tổng đại lý các công ty bảo hiểm nhân thọ trên toàn quốc';
        $this->view->title = "Danh sách Văn phòng, Tổng đại lý các công ty bảo hiểm nhân thọ trên toàn quốc";

        $data_res = [];
        //Mac dinh hien thi 10 cong ty
        $page_size = 10;
        if (!empty($_POST['page_size'])) {
            $page_size = $_POST['page_size'];
        }
        //Tinh so luot click Xem them
        $max_click = ceil(count((new \yii\db\Query())->select('*')->from('company')->where('type = 2 and id not in (68, 138)')->all()) / 10) - 1;

        //Cong ty trong bo loc
        //An 2 cong ty co ID la 68 va 138
        $all_company = (new \yii\db\Query())
            ->select('*')
            ->from('company')
            ->where('type = 2 and id not in (68, 138)')
            ->andWhere(
                'id in (
                select company_id
                from company_branch
                WHERE status = 1 and province_id is not null
                GROUP BY company_id
                ORDER BY company_id asc
                )'
            )
            ->all();
        $province = (new \yii\db\Query())->select('*')->from('province')->all();
        $district = (new \yii\db\Query())->select('*')->from('district')->all();
        $array_company = [];
        foreach ($all_company as $item) {
            $array_company[$item['id']] = $item['short_name'];
        }
        $array_province = [];
        foreach ($province as $item) {
            $array_province[$item['id']] = $item['province_name'];
        }
        $array_district = [];
        foreach ($district as $item) {
            $array_district[$item['id']] = $item['district_name'];
        }
        //Cong ty trong muc content
        //Cau lenh andWhere: chi hien thi cac cong ty co it nhat 1 chi nhanh
        $company_insurance = (new \yii\db\Query())
            ->select('*')
            ->from('company')
            ->where('type = 2 and id not in (68, 138)')
            ->andWhere(
                'id in (
                select company_id
                from company_branch
                WHERE status = 1 and province_id is not null
                GROUP BY company_id
                ORDER BY company_id asc
                )'
            )
            ->limit($page_size)
            ->all();

        $data_province = [];
        $data_companies = [];
        $arr_district = [];

        $max_click_company = null;
        $count_company = 0;
        $count_record = 0;

        if (!empty($_GET['company'])) {
            $company_id = $_GET['company'];
            //Mac dinh hien thi 20 tinh thanh co so luong chi nhanh nhieu nhat
            $page_size_company = 20;
            if (!empty($_POST['page_size_company'])) {
                $page_size_company = $_POST['page_size_company'];
            }
            $count_company = count((new \yii\db\Query())->select('province_id, count(id) as so_luong')->from('company_branch')->where('status = 1 and company_id = ' . $company_id . ' and province_id is not null')->groupBy('province_id')->orderBy('so_luong desc')->all());
            $max_click_company = ceil($count_company / $page_size_company) - 1;
            $company_by_id = (new \yii\db\Query())->select('*')->from('company')->where('type = 2 and id = ' . $company_id)->one();
            $company_name = $company_by_id['short_name'];

            Yii::$app->params['og_description']['content'] = 'Danh sách Văn phòng, Tổng đại lý các công ty bảo hiểm nhân thọ ' . $company_name;
            $this->view->title = "Danh sách Văn phòng, Tổng đại lý các công ty bảo hiểm nhân thọ " . $company_name;
            //Hien thi danh sach tinh thanh co chi nhanh cua cay ATM đang tim
            $province_group_by = (new \yii\db\Query())
                ->select('province_id, count(id) as so_luong')
                ->from('company_branch')
                ->where('status = 1 and company_id = ' . $company_id . ' and province_id is not null')
                ->groupBy('province_id')
                ->orderBy('so_luong desc, province_id asc')
                ->limit($page_size_company)
                ->all();
            foreach ($province_group_by as $item) {
                $data_province[] = [
                    'id' => $item['province_id'],
                    'province_name' => isset($array_province[$item['province_id']]) ? $array_province[$item['province_id']] : '',
                    'count' => $item['so_luong'],
                    'url' => $this->actionSlug($company_name) . '-' . $this->actionSlug($array_province[$item['province_id']]) . '-' . $company_id . '-' . $item['province_id'] . '.html',
                ];
            }

            $data_res['data_province'] = $data_province;
            $province_exist_order_by_id = (new \yii\db\Query())->select('province_id, count(id) as so_luong')->from('company_branch')->where('status = 1 and company_id = ' . $company_id . ' and province_id is not null')->groupBy('province_id')->orderBy('province_id')->all();
            $province = [];
            foreach ($province_exist_order_by_id as $item) {
                $province[] = [
                    'id' => $item['province_id'],
                    'province_name' => isset($array_province[$item['province_id']]) ? $array_province[$item['province_id']] : '',
                    'count' => $item['so_luong'],
                    'url' => $this->actionSlug($company_name) . '-' . $this->actionSlug($array_province[$item['province_id']]) . '-' . $company_id . '-' . $item['province_id'] . '.html',
                ];
            }

            if (!empty($_GET['province'])) {
                $province_id = $_GET['province'];
                $province_name = $array_province[$province_id];

                Yii::$app->params['og_description']['content'] = 'Chi nhánh, Văn phòng, Tổng đại lý công ty bảo hiểm nhân thọ ' . $company_name . ' tại ' . $province_name;
                $this->view->title = "Chi nhánh, Văn phòng, Tổng đại lý công ty bảo hiểm nhân thọ " . $company_name . ' tại ' . $province_name;

                $district_exist_order_by_id = (new \yii\db\Query())->select('district_id, count(id) as so_luong')->from('company_branch')->where('status = 1 and company_id = ' . $company_id . ' and province_id = ' . $province_id)->groupBy('district_id')->orderBy('district_id')->all();
                $count_record = count($district_exist_order_by_id);
                if ($count_record == 0) {
                    return $this->redirect(['cong-cu/tim-chi-nhanh-cong-ty-bao-hiem/' . $this->actionSlug($company_name) . '-' . $company_id . '.html']);
                }
                foreach ($district_exist_order_by_id as $item) {
                    $arr_district[] = [
                        'id' => $item['district_id'],
                        'district_name' => isset($array_district[$item['district_id']]) ? $array_district[$item['district_id']] : '',
                        'count' => $item['so_luong'],
                    ];
                }
                $companies = (new \yii\db\Query())->select('*')->from('company_branch')->where('status = 1 and company_id = ' . $company_id . ' and province_id = ' . $province_id)->all();
                foreach ($companies as $key => $item) {
                    $data_companies[] = [
                        'so_thu_tu' => $key + 1,
                        'branch_name' => $item['branch_name'],
                        'address' => $item['address'],
                        'phone' => $item['phone'],
                        'fax' => isset($item['fax']) ? $item['fax'] : '---',
                        'url_map' => 'https://maps.google.com/maps?q=' . $item['address'],
                    ];
                }
                $data_res['data_companies'] = $data_companies;
                if (!empty($_GET['district'])) {
                    $district_id = $_GET['district'];
                    $district_name = $array_district[$district_id];

                    Yii::$app->params['og_description']['content'] = 'Chi nhánh, Văn phòng, Tổng đại lý công ty bảo hiểm nhân thọ ' . $company_name . ' tại ' . $district_name . ' - ' . $province_name;
                    $this->view->title = "Chi nhánh, Văn phòng, Tổng đại lý công ty bảo hiểm nhân thọ " . $company_name . ' tại ' . $district_name . ' - ' . $province_name;

                    $companies = (new \yii\db\Query())->select('*')->from('company_branch')->where('status = 1 and company_id = ' . $company_id . ' and province_id = ' . $province_id . ' and district_id = ' . $district_id)->all();
                    $count_record = count($companies);
                    if ($count_record == 0) {
                        return $this->redirect(['cong-cu/tim-chi-nhanh-cong-ty-bao-hiem/' . $this->actionSlug($company_name) . '-' . $this->actionSlug($province_name) . '-' . $company_id . '-' . $province_id . '.html']);
                    }
                    $data_companies = [];
                    foreach ($companies as $key => $item) {
                        $data_companies[] = [
                            'so_thu_tu' => $key + 1,
                            'branch_name' => $item['branch_name'],
                            'address' => $item['address'],
                            'phone' => $item['phone'],
                            'fax' => isset($item['fax']) ? $item['fax'] : '---',
                            'url_map' => 'https://maps.google.com/maps?q=' . $item['address'],
                        ];
                    }
                    $data_res['data_companies'] = $data_companies;
                }
            }
        }
        $data_insurance = [];
        foreach ($company_insurance as $item) {
            $url = 'tim-chi-nhanh-cong-ty-bao-hiem/' . $this->actionSlug($item['short_name']) . '-' . $item['id'] . '.html';
            $data_insurance[] = [
                'long_name' => $item['long_name'],
                'short_name' => $item['short_name'],
                'url' => $url,
                'address' => isset($item['address']) ? $item['address'] : "",
                'phone' => isset($item['phone']) ? $item['phone'] : ""
            ];
        }
        $data_res['data_insurance'] = $data_insurance;
        $data_res['max_click'] = $max_click;

        if (!empty($_POST)) {
            echo json_encode($data_res);
            exit;
        }

        return $this->render('find-insurance', [
            'all_company' => $all_company,
            'company_insurance' => $company_insurance,
            'province' => $province,
            'data_insurance' => $data_insurance,

            'max_click' => $max_click,
            'max_click_company' => $max_click_company,
            'count_company' => $count_company,

            'count_record' => $count_record,

            'data_province' => $data_province,
            'data_companies' => $data_companies,

            'array_company' => $array_company,
            'array_province' => $array_province,
            'array_district' => $array_district,

            'arr_district' => $arr_district,
        ]);
    }

    /**
     *
     * Trang tim ATM - Code by ngtaiduy
     *
     * @param
     * @return
     *
     */
    public function actionFindAtm()
    {
        Yii::$app->params['og_description']['content'] = 'Điểm đặt cây ATM các ngân hàng trên toàn quốc';
        $this->view->title = "Điểm đặt cây ATM các ngân hàng trên toàn quốc";

        $data_res = [];
        //Mac dinh hien thi 10 cong ty
        $page_size = 10;
        if (!empty($_POST['page_size'])) {
            $page_size = $_POST['page_size'];
        }

        //Tinh so luot click Xem them
        $max_click = ceil(count((new \yii\db\Query())->select('*')->from('company')->where('type = 1')->andWhere('id not in (53, 37, 43, 48, 32, 19, 34)')
            ->andWhere(
                'id in (
                select company_id
                from place_atm
                WHERE province_id is not null
                GROUP BY company_id
                ORDER BY company_id asc
                )'
            )->all()) / 10) - 1;

        //Cong ty trong bo loc
        //An cac cong ty co Id la 53, 37, 43, 48, 32, 19, 34
        $all_company = (new \yii\db\Query())
            ->select('*')
            ->from('company')
            ->where('type = 1')
            ->andWhere('id not in (53, 37, 43, 48, 32, 19, 34)')
            ->andWhere(
                'id in (
                select company_id
                from place_atm
                WHERE province_id is not null
                GROUP BY company_id
                ORDER BY company_id asc
                )'
            )
            ->all();
        $all_product_gtk = (new \yii\db\Query())->select('*')->from('product_gui_tiet_kiem')->all();
        $array_company = [];
        $array_company_long_name = [];
        $array_slug_company = [];
        $array_gtk = [];
        foreach ($all_company as $item) {
            $array_company[$item['id']] = $item['short_name'];
            $array_company_long_name[$item['id']] = $item['long_name'];
            $array_slug_company[$item['id']] = str_replace('-', '', $item['slug_name']);
        }
        foreach ($all_product_gtk as $item) {
            $array_gtk[$item['company_id']] = $item['id'];
        }
        $province = (new \yii\db\Query())->select('*')->from('province')->all();
        $array_province = [];
        foreach ($province as $item) {
            $array_province[$item['id']] = $item['province_name'];
        }
        $district = (new \yii\db\Query())->select('*')->from('district')->all();
        $array_district = [];
        foreach ($district as $item) {
            $array_district[$item['id']] = $item['district_name'];
        }

        //Cong ty trong muc content
        $company_atm = (new \yii\db\Query())
            ->select('*')
            ->from('company')
            ->where('type = 1')
            ->andWhere('id not in (53, 37, 43, 48, 32, 19, 34)')
            ->andWhere(
                'id in (
                select company_id
                from place_atm
                WHERE province_id is not null
                GROUP BY company_id
                ORDER BY company_id asc
                )'
            )
            ->limit($page_size)
            ->all();

        $data_province = [];
        $data_district = [];
        $data_companies = [];
        $arr_district = [];
        $arr_most_view_company = [];

        $max_click_company = 0;
        $max_click_province = 0;
        $count_company = 0;
        $count_province = 0;
        $count_record = 0;
        $total_atm = 0;
        $total_atm_by_company_province = 0;

        if (!empty($_GET['company'])) {

            $company_id = $_GET['company'];
            $count_company_by_id = (new \yii\db\Query())
                ->select('*')
                ->from('company')
                ->where('type = 1')
                ->andWhere('id not in (53, 37, 43, 48, 32, 19, 34)')
                ->andWhere(
                    'id in (
                select company_id
                from place_atm
                WHERE province_id is not null
                GROUP BY company_id
                ORDER BY company_id asc
                )'
                )
                ->andWhere('id = ' . $company_id)
                ->count();
            if ($count_company_by_id == 0) {
                return $this->redirect('https://thebank.vn/');
            }
            $company_name = $array_company[$company_id];

            //Mac dinh hien thi 20 tinh thanh co so luong ATM nhieu nhat
            $page_size_company = 20;
            if (!empty($_POST['page_size_company'])) {
                $page_size_company = $_POST['page_size_company'];
            }
            $all_province_by_company = (new \yii\db\Query())->select('province_id, count(id) as so_luong')->from('place_atm')->where('company_id = ' . $company_id . ' and province_id in (select id from province)')->groupBy('province_id')->orderBy('so_luong desc, province_id asc')->all();
            $count_company = count($all_province_by_company);
            $max_click_company = ceil($count_company / $page_size_company) - 1;
            //Tinh tong so ATM cua cong ty
            foreach ($all_province_by_company as $item) {
                $total_atm += $item['so_luong'];
            }
            Yii::$app->params['og_description']['content'] = 'Điểm đặt cây ATM ngân hàng ' . $company_name . " trên toàn quốc";
            $this->view->title = "Điểm đặt cây ATM ngân hàng " . $company_name . " trên toàn quốc";
            //Hien thi danh sach tinh thanh co chi nhanh cua cay ATM đang tim
            $province_group_by = (new \yii\db\Query())
                ->select('province_id, count(id) as so_luong')
                ->from('place_atm')
                ->where('company_id = ' . $company_id . ' and province_id in (select id from province)')
                ->groupBy('province_id')
                ->orderBy('so_luong desc, province_id asc')
                ->limit($page_size_company)
                ->all();
            foreach ($province_group_by as $item) {
                $data_province[] = [
                    'id' => $item['province_id'],
                    'province_name' => isset($array_province[$item['province_id']]) ? $array_province[$item['province_id']] : '',
                    'count' => $item['so_luong'],
                    'url' => $this->actionSlug($company_name) . '-' . $this->actionSlug($array_province[$item['province_id']]) . '-' . $company_id . '-' . $item['province_id'] . '.html',
                ];
            }
            $data_res['data_province'] = $data_province;
            $province_exist_order_by_id = (new \yii\db\Query())->select('province_id, count(id) as so_luong')->from('place_atm')->where('company_id = ' . $company_id . ' and province_id in (select id from province)')->groupBy('province_id')->orderBy('so_luong desc, province_id asc')->all();
            $province = [];
            foreach ($province_exist_order_by_id as $item) {
                $province[] = [
                    'id' => $item['province_id'],
                    'province_name' => isset($array_province[$item['province_id']]) ? $array_province[$item['province_id']] : '',
                    'count' => $item['so_luong'],
                    'url' => $this->actionSlug($company_name) . '-' . $this->actionSlug($array_province[$item['province_id']]) . '-' . $company_id . '-' . $item['province_id'] . '.html',
                ];
            }

            //Lay ra 10 cong ty co thu hang cao nhat nam trong muc Co the ban can tim
            $most_view_company = (new \yii\db\Query())
                ->select('*')
                ->from('company')
                ->where('type = 1 and company.rank is not null')
                ->andWhere('id not in (53, 37, 43, 48, 32, 19, 34)')
                ->andWhere(
                    'id in (
                    select company_id
                    from place_atm
                    WHERE province_id is not null
                    GROUP BY company_id
                    ORDER BY company_id asc
                    )'
                )
                ->orderBy('company.rank')
                ->limit(10)
                ->all();
            foreach ($most_view_company as $item) {
                $arr_most_view_company[] = [
                    'id' => $item['id'],
                    'short_name' => $item['short_name'],
                ];
            }

            if (!empty($_GET['province'])) {
                $province_id = $_GET['province'];
                $province_name = $array_province[$province_id];

                //Mac dinh hien thi 20 quan huyen co so luong chi nhanh nhieu nhat
                $page_size_province = 20;
                if (!empty($_POST['page_size_province'])) {
                    $page_size_province = $_POST['page_size_province'];
                }
                $count_province = count((new \yii\db\Query())->select('district_id, count(id) as so_luong')->from('place_atm')->where('company_id = ' . $company_id . ' and province_id = ' . $province_id)->groupBy('district_id')->orderBy('so_luong desc, district_id asc')->all());
                $max_click_province = ceil($count_province / $page_size_province) - 1;
                $all_district_by_company_province = (new \yii\db\Query())->select('district_id, count(id) as so_luong')->from('place_atm')->where('company_id = ' . $company_id . ' and province_id = ' . $province_id)->groupBy('district_id')->orderBy('so_luong desc, district_id asc')->all();
                //Tinh tong so ATM theo cong ty va tinh thanh
                foreach ($all_district_by_company_province as $item) {
                    $total_atm_by_company_province += $item['so_luong'];
                }
                Yii::$app->params['og_description']['content'] = 'Điểm đặt cây ATM ' . $company_name . ' tại ' . $province_name;
                $this->view->title = "Điểm đặt cây ATM " . $company_name . ' tại ' . $province_name;

                if ($count_province == 0) {
                    return $this->redirect(['cong-cu/tim-atm/' . $this->actionSlug($company_name) . '-' . $company_id . '.html']);
                }
                //Hien thi danh sach quan huyen co chi nhanh cua cay ATM đang tim
                $district_group_by = (new \yii\db\Query())
                    ->select('district_id, count(id) as so_luong')
                    ->from('place_atm')
                    ->where('company_id = ' . $company_id . ' and province_id = ' . $province_id)
                    ->groupBy('district_id')
                    ->orderBy('so_luong desc, district_id asc')
                    ->limit($page_size_province)
                    ->all();

                foreach ($district_group_by as $item) {
                    $data_district[] = [
                        'id' => $item['district_id'],
                        'district_name' => isset($array_district[$item['district_id']]) ? $array_district[$item['district_id']] : '',
                        'count' => $item['so_luong'],
                        'url' => $this->actionSlug($company_name) . '-' . $this->actionSlug($array_district[$item['district_id']]) . '-' . $this->actionSlug($province_name) . '-' . $company_id . '-' . $province_id . '-' . $item['district_id'] . '.html',
                    ];
                }
                $data_res['data_district'] = $data_district;
                $district_exist_order_by_id = (new \yii\db\Query())->select('district_id, count(id) as so_luong')->from('place_atm')->where('company_id = ' . $company_id . ' and province_id = ' . $province_id)->groupBy('district_id')->orderBy('district_id')->all();
                foreach ($district_exist_order_by_id as $item) {
                    $arr_district[] = [
                        'id' => $item['district_id'],
                        'district_name' => isset($array_district[$item['district_id']]) ? $array_district[$item['district_id']] : '',
                        'count' => $item['so_luong']
                    ];
                }

                if (!empty($_GET['district'])) {
                    $district_id = $_GET['district'];
                    $district_name = $array_district[$district_id];

                    Yii::$app->params['og_description']['content'] = 'Điểm đặt cây ATM ' . $company_name . ' tại ' . $district_name . ' - ' . $province_name;
                    $this->view->title = "Điểm đặt cây ATM " . $company_name . ' tại ' . $district_name . ' - ' . $province_name;

                    $companies = (new \yii\db\Query())->select('*')->from('place_atm')->where('company_id = ' . $company_id . ' and province_id = ' . $province_id . ' and district_id = ' . $district_id)->all();
                    $count_record = count($companies);
                    if ($count_record == 0) {
                        return $this->redirect(['cong-cu/tim-atm/' . $this->actionSlug($company_name) . '-' . $this->actionSlug($province_name) . '-' . $company_id . '-' . $province_id . '.html']);
                    }
                    $data_companies = [];
                    foreach ($companies as $key => $item) {
                        $data_companies[] = [
                            'so_thu_tu' => $key + 1,
                            'company_name' => $company_name,
                            'address' => $item['address'],
                            'open_time' => $item['open_time'],
                            'url_map' => 'https://maps.google.com/maps?q=' . $item['address'],
                        ];
                    }
                    $data_res['data_companies'] = $data_companies;
                }
            }
        }
        $data_atm = [];
        foreach ($company_atm as $item) {
            $url = 'tim-atm/' . $this->actionSlug($item['short_name']) . '-' . $item['id'] . '.html';
            $data_atm[] = [
                'long_name' => $item['long_name'],
                'short_name' => $item['short_name'],
                'url' => $url,
                'address' => isset($item['address']) ? $item['address'] : "",
                'phone' => isset($item['phone']) ? $item['phone'] : ""
            ];
        }
        $data_res['data_atm'] = $data_atm;
        $data_res['max_click'] = $max_click;

        if (!empty($_POST)) {
            echo json_encode($data_res);
            exit;
        }

        return $this->render('find-atm', [
            'all_company' => $all_company,
            'company_atm' => $company_atm,
            'province' => $province,
            'data_atm' => $data_atm,

            'max_click' => $max_click,
            'max_click_company' => $max_click_company,
            'max_click_province' => $max_click_province,

            'total_atm' => $total_atm,
            'total_atm_by_company_province' => $total_atm_by_company_province,
            'count_company' => $count_company,
            'count_province' => $count_province,
            'count_record' => $count_record,

            'data_province' => $data_province,
            'data_district' => $data_district,
            'data_companies' => $data_companies,

            'array_company' => $array_company,
            'array_company_long_name' => $array_company_long_name,
            'array_slug_company' => $array_slug_company,
            'array_gtk' => $array_gtk,
            'array_province' => $array_province,
            'array_district' => $array_district,

            'arr_district' => $arr_district,

            'arr_most_view_company' => $arr_most_view_company,
        ]);
    }

    /**
     *
     * Trang tim chi nhanh ngan hang - Code by ngtaiduy
     *
     * @param
     * @return
     *
     */
    public function actionFindBank()
    {
        Yii::$app->params['og_description']['content'] = 'Chi nhánh, phòng giao dịch ngân hàng trên toàn quốc';
        $this->view->title = "Chi nhánh, phòng giao dịch ngân hàng trên toàn quốc";

        $data_res = [];
        //Mac dinh hien thi 10 cong ty
        $page_size = 10;
        if (!empty($_POST['page_size'])) {
            $page_size = $_POST['page_size'];
        }

        //Tinh so luot click Xem them
        $max_click = ceil(count((new \yii\db\Query())->select('*')->from('company')->where('type = 1 or type = 3')->andWhere('id not in (43, 53, 48, 122, 37, 32, 34, 19)')
            ->andWhere(
                'id in (
                select company_id
                from company_branch
                WHERE status = 1 and province_id is not null
                GROUP BY company_id
                ORDER BY company_id asc
                )'
            )->all()) / 10) - 1;
        //Cong ty trong bo loc
        //An cac cong ty co Id la 43, 53, 48, 122, 37, 32, 34, 19
        $all_company = (new \yii\db\Query())
            ->select('*')
            ->from('company')
            ->where('type = 1 or type = 3')
            ->andWhere('id not in (43, 53, 48, 122, 37, 32, 34, 19)')
            ->andWhere(
                'id in (
                select company_id
                from company_branch
                WHERE status = 1 and province_id is not null
                GROUP BY company_id
                ORDER BY company_id asc
                )'
            )
            ->all();
        $all_product_gtk = (new \yii\db\Query())->select('*')->from('product_gui_tiet_kiem')->all();
        $array_company = [];
        $array_company_long_name = [];
        $array_slug_company = [];
        $array_gtk = [];
        foreach ($all_company as $item) {
            $array_company[$item['id']] = $item['short_name'];
            $array_company_long_name[$item['id']] = $item['long_name'];
            $array_slug_company[$item['id']] = str_replace('-', '', $item['slug_name']);
        }
        foreach ($all_product_gtk as $item) {
            $array_gtk[$item['company_id']] = $item['id'];
        }
        $province = (new \yii\db\Query())->select('*')->from('province')->all();
        $array_province = [];
        foreach ($province as $item) {
            $array_province[$item['id']] = $item['province_name'];
        }
        $district = (new \yii\db\Query())->select('*')->from('district')->all();
        $array_district = [];
        foreach ($district as $item) {
            $array_district[$item['id']] = $item['district_name'];
        }

        //Cong ty trong muc content
        $company_bank = (new \yii\db\Query())
            ->select('*')
            ->from('company')
            ->where('type = 1 or type = 3')
            ->andWhere('id not in (43, 53, 48, 122, 37, 32, 34, 19)')
            ->andWhere(
                'id in (
                select company_id
                from company_branch
                WHERE status = 1 and province_id is not null
                GROUP BY company_id
                ORDER BY company_id asc
                )'
            )
            ->limit($page_size)
            ->all();

        $data_province = [];
        $data_district = [];
        $data_companies = [];
        $arr_district = [];
        $arr_most_view_company = [];

        $max_click_company = 0;
        $max_click_province = 0;
        $count_company = 0;
        $count_province = 0;
        $count_record = 0;
        $total_bank = 0;
        $total_bank_by_company_province = 0;

        if (!empty($_GET['company'])) {
            $company_id = $_GET['company'];
            $count_company_by_id = (new \yii\db\Query())
                ->select('*')
                ->from('company')
                ->where('type = 1 or type = 3')
                ->andWhere('id not in (43, 53, 48, 122, 37, 32, 34, 19)')
                ->andWhere(
                    'id in (
                select company_id
                from company_branch
                WHERE status = 1 and province_id is not null
                GROUP BY company_id
                ORDER BY company_id asc
                )'
                )
                ->andWhere('id = ' . $company_id)
                ->count();
            if ($count_company_by_id == 0) {
                return $this->redirect('https://thebank.vn/');
            }
            $company_name = $array_company[$company_id];
            //Mac dinh hien thi 20 tinh thanh co so luong ATM nhieu nhat
            $page_size_company = 20;
            if (!empty($_POST['page_size_company'])) {
                $page_size_company = $_POST['page_size_company'];
            }
            $all_province_by_company = (new \yii\db\Query())->select('province_id, count(id) as so_luong')->from('company_branch')->where('company_id = ' . $company_id . ' and province_id in (select id from province)')->groupBy('province_id')->orderBy('so_luong desc, province_id asc')->all();
            $count_company = count($all_province_by_company);
            $max_click_company = ceil($count_company / $page_size_company) - 1;
            //Tinh tong so ATM cua cong ty
            foreach ($all_province_by_company as $item) {
                $total_bank += $item['so_luong'];
            }
            Yii::$app->params['og_description']['content'] = 'Chi nhánh, phòng giao dịch ngân hàng ' . $company_name . " trên toàn quốc";
            $this->view->title = "Chi nhánh, phòng giao dịch ngân hàng " . $company_name . " trên toàn quốc";
            //Hien thi danh sach tinh thanh co chi nhanh cua cay ATM đang tim
            $province_group_by = (new \yii\db\Query())
                ->select('province_id, count(id) as so_luong')
                ->from('company_branch')
                ->where('company_id = ' . $company_id . ' and province_id in (select id from province)')
                ->groupBy('province_id')
                ->orderBy('so_luong desc, province_id asc')
                ->limit($page_size_company)
                ->all();
            foreach ($province_group_by as $item) {
                $data_province[] = [
                    'id' => $item['province_id'],
                    'province_name' => isset($array_province[$item['province_id']]) ? $array_province[$item['province_id']] : '',
                    'count' => $item['so_luong'],
                    'url' => $this->actionSlug($company_name) . '-' . $this->actionSlug($array_province[$item['province_id']]) . '-' . $company_id . '-' . $item['province_id'] . '.html',
                ];
            }
            $data_res['data_province'] = $data_province;
            $province_exist_order_by_id = (new \yii\db\Query())->select('province_id, count(id) as so_luong')->from('company_branch')->where('company_id = ' . $company_id . ' and province_id in (select id from province)')->groupBy('province_id')->orderBy('so_luong desc, province_id asc')->all();
            $province = [];
            foreach ($province_exist_order_by_id as $item) {
                $province[] = [
                    'id' => $item['province_id'],
                    'province_name' => isset($array_province[$item['province_id']]) ? $array_province[$item['province_id']] : '',
                    'count' => $item['so_luong'],
                    'url' => $this->actionSlug($company_name) . '-' . $this->actionSlug($array_province[$item['province_id']]) . '-' . $company_id . '-' . $item['province_id'] . '.html',
                ];
            }

            //Lay ra 10 cong ty co thu hang cao nhat nam trong muc Co the ban can tim
            $most_view_company = (new \yii\db\Query())
                ->select('*')
                ->from('company')
                ->where('type = 1 or type = 3')
                ->andWhere('company.rank is not null')
                ->andWhere('id not in (43, 53, 48, 122, 37, 32, 34, 19)')
                ->andWhere(
                    'id in (
                    select company_id
                    from company_branch
                    WHERE status = 1 and province_id is not null
                    GROUP BY company_id
                    ORDER BY company_id asc
                    )'
                )
                ->orderBy('company.rank')
                ->limit(10)
                ->all();
            foreach ($most_view_company as $item) {
                $arr_most_view_company[] = [
                    'id' => $item['id'],
                    'short_name' => $item['short_name'],
                ];
            }

            if (!empty($_GET['province'])) {
                $province_id = $_GET['province'];
                $province_name = $array_province[$province_id];
                //Mac dinh hien thi 20 quan huyen co so luong chi nhanh nhieu nhat
                $page_size_province = 20;
                if (!empty($_POST['page_size_province'])) {
                    $page_size_province = $_POST['page_size_province'];
                }
                $all_district_by_company_province = (new \yii\db\Query())->select('district_id, count(id) as so_luong')->from('company_branch')->where('company_id = ' . $company_id . ' and province_id = ' . $province_id)->groupBy('district_id')->orderBy('so_luong desc, district_id asc')->all();
                $count_province = count($all_district_by_company_province);
                $max_click_province = ceil($count_province / $page_size_province) - 1;
                //Tinh tong so ATM theo cong ty va tinh thanh
                foreach ($all_district_by_company_province as $item) {
                    $total_bank_by_company_province += $item['so_luong'];
                }
                Yii::$app->params['og_description']['content'] = 'Chi nhánh, phòng giao dịch ngân hàng ' . $company_name . ' tại ' . $province_name;
                $this->view->title = "Chi nhánh, phòng giao dịch ngân hàng " . $company_name . ' tại ' . $province_name;

                if ($count_province == 0) {
                    return $this->redirect(['cong-cu/tim-chi-nhanh-ngan-hang/' . $this->actionSlug($company_name) . '-' . $company_id . '.html']);
                }
                //Hien thi danh sach quan huyen co chi nhanh cua cay ATM đang tim
                $district_group_by = (new \yii\db\Query())
                    ->select('district_id, count(id) as so_luong')
                    ->from('company_branch')
                    ->where('company_id = ' . $company_id . ' and province_id = ' . $province_id)
                    ->groupBy('district_id')
                    ->orderBy('so_luong desc, district_id asc')
                    ->limit($page_size_province)
                    ->all();
                foreach ($district_group_by as $item) {
                    $data_district[] = [
                        'id' => $item['district_id'],
                        'district_name' => isset($array_district[$item['district_id']]) ? $array_district[$item['district_id']] : '',
                        'count' => $item['so_luong'],
                        'url' => $this->actionSlug($company_name) . '-' . $this->actionSlug($array_district[$item['district_id']]) . '-' . $this->actionSlug($province_name) . '-' . $company_id . '-' . $province_id . '-' . $item['district_id'] . '.html',
                    ];
                }
                $data_res['data_district'] = $data_district;
                $district_exist_order_by_id = (new \yii\db\Query())->select('district_id, count(id) as so_luong')->from('company_branch')->where('company_id = ' . $company_id . ' and province_id = ' . $province_id)->groupBy('district_id')->orderBy('district_id')->all();
                foreach ($district_exist_order_by_id as $item) {
                    $arr_district[] = [
                        'id' => $item['district_id'],
                        'district_name' => isset($array_district[$item['district_id']]) ? $array_district[$item['district_id']] : '',
                        'count' => $item['so_luong']
                    ];
                }

                if (!empty($_GET['district'])) {
                    $district_id = $_GET['district'];
                    $district_name = $array_district[$district_id];

                    Yii::$app->params['og_description']['content'] = 'Chi nhánh, phòng giao dịch ngân hàng ' . $company_name . ' tại ' . $district_name . ' - ' . $province_name;
                    $this->view->title = "Chi nhánh, phòng giao dịch ngân hàng " . $company_name . ' tại ' . $district_name . ' - ' . $province_name;

                    $companies = (new \yii\db\Query())->select('*')->from('company_branch')->where('company_id = ' . $company_id . ' and province_id = ' . $province_id . ' and district_id = ' . $district_id)->all();
                    $count_record = count($companies);
                    if ($count_record == 0) {
                        return $this->redirect(['cong-cu/tim-chi-nhanh-ngan-hang/' . $this->actionSlug($company_name) . '-' . $this->actionSlug($province_name) . '-' . $company_id . '-' . $province_id . '.html']);
                    }
                    $data_companies = [];
                    foreach ($companies as $key => $item) {
                        $fax = '';
                        if ($item['fax'] == null || strlen($item['fax']) == 0) {
                            $fax = '---';
                        } else {
                            $fax = $item['fax'];
                        }
                        $data_companies[] = [
                            'so_thu_tu' => $key + 1,
                            'branch_name' => $item['branch_name'],
                            'address' => $item['address'],
                            'phone' => $item['phone'],
                            'fax' => $fax,
                            'url_map' => 'https://maps.google.com/maps?q=' . $item['address'],
                        ];
                    }
                    $data_res['data_companies'] = $data_companies;
                }
            }
        }
        $data_bank = [];
        foreach ($company_bank as $item) {
            $url = 'tim-chi-nhanh-ngan-hang/' . $this->actionSlug($item['short_name']) . '-' . $item['id'] . '.html';
            $data_bank[] = [
                'long_name' => $item['long_name'],
                'short_name' => $item['short_name'],
                'url' => $url,
                'address' => isset($item['address']) ? $item['address'] : "",
                'phone' => isset($item['phone']) ? $item['phone'] : ""
            ];
        }
        $data_res['data_bank'] = $data_bank;
        $data_res['max_click'] = $max_click;

        if (!empty($_POST)) {
            echo json_encode($data_res);
            exit;
        }

        return $this->render('find-bank', [
            'all_company' => $all_company,
            'company_bank' => $company_bank,
            'province' => $province,
            'data_bank' => $data_bank,

            'max_click' => $max_click,
            'max_click_company' => $max_click_company,
            'max_click_province' => $max_click_province,

            'total_bank' => $total_bank,
            'total_bank_by_company_province' => $total_bank_by_company_province,
            'count_company' => $count_company,
            'count_province' => $count_province,
            'count_record' => $count_record,

            'data_province' => $data_province,
            'data_district' => $data_district,
            'data_companies' => $data_companies,

            'array_company' => $array_company,
            'array_company_long_name' => $array_company_long_name,
            'array_slug_company' => $array_slug_company,
            'array_gtk' => $array_gtk,
            'array_province' => $array_province,
            'array_district' => $array_district,

            'arr_district' => $arr_district,

            'arr_most_view_company' => $arr_most_view_company,
        ]);
    }

    public function actionGetDistrict() 
    {
        if (!empty($_POST)) { 
            $province_id = $_POST['province_id'];
            $districts = (new \yii\db\Query())->select('*')->from('district')->where(['province_id' => $province_id])->all();
            $list_district = [];
            foreach ($districts as $item) {
                $list_district[$item['id']] = $item['district_name'];
            }
            echo json_encode($list_district);
            exit;
        }  
    }    
    public function actionSlug($alias_url)
    {

        $search = [ 
            'à', 'á', 'ả', 'ã', 'ạ',
            'À', 'Á', 'Ả', 'Ã', 'Ạ',
            'ă', 'ằ', 'ắ', 'ẳ', 'ẵ', 'ặ',
            'Ă', 'Ằ', 'Ắ', 'Ẳ', 'Ẵ', 'Ặ',
            'â', 'ầ', 'ấ', 'ẩ', 'ẫ', 'ậ',
            'Â', 'Ầ', 'Ấ', 'Ẩ', 'Ẫ', 'Ậ',
            'è', 'é', 'ẻ', 'ẽ', 'ẹ',
            'È', 'É', 'Ẻ', 'Ẽ', 'Ẹ',
            'ê', 'ề', 'ế', 'ể', 'ễ', 'ệ',
            'Ê', 'Ề', 'Ế', 'Ể', 'Ễ', 'Ệ',
            'ì', 'í', 'ỉ', 'ĩ', 'ị',
            'Ì', 'Í', 'I', 'Ĩ', 'Ị',
            'ò', 'ó', 'ỏ', 'õ', 'ọ',
            'Ò', 'Ó', 'Ỏ', 'Õ', 'Ọ',
            'ô', 'ồ', 'ố', 'ổ', 'ỗ', 'ộ',
            'Ô', 'Ồ', 'Ố', 'Ổ', 'Ỗ', 'Ộ',
            'ơ', 'ờ', 'ớ', 'ở', 'ỡ', 'ợ',
            'Ơ', 'Ờ', 'Ớ', 'Ở', 'Ỡ', 'Ợ',
            'ù', 'ú', 'ủ', 'ũ', 'ụ',
            'Ù', 'Ú', 'Ủ', 'Ũ', 'Ụ',
            'ư', 'ừ', 'ứ', 'ử', 'ữ', 'ự',
            'Ư', 'Ừ', 'Ứ', 'Ử', 'Ữ', 'Ự',
            'ỳ', 'ý', 'ỷ', 'ỹ', 'ỵ',
            'Ỳ', 'Ý', 'Ỷ', 'Ỹ', 'Ỵ'
        ];
        $replace = [
            'a', 'a', 'a', 'a', 'a',
            'a', 'a', 'a', 'a', 'a',
            'a', 'a', 'a', 'a', 'a', 'a',
            'a', 'a', 'a', 'a', 'a', 'a',
            'a', 'a', 'a', 'a', 'a', 'a',
            'a', 'a', 'a', 'a', 'a', 'a',
            'e', 'e', 'e', 'e', 'e',
            'e', 'e', 'e', 'e', 'e',
            'e', 'e', 'e', 'e', 'e', 'e',
            'e', 'e', 'e', 'e', 'e', 'e',
            'i', 'i', 'i', 'i', 'i',
            'i', 'i', 'i', 'i', 'i',
            'o', 'o', 'o', 'o', 'o',
            'o', 'o', 'o', 'o', 'o',
            'o', 'o', 'o', 'o', 'o', 'o',
            'o', 'o', 'o', 'o', 'o', 'o',
            'o', 'o', 'o', 'o', 'o', 'o',
            'o', 'o', 'o', 'o', 'o', 'o',
            'u', 'u', 'u', 'u', 'u', 
            'u', 'u', 'u', 'u', 'u',
            'u', 'u', 'u', 'u', 'u', 'u',
            'u', 'u', 'u', 'u', 'u', 'u',
            'y', 'y', 'y', 'y', 'y',
            'y', 'y', 'y', 'y', 'y'
        ];
        $alias_url = str_replace($search, $replace, $alias_url);
        $divider = '-';
        // replace non letter or digits by divider
        $alias_url = preg_replace('~[^\pL\d]+~u', $divider, $alias_url);

        // transliterate
        $alias_url = iconv('utf-8', 'ASCII//TRANSLIT//IGNORE', $alias_url);

        // remove unwanted characters
        $alias_url = preg_replace('~[^-\w]+~', '', $alias_url);

        // trim
        $alias_url = trim($alias_url, $divider);

        // remove duplicate divider
        $alias_url = preg_replace('~-+~', $divider, $alias_url);

        // lowercase
        $alias_url = strtolower($alias_url);

        if (empty($alias_url)) {
            return 'n-a';
        }

        return $alias_url;
    }    
    public function actionLoanEstimate(){
        $this->view->title = "Công cụ ước tính số tiền có thể vay";
        return $this->render('loan-estimate');
    }
    public function actionEstimate(){

        Yii::$app->params['og_description']['content'] = 'Công cụ ước tính số tiền vay phải trả hàng tháng';
        $this->view->title = "Công cụ ước tính số tiền vay phải trả hàng tháng";
        return $this->render('estimate');
    }
}