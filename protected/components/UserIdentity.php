<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    private $_id;
    private $_level;

    public function authenticate() {
        $record = User::model()->find(array('condition' => 'username="' . $this->username . '"'));  // check user name from database
        if ($record === null) {
            $this->_id = 'user Null';
            $this->_level = '-';
            $this->errorCode = "Your user name does not found in our database";
        } else if ($record->password !== sha1($this->password)) {            // compare db password with passwod field
            $this->_id = $this->id;
            $this->_level = $this->level;
            $this->errorCode = "Your password are invalid";
        } else {
//            session_start();
            $_SESSION['level'] = $record->level;
            $_SESSION['nama'] = $record->nama;
            $this->_id = $record->id;
            $this->_level = $record->level;
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    public function getId() {       //  override Id
        return $this->_id;
    }

    public function getLevel() {       //  override Level
        return $this->_level;
    }

}
