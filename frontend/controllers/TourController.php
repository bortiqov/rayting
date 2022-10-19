<?php

namespace frontend\controllers;

use common\models\Course;
use common\models\UserCourse;
use common\modules\transaction\models\Transaction;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;

class TourController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionBuy($id)
    {
//        if (\Yii::$app->user->isGuest) return $this->redirect(['site/login']);

        $course = Course::findOne($id);

        $transaction = new Transaction();
        $transaction->course_id = $course->id;
        $transaction->user_id = 1;
        $transaction->state = 0; // created by us
        if ($transaction->save()) {
            $user_id = 1;

            $exists = UserCourse::find()
                ->andWhere(['user_id' => $user_id])
                ->andWhere(['course_id' => $course->id])
                ->exists();

            if (!$exists) {
                $userCourse = new UserCourse();
                $userCourse->user_id = $user_id;
                $userCourse->course_id = $course->id;
                $userCourse->save();
            }

            return $this->redirect(['choose-method', 'id' => $transaction->id]);
        } else {
            throw new BadRequestHttpException("Transaction not save");
        }


    }

    public function actionChooseMethod($id)
    {
        $transaction = Transaction::findOne($id);
        return $this->render('choose-method', ['model' => $transaction]);
    }

    public function actionCharge($method, $userId, $amount)
    {
        $methods = ['paycom', 'click'];

        $this->layout = 'payment';

        if (!in_array($method, $methods)) throw new BadRequestHttpException(__("Payment method does not exist."));

        \Yii::$app->response->format = Response::FORMAT_HTML;

        return $this->render("$method", [
            'amount' => $amount,
            'userId' => $userId
        ]);
    }
}