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
use frontend\models\QaCategory;
use frontend\models\QaQuestion;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\db\Expression;
use yii\helpers\Url ;


/**
 * Tool controller
 */

class QacenterController extends Controller
{
    public function actionExample()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';

        echo "<pre>";
        print_r(Yii::$app->getRequest()->getUserIP());
        echo "</pre>";
        die;
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

    public function actionQacenter($type = null, $category_id = null, $search = null, $slug = '')
    {
        Yii::$app->params['og_description']['content'] = 'TheBank - Trung tâm hỏi đáp';
        $this->view->title = "TheBank - Trung tâm hỏi đáp";
        $current_url = Url::to(['qacenter/qacenter']);

        $active_default = '';
        $active_pb = '';
        $active_notans = '';
        if($type == 'pho-bien' || $type == 'chua-co-tra-loi'){
            if($type == 'pho-bien')
                $active_pb = 'active';
            else
                $active_notans = 'active';
        }else{
            $active_default = 'active';
        }
        $model = new QaQuestion();
        if ($this->request->isPost && !empty($this->request->post('question')) && !empty($this->request->post('category_id'))) {
            $model->question = $this->request->post('question');

            // if (!Yii::$app->user->isGuest) {
            //     $model->user_id = Yii::$app->user->identity->id;
            //     $model->user_name = Yii::$app->user->identity->display_name;
            // }
            $model->user_id = 0;
            $model->user_name = 'thebank_v2';

            $model->date_create = new Expression('NOW()');
            $model->category_id = $this->request->post('category_id');
            $model->status = 2;
            $model->ip = Yii::$app->getRequest()->getUserIP();
            $model->is_faq = 0;

            $model->save(false);
        }

        $qa_category = QaCategory::find()->all();
        $qa_category_2 = QaCategory::getListCategory();
        $arr_cate = [];
        foreach($qa_category_2 as $val) {
            $arr_cate[$val['id']] = $val['name'];
        }

        $page_size = 10;

        $total_question = count(QaQuestion::find()->where('status = 1 and is_faq = 0 and user_id > 0')->all());
        $total_page = ceil($total_question / $page_size);

        $total_question_popular = count(QaQuestion::find()->where('status = 1 and is_faq = 0 and user_id > 0')->all());
        $total_page_popular = ceil($total_question_popular / $page_size);

        $total_question_not_answer = count(QaQuestion::find()->where('status = 1 and is_faq = 0 and user_id > 0 and nums_user_answer = 0')->all());
        $total_page_not_answer = ceil($total_question_not_answer / $page_size);

        $lq_newest = (new \yii\db\Query())
            ->select(['*'])
            ->from('qa_question')
            ->where('status = 1 and is_faq = 0 and user_id > 0')
            ->orderBy('date_create DESC')
            ->limit($page_size)
            ->all();

        $count_newest = count((new \yii\db\Query())->select('*')->from('qa_question')->where('status = 1 and is_faq = 0 and user_id > 0')->all());

        $lq_popular = (new \yii\db\Query())
            ->select(['*'])
            ->from('qa_question')
            ->where('status = 1 and is_faq = 0 and user_id > 0')
            ->orderBy('nums_user_answer DESC')
            ->limit($page_size)
            ->all();

        $count_popular = count((new \yii\db\Query())->select('*')->from('qa_question')->where('status = 1 and is_faq = 0 and user_id > 0')->all());

        $lq_not_answer = (new \yii\db\Query())
            ->select(['*'])
            ->from('qa_question')
            ->where('status = 1 and is_faq = 0 and user_id > 0 and nums_user_answer = 0')
            ->orderBy('date_create DESC')
            ->limit($page_size)
            ->all();
    
        $count_not_answer = count((new \yii\db\Query())->select('*')->from('qa_question')->where('status = 1 and is_faq = 0 and user_id > 0 and nums_user_answer = 0')->all());

        $data_res = [];

        $lq_newest_query = (new \yii\db\Query())
            ->select(['*'])
            ->from('qa_question')
            ->where('status = 1 and is_faq = 0 and user_id > 0');

        $lq_popular_query = (new \yii\db\Query())
            ->select(['*'])
            ->from('qa_question')
            ->where('status = 1 and is_faq = 0 and user_id > 0')
            ->orderBy('nums_user_answer DESC');

        $lq_not_answer_query = (new \yii\db\Query())
            ->select(['*'])
            ->from('qa_question')
            ->where('status = 1 and is_faq = 0 and user_id > 0 and nums_user_answer = 0');
        if (!empty($_GET['q'])) {
            $key = $_GET['q'];
            $total_data_search = QaQuestion::find()->where('status = 1 and is_faq = 0 and user_id > 0 and question like ' . '"' . '%' . $key . '%' . '"')->limit(10)->all();
            $arr_data = [];
            foreach ($total_data_search as $val) {
                $name_category = QaCategory::find()->where('id = ' . $val['category_id'])->one();
                if (!empty($name_category)) {
                    $arr_data[] = [
                        'url'   => 'https://thebank.vn/hoi-dap-faq/' . $val['category_id'] . '-' . $this->actionSlug($name_category->name) . '/' . $val['id'] . '-' .  $this->actionSlug($val['question']) .  '.html',
                        'label' => str_replace($_GET['q'], '<strong style="color: blue">' . $_GET['q'] . '</strong>', $val['question']),
                    ];
                }
            }
            echo json_encode($arr_data);
            exit;
        }
        if (!empty($_GET['search-qa'])) {
            $keyword = $_GET['search-qa'];
            $keyword = trim($keyword);
            $lq_newest_query = $lq_newest_query->andWhere('question like "%' . $keyword . '%"');
            $lq_popular_query = $lq_popular_query->andWhere('question like "%' . $keyword . '%"');
            $lq_not_answer_query = $lq_not_answer_query->andWhere('question like "%' . $keyword . '%"');

            $total_question = count($lq_newest_query->all());
            $total_page = ceil($total_question / $page_size);
            $total_question_popular = count($lq_popular_query->all());
            $total_page_popular = ceil($total_question_popular / $page_size);
            $total_question_not_answer = count($lq_not_answer_query->all());
            $total_page_not_answer = ceil($total_question_not_answer / $page_size);

            $count_newest = $total_question;
            $count_popular = $total_question_popular;
            $count_not_answer = $total_question_not_answer;
        }

        if (!empty($_GET['category_id'])) {
            $category_id = $_GET['category_id'];
            $lq_newest_query = $lq_newest_query->andWhere('category_id = ' . $_GET['category_id']);
            $lq_popular_query = $lq_popular_query->andWhere('category_id = ' . $_GET['category_id']);
            $lq_not_answer_query = $lq_not_answer_query->andWhere('category_id = ' . $_GET['category_id']);
            $current_url = Url::to(['qacenter/qacenter', 'category_id' => $category_id, 'slug' => $_GET['slug']]);
        }

        $current_url = str_replace('.html', '', $current_url);

        if (!empty($_POST)) {
            if (!empty($_POST['search_key'])) {
                $lq_newest_query = $lq_newest_query->andWhere('question like "%' . str_replace('+', ' ', $_POST['search_key']) . '%"');
                $lq_popular_query = $lq_popular_query->andWhere('question like "%' . str_replace('+', ' ', $_POST['search_key']) . '%"');
                $lq_not_answer_query = $lq_not_answer_query->andWhere('question like "%' . str_replace('+', ' ', $_POST['search_key']) . '%"');
            }
            
            if (!empty($_POST['page'])) {
                $page = $_POST['page'];
                $page_current = $page - 1;
                $offset = ($page - 1) * 10;
            }
            if (!empty($_POST['category_id'])) {
                $lq_newest_query = $lq_newest_query->andWhere('category_id = ' . $_POST['category_id']);
                $lq_popular_query = $lq_popular_query->andWhere('category_id = ' . $_POST['category_id']);
                $lq_not_answer_query = $lq_not_answer_query->andWhere('category_id = ' . $_POST['category_id']);
            }
            if (!empty($_POST['page_size'])) {
                $page_size = $_POST['page_size'];
            }
        }

        $total_question = count($lq_newest_query->all());
        $total_page = ceil($total_question / $page_size);
        $total_question_popular = count($lq_popular_query->all());
        $total_page_popular = ceil($total_question_popular / $page_size);
        $total_question_not_answer = count($lq_not_answer_query->all());
        $total_page_not_answer = ceil($total_question_not_answer / $page_size);

        $cacul_page = $this->caculpage($total_question, 0, $page_size, $total_page);
        $data_res['cacul_page'] = $cacul_page;

        $cacul_page_popular = $this->caculpage($total_question_popular, 0, $page_size, $total_page_popular);
        $data_res['cacul_page_popular'] = $cacul_page_popular;

        $cacul_page_not_answer = $this->caculpage($total_question_not_answer, 0, $page_size, $total_page_not_answer);
        $data_res['cacul_page_not_answer'] = $cacul_page_not_answer;

        if (!empty($_POST['page'])) {
            $lq_newest_query->offset($offset);
            $lq_popular_query->offset($offset);
            $lq_not_answer_query->offset($offset);

            $cacul_page = $this->caculpage($total_question, $page_current, $page_size, $total_page);
            $data_res['cacul_page'] = $cacul_page;

            $cacul_page_popular = $this->caculpage($total_question_popular, $page_current, $page_size, $total_page_popular);
            $data_res['cacul_page_popular'] = $cacul_page_popular;

            $cacul_page_not_answer = $this->caculpage($total_question_not_answer, $page_current, $page_size, $total_page_not_answer);
            $data_res['cacul_page_not_answer'] = $cacul_page_not_answer;
        }
     
        $lq_newest = $lq_newest_query->orderBy('date_create DESC')->limit($page_size)->all();
        $lq_popular = $lq_popular_query->limit($page_size)->all();
        $lq_not_answer = $lq_not_answer_query->orderBy('date_create DESC')->limit($page_size)->all();
 
        $data_lq_newest = [];
        foreach($lq_newest as $val) {
            $url = Url::to(['qacenter/qacenter', 'category_id' => $val['category_id'], 'slug' => $this->actionSlug(isset($arr_cate[$val['category_id']]) ? $arr_cate[$val['category_id']] : '')]);
            $url_question = 'https://thebank.vn/hoi-dap-faq/' . $val['category_id'] . '-' . $this->actionSlug(isset($arr_cate[$val['category_id']]) ? $arr_cate[$val['category_id']] : '') . '/' . $val['id'] . '-' . $this->actionSlug($val['question']) . '.html';
            $data_lq_newest[] = [
                'id'                => $val['id'],
                'question'          => $val['question'],
                'user_id'           => $val['user_id'],
                'user_name'         => $val['user_name'],
                'date_create'        => $val['date_create'],
                'category_id'        => $val['category_id'],
                'nums_user_answer'  => $val['nums_user_answer'],
                'status'            => $val['status'],
                'description'        => $val['description'],
                'user_interest'        => $val['user_interest'],
                'is_faq'            => $val['is_faq'],
                'viewed'            => $val['viewed'],
                'status_syun_elastic'  => $val['status_syun_elastic'],
                'viewed'            => $val['viewed'],
                'category_name'            => isset($arr_cate[$val['category_id']]) ? $arr_cate[$val['category_id']] : '',
                'href'              => $url,
                'url_question'      => $url_question,
            ];
        }
        $data_res['lq_newest'] = $data_lq_newest;
        // echo '<pre>';
        // print_r($data_lq_newest);
        // echo '<pre>';
        // die;
        $data_lq_popular = [];
        foreach($lq_popular as $val) {
            $url = Url::to(['qacenter/qacenter', 'category_id' => $val['category_id'], 'slug' => $this->actionSlug(isset($arr_cate[$val['category_id']]) ? $arr_cate[$val['category_id']] : '')]);
            $url_question = 'https://thebank.vn/hoi-dap-faq/' . $val['category_id'] . '-' . $this->actionSlug(isset($arr_cate[$val['category_id']]) ? $arr_cate[$val['category_id']] : '') . '/' . $val['id'] . '-' . $this->actionSlug($val['question']) . '.html';
            $data_lq_popular[] = [
                'id'                => $val['id'],
                'question'          => $val['question'],
                'user_id'           => $val['user_id'],
                'user_name'         => $val['user_name'],
                'date_create'        => $val['date_create'],
                'category_id'        => $val['category_id'],
                'nums_user_answer'  => $val['nums_user_answer'],
                'status'            => $val['status'],
                'description'        => $val['description'],
                'user_interest'        => $val['user_interest'],
                'is_faq'            => $val['is_faq'],
                'viewed'            => $val['viewed'],
                'status_syun_elastic'  => $val['status_syun_elastic'],
                'viewed'            => $val['viewed'],
                'category_name'            => isset($arr_cate[$val['category_id']]) ? $arr_cate[$val['category_id']] : '',
                'href'              => $url,
                'url_question'      => $url_question,
            ];
        }        
        $data_res['lq_popular'] = $data_lq_popular;
        $data_lq_not_answer = [];
        foreach($lq_not_answer as $val) {
            $url = Url::to(['qacenter/qacenter', 'category_id' => $val['category_id'], 'slug' => $this->actionSlug(isset($arr_cate[$val['category_id']]) ? $arr_cate[$val['category_id']] : '')]);
            $url_question = 'https://thebank.vn/hoi-dap-faq/' . $val['category_id'] . '-' . $this->actionSlug(isset($arr_cate[$val['category_id']]) ? $arr_cate[$val['category_id']] : '') . '/' . $val['id'] . '-' . $this->actionSlug($val['question']) . '.html';
            $data_lq_not_answer[] = [
                'id'                => $val['id'],
                'question'          => $val['question'],
                'user_id'           => $val['user_id'],
                'user_name'         => $val['user_name'],
                'date_create'        => $val['date_create'],
                'category_id'        => $val['category_id'],
                'nums_user_answer'  => $val['nums_user_answer'],
                'status'            => $val['status'],
                'description'        => $val['description'],
                'user_interest'        => $val['user_interest'],
                'is_faq'            => $val['is_faq'],
                'viewed'            => $val['viewed'],
                'status_syun_elastic'  => $val['status_syun_elastic'],
                'viewed'            => $val['viewed'],
                'category_name'            => isset($arr_cate[$val['category_id']]) ? $arr_cate[$val['category_id']] : '',
                'href'              => $url,
                'url_question'      => $url_question,
            ];
        }    
        $data_res['lq_not_answer'] = $data_lq_not_answer;
 
        $data_res['total_question'] = $total_question;
        $data_res['total_question_popular'] = $total_question_popular;
        $data_res['total_question_not_answer'] = $total_question_not_answer;

        $list_li = [];
        if ($total_page > 1 && $total_page < 5) {
            for ($i = 1; $i <= 4 && $i <= $total_page; $i++) {
                $list_li[]['page'] = $i;
            }
        } else if ($total_page >= 5) {
            for ($i = 1; $i <= 4 && $i <= $total_page; $i++) {
                $list_li[]['page'] = $i;
            }
            $list_li[]['page'] = '>';
            $list_li[]['page'] = '>>';
        }
        $data_res['list_li'] = $list_li;

        $list_li_popular = [];
        if ($total_page_popular > 1 && $total_page_popular < 5) {
            for ($i = 1; $i <= 4 && $i <= $total_page_popular; $i++) {
                $list_li_popular[]['page'] = $i;
            }
        } else if ($total_page_popular >= 5) {
            for ($i = 1; $i <= 4 && $i <= $total_page_popular; $i++) {
                $list_li_popular[]['page'] = $i;
            }
            $list_li_popular[]['page'] = '>';
            $list_li_popular[]['page'] = '>>';
        }
        $data_res['list_li_popular'] = $list_li_popular;

        $list_li_not_answer = [];
        if ($total_page_not_answer > 1 && $total_page_not_answer < 5) {
            for ($i = 1; $i <= 4 && $i <= $total_page_not_answer; $i++) {
                $list_li_not_answer[]['page'] = $i;
            }
        } else if ($total_page_not_answer >= 5) {
            for ($i = 1; $i <= 4 && $i <= $total_page_not_answer; $i++) {
                $list_li_not_answer[]['page'] = $i;
            }
            $list_li_not_answer[]['page'] = '>';
            $list_li_not_answer[]['page'] = '>>';
        }
        $data_res['list_li_not_answer'] = $list_li_not_answer;

        if (!empty($_POST)) {
            echo json_encode($data_res);
            exit;
        }
      
        return $this->render('qacenter', [
            'current_url' => $current_url,

            'qa_category' => $qa_category,
            'qa_category_2' => $qa_category_2,

            'lq_newest' => $lq_newest,
            'count_newest' => $count_newest,
            'lq_popular' => $lq_popular,
            'count_popular' => $count_popular,
            'lq_not_answer' => $lq_not_answer,
            'count_not_answer' => $count_not_answer,
            
            'total_question' => $total_question,
            'total_question_popular' => $total_question_popular,
            'total_question_not_answer' => $total_question_not_answer,

            'list_li' => $list_li,
            'total_page' => $total_page,
            'list_li_popular' => $list_li_popular,
            'total_page_popular' => $total_page_popular,
            'list_li_not_answer' => $list_li_not_answer,
            'total_page_not_answer' => $total_page_not_answer,

            'category_id' => $category_id,
            'type'          => $type,
            'arr_cate'      => $arr_cate,
            'active_default'    => $active_default,
            'active_pb'         => $active_pb,
            'active_notans'     => $active_notans,
        ]);
    }

    public function caculpage($count, $current_page, $display, $pages)
    {
        $data = '';
        $current_page = $current_page + 1;
        if ($count > $display) {
            $pages = (int)$pages;

            if ($current_page >= 4) {
                $start_page = $current_page - 3;
                if ($pages > $current_page + 3)
                    $end_page = $current_page + 3;
                else if ($current_page <= $pages && $current_page > $pages - 6) {
                    $start_page = $pages - 6;
                    $end_page = $pages;
                } else
                    $end_page = $pages;
            } else {
                $start_page = 1;
                if ($pages > 4)
                    $end_page = 4;
                else
                    $end_page = $pages;
            }
            // var
            if ($start_page <= 0)
                $start_page = 1;
            if ($current_page > 1) {
                $data .= "<a href='javascript:void(0)' class='pager' rel='1'> << </a>";
            } else {
                // $first_btn = false;
            }

            // FOR ENABLING THE PREVIOUS BUTTON
            if ($current_page > 1) {
                $pre = $current_page - 1;
                $data .= "<a href='javascript:void(0)' class='pager' rel='" . $pre . "'> < </a>";
            } else {
                // $previous_btn = false;
            }
            for ($i = $start_page; $i <= $end_page; $i++) {

                if ($current_page == $i)
                    $data .= "<a style='font-weight:bold;' href='javascript:void(0)' class='pager' rel=" . $i . "> $i </a>";
                else
                    $data .= "<a href='javascript:void(0)' class='pager' rel=" . $i . "> $i </a>";
            }

            // TO ENABLE THE NEXT BUTTON
            if ($current_page < $pages) {
                $nex = $current_page + 1;
                $data .= "<a href='javascript:void(0)' class='pager' rel=" . $nex . "> > </a>";
            } else {
                // $next_btn = false;
            }
            //  TO ENABLE THE LAST BUTTON
            if ($current_page < $pages) {
                $data .= "<a href='javascript:void(0)' class='pager' rel=" . $pages . "> >> </a>";
            } else {
                //$last_btn =false;
            }

            return $data;
            exit;
        }
    }
}
