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

class QaCategoryController extends Controller
{
    public function actionTest() {
        $model = new QaCategory();
        $model_qa_category	= $model->getListCategory();
        // $model = QaCategory::find()->where(['id' => '2'])->one();

        // echo '<pre>';
        // print_r($model_qa_category);
        // echo '</pre>';
        // die;
    }
}
