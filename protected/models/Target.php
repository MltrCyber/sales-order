<?php

/**
 * This is the model class for table "target".
 *
 * The followings are the available columns in table 'target':
 * @property integer $id
 * @property string $bulan
 * @property string $tahun
 * @property string $target
 * @property double $bonus
 */
class Target extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'target';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('bulan, tahun, target, bonus, id_marketing', 'required'),
            array('bonus, tahun, target', 'numerical'),
            array('bulan', 'length', 'max' => 2),
            array('tahun', 'length', 'max' => 5),
            array('target', 'length', 'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, bulan, tahun, target, bonus', 'safe', 'on' => 'search'),
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
    
    public function getKodeMarketing() {
        return isset($this->Marketing->kode) ? $this->Marketing->kode : '-';
    }

    public function getMarketing() {
        return isset($this->Marketing->nama) ? $this->Marketing->nama : '-';
    }

    public function getTargetBulan() {
        $data = Yii::app()->tindik->listbulan();
        return $data[$this->bulan];
    }

    public function getTargetSales() {
        return Yii::app()->tindik->rupiah($this->target);
    }

    public function getBonusSales() {
        return $this->bonus . ' %';
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'bulan' => 'Bulan',
            'tahun' => 'Tahun',
            'target' => 'Target',
            'bonus' => 'Bonus',
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
        $criteria->compare('bulan', $this->bulan, true);
        $criteria->compare('tahun', $this->tahun, true);
        $criteria->compare('target', $this->target, true);
        $criteria->compare('bonus', $this->bonus);
        
        if($_SESSION['level'] == "marketing"){
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
     * @return Target the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
