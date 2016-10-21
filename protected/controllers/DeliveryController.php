<?php

class DeliveryController extends Controller {

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
         $inv = Invoice::model()->findByPk($model->id_invoice);
        $this->render('view', array(
            'model' => $model,
            'inv' => $inv,
        ));
    }

    public function actionCreate() {
        $model = new Delivery;

        if (isset($_GET['id'])) {
            $inv = Invoice::model()->findByPk($_GET['id']);
        }

        if (isset($_POST['Delivery'])) {
            $model->attributes = $_POST['Delivery'];
            $model->tanggal = Yii::app()->tindik->tglyy($model->tanggal);
            $model->id_invoice = $inv->id;
            $model->status = 'Pending';
            if ($model->save()) {
                $inv->delivery = 1;
                $inv->save();
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $model->kode = $model->getNewKode();

        $this->render('create', array(
            'model' => $model,
            'inv' => $inv,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['Delivery'])) {
            $model->attributes = $_POST['Delivery'];
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
        $model = new Delivery('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Delivery']))
            $model->attributes = $_GET['Delivery'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = Delivery::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'delivery-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
