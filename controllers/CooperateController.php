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

class CooperateController extends Controller
{
  
  public function actionIndex(){
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
     
    $count_customer = substr($response,
                  strpos($response, ':', strpos($response, ':')+1) + 1,
                  strpos($response, '}', strpos($response, ':')) - 1 - strpos($response, ':', strpos($response, ':') + 1));
      curl_close($curl);
      $this->view->title = "TheBank - Cơ hội hợp tác và kinh doanh";
    return $this->render('cooperate',[
      'count_customer'=>$count_customer
      
    ]);
  }
}
