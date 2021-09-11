<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sinkronisasi extends CI_Controller
{
    //target sync url
    public $sync_url_main_to_target = "https://custravel.com/simrs/index.php/sinkronisasi/push_sync";
    public $sync_url_target_to_main = "https://custravel.com/simrs/index.php/sinkronisasi/pull_sync";
    
    function __construct()
    {
        parent::__construct();
        // is_login();
		
    }

    public function index()
    {
        // $this->data['last_sync'] = $this->get_last_sync();
        // $this->template->load('template','sinkronisasi/sinkronisasi_manual',$this->data);
    }
    
    public function sinkronisasi_action(){
        $this->getdbupdate();
        
        $ch = curl_init($this->sync_url_target_to_main);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
		// execute!
		$response = curl_exec($ch);
		// close the connection, release resources used
		curl_close($ch);
        
        // $this->update_last_sync();
		redirect('sinkronisasi');
    }
    
    public function getdbupdate(){
		$table_list = $this->table_list();
		if(count($table_list)>0){
			foreach ($table_list as $key => $table_name) {
				$response_array['data'][$table_name] = $this->synch_table_data($table_name);
			}
			$response_array['status']="success";
			$response_array['message']="Database synchronization initiated.";
// 			echo json_encode($response_array);
			//Set session sukses
            $this->session->set_flashdata('message', 'Sinkronisasi Data Berhasil');
            $this->session->set_flashdata('message_type', 'success');
            $this->session->set_flashdata('message_content', json_encode($response_array));
// 			exit;
		} else {
			$response_array['status']="fail";
			$response_array['message']="No Tables Found.";
			$response_array['data']=array();
// 			echo json_encode($response_array);
            $this->session->set_flashdata('message', 'Sinkronisasi Data Gagal');
            $this->session->set_flashdata('message_type', 'danger');
            $this->session->set_flashdata('message_content', json_encode($response_array));
// 			exit;
		}
		
		$this->update_last_sync();
	}	
	
	public function table_list(){
	    $sql = 'SHOW TABLES';
        $result = $this->db->query($sql)->result();
        $table_array = array();
        $table_list_name = 'Tables_in_' . $this->db->database;
        $no_sync_table = $this->get_no_sync_table();
        if(count($result) > 0){
            foreach($result as $data){
                $flag_table_list = true;
                foreach($no_sync_table as $no_sync){
                    if($data->$table_list_name == $no_sync->table_name)
                        $flag_table_list = false;
                }
                if($flag_table_list)
                    $table_array[] = $data->$table_list_name;
            }
        }
		return $table_array;
	}
	
	private function synch_table_data($table_name){
			$post_data['table_name'] = $table_name;
            $sql = "SELECT * FROM " . $table_name . " WHERE dtm_upd > '" . $this->get_last_sync() . "'";
            $table_query = $this->db->query($sql)->result_array();
            
			if(count($table_query)>0){
				foreach($table_query as $table_data){
					$post_data['table_data'][] = $table_data;
				}	
			}
			
// 			echo json_encode($post_data);
			//SYNC DATA TO LIVE SERVER
			$ch = curl_init($this->sync_url_main_to_target);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
			// execute!
			$response = curl_exec($ch);
			// close the connection, release resources used
			curl_close($ch);
			return $response;
	}
	
	private function get_last_sync(){
	    $this->db->where('id',1);
	    $data = $this->db->get('last_sync')->row();
	    return $data->last_sync;
	}
	
	private function get_no_sync_table(){
	    return $this->db->get('no_sync_table')->result();
	}
	
	public function update_last_sync(){
	    $this->db->where('id',1);
	    $this->db->update('last_sync',array(
	        'last_sync'=> date("Y-m-d H:i:s",  time()),
            'dtm_upd' => date("Y-m-d H:i:s",  time())
	    ));
	}
	
// 	public function pull_sync(){
// 	    if(isset($_POST['do']) && $_POST['do']!=""){
//         	$this->getdbupdate();
//         } else {
//         	echo "Parameter Missings.";
//         	exit;
//         }
// 	}

    public function pull_sync(){
	    if(isset($_POST['table_name']) && $_POST['table_name']!=""){
	        $post_data['table_name'] = $_POST['table_name'];
        	$sql = "SELECT * FROM " . $_POST['table_name'] . " WHERE dtm_upd > '" . $this->get_last_sync() . "'";
            $table_query = $this->db->query($sql)->result_array();
			if(count($table_query)>0){
				foreach($table_query as $table_data){
					$post_data['table_data'][] = $table_data;
				}	
			}
			else
			    $post_data['table_data'] = null;
			
        	print_r(json_encode($post_data));
        
        // $data[] = array('satu','dua');
        // print_r($data);
        	exit;
        } else {
        	echo "Parameter Missings.";
        	exit;
        }
	}
	
	//Receive request from other server
	public function push_sync(){
	    if(isset($_POST['table_name']) && $_POST['table_name']!=""){
        	$output = $this->table_update($_POST);
        	print_r($output);
        	exit;
        } else {
        	echo "Parameter Missings.";
        	exit;
        }
	}
	
	public function table_update(array $post_array){
		$table_name = @$post_array['table_name'];
		$table_data = @$post_array['table_data'];
		
		return $this->get_existing_data($table_name,$table_data);
	}
	
	private function get_existing_data($table_name,$table_data){
	    $count_ins = 0;
	    $count_upd = 0;
	    if(count($table_data) > 0){
    	    for($i=0;$i<count($table_data);$i++){
    	        //Get Data
    	        $id_name = key($table_data[$i]);
    	        $id_value = $table_data[$i][$id_name];
    	        $data_ins = $table_data[$i];
        		
        		$data = $this->get_data($id_name,$id_value,$table_name);
        		//Jika ada maka hapus terus update, Jika tidak ada maka langsung insert saja
        		if($data != null){
        		    $insert = $this->update_data($id_name,$id_value,$table_name,$data_ins);
        		    $count_upd++;
        		} else {
        		    $insert = $this->insert_data($data_ins,$table_name);
        		    $count_ins++;
        		}
        // 		echo json_encode($data_ins);
    	    }
	    }
        return 'Jumlah insert = ' . $count_ins . ', Jumlah update = ' . $count_upd;
	}
	
	private function get_data($id_name,$id_value,$table_name){
	    $this->db->where($id_name,$id_value);
        return $this->db->get($table_name)->row();
	}
	
	private function update_data($id_name,$id_value,$table_name,$data){
	    $this->db->where($id_name, $id_value);
        $this->db->update($table_name, $data);
	}
	
	private function insert_data($data, $table_name){
	    $this->db->insert($table_name, $data);
	}
    
}