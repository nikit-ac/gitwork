<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Orders;
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

                return $this->render('index', [
                    'dataProvider' => $dataProvider,
                ]);
    }


    public function actionAddnew()
    {
        $orderNow = orders::find()->where(['active' => 1])->one();
        if ($orderNow == null) {
            $post_order = Yii::$app->request->post()['Orders'];
            $order = new Orders($post_order);
            $order->time_begin = date("Y-m-d H:i:s");
            $order->active = 1;
            $order->save();
            $resultAdd = 3;
        } else{
            $resultAdd = 2;
        }
        Yii::$app->response->redirect(array('site/index', 'resultAdd' => $resultAdd));
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
        } else{
            $resultAdd = 2;
        }
     //  return $this->renderAjax('site/index', 'resultAdd' => $resultAdd);
       Yii::$app->response->redirect(array('site/index', 'resultAdd' => $resultAdd));
    }

    public function actionStop()
    {
        $orderNow    = orders::find()->where(['active' => 1])->one();
        $timeOld     = $orderNow->time_total;
        $timeBegin   = new DateTime($orderNow->time_begin);
        $timeEnd     = new DateTime(date("Y-m-d H:i:s"));
        $orderNow->active = 0;
        $timeWork    = $timeBegin->diff($timeEnd);
        $MinutesWork = $timeWork->i + $timeWork->h*60 + $timeWork->d*60*24 + $timeOld;
        $orderNow->time_total = $MinutesWork;
        $orderNow->save();
        Yii::$app->response->redirect(array('site/index'));
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
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
