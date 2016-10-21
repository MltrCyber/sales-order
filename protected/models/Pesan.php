<?php

/**
 * This is the model class for table "pesan".
 *
 * The followings are the available columns in table 'pesan':
 * @property integer $id
 * @property integer $pengirim_id
 * @property integer $penerima_id
 * @property string $tanggal
 * @property string $isi
 * @property integer $dibaca
 */
class Pesan extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'pesan';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('pengirim_id, penerima_id, tanggal, dibaca, isi, subjek', 'required'),
            array('pengirim_id, penerima_id, dibaca, pesan_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, pengirim_id, penerima_id, tanggal, isi, dibaca, pesan_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'Pengirim' => array(self::BELONGS_TO, 'User', 'pengirim_id'),
            'Penerima' => array(self::BELONGS_TO, 'User', 'penerima_id'),
        );
    }

    public function getStatus() {
        $jml = Pesan::model()->findAll(array('condition' => 'penerima_id=' . Yii::app()->user->id . ' and dibaca = 0 and pesan_id = ' . $this->pesan_id));
        $jumlah = count($jml);
        if ($jumlah == 0) {
            $psn = '';
        } else {
            $psn = '<span class="badge">' . $jumlah . ' pesan belum dibaca</span>';
        }
        return $psn;
    }

    public function getPenerimaPesan() {
        $pesan = Pesan::model()->find(array('condition' => '(hapus1 != ' . Yii::app()->user->id . ' and hapus2 != ' . Yii::app()->user->id . ') and pesan_id="'.$this->pesan_id.'"', 'order' => 'id DESC'));
        $data = '<b>';
        $data .= isset($this->Penerima->nama) ? $this->Penerima->nama : '-';
        $data .= '</b><br>';
        $data .= $pesan->isi;
        return $data;
    }

    public function getSubjekPesan() {
        $pesan = Pesan::model()->find(array('condition' => '(hapus1 != ' . Yii::app()->user->id . ' and hapus2 != ' . Yii::app()->user->id . ') and pesan_id="'.$this->pesan_id.'"', 'order' => 'id ASC'));
        return '<b>'.$pesan->subjek.'</b>';
    }

    public function getTanggalPesan() {
        $tgl = explode(" ", $this->tanggal);
        $tanggal = Yii::app()->tindik->tgl_indo($tgl[0]) . ' at ' . $tgl[1];
//        $tanggal = '';
        return $tanggal;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'pesan_id' => 'Pesan Id',
            'pengirim_id' => 'Pengirim',
            'penerima_id' => 'Penerima',
            'tanggal' => 'Tanggal',
            'isi' => 'Isi',
            'dibaca' => 'Dibaca',
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
        $criteria->compare('tanggal', $this->tanggal, true);
        $criteria->compare('isi', $this->isi, true);
        $criteria->compare('dibaca', $this->dibaca);

        $criteria->addCondition('penerima_id = ' . Yii::app()->user->id . ' or pengirim_id = ' . Yii::app()->user->id);
        $criteria->addCondition('hapus1 != ' . Yii::app()->user->id . ' and hapus2 != ' . Yii::app()->user->id);
//         $criteria->addCondition('hapus1 != ' . Yii::app()->user->id . ' or hapus2 != ' . Yii::app()->user->id);
        $criteria->select = '*';
        $criteria->group = 'pesan_id';
        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
//            'groupBy' => 'penerima_id',
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Pesan the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
