<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Drug_stock extends MX_Controller {

	public $data = array();
	
	 function __construct(){
		parent::__construct();
		$this->checkLogin();
        $this->load->helper('url');
         $this->load->library('session');
		//$this->load->library('MdsCore');
		$this->load->model("mdrug_stock");
	 }
	 public function index($drug_stock_id=NULL){

		return;
	 }
	 
	 private function update_stock_drug_list($drug_stock_id){

		$data['who_drug_list'] = $this->mdrug_stock->get_who_drug_list();	
                $data['drug_stock_info'] = $this->mdrug_stock->get_drug_stock_info($drug_stock_id);
                if($data['drug_stock_info']['parent']){
                                                 $Parent = $data['drug_stock_info']['parent'];
                                            }else{
                                                $Parent = NULL; 
                                            }
                                                        // echo $Parent;
             		if (!empty($data['who_drug_list'])){
			for ($i=0; $i<count($data['who_drug_list']);++$i){
                            	if ($this->mdrug_stock->is_drug_exsist($drug_stock_id,$data['who_drug_list'][$i]["wd_id"]) == 0 && $this->mdrug_stock->is_active_on_parent($Parent,$data['who_drug_list'][$i]["wd_id"])==1){
			//if ($this->mdrug_stock->is_drug_exsist($drug_stock_id,$data['who_drug_list'][$i]["wd_id"]) == 0 ){		
                            $drug_data = array(
						"drug_stock_id"=> $drug_stock_id,
						"who_drug_id"=> $data["who_drug_list"][$i]["wd_id"],
						"who_drug_count"=>0,
                                                "who_drug_remain"=>0,
						"Active"=>1,
                                                "ParentID"=>$Parent
                                            
					);
					$this->load->model("mpersistent");
					$this->mpersistent->create("drug_count",$drug_data);
                            	}
			}
		}
		return true;
	 }
         
	 private function update_stock_drug_listALL($drug_stock_id){
		$data['who_drug_list'] = $this->mdrug_stock->get_who_drug_listALL();	
                $data['drug_stock_info'] = $this->mdrug_stock->get_drug_stock_info($drug_stock_id);
                if($data['drug_stock_info']['parent']){
                                                 $Parent = $data['drug_stock_info']['parent'];
                                            }else{
                                                $Parent = NULL; 
                                            }
		if (!empty($data['who_drug_list'])){
			for ($i=0; $i<count($data['who_drug_list']);++$i){
                            	if ($this->mdrug_stock->is_drug_exsist($drug_stock_id,$data['who_drug_list'][$i]["wd_id"]) == 0){
					$drug_data = array(
						"drug_stock_id"=> $drug_stock_id,
						"who_drug_id"=> $data["who_drug_list"][$i]["wd_id"],
						"who_drug_count"=>0,
                                                "who_drug_remain"=>0,
						"Active"=>1,
                                                "ParentID"=>$Parent
                                            
					);
					$this->load->model("mpersistent");
					$this->mpersistent->create("drug_count",$drug_data);
                            	}
			}
		}
		return true;
	 }
                  

         
	public function add_stock(){
		$drug_count_id = $_POST["drug_count_id"]; 
		$who_drug_count= $_POST["who_drug_count"];
                $who_remain_count = $_POST["who_remain_count"]; // remain
                $hdrug = $_POST["hdrug"]; // drug store
                $AddCount = $_POST["AddCount"]; //  add input
                $inpdrgi = $_POST["inpdrgi"]; //drugid
                $hdrug_S = $_POST["hdrug_S"];
                $pid = $_POST["pid"]; 
                $intremain_count = intval($who_remain_count) - intval($AddCount);
                $who_remain_count_update = intval($who_remain_count) + intval($AddCount);
		if (!$who_drug_count || !$drug_count_id){
			echo -1;
			return;
		}
		$this->load->database();
		$this->load->model("mpersistent");
		//($table=null,$key_field=null,$id=null,$data)
		 $this->mpersistent->update("drug_count","drug_count_id",$drug_count_id,array("drug_count_id"=>$drug_count_id,"who_drug_count"=>$who_drug_count,"who_drug_remain"=>$who_drug_count  ,"active"=>"1"));
                if($hdrug > 1){ 
                 $this->mpersistent->update("drug_count","drug_count_id",$pid,array("drug_count_id"=>$pid,"who_drug_count"=>$intremain_count,"who_drug_remain"=>$intremain_count,"active"=>"1"));
                }
                else{
                 $this->mpersistent->update("drug_count","drug_count_id",$drug_count_id,array("drug_count_id"=>$drug_count_id,"who_drug_count"=>$who_remain_count_update,"who_drug_remain"=>$who_remain_count_update,"active"=>"1"));   
                } 
		echo $drug_count_id;
                
	}
        
        public function remove_stock(){
		$drug_count_id = $_POST["drug_count_id"]; 
		$who_drug_count= $_POST["who_drug_count"];
                $who_remain_count = $_POST["who_remain_count"]; // remain
                $hdrug = $_POST["hdrug"]; // drug store
                $AddCount = $_POST["AddCount"]; //  add input
                $inpdrgi = $_POST["inpdrgi"]; //drugid
                $hdrug_S = $_POST["hdrug_S"];
                $intremain_count = intval($who_remain_count) - intval($AddCount);
                $who_remain_count_update = intval($who_remain_count) + intval($AddCount);
		if (!$who_drug_count || !$drug_count_id){
			echo -1;
			return;
		}
		$this->load->database();
		$this->load->model("mpersistent");
		//($table=null,$key_field=null,$id=null,$data)
		 $this->mpersistent->update("drug_count","drug_count_id",$drug_count_id,array("drug_count_id"=>$drug_count_id,"who_drug_count"=>$who_drug_count,"who_drug_remain"=>$who_drug_count,"active"=>"1"));
                if($hdrug != 1){
                 $this->mpersistent->update("drug_count","drug_count_id",$hdrug_S,array("drug_count_id"=>$hdrug_S,"who_drug_count"=>$who_remain_count_update,"who_drug_remain"=>$who_remain_count_update,"active"=>"1"));
                }else{
                 $this->mpersistent->update("drug_count","drug_count_id",$drug_count_id,array("drug_count_id"=>$drug_count_id,"who_drug_count"=>$who_remain_count_update,"who_drug_remain"=>$who_remain_count_update,"active"=>"1"));      
                }
		echo $drug_count_id;
                
	}
        
	public function add_stock_active(){
		$drug_count_id = $_POST["drug_count_id"]; 
		$flage= $_POST["flage"];
                

		$this->load->database();
		$this->load->model("mpersistent");
		//($table=null,$key_field=null,$id=null,$data)
		echo $this->mpersistent->update("drug_count","drug_count_id",$drug_count_id,array("drug_count_id"=>$drug_count_id,"Active"=>$flage));
                $this->load->model("mdrug_stock");
                $data = $this->mdrug_stock->get_who_drug($drug_count_id); 
                if($data['0']['drug_stock_id'] == 1 ){
                $this->mpersistent->update("who_drug","wd_id",$data['0']['who_drug_id'],array("wd_id"=>$data['0']['who_drug_id'],"Active"=>$flage));
                $this->mpersistent->update_all_drug_count($data['0']['who_drug_id'],$flage);
                }
	}        
        //drug store updated vesion
	public function view($drug_stock_id=NULL) 
	{ 		
                
		if (!Modules::run('security/check_view_access','drug_stock','can_view')){
			$data["error"] =" User group '".$this->session->userdata('UserGroup')."' have no rights to view this data";
			$this->load->vars($data);
			$this->load->view('drug_stock_error');
			exit;
		}	
		
		$data['drug_stock_list'] = $this->mdrug_stock->get_drug_stock_list();	
			
		if ($this->config->item('purpose') =="PP"){
			$drug_stock_id=1;
		}			
		if ($drug_stock_id){
                    $data['dstock_id'] = $drug_stock_id;
                    
			if ($this->update_stock_drug_list($drug_stock_id)){
				$data['drug_stock_info'] = $this->mdrug_stock->get_drug_stock_info($drug_stock_id);	
			}
                        
                        $data['drug_count_list'] =$this->mdrug_stock->get_drug_count_list($drug_stock_id); // child
                        //if($data['drug_stock_info']['parent'] && $data['drug_stock_info']['parent']>0){
                        if($data['drug_stock_info']['parent'] > 0){
                       $data['drug_count_list_remain'] =$this->mdrug_stock->get_parent_drug_count_list($data['drug_stock_info']['parent'],$drug_stock_id); //parent
                        }else{
                            $data['drug_count_list_remain'] =$this->mdrug_stock->get_drug_count_list("1");
                        }
		}
		
		
		
                
		$this->load->vars($data);
		$this->load->view('drug_stock_view');		
	}
        
        public function viewall($drug_stock_id=NULL)
	{			
		if (!Modules::run('security/check_view_access','drug_stock','can_view')){
			$data["error"] =" User group '".$this->session->userdata('UserGroup')."' have no rights to view this data";
			$this->load->vars($data);
			$this->load->view('drug_stock_error');
			exit;
		}	
		
		$data['drug_stock_list'] = $this->mdrug_stock->get_drug_stock_list();	
			
		if ($this->config->item('purpose') =="PP"){
			$drug_stock_id=1;
		}			
		if ($drug_stock_id){
			if ($this->update_stock_drug_list($drug_stock_id)){
				$data['drug_stock_info'] = $this->mdrug_stock->get_drug_stock_info($drug_stock_id);	
			}
		}
		
		
		$data['drug_count_list'] =$this->mdrug_stock->get_drug_count_listall($drug_stock_id);
                $data['drug_count_list_remain'] =$this->mdrug_stock->get_drug_count_listall("1");
                
		$this->load->vars($data);
		$this->load->view('drug_stock_viewall');		
	}
	
	
	public function add_question(){
		$quest_id = $_GET["quest_id"]; 
		$qid= $_GET["qid"];
		if (!$quest_id || !$qid){
			echo -1;
			return;
		}
		$this->load->database();
		$this->load->model("mpersistent");
		if ($this->is_question_exsist($quest_id,$qid)){
			echo 0;
			return;
		}
		$count = $this->count_all_question($quest_id);
		echo $this->mpersistent->create("qu_question",array("qu_questionnaire_id"=>$quest_id,"qu_question_repos_id"=>$qid,"active"=>"1","show_order"=>$count+1));
	}
	
	function is_question_exsist($quest_id,$qid){
		$this->load->database();
		$this->load->model("mquestionnaire");
		$count =  $this->mquestionnaire->count_question($quest_id, $qid);
		if ($count>0){
			return true;
		}
		return false;
	}
		
	function count_all_question($quest_id){
		$this->load->database();
		$this->load->model("mquestionnaire");
		return $this->mquestionnaire->count_all_question($quest_id);
	}
	
	public function open($id=null){
		$data = array();
		$this->load->database();
		$this->load->model("mquestionnaire");
		$data['questionnaire_info'] = $this->mquestionnaire->get_questionnaire_info($id);
		if (empty($data['questionnaire_info'])){ 
			$data['error'] = "Questionnaire not found";
			$this->load->vars($data);
			$this->load->view('questionnaire_error');
			return;
		}
		$data['question_list'] = $this->mquestionnaire->get_question_list($id);
		if(isset($data['question_list']) && count($data['question_list'])){
			for($i=0; $i < count($data['question_list']); ++$i){
				if ($data['question_list'][$i]['question_type'] == "Select"){
					$data['select'.$data['question_list'][$i]['qu_question_id']] = $this->mquestionnaire->get_select_data($data['question_list'][$i]['qu_question_id']);
				}
			}
		}
		$data["mode"] = "VIEW";
		$this->load->vars($data);
		$this->load->view('questionnaire_view');
	}
	public function save(){
		echo "Data Sent to server...";
	}
        
        public function save_drug_stock(){
		 $frm = 'drug_stock';
        if (!file_exists('application/forms/' . $frm . '.php')) {
            die("Form " . $frm . "  not found");
        }
        include 'application/forms/' . $frm . '.php';
        $data["form"] = $form;
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->model("mpersistent");
        if($_POST['drug_stock_id'] != 1 ){
        $this->form_validation->set_error_delimiters('<span class="field_error">', '</span>');
        
        for ($i = 0; $i < count($form["FLD"]); ++$i) {
            $this->form_validation->set_rules(
                $form["FLD"][$i]["name"], '"' . $form["FLD"][$i]["label"] . '"', $form["FLD"][$i]["rules"]
            );
        }
        }
        $this->form_validation->set_rules($form["OBJID"]);
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->vars($data);
            echo Modules::run('form/create', 'drug_stock');
        } else {
            $this->load->model("mdrug_stock");
            $parent_level=$this->mdrug_stock->get_parent_level($this->input->post("parent"));
            $level=$parent_level+1;
            if( $parent_level>6){
                echo "ERROR in saving";
                return;
            }
            $sve_data = array(
                'name' => $this->input->post("name"),
                'parent'  => $this->input->post("parent"),
                'UID_name' => strtoupper($this->input->post("UID_name")),
                'Active' => $this->input->post("Active"),
                'UID' => $this->input->post("UID"),
                'level' => $level
               
            );
            $id = $this->input->post($form["OBJID"]);
            $status = false;
			
            if ($id > 0) {
                $status = $this->mpersistent->update($frm, $form["OBJID"], $id, $sve_data);
                $this->session->set_flashdata(
                    'msg', 'REC: ' . ucfirst(strtolower($this->input->post("name"))) . ' Updated'
                );
				if ( $status){
					header("Status: 200");
					header("Location: ".site_url($form["NEXT"]));
				}
            } else {
                $status = $this->mpersistent->create($frm, $sve_data);
                $this->session->set_flashdata(
                    'msg', 'REC: ' . 'Drug Stock created'
                );
				if ( $status>0){
					//echo Modules::run($form["NEXT"], $status);
					//$status1 = $this->mpersistent->update('hospital','HID' , $this->session->userdata("HID"), array("Current_BHT"=>$this->input->post("BHT")));
					header("Status: 200");
					header("Location: ".site_url($form["NEXT"]));
					return;
				}
            }
            echo "ERROR in saving";
        }
	}
       
        public function save_drug_return(){
		 $frm = 'drug_return';
        if (!file_exists('application/forms/' . $frm . '.php')) {
            die("Form " . $frm . "  not found");
        }
        include 'application/forms/' . $frm . '.php';
        $data["form"] = $form;
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->model("mpersistent");
        
        //if($_POST['drug_stock_id'] != 1 ){
        $this->form_validation->set_error_delimiters('<span class="field_error">', '</span>');
        
        for ($i = 0; $i < count($form["FLD"]); ++$i) {
            $this->form_validation->set_rules(
                $form["FLD"][$i]["name"], '"' . $form["FLD"][$i]["label"] . '"', $form["FLD"][$i]["rules"]
            );
        }
        //}
        $this->form_validation->set_rules($form["OBJID"]);
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->vars($data);
            echo Modules::run('form/create', 'drug_return');
        } else {

            }
            //die(print_r($_POST));
            $sve_data = array(
                'dret_who_drug_txt' => $this->input->post("dret_who_drug_txt"),
                'dret_drug_stock_txt'  => $this->input->post("dret_drug_stock_txt"),
                'dret_amount' => strtoupper($this->input->post("dret_amount")),
                'dret_f_drug_stock_txt' => $this->input->post("dret_f_drug_stock_txt"),
                'dret_user_txt' => $this->input->post("dret_user_txt"),
                'dret_comment' => $this->input->post("dret_comment"),
                'dret_status' => $this->input->post("dret_status"),
                'dret_who_drug_id' => $this->input->post("dret_who_drug_id"),
                'dret_drug_stock_id' => $this->input->post("dret_drug_stock_id"),
                'dret_f_drug_stock_id' => $this->input->post("dret_f_drug_stock_id"),
                'dret_user' => $this->input->post("dret_user"),
                'dret_app_user' => $this->input->post("dret_app_user"),
                'dret_app_comment' => $this->input->post("dret_app_comment"),
                'dret_rec_comment' => $this->input->post("dret_rec_comment"),
                'drug_batchno' => $this->input->post("drug_batchno")
                
               
            ); 
            $id = $_POST[$form["OBJID"]];
            if ($id>0) {
           if( $sve_data['dret_status']=="Approve" ){ 
                                $this->load->model("mdrug_stock");
                                $this->mdrug_stock->update_drug_return($id,$_POST['dret_drug_stock_id'],$_POST['dret_f_drug_stock_id'],$_POST['dret_who_drug_id'],$_POST['dret_amount']);
                                
                            }
            }
            
            $id = $this->input->post($form["OBJID"]);
            $status = false;
			
            if ($id > 0) {
                $status = $this->mpersistent->update($frm, $form["OBJID"], $id, $sve_data);
                $this->session->set_flashdata(
                    'msg', 'REC: ' . ucfirst(strtolower($this->input->post("name"))) . ' Updated'
                );
				if ( $status){
					header("Status: 200");
					header("Location: ".site_url($form["NEXT"]));
				}
            } else {
                $status = $this->mpersistent->create($frm, $sve_data);
                $this->session->set_flashdata(
                    'msg', 'REC: ' . 'Drug Return'
                );
				if ( $status>0){
					//echo Modules::run($form["NEXT"], $status);
					//$status1 = $this->mpersistent->update('hospital','HID' , $this->session->userdata("HID"), array("Current_BHT"=>$this->input->post("BHT")));
					header("Status: 200");
					header("Location: ".site_url($form["NEXT"]));
					return;
				}
            }
            echo "ERROR in saving";
        
	}
    public function save_manual_lot_balancing(){
		 $frm = 'manual_lot_balancing';
        if (!file_exists('application/forms/' . $frm . '.php')) {
            die("Form " . $frm . "  not found");
        }
        include 'application/forms/' . $frm . '.php';
        $data["form"] = $form;
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->model("mpersistent");
        $this->form_validation->set_error_delimiters('<span class="field_error">', '</span>');
        $this->form_validation->set_rules("Attach_Name", "Attach_Name", "required");

     /*   if ($this->form_validation->run() == FALSE) {
            $error = array('Attach_Name' => "Please select Attach_Type");
            header("Status: 200");
            header("Location: " . site_url('/preference/load/manual_lot_balancing'));
        } else {
            $allowed = array('image/gif', 'image/png', 'image/jpeg', 'application/pdf');
            $mime = mysql_real_escape_string($_FILES['Attach_File']['type']);
            if (!in_array($mime, $allowed)) {
                echo 'File Type Not Allowed';
                return FALSE;
        } */
        
        



        
        //if($_POST['drug_stock_id'] != 1 ){
        $this->form_validation->set_error_delimiters('<span class="field_error">', '</span>');
        
        for ($i = 0; $i < count($form["FLD"]); ++$i) {
            $this->form_validation->set_rules(
                $form["FLD"][$i]["name"], '"' . $form["FLD"][$i]["label"] . '"', $form["FLD"][$i]["rules"]
            );
        }
        //}
        $allowed = array('image/gif', 'image/png', 'image/jpeg', 'application/pdf');
        $mime = mysql_real_escape_string($_FILES['Attach_Name']['type']);
        if (!in_array($mime, $allowed)) {
            
           $this->session->set_flashdata(
                    'msg', 'REC: ' . 'Error invalid file format'
                );
            header("Location: " . site_url('/preference/load/manual_lot_balancing'));
            return FALSE;
        }
        
        
        $this->form_validation->set_rules($form["OBJID"]);
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->vars($data);
            echo Modules::run('form/create', 'manual_lot_balancing');
        } else {

            }
    
            $file = file_get_contents($_FILES['Attach_Name']['tmp_name']); //SQL Injection defence!
            $image_name = mysql_real_escape_string($_FILES['Attach_Name']['name']);
            $size = intval($_FILES['Attach_Name']['size']);
            
            //die(print_r($_POST));
            $sve_data = array(
                'mlb_who_drug_txt' => $this->input->post("mlb_who_drug_txt"),
                'mlb_drug_stock_txt'  => $this->input->post("mlb_drug_stock_txt"),
                'mlb_amount' => strtoupper($this->input->post("mlb_amount")),
                'mlb_f_drug_stock_txt' => $this->input->post("mlb_f_drug_stock_txt"),
                'mlb_user_txt' => $this->input->post("mlb_user_txt"),
                'mlb_comment' => $this->input->post("mlb_comment"),
                'mlb_status' => $this->input->post("mlb_status"),
                'mlb_who_drug_id' => $this->input->post("mlb_who_drug_id"),
                'mlb_drug_stock_id' => $this->input->post("mlb_drug_stock_id"),
                'mlb_f_drug_stock_id' => $this->input->post("mlb_f_drug_stock_id"),
                'mlb_user' => $this->input->post("mlb_user"),
                'mlb_app_user' => $this->input->post("mlb_app_user"),
                'mlb_app_comment' => $this->input->post("mlb_app_comment"),
                'mlb_rec_comment' => $this->input->post("mlb_rec_comment"),
                'drug_batchno' => $this->input->post("drug_batchno"),
                 "Attach_File" => $file,
                "Attach_Format" => $mime,
                "Attach_Name" => $image_name,
                "Attach_Size" => $size,
                
               
            ); 
            $id = $_POST[$form["OBJID"]];
            if ($id>0) {
           if( $sve_data['mlb_status']=="Approve" ){ 
                                $this->load->model("mdrug_stock");
                                $this->mdrug_stock->update_manual_lot_balancing($id,$_POST['mlb_drug_stock_id'],$_POST['mlb_f_drug_stock_id'],$_POST['mlb_who_drug_id'],$_POST['mlb_amount']);
                                
                            }
            }
        //}
            $id = $this->input->post($form["OBJID"]);
            $status = false;
			
            if ($id > 0) {
                $status = $this->mpersistent->update($frm, $form["OBJID"], $id, $sve_data);
                $this->session->set_flashdata(
                    'msg', 'REC: ' . ucfirst(strtolower($this->input->post("name"))) . ' Updated'
                );
				if ( $status){
					header("Status: 200");
					header("Location: ".site_url($form["NEXT"]));
				}
            } else {
                $status = $this->mpersistent->create($frm, $sve_data);
                $this->session->set_flashdata(
                    'msg', 'REC: ' . 'Manual Lot Balancing'
                );
				if ( $status>0){
					//echo Modules::run($form["NEXT"], $status);
					//$status1 = $this->mpersistent->update('hospital','HID' , $this->session->userdata("HID"), array("Current_BHT"=>$this->input->post("BHT")));
					header("Status: 200");
					header("Location: ".site_url($form["NEXT"]));
					return;
				}
            }
            echo "ERROR in saving";
        
	}
        
    public function attach_view($hash) {
        $this->load->model('mpersistent');
        $data["attach"] = $this->mpersistent->open_id($hash, "manual_lot_balancing", "mlb_id");

        $this->load->vars($data);
        $this->load->view('attach_view');
    }
        
        
	public function add_ooption($qu_id){
		
	}
   private function loadMDSPager($fName) {
        $path='application/forms/' . $fName . '.php';
        require $path;
        $frm = $form;
        $columns = $frm["LIST"];
        $table = $frm["TABLE"];
        $sql = "SELECT ";

        foreach ($columns as $column) {
            $sql.=$column . ',';
        }
        $sql = substr($sql, 0, -1);
        $sql.=" FROM $table ";
        $this->load->model('mpager');
        $this->mpager->setSql($sql);
        $this->mpager->setDivId('prefCont');
        $this->mpager->setSortorder('asc');
        //set colun headings
        $colNames = array();
        foreach ($frm["DISPLAY_LIST"] as $colName) {
            array_push($colNames, $colName);
        }
        $this->mpager->setColNames($colNames);

        //set captions
        $this->mpager->setCaption($frm["CAPTION"]);
        //set row id
        $this->mpager->setRowid($frm["ROW_ID"]);

        //set column models
        foreach ($frm["COLUMN_MODEL"] as $columnName => $model) {
            if (gettype($model) == "array") {
                $this->mpager->setColOption($columnName, $model);
            }
        }

        //set actions
        $action = $frm["ACTION"];
        $this->mpager->gridComplete_JS = "function() {
            var c = null;
            $('.jqgrow').mouseover(function(e) {
                var rowId = $(this).attr('id');
                c = $(this).css('background');
                $(this).css({'background':'yellow','cursor':'pointer'});
            }).mouseout(function(e){
                $(this).css('background',c);
            }).click(function(e){
                var rowId = $(this).attr('id');
                window.location='$action'+rowId;
            });
            }";

        //report starts
        if(isset($frm["ORIENT"])){
            $this->mpager->setOrientation_EL($frm["ORIENT"]);
        }
        if(isset($frm["TITLE"])){
            $this->mpager->setTitle_EL($frm["TITLE"]);
        }

//        $pager->setSave_EL($frm["SAVE"]);
        $this->mpager->setColHeaders_EL(isset($frm["COL_HEADERS"])?$frm["COL_HEADERS"]:$frm["DISPLAY_LIST"]);
        //report endss

        $data['pager']=$this->mpager->render(false);
        $data["pre_page"] = $fName;
        $this->load->vars($data);
		$this->load->view('questionnaire');
//        return "<h1>$sql";
    }	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
