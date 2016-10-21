<?php

/**
 * This is the model class for table "so".
 *
 * The followings are the available columns in table 'so':
 * @property integer $id
 * @property string $kode
 * @property integer $id_quotation
 * @property double $fee
 * @property string $total
 * @property string $tanggal
 * @property string $status
 */
class So extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'so';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('kode, id_quotation, fee, total, tanggal, status', 'required'),
            array('id_quotation', 'numerical', 'integerOnly' => true),
            array('fee', 'numerical'),
            array('kode, status', 'length', 'max' => 15),
            array('total', 'length', 'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, kode, id_quotation, fee, total, tanggal, status', 'safe', 'on' => 'search'),
        );
    }

    public function getNewKode() {
        $model = So::model()->find(array('order' => 'id DESC'));

        if (isset($model)) {
            $urut = substr($model->kode, -3) + 1;
            $kode = substr('100' . $urut, strlen($urut));
            $data["kode"] = "SOR1" . $kode;
        } else {
            $data['kode'] = "SOR1001";
        }
        return $data['kode'];
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'Quotation' => array(self::BELONGS_TO, 'Quotation', 'id_quotation'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'kode' => 'ID Sales Order',
            'id_quotation' => 'Id Quotation',
            'fee' => 'Fee',
            'total' => 'Total',
            'tanggal' => 'Tanggal Order',
            'status' => 'Status',
        );
    }

    public function getIdQuot() {
        return isset($this->Quotation->kode) ? $this->Quotation->kode : '-';
    }

    public function getIdCust() {
        return isset($this->Quotation->idCust) ? $this->Quotation->idCust : '-';
    }

    public function getIdMarketing() {
        return isset($this->Quotation->idMarketing) ? $this->Quotation->idMarketing : '-';
    }

    public function getTotalBayar() {
        $fee = $this->total * ($this->fee / 100);
        return $this->total - $fee;
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
        $criteria->compare('t.fee', $this->fee);
        $criteria->compare('t.total', $this->total, true);
        $criteria->compare('t.tanggal', $this->tanggal, true);
        $criteria->compare('t.status', 'proses', true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return So the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
