<?php

class QuotationController extends Controller {

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

        $inq = Inquiry::model()->findByPk($model->id_inquiry);

        $this->render('view', array(
            'model' => $model,
            'inq' => $inq,
        ));
    }

    public function actionCreate() {
        $model = new Quotation;

        if (isset($_GET['id'])) {
            $inq = Inquiry::model()->findByPk($_GET['id']);
        }

        if (isset($_POST['Quotation'])) {
            $model->attributes = $_POST['Quotation'];
            $model->tanggal = date("Y-m-d");
            $model->status = 'pending';
            if ($model->save()) {
                $inq = Inquiry::model()->findByPk($_GET['id']);
                $inq->status = 'quotation';
                $inq->save();
                for ($i = 0; $i < count($_POST['id_inquiry_det']); $i++) {
                    $inqDet = InquiryDet::model()->findByPk($_POST['id_inquiry_det'][$i]);
                    $inqDet->harga = $_POST['harga'][$i];
                    $inqDet->save();
                }
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $model->kode = $model->getNewKode();

        $this->render('create', array(
            'model' => $model,
            'inq' => $inq,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['Quotation'])) {
            $model->attributes = $_POST['Quotation'];
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
        $model = new Quotation('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Quotation']))
            $model->attributes = $_GET['Quotation'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = Quotation::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'quotation-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
