<?php

class InquiryController extends Controller {

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
                'actions' => array('create', 'update', 'getCustomer'),
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

    public function actionGetCustomer() {
        $id = $_POST['Inquiry']['id_customer'];
        $model = Customer::model()->findByPk($id);
        echo json_encode($model->attributes);
    }

    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionCreate() {
        $model = new Inquiry;
        $model->kode = $model->getNewKode();

        if (isset($_POST['Inquiry'])) {
            $model->attributes = $_POST['Inquiry'];
            $model->id_marketing = Yii::app()->user->id;
            $model->status = 'pending';
            $model->tanggal = date("Y-m-d");
//            $model->tanggal = Yii::app()->tindik->tglyy($model->tanggal);
            if ($model->save()) {
                for ($i = 0; $i < count($_POST['Barang']['kode']); $i++) {
                    $barang = new Barang;
                    $barang->kode = $_POST['Barang']['kode'][$i];
                    $barang->nama = $_POST['Barang']['nama'][$i];
                    $barang->harga = 0;
                    $barang->satuan = '-';
                    $barang->stok = 0;
                    $barang->save();

                    $inqDet = new InquiryDet;
                    $inqDet->id_barang = $barang->id;
                    $inqDet->id_inquiry = $model->id;
                    $inqDet->jumlah = $_POST['Barang']['jumlah'][$i];
                    $inqDet->harga = 0;
                    $inqDet->save();
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

        if (isset($_POST['Inquiry'])) {
            $model->attributes = $_POST['Inquiry'];
            $model->id_marketing = Yii::app()->user->id;
            $model->status = 'pending';
            $model->tanggal = date("Y-m-d");
            if ($model->save()) {
                $delDet = InquiryDet::model()->deleteAll('id_inquiry=' . $model->id);
                for ($i = 0; $i < count($_POST['Barang']['kode']); $i++) {
                    $barang = new Barang;
                    $barang->kode = $_POST['Barang']['kode'][$i];
                    $barang->nama = $_POST['Barang']['nama'][$i];
                    $barang->harga = 0;
                    $barang->satuan = '-';
                    $barang->stok = 0;
                    $barang->save();

                    $inqDet = new InquiryDet;
                    $inqDet->id_barang = $barang->id;
                    $inqDet->id_inquiry = $model->id;
                    $inqDet->jumlah = $_POST['Barang']['jumlah'][$i];
                    $inqDet->harga = 0;
                    $inqDet->save();
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
            InquiryDet::model()->deleteAll('id_inquiry=' . $id);

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionIndex() {
        $model = new Inquiry('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Inquiry']))
            $model->attributes = $_GET['Inquiry'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = Inquiry::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'inquiry-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
