<?php

/**
 * This is the model class for table "inquiry".
 *
 * The followings are the available columns in table 'inquiry':
 * @property integer $id
 * @property string $kode
 * @property integer $id_customer
 * @property integer $id_marketing
 * @property string $tanggal
 * @property string $status
 */
class Inquiry extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'inquiry';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('kode, id_customer, id_marketing, tanggal, status', 'required'),
            array('id_customer, id_marketing', 'numerical', 'integerOnly' => true),
            array('kode', 'length', 'max' => 15),
            array('status', 'length', 'max' => 25),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, kode, id_customer, id_marketing, tanggal, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'Customer' => array(self::BELONGS_TO, 'Customer', 'id_customer'),
            'Marketing' => array(self::BELONGS_TO, 'Marketing', 'id_marketing'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'kode' => 'ID Inquiry',
            'id_customer' => 'Customer',
            'id_marketing' => 'Marketing',
            'tanggal' => 'Tanggal',
            'status' => 'Status',
        );
    }

    public function getIdCust() {
        return isset($this->Customer->kode) ? $this->Customer->kode : '-';
    }

    public function getNamaCust() {
        return isset($this->Customer->nama) ? $this->Customer->nama : '-';
    }

    public function getNewKode() {
        $model = Inquiry::model()->find(array('order' => 'id DESC'));

        if (isset($model)) {
            $urut = substr($model->kode, -3) + 1;
            $kode = substr('100' . $urut, strlen($urut));
            $data["kode"] = "INQ1" . $kode;
        } else {
            $data['kode'] = "INQ1001";
        }
        return $data['kode'];
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

//        $criteria->compare('id', $this->id);
        if (!empty($this->kode))
            $criteria->compare('kode', $this->kode, true);

        if (!empty($this->id_customer))
            $criteria->compare('id_customer', $this->id_customer);

        if (!empty($this->tanggal))
            $criteria->compare('tanggal', $this->tanggal);

        $criteria->compare('status', $this->status, true);

        if ($_SESSION['level'] == "marketing") {
            $criteria->compare('id_marketing', Yii::app()->user->id);
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Inquiry the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
