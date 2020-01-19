<?php

class Comment
{
    protected $db;
    private $_id;
    private $_id_user;
    private $_id_wpis;
    private $_comment;
    private $_filter;

    public function getId()
    {
        return $this->_id;
    }
    public function setFilter($filter) {
        $this->_filter = $filter;
    }
    public function setIdUser($id_user) {
        $this->_id_user = $id_user;
    }
    public function setIdWpis($id_wpis) {
        $this->_id_wpis= $id_wpis;
    }
    public function setComment($comment) {
        $this->_comment = $comment;
    }

    public function __construct() {
        $this->db = new DBConnection();
        $this->db = $this->db->returnConnection();
    }

    // Add Comment Method
    public function addComment()
    {

        $query = 'INSERT INTO komentarze SET 
            id_wpis="' . $this->_id_wpis . '",
            id_user="' . $this->_id_user . '",
            komentarz="' . $this->_comment . '"';
        $result = $this->db->query($query) or die($this->db->error);
        return true;
    }

    public function getAllComments($filter) {
    $query = 'SELECT * FROM komentarze WHERE id_wpis = "'.$filter.'"';
    $result = $this->db->query($query) or die($this->db->error);
    $animal_data = [];
    while($content = $result->fetch_array(MYSQLI_ASSOC)){
        $animal_data[] = $content;
    }
    return $animal_data;
}

}

?>