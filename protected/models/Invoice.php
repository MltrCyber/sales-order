<?php

/**
 * This is the model class for table "invoice".
 *
 * The followings are the available columns in table 'invoice':
 * @property integer $id
 * @property string $kode
 * @property integer $id_po
 * @property string $tanggal
 * @property string $status_bayar
 * @property string $status
 */
class Invoice extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'invoice';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('kode, id_po, tanggal, status_bayar, status', 'required'),
            array('id_po', 'numerical', 'integerOnly' => true),
            array('kode, status_bayar, status', 'length', 'max' => 15),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, kode, id_po, tanggal,jenis_pembayaran ,status_bayar, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'Po' => array(self::BELONGS_TO, 'Po', 'id_po'),
        );
    }

    public function getNewKode() {
        $model = Invoice::model()->find(array('order' => 'id DESC', 'condition' => 'year(tanggal)=' . date("Y")));

        if (isset($model)) {
            $urut = substr($model->kode, 0, 6) + 1;
            $kode = substr('400000' . $urut, strlen($urut));
            $data["kode"] = $kode . date("Y");
        } else {
            $data['kode'] = "400001" . date("Y");
        }
        return $data['kode'];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'kode' => 'ID Invoice',
            'id_po' => 'Id Po',
            'tanggal' => 'Tanggal',
            'status_bayar' => 'Status Bayar',
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

        $criteria->with = 'Po.Quotation.Inquiry';

        if ($_SESSION['level'] == "marketing") {
            $criteria->compare('Inquiry.id_marketing', Yii::app()->user->id);
        }
        
        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.kode', $this->kode, true);
        $criteria->compare('t.id_po', $this->id_po);
        $criteria->compare('t.tanggal', $this->tanggal, true);
        $criteria->compare('t.status_bayar', $this->status_bayar, true);
        $criteria->compare('t.status', $this->status, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Invoice the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
