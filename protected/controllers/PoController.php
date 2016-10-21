<?php

class PoController extends Controller {

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
                'actions' => array('create', 'update', 'approve', 'reject', 'ubahStatus', 'invoice'),
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

    public function actionUbahStatus() {
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $model = $this->loadModel($id);
        $model->invoice = 1;
        $model->save();
        
        $this->redirect('invoice/proses');
    }

    public function actionView($id) {
        $model = $this->loadModel($id);
        $soId = isset($model->Quotation->So->id) ? $model->Quotation->So->id : 0;
        $so = So::model()->findByPk($soId);
        $this->render('view', array(
            'model' => $model,
            'so' => $so,
        ));
    }

    public function actionCreate() {
        $model = new Po;

        if (isset($_GET['id'])) {
            $so = So::model()->findByPk($_GET['id']);
        }

        if (isset($_POST['Po'])) {
            $model->attributes = $_POST['Po'];

            if (isset($_GET['status']))
                $model->status = 'Reject';
            else
                $model->status = 'Approve';

            $so->status = 'Po';
            $so->save();

            $model->tanggal = date("Y-m-d");
            if ($model->save()) {
                for ($i = 0; $i < count($_POST['id_barang']); $i++) {
                    $poDet = new PoDet();
                    $poDet->id_po = $model->id;
                    $poDet->id_barang = $_POST['id_barang'][$i];
                    $poDet->jumlah = $_POST['jumlah'][$i];
                    $poDet->harga = $_POST['harga'][$i];
                    $poDet->harga_beli = $_POST['harga_beli'][$i];
                    $poDet->save();
                }
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $model->kode = $model->getNewKode();

        $this->render('create', array(
            'model' => $model,
            'so' => $so,
        ));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        if (isset($_POST['Po'])) {
            $model->attributes = $_POST['Po'];
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
        $model = new Po('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Po']))
            $model->attributes = $_GET['Po'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }
    
     public function actionInvoice() {
        $model = new Po('searchInvoice');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Po']))
            $model->attributes = $_GET['Po'];

        $this->render('invoice', array(
            'model' => $model,
        ));
    }

    public function actionApprove() {
        $model = new Po('searchAccept');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Po']))
            $model->attributes = $_GET['Po'];

        $this->render('accept', array(
            'model' => $model,
        ));
    }

    public function actionReject() {
        $model = new Po('searchReject');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Po']))
            $model->attributes = $_GET['Po'];

        $this->render('reject', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = Po::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'po-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
