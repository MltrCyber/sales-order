<?php

/**
 * This is the model class for table "po".
 *
 * The followings are the available columns in table 'po':
 * @property integer $id
 * @property string $kode
 * @property integer $id_quotation
 * @property integer $id_marketing
 * @property integer $id_customer
 * @property string $tanggal
 * @property string $status
 */
class Po extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'po';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('kode, id_quotation, id_marketing, id_customer, tanggal, status', 'required'),
            array('id_quotation, id_marketing, id_customer', 'numerical', 'integerOnly' => true),
            array('kode, status', 'length', 'max' => 15),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, kode, id_quotation, id_marketing, id_customer, tanggal, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'Quotation' => array(self::BELONGS_TO, 'Quotation', 'id_quotation'),
            'Marketing' => array(self::BELONGS_TO, 'Marketing', 'id_marketing'),
            'Customer' => array(self::BELONGS_TO, 'Customer', 'id_customer'),
//            'So' => array(self::HAS_ONE, 'So', 'id_po'),
        );
    }

    public function getIdQuot() {
        return isset($this->Quotation->kode) ? $this->Quotation->kode : '-';
    }

    public function getIdCust() {
        return isset($this->Customer->kode) ? $this->Customer->kode : '-';
    }

    public function getIdMarketing() {
        return isset($this->Marketing->kode) ? $this->Marketing->kode : '-';
    }

    public function getTglOrder() {
        return isset($this->Quotation->So->tanggal) ? $this->Quotation->So->tanggal : '-';
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'kode' => 'ID PO',
            'id_quotation' => 'Id Quotation',
            'id_marketing' => 'Id Marketing',
            'id_customer' => 'Id Customer',
            'tanggal' => 'Tanggal',
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
        $criteria->with = 'Quotation.Inquiry';

        if ($_SESSION['level'] == "marketing") {
            $criteria->compare('Inquiry.id_marketing', Yii::app()->user->id);
        }

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.kode', $this->kode, true);
        $criteria->compare('t.id_quotation', $this->id_quotation);
        $criteria->compare('t.id_marketing', $this->id_marketing);
        $criteria->compare('t.id_customer', $this->id_customer);
        $criteria->compare('t.tanggal', $this->tanggal, true);
        $criteria->compare('t.status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchAccept() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
//        $criteria->with = 'Quotation.Inquiry';

        if ($_SESSION['level'] == "marketing") {
            $criteria->compare('t.id_marketing', Yii::app()->user->id);
        }

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.kode', $this->kode, true);
        $criteria->compare('t.id_quotation', $this->id_quotation);
        $criteria->compare('t.id_marketing', $this->id_marketing);
        $criteria->compare('t.id_customer', $this->id_customer);
        $criteria->compare('t.tanggal', $this->tanggal, true);
        $criteria->compare('t.status', 'Approve', true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchReject() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->with = 'Quotation.Inquiry';

        if ($_SESSION['level'] == "marketing") {
            $criteria->compare('Inquiry.id_marketing', Yii::app()->user->id);
        }

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.kode', $this->kode, true);
        $criteria->compare('t.id_quotation', $this->id_quotation);
        $criteria->compare('t.id_marketing', $this->id_marketing);
        $criteria->compare('t.id_customer', $this->id_customer);
        $criteria->compare('t.tanggal', $this->tanggal, true);
        $criteria->compare('t.status', 'Reject', true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchInvoice() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->with = 'Quotation.Inquiry';

        if ($_SESSION['level'] == "marketing") {
            $criteria->compare('Inquiry.id_marketing', Yii::app()->user->id);
        }

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.kode', $this->kode, true);
        $criteria->compare('t.id_quotation', $this->id_quotation);
        $criteria->compare('t.id_marketing', $this->id_marketing);
        $criteria->compare('t.id_customer', $this->id_customer);
        $criteria->compare('t.tanggal', $this->tanggal, true);
        $criteria->compare('t.invoice', '0', true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getNewKode() {
        $model = Po::model()->find(array('order' => 'id DESC', 'condition' => 'year(tanggal)=' . date("Y")));

        if (isset($model)) {
            $urut = substr($model->kode, 0, 6) + 1;
            $kode = substr('200000' . $urut, strlen($urut));
            $data["kode"] = $kode . date("Y");
        } else {
            $data['kode'] = "200001" . date("Y");
        }
        return $data['kode'];
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Po the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
