<?php
class forelosComisionista_model extends CI_Model{
 
    public function __construct()
    {
            parent::__construct();
            $this->load->database();
             
    }
    public function forelosComisionistas(){
        try {
            //$sql =  "call sp_select_forelosComisionistas();" ;
            $sql =  "call sp_select_forelos_Comisionistas();" ;
            $result = $this->db->query($sql);
            $this->db->last_query();
            $res= $result->result();
            $result->next_result(); 
            $result->free_result(); 
            $db_error = $this->db->error();
            if (!empty($db_error['message'])) {
                log_message( 'error','Database error! Error Code [' . $db_error['code'] . '] Error: ' . $db_error['message']);
            }
            return $res;   
        }catch (Exception $e) {
            log_message('error: ',$e->getMessage());
            return false;
        }  
    }



    
}
?>