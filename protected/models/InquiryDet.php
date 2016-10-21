<?php

/**
 * This is the model class for table "inquiry_det".
 *
 * The followings are the available columns in table 'inquiry_det':
 * @property integer $id
 * @property integer $id_inquiry
 * @property integer $id_barang
 * @property string $harga
 */
class InquiryDet extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'inquiry_det';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id_inquiry, id_barang, harga', 'required'),
            array('id_inquiry, id_barang', 'numerical', 'integerOnly' => true),
            array('harga', 'length', 'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, id_inquiry, id_barang, harga', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'Barang' => array(self::BELONGS_TO, 'Barang', 'id_barang'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'id_inquiry' => 'Id Inquiry',
            'id_barang' => 'Id Barang',
            'harga' => 'Harga',
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
        $criteria->compare('id_inquiry', $this->id_inquiry);
        $criteria->compare('id_barang', $this->id_barang);
        $criteria->compare('harga', $this->harga, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return InquiryDet the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
