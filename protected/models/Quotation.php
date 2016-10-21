<?php

/**
 * This is the model class for table "quotation".
 *
 * The followings are the available columns in table 'quotation':
 * @property integer $id
 * @property string $kode
 * @property integer $id_inquiry
 * @property double $fee
 * @property string $tanggal
 * @property string $status
 */
class Quotation extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'quotation';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('kode, id_inquiry, tanggal, status', 'required'),
            array('id_inquiry', 'numerical', 'integerOnly' => true),
//            array('fee, total', 'numerical'),
            array('kode, status', 'length', 'max' => 15),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, kode, id_inquiry, tanggal, status', 'safe', 'on' => 'search'),
        );
    }

    public function getIdInquiry() {
        return isset($this->Inquiry->kode) ? $this->Inquiry->kode : '-';
    }

    public function getIdCust() {
        return isset($this->Inquiry->Customer->kode) ? $this->Inquiry->Customer->kode : '-';
    }

    public function getNamaCust() {
        return isset($this->Inquiry->Customer->nama) ? $this->Inquiry->Customer->nama : '-';
    }

    public function getIdMarketing() {
        return isset($this->Inquiry->Marketing->kode) ? $this->Inquiry->Marketing->kode : '-';
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'Inquiry' => array(self::BELONGS_TO, 'Inquiry', 'id_inquiry'),
            'So' => array(self::HAS_ONE, 'So', 'id_quotation'),
        );
    }

    public function getNewKode() {
        $model = Quotation::model()->find(array('order' => 'id DESC', 'condition' => 'year(tanggal)=' . date("Y")));

        if (isset($model)) {
            $urut = substr($model->kode, 0, 6) + 1;
            $kode = substr('100000' . $urut, strlen($urut));
            $data["kode"] = $kode . date("Y");
        } else {
            $data['kode'] = "100000" . date("Y");
        }
        return $data['kode'];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'kode' => 'ID Quotation',
            'id_inquiry' => 'Id Inquiry',
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
        $criteria->with = 'Inquiry';

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.kode', $this->kode, true);
        $criteria->compare('t.id_inquiry', $this->id_inquiry);
        $criteria->compare('t.tanggal', $this->tanggal, true);
        $criteria->compare('t.status', $this->status, true);
        
        if ($_SESSION['level'] == "marketing") {
            $criteria->compare('Inquiry.id_marketing', Yii::app()->user->id);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Quotation the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
