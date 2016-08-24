<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Orders;
use app\models\User;
use yii\data\ActiveDataProvider;
use DateTime;


class SiteController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => Orders::find(),
        ]);
        $activeOrder = Orders::getActive()->work_dir;

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'activeOrder' => $activeOrder
        ]);
    }

    public function actionAdd()
    {   
        if (!Orders::getActive()) {
            $post_order = Yii::$app->request->post()['Orders'];
            $order = new Orders($post_order);
            $order->time_begin = date("Y-m-d H:i:s");
            $order->active = 1;
            $order->save();
        }
        Yii::$app->response->redirect(array('site/index'));
    }

    public function actionEdit($id)
    {
        $orderNow = orders::find()->where(['active' => 1])->one();
        if ($orderNow == null) {
            $orderWork = orders::findone($id);
            $orderWork->active = 1;
            $orderWork->time_begin = date("Y-m-d H:i:s");
            $orderWork->save();
            $resultAdd = 1;
        } else {
            $resultAdd = 2;
        }
        //  return $this->renderAjax('site/index', 'resultAdd' => $resultAdd);
        Yii::$app->response->redirect(array('site/index', 'resultAdd' => $resultAdd));
    }

    public function actionStop()
    {
        $activeOrder = Orders::getActive();
        $timeOld = $activeOrder->time_total;
        $timeBegin = new DateTime($activeOrder->time_begin);
        $timeEnd = new DateTime(date("Y-m-d H:i:s"));
        $activeOrder->active = 0;
        $timeWork = $timeBegin->diff($timeEnd);
        $minutesWork = $timeWork->i + $timeWork->h * 60 + $timeWork->d * 60 * 24 + $timeOld;
        $activeOrder->time_total = $minutesWork;
        $activeOrder->save();
        return $this->render('index');
//        Yii::$app->response->redirect(array('site/index'));
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new User();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }


}
