<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\District;

class InsuranceController extends Controller
{
    public function actionListInsurance()
    {
        Yii::$app->params['og_description']['content'] = 'Danh sách các công ty bảo hiểm Việt Nam';
        $this->view->title = "Danh sách các công ty bảo hiểm Việt Nam";

        
            $list_insurance = (new \yii\db\Query())
            ->select('*')
            ->from('company')
            ->where('type = 2 and is_show = 1 and id in (112,107,79,88,77,94,78,96,80,97,110,111,74,66,124,95,126,106,101,103,67,69,148,89,90,61,64,65,72,73,75,91,100,105,76) ')
            
            ->all();
        $data = [];
        foreach ($list_insurance as $item) {
            $url = 'https://thebank.vn/cong-ty-bao-hiem-' . $this->actionSlug(isset($item['short_name']) ? $item['short_name'] : '') . '-' . $item['id'] . '.html';
            $data[$item['id']] = [
                'name' => $item['short_name'],
                'url' => $url
            ];
        }
        $array_id_company=[112,107,79,88,77,94,78,96,80,97,110,111,74,66,124,95,126,106,101,103,67,69,148,89,90,61,64,65,72,73,75,91,100,105,76];
        $data2 = [];
        foreach($array_id_company  as $item){
            $data2[] = $data[$item];
        }
        
        
        $max_click = ceil(count($list_insurance)/20) - 1;
       
        
        return $this->render('list-insurance', [
            
            'max_click'=> $max_click,
            'data2' => $data2,
            
        ]);
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
