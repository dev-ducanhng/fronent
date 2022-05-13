<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'enableCsrfValidation'=>false,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,      
            'class' => 'yii\web\UrlManager',      
            'rules' => [
                'cong-cu/tinh-lai-tien-gui-tiet-kiem.html'=>'tool/savings-rate',
                'cong-cu/internet-banking.html' => 'tool/internet-banking',
                'tro-giup.html' => 'tool/trung-tam-tro-giup',
                've-chung-toi.html' => 'guide/about-us',
                'dang-ky-viet-bai.html' => 'post/create',
                'hoi-dap-faq/<category_id:\d+>-<slug:[-a-zA-Z 0-9]+>/<type:(pho-bien|everything|cau-hoi-cua-toi|chua-co-tra-loi)>.html' => 'qacenter/qacenter',
                'hoi-dap-faq/<category_id:\d+>-<slug:[-a-zA-Z 0-9]+>.html' => 'qacenter/qacenter',
                'hoi-dap-faq/<type:(pho-bien|everything|cau-hoi-cua-toi|chua-co-tra-loi)>.html'	=> 'qacenter/qacenter',
                'hoi-dap-faq.html' => 'qacenter/qacenter',
                'bao-chi-va-truyen-thong.html' => 'media/media',
                'co-hoi-hop-tac-kinh-doanh.html' => 'cooperate/index',

                'chuyen-gia-tai-chinh/tu-van-<service:.*?>/to-chuc-<company:.*?>-tai-<district:.*?>-tinh-<province:.*?>.html' => 'buyer/index-supplier',
                'chuyen-gia-tai-chinh/tu-van-<service:.*?>/to-chuc-<company:.*?>-tinh-<province:.*?>.html' => 'buyer/index-supplier',
                'chuyen-gia-tai-chinh/tu-van-<service:.*?>/to-chuc-<company:.*?>-thanh-pho-<province:.*?>.html' => 'buyer/index-supplier',
                'chuyen-gia-tai-chinh/to-chuc-<company:.*?>-tinh-<province:.*?>.html' => 'buyer/index-supplier',
                'chuyen-gia-tai-chinh/to-chuc-<company:.*?>-thanh-pho-<province:.*?>.html' => 'buyer/index-supplier',
                'chuyen-gia-tai-chinh/tu-van-<service:.*?>/to-chuc-<company:.*?>.html' => 'buyer/index-supplier',
                'chuyen-gia-tai-chinh/to-chuc-<company:.*?>.html' => 'buyer/index-supplier',
                'chuyen-gia-tai-chinh/tu-van-<service:.*?>.html' => 'buyer/index-supplier',
                'chuyen-gia-tai-chinh.html' => 'buyer/index-supplier',  
                'cong-cu.html' => 'tool/tool',  
                'danh-ba-ngan-hang.html' => 'tool/subdomain-insurance',  
                'cong-cu/uoc-tinh-so-tien-co-the-vay.html' => 'tool/loan-estimate',  
                'cong-cu/tim-chi-nhanh-cong-ty-bao-hiem/<slug_company:[-a-zA-Z 0-9]+>-<slug_district:[-a-zA-Z 0-9]+>-<slug_province:[-a-zA-Z 0-9]+>-<company:\d+>-<province:\d+>-<district:\d+>.html' => 'tool/find-insurance',
                'cong-cu/tim-chi-nhanh-cong-ty-bao-hiem/<slug_company:[-a-zA-Z 0-9]+>-<slug_province:[-a-zA-Z 0-9]+>-<company:\d+>-<province:\d+>.html' => 'tool/find-insurance',
                'cong-cu/tim-chi-nhanh-cong-ty-bao-hiem/<slug_company:[-a-zA-Z 0-9]+>-<company:\d+>.html' => 'tool/find-insurance',
                'cong-cu/tim-chi-nhanh-cong-ty-bao-hiem.html' => 'tool/find-insurance',
                'danh-sach-cong-ty-bao-hiem.html' => 'insurance/list-insurance',
                'cong-cu/uoc-tinh-so-tien-vay-phai-tra-hang-thang.html' => 'tool/estimate',
                'chung-chi-quy.html' => 'fundcertificates/index',
                'cong-cu/tim-atm/<slug_company:[-a-zA-Z 0-9]+>-<slug_district:[-a-zA-Z 0-9]+>-<slug_province:[-a-zA-Z 0-9]+>-<company:\d+>-<province:\d+>-<district:\d+>.html' => 'tool/find-atm',
                'cong-cu/tim-atm/<slug_company:[-a-zA-Z 0-9]+>-<slug_province:[-a-zA-Z 0-9]+>-<company:\d+>-<province:\d+>.html' => 'tool/find-atm',
                'cong-cu/tim-atm/<slug_company:[-a-zA-Z 0-9]+>-<company:\d+>.html' => 'tool/find-atm',
                'cong-cu/tim-atm.html' => 'tool/find-atm',  
                'cong-cu/diem-uu-dai.html' => 'promotion/promotion',
                'diem-uu-dai/ngan-hang/<slug_company:[-a-zA-Z 0-9]+>-<company:\d+>.html' => 'promotion/promotion',
                'diem-uu-dai/dich-vu/<slug_service:[-a-zA-Z 0-9]+>-<service:\d+>.html' => 'promotion/promotion',
                'cong-cu/tim-chi-nhanh-ngan-hang/<slug_company:[-a-zA-Z 0-9]+>-<slug_district:[-a-zA-Z 0-9]+>-<slug_province:[-a-zA-Z 0-9]+>-<company:\d+>-<province:\d+>-<district:\d+>.html' => 'tool/find-bank',
                'cong-cu/tim-chi-nhanh-ngan-hang/<slug_company:[-a-zA-Z 0-9]+>-<slug_province:[-a-zA-Z 0-9]+>-<company:\d+>-<province:\d+>.html' => 'tool/find-bank',
                'cong-cu/tim-chi-nhanh-ngan-hang/<slug_company:[-a-zA-Z 0-9]+>-<company:\d+>.html' => 'tool/find-bank',
                'cong-cu/tim-chi-nhanh-ngan-hang.html' => 'tool/find-bank',
            ],
                
        ],
    ],
    'params' => $params,
];
