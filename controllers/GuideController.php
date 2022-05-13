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

class GuideController extends Controller
{
    public function actionAboutUs()
    {
      Yii::$app->params['og_description']['content'] = 'Về chúng tôi';
      $this->view->title = "Về chúng tôi";
      $curl = curl_init();
  
      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://thebank.vn/api/api/countUser',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
          'Cookie: PHPSESSID=if2fbk343gms38deq1k2daiqr6'
        ), 
      ));
  
      $response = curl_exec($curl);
      //  var_dump($response);die;
       
      $count_supplier = substr($response,
                  strpos($response, ':') + 1,
                  strpos($response, ',') - 1 - strpos($response, ':'));
  
      $count_customer = substr($response,
                  strpos($response, ':', strpos($response, ':')+1) + 1,
                  strpos($response, '}', strpos($response, ':')) - 1 - strpos($response, ':', strpos($response, ':') + 1));
      curl_close($curl);
  
      return $this->render('about-us'
      , [
        'response' => $response,
        'count_supplier'=>$count_supplier,
        'count_customer'=>$count_customer
      ]);
    }
}
