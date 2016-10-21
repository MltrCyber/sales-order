<?php

class SoController extends Controller {

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'proses'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionView($id) {
        $model = $this->loadModel($id);

//        if (isset($_GET['id'])) {
        $quo = Quotation::model()->findByPk($model->id_quotation);
//        }

        $this->render('view', array(
            'model' => $model,
            'quo' => $quo,
        ));
    }

    public function actionCreate() {
        $model = new So;

        if (isset($_GET['id'])) {
            $quo = Quotation::model()->findByPk($_GET['id']);
        }

        if (isset($_POST['So'])) {
            $model->attributes = $_POST['So'];
            $model->id_quotation = $_GET['id'];
            $model->tanggal = Yii::app()->tindik->tglyy($model->tanggal);
            $model->fee = empty($model->fee) ? 0 : $model->fee;
            $model->total = isset($_POST['So']['total']) ? $_POST['So']['total'] : 0;
            $model->status = 'proses';
            if ($model->save()) {
                $quo->status = 'so';
                $quo->save();
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $model->kode = $model->getNewKode();
        $model->tanggal = date("d-m-Y");

        $this->render('create', array(
            'model' => $model,
            'quo' => $quo
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['So'])) {
            $model->attributes = $_POST['So'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $this->loadModel($id)->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionIndex() {
        $model = new So('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['So']))
            $model->attributes = $_GET['So'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionProses() {
        $model = new So('searchProses');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['So']))
            $model->attributes = $_GET['So'];

        $this->render('proses', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = So::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'so-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
