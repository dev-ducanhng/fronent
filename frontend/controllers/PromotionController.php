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
use frontend\models\QaCategory;

/**
 * Tool controller
 */

  
class PromotionController extends Controller
{
    /**
     *
     * Trang tim diem uu dai - Code by Nguyen Duc Anh
     *
     * @param
     * @return
     *
     */
    public function actionPromotion()
    {   
        
        $this->view->title='Danh sách điểm ưu đãi cho chủ thẻ tín dụng của các ngân hàng trên toàn quốc';
        $data_res = [];
        $province = (new \yii\db\Query())->select('*')->from('province')->all();
        $all_company = (new \yii\db\Query())
            ->select('*')
            ->from('company')
            ->where('type = 1 and id not in (43,53,48,122,112,37,32,34,19,44,45,134,133,129,132,136,143)')
            ->all();
        $all_service = (new \yii\db\Query())
            ->select('*')
            ->from('service')
            ->all();
        //Dem so luong uu dai

        $count = (new \yii\db\Query())
            ->select('*')
            ->from('promotion')
            ->where("NOT list_service_id = ';;' ")
            ->count();

        //Dem so luong click xem them
        $max_click = ceil($count / 12) - 1;
        $data_res['max_click'] = $max_click;
        $arr_ser = [];
        $all_ser = (new \yii\db\Query())
            ->select('*')
            ->from('service')
            ->all();

        foreach ($all_ser as $item) {
            
            $arr_ser[] = [
                'id' => $item['id'],
                'title' => $item['title'],
                'count' => (new \yii\db\Query())->select('*')->from('promotion')->where('list_service_id like "%;' . $item['id'] . ';%"')->count(),
                'url' => '/diem-uu-dai/dich-vu/' . $this->actionSlug($item['title']) . '-' . $item['id'] . '.html',
            ];
        }

        $companies = (new \yii\db\Query())
            ->select('*')
            ->from('company')
            
            ->all();
        $arr_company = [];
        foreach ($companies as $item) {
            $arr_company[$item['id']] = $item['long_name'];
        }
        $arr_company_short = [];
        foreach ($companies as $item) {
            $arr_company_short[$item['id']] = $item['short_name'];
        }

        //Mac dinh 12 ban ghi
        $page_size = 12;
        if (!empty($_POST['page_size'])) {
            $page_size = $_POST['page_size'];
        }
        $all_promotion = (new \yii\db\Query())
            ->select('*')
            ->from('promotion')
            ->limit($page_size)
            ->orderBy('id desc')
            ->all();
        

        $query = (new \yii\db\Query())
            ->limit(100)
            ->select('*')->from('promotion');
        $sl_card = [];
        if (!empty($_GET['company'])) {
            $company_id = $_GET['company'];
            $query = $query->where('company_id = ' . $company_id);
            $company_id = $_GET['company'];
            $cards = (new \yii\db\Query())->select('*')->from('card')->where(['company_id' => $company_id])
            
            ->all();
            foreach ($cards as $item) {
                if($item['name'] ==''){
                    $item['name']= $item['short_name'];
                }
                $sl_card[] = [
                    'id' => $item['id'],
                    'short_name' => $item['name']
                ];
            }
        }
        if (!empty($_GET['service'])) {
            $service_id = $_GET['service'];
            $query = $query->andWhere('list_service_id like "%;' . $service_id . ';%"');
        }
        if (!empty($_GET['province'])) {
            $sprovince_id = $_GET['province'];
            $query = $query->andWhere('list_province_id like "%;' . $sprovince_id . ';%"');
        }
        if (!empty($_GET['card'])) {
           $query1 = "";
            for ($i=0; $i<count($_GET['card']); $i++) {
                if ($i == count($_GET['card']) - 1) {
                    $query1 = $query1 . 'list_card_id like "%;'. $_GET['card'][$i] . ';%"';
                }
                else{
                    $query1 = $query1 . 'list_card_id like "%;'. $_GET['card'][$i] . ';%" OR ' ;
                }

                
                
            }   
            
            $query = $query->andWhere($query1);
          
           
        }

        if (!empty($_GET)) {
            $count = $query->count();
            $max_click = ceil($count / 12) - 1;
            $data_res['max_click'] = $max_click;
            $all_promotion = $query->orderBy('id desc')->limit($page_size)->all();
        }

        $company_3 = (new \yii\db\Query())->select('*')->from('company')
            ->where('id in (5,50,51)')
            ->all();
        $arr_company_3 = [];
        foreach ($company_3 as $item) {
            $arr_company_3[] = [
                'id' => $item['id'],
                'name' => $item['short_name'],
                'url' => '/diem-uu-dai/ngan-hang/' . $this->actionSlug($item['short_name']) . '-' . $item['id'] . '.html',

            ];
        }
        
        $arr_all_pro = [];
        foreach ($all_promotion as $item) {
            if (strlen(str_replace(';', '', $item['img'])) == strlen($item['img'])) {
                $img = $item['img'];
            } else {
                $img = substr(
                    $item['img'],
                    1,
                    strpos($item['img'], ';', strpos($item['img'], ';', 0) + 1) - strpos($item['img'], ';', 0) - 1
                );
            }
            $star = '';
            if ($item['point_rating'] == 0) {
                $star = '<img src="/stores/images/promotion/sao.png" alt="">
                <img src="/stores/images/promotion/sao.png" alt="anh">
                <img src="/stores/images/promotion/sao.png" alt="anh">
                <img src="/stores/images/promotion/sao.png" alt="anh">
                <img src="/stores/images/promotion/sao.png" alt="anh">';
            } else if ($item['point_rating'] == 1) {
                $star = '<img src="/stores/images/promotion/saoden.png" alt="">
                <img src="/stores/images/promotion/sao.png" alt="anh">
                <img src="/stores/images/promotion/sao.png" alt="anh">
                <img src="/stores/images/promotion/sao.png" alt="anh">
                <img src="/stores/images/promotion/sao.png" alt="anh">';
            } else if ($item['point_rating'] == 2) {
                $star = '<img src="/stores/images/promotion/saoden.png" alt="">
                <img src="/stores/images/promotion/saoden.png" alt="anh">
                <img src="/stores/images/promotion/sao.png" alt="anh">
                <img src="/stores/images/promotion/sao.png" alt="anh">
                <img src="/stores/images/promotion/sao.png" alt="anh">';
            } else if ($item['point_rating'] == 3) {
                $star = '<img src="/stores/images/promotion/saoden.png" alt="">
                <img src="/stores/images/promotion/saoden.png" alt="anh">
                <img src="/stores/images/promotion/saoden.png" alt="anh">
                <img src="/stores/images/promotion/sao.png" alt="anh">
                <img src="/stores/images/promotion/sao.png" alt="anh">';
            } else if ($item['point_rating'] == 4) {
                $star = '<img src="/stores/images/promotion/saoden.png" alt="">
                <img src="/stores/images/promotion/saoden.png" alt="anh">
                <img src="/stores/images/promotion/saoden.png" alt="anh">
                <img src="/stores/images/promotion/saoden.png" alt="anh">
                <img src="/stores/images/promotion/sao.png" alt="anh">';
            } else if ($item['point_rating'] == 5) {
                $star = '<img src="/stores/images/promotion/saoden.png" alt="">
                <img src="/stores/images/promotion/saoden.png" alt="anh">
                <img src="/stores/images/promotion/saoden.png" alt="anh">
                <img src="/stores/images/promotion/saoden.png" alt="anh">
                <img src="/stores/images/promotion/saoden.png" alt="anh">';
            } else {
                $star = '';
            }
            $date_year = substr($item['start_date'],0,4);
            $date_month = substr($item['start_date'],5,2);
            $date_day = substr($item['start_date'],8,2);
            
            //han su dung
            
            $hsd="";
            $time_hien_tai = date('Y-m-d') ;
            $end_date = strtotime($item['end_date']) ;
            if(( intval($time_hien_tai)  - intval($end_date)  ) > 0  ){
                 $hsd="<span>Còn hạn</span>";
                
            }else{
               $hsd="<span>Hết hạn </span>";
            }

            
            $arr_all_pro[] = [
                'img' => 'https://thebank.vn/static/6/350/350/90/' . $img,
                'provider_name' => $this->limitWords($item['provider_name'], 5),
                'viewed' => $item['viewed'],
                'company_id' => $item['company_id'],
                'company_name' => isset($arr_company[$item['company_id']]) ? $arr_company[$item['company_id']] : '',
                'excerpt' => $this->limitWords($item['excerpt'], 4),
                'point_rating' => $item['point_rating'],
                'url' => '/diem-uu-dai/ngan-hang/' . $this->actionSlug($arr_company_short[$item['company_id']]) . '-' . $item['company_id'] . '.html',
                'star' => $star,
                'url_detail'=>'https://thebank.vn/diem-uu-dai/'. '-' . $this->actionSlug($item['provider_name']). '-'.$item['id'] .'.html',
                'start_date'=> $date_day  .'-' .$date_month . '-' . $date_year,
                'hsd'=> $hsd,
            ];
        }

        $data_res['arr_all_pro'] = $arr_all_pro;

        if (!empty($_POST)) {
            echo json_encode($data_res);
            exit;
        }

        if (!empty($_GET['card'])) {
            $count_card = count($_GET['card']); 
        } else {
            $count_card = 0;
        }
        
        return $this->render(
            'promotion',
            [
                'all_company' => $all_company,
                'province' => $province,
                'arr_all_pro' => $arr_all_pro,
                'arr_company' => $arr_company,
                'count' => $count,
                'arr_ser' => $arr_ser,
                'all_service' => $all_service,
                'sl_card'   => $sl_card,
                'company_3' => $company_3,
                'arr_company_3' => $arr_company_3,
                'max_click' => $max_click,
                'count_card'=>$count_card,
            ]
        );
    }

    /**
     *
     * Trang danh sach nha cung cap - Code by Nguyen Duc Anh
     *
     * @param
     * @return
     *
     */

    public function actionSupplier(){
        $all_service = (new \yii\db\Query())
            ->select('*')
            ->from('service')
            ->all();
            $province = (new \yii\db\Query())->select('*')->from('province')->all();
            // nha cung cap 
            $provider = (new \yii\db\Query())->select('*')->from('provider')->limit(15)->all();
           
            $count = (new \yii\db\Query())
            ->select('*')
            ->from('provider')
            ->count();
           $query = (new \yii\db\Query())->select('*')->from('provider')->limit(15);
           if(!empty($_GET['service'])){
            $service_id = $_GET['service'];
                $query = $query->andWhere('list_service like "%;' . $service_id . ';%"');
           }
           if(!empty($_GET['province'])){
            $province_id = $_GET['province'];
                $query = $query->andWhere('list_province like "%;' . $province_id . ';%" OR list_province like "%-1%"')
                
                ;
           }
        if(!empty($_GET)){
            $provider= $query->orderBy('id desc')->all();
            $count = count($provider);
        }
        
            $arr_all_provider = [];
            foreach ($provider as $item) {
               
                $arr_all_provider[] = [
                    'avatar' => 'https://thebank.vn/static/6/350/350/90/' . $item['avatar'],
                    'name' => $this->limitWords($item['name'], 5),
                    'total_promotion'=> $item['total_promotion'],
                    'viewed' => $item['viewed'],
                    'url_detail' => 'https://thebank.vn/diem-uu-dai/nha-cung-cap/'. '-' . $this->actionSlug($item['name']). '-'.$item['id'] .'.html',
                    
                 
                ];
            }
            $all_promotion = (new \yii\db\Query())
            ->select('*')
            ->from('promotion')
            ->limit(10)
            ->orderBy('end_date desc')
            ->where('amount is not null')
            ->all();
           
            $arr_all_pro = [];
            foreach ($all_promotion as $item) {
                if (strlen(str_replace(';', '', $item['img'])) == strlen($item['img'])) {
                    $img = $item['img'];
                } else {
                    $img = substr(
                        $item['img'],
                        1,
                        strpos($item['img'], ';', strpos($item['img'], ';', 0) + 1) - strpos($item['img'], ';', 0) - 1
                    );
                }

                $amount = '';

                if($item['amount'] < 1){
                    $amount = $item['amount'] * 100;
                }else{
                    $amount = $item['amount'];
                }
              
                $arr_all_pro[] = [
                  
                    'provider_name' => $this->limitWords($item['provider_name'], 2),
                    'viewed' => $item['viewed'],
                    'company_id' => $item['company_id'],
                    'company_name' => isset($arr_company[$item['company_id']]) ? $arr_company[$item['company_id']] : '',
                    'excerpt' => $this->limitWords($item['excerpt'], 4),
                    'point_rating' => $item['point_rating'],
                    'amount' =>$amount,
                    'url_detail'=>'https://thebank.vn/diem-uu-dai/'. '-' . $this->actionSlug($item['provider_name']). '-'.$item['id'] .'.html',
                    'img'=> 'https://thebank.vn/static/6/350/350/90/' . $img,
                ];
                
            }
        return $this->render(
            'supplier',
            [
                'province'=>$province,
                'all_service'=>  $all_service,
                'arr_all_provider'=>$arr_all_provider,
                'count'=>$count,
                'arr_all_pro'=>$arr_all_pro,

            ]

        );
    }

    public static function limitWords($string, $maxOut)
    {
        if ($string == '')
            return '';
        $string2Array = explode(' ', $string, ($maxOut + 1));

        if (count($string2Array) > $maxOut) {
            array_pop($string2Array);
            $output = implode(' ', $string2Array) . ' ...';
        } else {
            $output = $string;
        }

        return $output;
    }
    public function actionCardByCompanyId()
    {
        if (!empty($_POST)) {
            $company_id = $_POST['company_id'];
            $cards = (new \yii\db\Query())->select('*')->from('card')->where(['company_id' => $company_id])
            // ->andWhere('card_type_id = 6')
            ->all();
            $list_company = [];
            foreach ($cards as $item) {
                if($item['name'] ==''){
                    $item['name']= $item['short_name'];
                }
                $list_company[$item['id']] = $item['name'];
            }
            echo json_encode($list_company);
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
}
