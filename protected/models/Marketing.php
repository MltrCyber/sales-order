<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $kode
 * @property string $nama
 * @property string $alamat
 * @property string $no_tlp
 * @property string $username
 * @property string $password
 * @property string $level
 */
class Marketing extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('kode, nama, alamat, no_tlp, username, password, level', 'required'),
            array('kode, no_tlp', 'length', 'max' => 25),
            array('nama', 'length', 'max' => 100),
            array('username', 'length', 'max' => 20),
            array('password', 'length', 'max' => 255),
            array('level', 'length', 'max' => 9),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, kode, nama, alamat, no_tlp, username, password, level', 'safe', 'on' => 'search'),
        );
    }

    public function getKodeAndUsername() {
        $model = Marketing::model()->find(array('condition' => 'level="marketing"', 'order' => 'id DESC'));

        if (isset($model)) {
            $urut = substr($model->kode, -4) + 1;
            $kode = substr('1000' . $urut, strlen($urut));
            $data["kode"] = "MAR" . $kode;
            $data["username"] = $kode;
        } else {
            $data['kode'] = "MAR1001";
            $data['username'] = "1001";
        }
        return $data;
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'kode' => 'ID Marketing',
            'nama' => 'Nama',
            'alamat' => 'Alamat',
            'no_tlp' => 'No Tlp',
            'username' => 'Username',
            'password' => 'Password',
            'level' => 'Level',
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
        $criteria->compare('alamat', $this->alamat, true);
        $criteria->compare('no_tlp', $this->no_tlp, true);
        $criteria->compare('username', $this->username, true);
        $criteria->compare('password', $this->password, true);
        $criteria->compare('level', 'marketing', true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Marketing the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
