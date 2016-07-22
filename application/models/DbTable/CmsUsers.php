

<?php

class Application_Model_DbTable_CmsUsers extends Zend_Db_Table_Abstract {

    const DEFAULT_PASSWORD = 'cubesphp';
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    protected $_name = 'cms_users'; //pravi naziv tabele u bazi

    /**
     * 
     * @param int $id
     * @return null|array Associative array with keys as cms_users table columns or NULL if not found
     */

    public function getUserById($id) {
        //preko ovoga dobijamo kveri bilder
        $select = $this->select();
        $select->where('id = ?', $id);

        //vraca zapise iz tabele // fetchRow vraca 1 red iz tabele
        $row = $this->fetchRow($select);

        //proverava da li je $row instanca Zend_Db_Table_Row
        if ($row instanceof Zend_Db_Table_Row) {
            //vrati mi svoje atribute kao asocijativni niz
            return $row->toArray();
        } else {
            //row is not found
            return null;
        }
    }

    /**
     * 
     * @param array $user Associative array with keys as column names and values as column new values
     * @return int ID of new user
     */
    public function insertUser($user) {

        //set default password for new user
        $user['password'] = md5(self::DEFAULT_PASSWORD);

        return $this->insert($user);
    }

    /**
     * 
     * @param int $id
     * @param array $user Associative array with keys as column names and values as column new values
     */
    public function updateUser($id, $user) {
        //proverava da li je setovan id 
        if (isset($user['id'])) {
            //Forbid changing user id
            unset($user['id']);
        }

        $this->update($user, 'id = ' . $id);
    }

    /**
     * 
     * @param int $id
     * @param string $newPassword Plain password, not hashed
     */
    public function changeUserPassword($id, $newPassword) {
        //update "password" column, set md5 values of new password, for user with id = $id
        //array('password' =>md5($newPassword)) = $data
        //'id = ' .$id = $where
        $this->update(array(
            'password' => md5($newPassword)), 'id = ' . $id);
    }

    /*
     * @param int $id ID of user to delete
     */

    public function deleteUser($id) {

        $this->delete('id = ' . $id);
    }
    
    
    /**
     * 
     * @param int $id ID of user to disable
     */
    public function disableUser($id) {

        $this->update(array(
            'status' => self::STATUS_DISABLED
                ), 'id = ' . $id);
    }

    /**
     * 
     * @param int $id ID of user to enable
     */
    public function enableUser($id) {

        $this->update(array(
            'status' => self::STATUS_ENABLED
                ), 'id = ' . $id);
    }

    public function resetUserPassword($id, $newPassword) {

        $this->update(array(
            'password' => self::DEFAULT_PASSWORD
                ), 'id = ' . $id);
    }

}
