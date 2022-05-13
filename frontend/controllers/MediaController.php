<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\db\Query;

/**
 * Tool controller
 */

class MediaController extends Controller
{
    public function actionMedia() {
        $this->view->title = "Báo chí và truyền thông nói về TheBank";
        Yii::$app->params['og_description']['content'] = 'Báo chí và truyền thông.';
        return $this->render('media');
    }
   
}