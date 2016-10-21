<?php

/**
 * This is the model class for table "delivery".
 *
 * The followings are the available columns in table 'delivery':
 * @property integer $id
 * @property integer $id_invoice
 * @property string $tanggal
 * @property string $petugas
 * @property string $status
 */
class Delivery extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'delivery';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_invoice,kode, tanggal, petugas, status', 'required'),
            array('id_invoice', 'numerical', 'integerOnly' => true),
            array('petugas,kode', 'length', 'max' => 50),
            array('status', 'length', 'max' => 15),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_invoice, tanggal, petugas, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'Invoice' => array(self::BELONGS_TO, 'Invoice', 'id_invoice'),
        );
    }

    public function getIdInv() {
        return isset($this->Invoice->kode) ? $this->Invoice->kode : '-';
    }

    public function getIdPo() {
        return isset($this->Invoice->Po->kode) ? $this->Invoice->Po->kode : '-';
    }

    public function getIdMarketing() {
        return isset($this->Invoice->Po->Marketing->kode) ? $this->Invoice->Po->Marketing->kode : '-';
    }

    public function getTotalBayar() {
        return isset($this->Invoice->Po->Quotation->So->totalBayar) ? $this->Invoice->Po->Quotation->So->totalBayar : '-';
    }

    public function getTglOrder() {
        return isset($this->Invoice->Po->tglOrder) ? $this->Invoice->Po->tglOrder : '-';
    }

    public function getNewKode() {
        $model = Delivery::model()->find(array('order' => 'id DESC', 'condition' => 'year(tanggal)=' . date("Y")));

        if (isset($model)) {
            $urut = substr($model->kode, 0, 6) + 1;
            $kode = substr('300000' . $urut, strlen($urut));
            $data["kode"] = $kode . date("Y");
        } else {
            $data['kode'] = "300001" . date("Y");
        }
        return $data['kode'];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'id_invoice' => 'Id Invoice',
            'kode' => 'ID Delivery',
            'tanggal' => 'Tanggal',
            'petugas' => 'Petugas',
            'status' => 'Status',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->with = 'Invoice.Po.Quotation.Inquiry';

        if ($_SESSION['level'] == "marketing") {
            $criteria->compare('Inquiry.id_marketing', Yii::app()->user->id);
        }
        $criteria->compare('id', $this->id);
        $criteria->compare('id_invoice', $this->id_invoice);
        $criteria->compare('tanggal', $this->tanggal, true);
        $criteria->compare('petugas', $this->petugas, true);
        $criteria->compare('status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Delivery the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
