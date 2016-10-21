<?php

class PengumumanController extends Controller {

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
        $model = $this->loadModel($id);
        if ($_SESSION['level'] == "marketing") {
            $det = PengumumanBaca::model()->find(array('condition' => 'id_user=' . Yii::app()->user->id . ' and id_pengumuman=' . $model->id));
            $det->baca = 1;
            $det->save();
        }
        $this->render('view', array(
            'model' => $model,
        ));
    }

    public function actionCreate() {
        $model = new Pengumuman;

        if (isset($_POST['Pengumuman'])) {
            $model->attributes = $_POST['Pengumuman'];
            $model->tanggal = date("Y-m-d");
            if ($model->save()) {
                $marketing = Marketing::model()->findAll(array('condition' => 'level="marketing"'));
                foreach ($marketing as $val) {
                    $det = new PengumumanBaca;
                    $det->id_pengumuman = $model->id;
                    $det->id_user = $val->id;
                    $det->baca = 0;
                    $det->save();
                }
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['Pengumuman'])) {
            $model->tanggal = date("Y-m-d");
            if ($model->save()) {
                PengumumanBaca::model()->deleteAll('id_pengumuman=' . $id);
                $marketing = Marketing::model()->findAll(array('condition' => 'level="marketing"'));
                foreach ($marketing as $val) {
                    $det = new PengumumanBaca;
                    $det->id_pengumuman = $model->id;
                    $det->id_user = $val->id;
                    $det->baca = 0;
                    $det->save();
                }
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        if (Yii::app()->request->isPostRequest) {
// we only allow deletion via POST request
            $this->loadModel($id)->delete();
            PengumumanBaca::model()->deleteAll('id_pengumuman=' . $id);

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionIndex() {
        $model = new Pengumuman('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Pengumuman']))
            $model->attributes = $_GET['Pengumuman'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = Pengumuman::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'pengumuman-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
