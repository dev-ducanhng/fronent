<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
// use frontend\assets\AppAsset;
// use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
// use yii\bootstrap4\Nav;
// use yii\bootstrap4\NavBar;

$controller = Yii::$app->controller->action->id;
$arr_layout_old = ['trung-tam-tro-giup', 'savings-rate','internet-banking'];
// AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="robots" content="noindex,nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php //$this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php 
    $this->head();
    $this->registerMetaTag(Yii::$app->params['og_title'], 'og_title');                                                                                                            
    $this->registerMetaTag(Yii::$app->params['og_description'], 'og_description');
    $this->registerMetaTag(Yii::$app->params['og_url'], 'og_url');
    $this->registerMetaTag(Yii::$app->params['og_image'], 'og_image');
    $full_url = 'https://thebank.vn/' . Yii::$app->request->url;
    ?>
        <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "FinancialService",
            "name": "TheBank",
            "image": "https://thebank.vn/themes/pcmembership/images/tb-logo.png",
            "@id": "TheBank",
            "url": "https://thebank.vn/",
            "telephone": "02473076688",
            "priceRange": "1$-10000$",
            "address": {
            "@type": "PostalAddress",
            "streetAddress": "Tầng 9, Tòa Licogi13 - 164 Khuất Duy Tiến, Thanh Xuân, Hà Nội",
            "addressLocality": "Hà Nội",
            "postalCode": "100000",
            "addressCountry": "VN"
            },
            "geo": {
            "@type": "GeoCoordinates",
            "latitude": 20.999209,
            "longitude": 105.798168
        },
            "openingHoursSpecification": [{
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": [
            "Monday",
            "Tuesday",
            "Wednesday",
            "Thursday",
            "Friday"
            ],
            "opens": "08:00",
            "closes": "17:30"
        },{
        "@type": "OpeningHoursSpecification",
        "dayOfWeek": "Saturday",
        "opens": "08:00",
        "closes": "12:00"
        }],
        "sameAs": [
        "https://www.facebook.com/thebank.vn/",
        "https://www.facebook.com/chuyengiataichinh.thebank/",
        "https://www.facebook.com/thebank.diemuudaithe/",
        "https://www.facebook.com/DauTuTaiChinh.TheBank/",
        "https://www.facebook.com/thebank.vn/",
        "https://twitter.com/thebankvn",
        "https://thebankvn.tumblr.com/",
        "https://www.youtube.com/channel/UC7r_h2DkyCWXsKPtKFwlNgg",
        "https://dantri.com.vn/suc-manh-so/vong-rot-von-dau-tien-dua-thebankvn-vao-be-phong-trong-cuoc-choi-fintech-tai-vn-20190128163445970.htm",
        "https://theleader.vn/thebankvn-vao-be-phong-trong-cuoc-choi-fintech-tai-viet-nam-1548662629718.htm",
        "https://forbesvietnam.com.vn/tin-cap-nhat/cyberagent-capital-rot-von-vao-fintech-so-sanh-tai-chinh-thebank-5259.html",
        "https://vi.gravatar.com/thebankvnn",
        "https://www.pinterest.com/thebankvnn/",
        "https://www.behance.net/thebankvn"
        ]
        }
    </script>
    <script type="application/ld+json">{
        "@context": "http://schema.org",
        "@type": "Person",
        "name": "Nguyễn Thành Đạt",
        "jobTitle": "CEO",
        "image" : "https://scontent.fhan4-1.fna.fbcdn.net/v/t1.0-9/18301428_1704029436275621_5954941032557844446_n.jpg?_nc_cat=105&_nc_ht=scontent.fhan4-1.fna&oh=0e1a12832cc8e81c56eaa1c2a0665879&oe=5D5D8429",
        "worksFor" : "TheBank",
        "url": "https://thebank.vn/",
        "sameAs":["https://dantri.com.vn/suc-manh-so/vong-rot-von-dau-tien-dua-thebankvn-vao-be-phong-trong-cuoc-choi-fintech-tai-vn-20190128163445970.htm",
        "http://thoibaonganhang.vn/preview_article/t/co-hoi-trai-nghiem-dich-vu-tai-chinh-ngan-hang-online-56355.html" ],
        "AlumniOf" : [ "AIT School of Management",
        "Trường Đại Học Ngoại Ngữ, Đại Học Quốc Gia Hà Nội",
        "ĐẠI HỌC BÁCH KHOA HÀ NỘI - HANOI UNIVERSITY OF SCIENCE AND TECHNOLOGY"],
        "address": {
        "@type": "PostalAddress",
        "addressLocality": "Hà Nội",
        "addressRegion": "Việt Nam"
        }}
    </script>
    <script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "Corporation",
            "name": "TheBank",
            "url": "https://thebank.vn/",
            "logo": "https://thebank.vn/themes/pcmembership/images/tb-logo.png",
            "contactPoint": [{
            "@type": "ContactPoint",
            "telephone": "+84 (024 7307 6688)",
            "contactType": "customer service",
            "contactOption": "TollFree",
            "areaServed": "VN",
            "availableLanguage": "Vietnamese"
        },{
        "@type": "ContactPoint",
        "telephone": "+84 (1900 636 232)",
        "contactType": "sales",
        "contactOption": "TollFree",
        "areaServed": "VN",
        "availableLanguage": "Vietnamese"
        }],
        "sameAs": [
        "https://www.facebook.com/thebank.vn/",
        "https://twitter.com/thebankvn",
        "https://www.youtube.com/channel/UC7r_h2DkyCWXsKPtKFwlNgg",
        "https://dantri.com.vn/suc-manh-so/vong-rot-von-dau-tien-dua-thebankvn-vao-be-phong-trong-cuoc-choi-fintech-tai-vn-20190128163445970.htm",
        "https://theleader.vn/thebankvn-vao-be-phong-trong-cuoc-choi-fintech-tai-viet-nam-1548662629718.htm",
        "https://forbesvietnam.com.vn/tin-cap-nhat/cyberagent-capital-rot-von-vao-fintech-so-sanh-tai-chinh-thebank-5259.html"
        ]
        }
    </script>    
    
    <link rel="canonical" href="<?= $full_url ?>" />

    <link rel="icon" type="image/png" href="https://thebank.vn/images/favicon.png" sizes="32x32">
    <link rel="stylesheet" type="text/css" href="/stores/css/bootstrap.min.css">

    <?php /*    <!-- qc ads  -->
    <script data-ad-client="ca-pub-2123385994742012" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

    <!-- quảng cáo netlink -->
    <script async src="https://securepubads.g.doubleclick.net/tag/js/gpt.js"></script>
    <script>
    window.googletag = window.googletag || {cmd: []};
    googletag.cmd.push(function() {
      googletag.defineSlot('/93656639,22556588427/thebank.vn/thebank_header_PC', [970, 120], 'div-gpt-ad-1632884657151-0').addService(googletag.pubads());
      googletag.defineSlot('/93656639,22556588427/thebank.vn/thebank_sidebar_PC', [300, 600], 'div-gpt-ad-1632884829132-0').addService(googletag.pubads());
          googletag.defineSlot('/93656639,22556588427/thebank.vn/thebank_mid_PC', [950, 120], 'div-gpt-ad-1632884707370-0').addService(googletag.pubads());
          googletag.defineSlot('/93656639,22556588427/thebank.vn/thebank_post_PC', [950, 120], 'div-gpt-ad-1632884765323-0').addService(googletag.pubads());
          googletag.defineSlot('/93656639,22556588427/thebank.vn/thebank_sapo_PC', [950, 120], 'div-gpt-ad-1632884794091-0').addService(googletag.pubads());
          googletag.pubads().enableSingleRequest();
      googletag.enableServices();
    });
  </script>    
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>*/ ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<!-- check layout step 1 -->
<?php if(in_array($controller, $arr_layout_old)) : ?> 
    <?= $this->render('header_old'); ?>
<?php else : ?>
    <?= $this->render('header'); ?>
<?php endif; ?>

<main role="main" class="flex-shrink-0 main_page">

    <!-- check layout step 1 -->
    <?php if(in_array($controller, $arr_layout_old)) : ?> 
        <?php /*<?= $this->render('sidebar_supplier'); ?>*/ ?>
        <?= $this->render('sidebar_default_old'); ?>
    <?php else : ?>
        <?= $this->render('sidebar_default'); ?>
    <?php endif; ?>

    
    <!-- <div class="container"> -->
        <?= $content ?>
    <!-- </div> -->
</main>

<!-- check layout step 1 -->
<?php if(in_array($controller, $arr_layout_old)) : ?> 
    <?= $this->render('footer_old'); ?>
<?php else : ?>
    <?= $this->render('footer'); ?>
<?php endif; ?>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
