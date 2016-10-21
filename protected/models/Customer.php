<?php

/**
 * This is the model class for table "customer".
 *
 * The followings are the available columns in table 'customer':
 * @property integer $id
 * @property string $kode
 * @property string $nama
 * @property string $cp
 * @property string $telepon
 * @property string $email
 * @property integer $id_marketing
 */
class Customer extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'customer';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('kode, cp, telepon', 'required'),
            array('telepon', 'numerical', 'integerOnly' => true),
            array('kode, telepon', 'length', 'max' => 25),
            array('nama', 'length', 'max' => 100),
            array('cp, email', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, kode, nama, cp, telepon, email, id_marketing', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'Marketing' => array(self::BELONGS_TO, 'Marketing', 'id_marketing'),
        );
    }

    public function getKodeCust() {
        $model = Customer::model()->find(array('order' => 'id DESC'));

        if (isset($model)) {
            $urut = substr($model->kode, -4) + 1;
            $kode = substr('1000' . $urut, strlen($urut));
            $data["kode"] = "CUST" . $kode;
        } else {
            $data['kode'] = "CUST1001";
        }
        return $data['kode'];
    }

    public function getKodeMarketing() {
        return isset($this->Marketing->kode) ? $this->Marketing->kode : '-';
    }

    public function getNamaMarketing() {
        return isset($this->Marketing->nama) ? $this->Marketing->nama : '-';
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'kode' => 'Kode',
            'nama' => 'Nama',
            'cp' => 'Contact Person',
            'telepon' => 'Telepon',
            'email' => 'Email',
            'id_marketing' => 'Id Marketing',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('kode', $this->kode, true);
        $criteria->compare('nama', $this->nama, true);
        $criteria->compare('cp', $this->cp, true);
        $criteria->compare('telepon', $this->telepon, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('id_marketing', $this->id_marketing);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Customer the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
