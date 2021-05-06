<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$this->load->view('employee_csv_details');
	}
	public function upload_file(){
		//take column position
		$name = $this->input->post('name_column');
		$emp_code = $this->input->post('emp_code_column');
		$emp_department = $this->input->post('dept_column');
		$emp_dob = $this->input->post('dob_column');
		$emp_joiningdate = $this->input->post('jdate_column');

		$csvMimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
	    if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$csvMimes)){
	        if(is_uploaded_file($_FILES['file']['tmp_name'])){
	            
	            //open uploaded csv file with read only mode
	            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
				$fp = file($_FILES['file']['tmp_name'], FILE_SKIP_EMPTY_LINES);
				//check file rows not exceed 20
				if(count($fp)>21)
				{
					$this->session->set_flashdata('flash_msg', 'You can only upload CSV file with maximum 20 rows.');
					redirect(base_url()); 
					return;
				}
	            if (($handle = $csvFile) !== FALSE){
					$row = fgetcsv($handle, 1000, ",");
					//$column_count= count($row);
					//print_r($row);
				    //exit;
 
				}
				$row = fgetcsv($csvFile, 1000, ",");
				$column_count= count($row);
				
				//check file columns not less than 5
				if($column_count < 4)
				{
					$this->session->set_flashdata('flash_msg', 'You can only upload CSV file with minimum 5 columns.');
					redirect(base_url()); 

				}
				//print_r($column_count);
				
	            // skip first line
	            // if your csv file have no heading, just comment the next line
	            fgetcsv($csvFile);
				
				
	            //parse data from csv file line by line
	            while(($line = fgetcsv($csvFile)) !== FALSE){
					
					
					$dateString = $line[3];
						
					$Age_Date = DateTime::createFromFormat('d/m/Y', $dateString, new DateTimeZone(('UTC')));
					
					$dob =  $Age_Date->format('Y-m-d');
					
				
					$JdateString = $line[4];
					
					$JDate = DateTime::createFromFormat('d/m/Y', $JdateString, new DateTimeZone(('UTC')));
					$joining_date =  $JDate->format('Y-m-d');
	                //check whether member already exists in database with same email
	                $result = $this->db->get_where("emp_details", array("emp_code"=>$line[0]))->result();
					if(count($result) > 0){
						//update employee data
						$this->db->update("emp_details", array("emp_name"=>$line[1], "emp_department"=>$line[2], "emp_dob"=>$dob, "emp_joiningdate"=>$joining_date), array("emp_code"=>$line[0]));
						redirect(base_url());
					}else{
						//insert employee data into database
						$this->db->insert("emp_details", array("emp_code"=>$line[0], "emp_name"=>$line[1], "emp_department"=>$line[2], "emp_dob"=>$dob, "emp_joiningdate"=>$joining_date));
						redirect(base_url());
					}
	            }
	            
	            //close opened csv file
	            fclose($csvFile);

	            $qstring["status"] = 'Success';
	        }else{
	            $qstring["status"] = 'Error';
	        }
	    }else{
	        $qstring["status"] = 'Invalid file';
	    }
	    $this->load->view('employee_csv_details',$qstring);
	}

		//Add employee using form
		public function add(){
			if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('employee_code', 'Employee Code', 'trim|required');
			$this->form_validation->set_rules('employee_name', 'Employee Name', 'trim|required');
			$this->form_validation->set_rules('employee_department', 'Employee Department', 'trim|required');
			$this->form_validation->set_rules('employee_dob', 'Employee DOB', 'trim|required');
			$this->form_validation->set_rules('employee_jdate', 'Employee Joining Date', 'trim|required');
			if($this->form_validation->run() == FALSE)
				{
				  $this->load->view('employee_csv_details'); 
				}
				
			
			else
			   {
			    $data = array(
                         'emp_code'               => $this->input->post('employee_code'),  
                         'emp_name'               => $this->input->post('employee_name'), 
                         'emp_department'         => $this->input->post('employee_department'), 
						 'emp_dob'         		  => $this->input->post('employee_dob'),  
                         'emp_joiningdate'        => $this->input->post('employee_jdate'), 
				 );	 
				 $lastID=$this->Common_model->save('emp_details',$data); 
				 $this->session->set_flashdata('flash_msg','<div class="alert alert-success text-center">Employee details added successfully.</div>');
			     redirect(base_url());
				}
			
			}
		
		
	}
}
