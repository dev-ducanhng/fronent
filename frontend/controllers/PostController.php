<?php

namespace frontend\controllers;

use common\models\Dangkytuvan;
use frontend\models\Post;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\db\Query;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }
    /**
     * Lists all Post models.
     *
     * @return string
     */
    public function actionIndex()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => Post::find(),
        ]);
        if (isset($_GET['keyw'])) {
        //    var_dump();die;
           $posts = Post::find()->where(['like', 'post_title', '%'.$_GET['keyw'].'%',false])
           ->orWhere(['like', 'name', '%'.$_GET['keyw'].'%',false])
           ->all();
        } else {
            $posts = Post::find()->all();
        }
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'posts' => $posts,
        ]);
    }
    /**
     * Displays a single Post model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {   
        
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
        
    }
    

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */

    public function actionUploadFileAuthor()
    { 
        if(!empty($_FILES['file']))
        {
            $year = date('Y');
            $month = date('m');
            $day = date('d');
            // Create directory if it does not exist
            if(!is_dir("uploads/imageauthor/". $year ."/")) {
                mkdir("uploads/imageauthor/". $year ."/");
            }
            if(!is_dir("uploads/imageauthor/". $year ."/" . $month . "/")) {
                mkdir("uploads/imageauthor/". $year ."/" . $month . "/");
            }
            if(!is_dir("uploads/imageauthor/". $year ."/" . $month . "/" . $day . "/")) {
                mkdir("uploads/imageauthor/". $year ."/" . $month . "/" . $day . "/");
            }
            $temp = explode(".", $_FILES["file"]["name"]);
            $newfilename = date('H-i-s-') . rand() . '.' . end($temp);
            // Move the uploaded file
            move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/imageauthor/". $year ."/" . $month . "/" . $day ."/". $newfilename);
            echo 'success';
            exit;
        }
    }
    public function actionCreate()
    {
        $model = new Post();
        // var_dump(!empty($_FILES['file']));die;

        if(!empty($_POST)) {
            // $model->post_author = $_POST['introduce_author'];
            $model->post_title = $_POST['title_post'];
            $model->post_content = $_POST['content_post'];
            $model->post_excerpt = $_POST['post_description'];
            // $model->avatar = $filenameAvatar;
            // var_dump($model);die;    
            $model->save();
        } 

        Yii::$app->params['og_description']['content'] = 'Bài viết';
        $this->view->title = "Đăng kí bài viết";
        return $this->render('createPost', [
            'model' => $model,
        ]);
               
  
    }
 


    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
  
}