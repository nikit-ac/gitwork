<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\RegForm;

class UserController extends Controller
{

    public function actionAbout ($user = 'sss')
    {
        $imgfile = 'xxx.png';
        $info = 'cbjsbhjcsd jdsb sjhb hjds fdjs jhd fbhfd jhfdbjs fd gfsnhgf ndgb gfd ghfd n gnbfd gn fdmn gmndf nmg';
        return $this->render('about', [
          'user'    => $user,
          'imgfile' => $imgfile,
          'info'    => $info
          ]);
    }

    public function actionEdit ()
    {
        return $this->render('');
    }

    public function actionComment ()
    {
        return $this->render('');
    }

    public function actionReg ()
    {
        $model = New RegForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate() ) {
            if ($user = $model->reg) {
                if ($user->status === User::STATUS_ACTIVE) {
                    if (Yii::$app->getUser()->login($user)) {
                        return $this->goHome();
                    }
                }
                return $this->goHome();
            } else{
                Yii::$app->session->setFlash('error', "ошибка");
                Yii::error('ошибка при регистрации');
                return $this->refresh();
            }
        } else{
            $model = New Regform();
            return $this->render('regForm', [
                'model' => $model,
            ]);
        }
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
}