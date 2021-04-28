<?php


namespace frontend\controllers;


use common\models\ReportRecord;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class ReportController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update', 'view', 'list'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'congrats'],
                        'allow' => true,
                        'roles' => ['?','@'],
                    ],
                    [
                        'actions' => ['create','list','update','view'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
        ];
    }

    public function actionCreate($p_ref)
    {
        $reportRecord = new ReportRecord();
        $reportRecord->page_ref = $p_ref;
        if($reportRecord->load(Yii::$app->request->post()))
        {
            if ($reportRecord->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Report sent'));
                return $this->redirect(['congrats']);
            }
            Yii::$app->session->setFlash('error', 'Похоже, что-то пошло не так...<br>' . print_r($reportRecord->errors, true));
        }

        return $this->render('create', [
            'r_record' => $reportRecord,
        ]);
    }

    public function actionList()
    {
        $reportRecords = ReportRecord::find()->where(['solved' => false])->all();
        return $this->render('list',[
            'r_records' => $reportRecords
        ]);
    }

    public function actionView($id)
    {
        $record = ReportRecord::find()->where(['id'=>$id])->one();

        if($record->load(Yii::$app->request->post()))
        {
            $record->solver_id = Yii::$app->user->id;
            if ($record->save()) {
                Yii::$app->session->setFlash('success', 'Данные внесены');
                return $this->redirect(['list']);
            }
            Yii::$app->session->setFlash('error', 'Похоже, что-то пошло не так...<br>' . print_r($record->errors, true));
        }

        return $this->render('view',[
            'record'=>$record
        ]);
    }

    public function actionCongrats()
    {
        return $this->render('congrats');
    }
}