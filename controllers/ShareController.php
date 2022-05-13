<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;

class ShareController extends Controller
{
    //trang chuyen gia tai chinh
    public function actionGetdistrict()
    {
        $sql = (new \yii\db\Query());
        if(isset($_POST['province'])) {
            $province = $_POST['province'];
            $list_district = $sql->select(['id','district_name'])->from('district')->where(['province_id' => $province])->all();
            echo json_encode($list_district);
            exit;
        }
    }
	public function actiongetdbmongo($return_connection = false)
	{
		$db 	= 'thebank_db';
		$mongo	= new MongoClient('mongodb://doantrong:123Qwe!@#@122.248.226.29:27017/' . $db,array("socketTimeoutMS" => "120000"));
		if(!$return_connection)
			return $mongo->$db;
		else
			return array('db' => $mongo->$db,'connection'=>$mongo);
	}    
    public function Slug($alias_url)
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
