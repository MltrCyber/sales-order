<?php

class PesanController extends Controller {

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'index', 'view', 'lihat'),
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

    public function actionLihat($id) {
        $this->pageTitle = 'Safety Management System - View Message';
        $pesan = Pesan::model()->findByPk($id);

        if (isset($_POST['Pesan'])) {
            if ($pesan->pengirim_id == Yii::app()->user->id) {
                $penerima = $pesan->penerima_id;
            } else {
                $penerima = $pesan->pengirim_id;
            }

            $model = new Pesan;
            $model->pesan_id = $pesan->pesan_id;
            $model->subjek = $pesan->subjek;
            $model->pengirim_id = Yii::app()->user->id;
            $model->penerima_id = $penerima;
            $model->tanggal = date("Y-m-d H:i:s");
            $model->dibaca = 0;
            $model->isi = $_POST['Pesan']['isi'];
            if ($model->save()) {
//                $saveLog = User::model()->LogUser('Membalas pesan');
                Yii::app()->user->setFlash('success', '<strong>Success! </strong>data berhasil disimpan.');
            } else {
                Yii::app()->user->setFlash('danger', '<strong>Error! </strong>data gagal disimpan.');
            }
        }

        $this->render('view', array(
            'model' => $pesan,
        ));
    }

    public function actionCreate() {
        $this->pageTitle = 'Safety Management System - Create Message';
        $model = new Pesan;

        if (isset($_POST['Pesan'])) {
            $model->attributes = $_POST['Pesan'];
            $model->pengirim_id = Yii::app()->user->id;
            $model->tanggal = date("Y-m-d H:i:s");
            $model->dibaca = 0;
            $model->isi = $_POST['Pesan']['isi'];
            if ($model->save()) {
                $pesan = Pesan::model()->findByPk($model->id);
                $pesan->pesan_id = $model->id;
                $pesan->save();
                $penerima = User::model()->findByPk($_POST['Pesan']['penerima_id']);
//                $saveLog = User::model()->LogUser('Mengirim pesan kepada ' . $penerima->nama);
                $this->redirect(array('lihat', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $pesan = Pesan::model()->findByPk($id);
        if ($pesan->penerima_id == Yii::app()->user->id) {
            $userId = $pesan->pengirim_id;
        } else {
            $userId = $pesan->penerima_id;
        }

        $psn = Pesan::model()->findAll(array('condition' => 'pesan_id = ' . $pesan->pesan_id));
        foreach ($psn as $val) {
            if ($val->hapus1 == 0 or $val->hapus1 == Yii::app()->user->id) {
                $val->hapus1 = Yii::app()->user->id;
            } else {
                $val->hapus2 = Yii::app()->user->id;
            }

            $val->save();
        }

        $penerima = User::model()->findByPk($userId);
//        $saveLog = User::model()->LogUser('Menghapus percakapan dengan ' . $penerima->nama);

        $this->redirect(array('index'));
    }

    public function actionIndex() {
        $this->pageTitle = 'Safety Management System - Message';
        $model = new Pesan('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Pesan']))
            $model->attributes = $_GET['Pesan'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function loadModel($id) {
        $model = Pesan::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'pesan-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
