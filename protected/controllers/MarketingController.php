<?php

class MarketingController extends Controller {

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
                'actions' => array('create', 'update'),
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
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate() {
        $model = new Marketing;

        if (isset($_POST['Marketing'])) {
            $model->attributes = $_POST['Marketing'];
            $model->level = 'marketing';
            $model->password = sha1($model->password);
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $kd = $model->getKodeAndUsername();
        $model->kode = $kd['kode'];
        $model->username = $kd['username'];

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $password = $model->password;

        if (isset($_POST['Marketing'])) {
            $model->attributes = $_POST['Marketing'];
            if (!empty($model->password)) {
                $model->password = sha1($model->password);
            } else {
                $model->password = $password;
            }

            $model->level = 'marketing';
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $model->password = '';
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
        $model = new Marketing('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Marketing']))
            $model->attributes = $_GET['Marketing'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = Marketing::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'marketing-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
