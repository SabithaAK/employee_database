<!DOCTYPE html>
<html lang="en">
<head>
  <title>Import CSV File Data into MySQL Database using PHP</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <style type="text/css">
    .panel-heading a{float: right;}
    #importFrm{margin-bottom: 20px;display: none;}
    #importFrm input[type=file] {display: inline;}
    p.flash_message {color: red;font-weight: bold;}
    .btn-group-lg>.btn, .btn-lg {
    padding: 3px 7px;
    font-size: 14px;
    line-height: 1.3333333;
    border-radius: 6px;
    }
    button.btn.btn-info.btn-lg {
    margin-left: 795px;
    /* float: right; */
    /* margin-right: 515px; */
    }
  
  </style>
</head>
<body>

<div class="container">
    <h2>Add Employee Data into MySQL Database using PHP</h2>
    <?php if($this->session->flashdata('flash_msg')){?>
    <div class="alert alert-danger">   <?php echo $this->session->flashdata('flash_msg');?> </div>
    <?php } ?>
    
    <div class="panel panel-default">
    	<div class="panel-heading">
            Employee list
            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Add Emloyee</button><a href="javascript:void(0);" onclick="$('#importFrm').slideToggle();">Import Employees</a>
        </div>
        <div class="panel-body">
            <form action="<?php echo base_url("Welcome/upload_file");?>" method="post" enctype="multipart/form-data" id="importFrm">
            <label>You can select the column values from here.  </label>
                
                <div class="form-group">
                <label>Name </label>
                <select name="name_column" id="name_column">
                <option value="0">emp_code</option>
                <option value="1">emp_name</option>
                <option value="2">emp_department</option>
                <option value="3">emp_dob</option>
                <option value="4">emp_joiningdate</option>
                </select>
                </div>
                <div class="form-group">
                <label>Employee code</label>
                <select name="emp_code_column" id="emp_code_column">
                <option value="0">emp_code</option>
                <option value="1">emp_name</option>
                <option value="2">emp_department</option>
                <option value="3">emp_dob</option>
                <option value="4">emp_joiningdate</option>
                </select>
                </div>
                <div class="form-group">
                <label>Department</label>
                <select name="dept_column" id="dept_column">
                <option value="0">emp_code</option>
                <option value="1">emp_name</option>
                <option value="2">emp_department</option>
                <option value="3">emp_dob</option>
                <option value="4">emp_joiningdate</option>
                </select>
                </div>
                <div class="form-group">
                <label>Date of Birth</label>
                <select name="dob_column" id="dob_column">
                <option value="0">emp_code</option>
                <option value="1">emp_name</option>
                <option value="2">emp_department</option>
                <option value="3">emp_dob</option>
                <option value="4">emp_joiningdate</option>
                </select>
                </div>
                <div class="form-group">
                <label>Joining Date</label>
                <select name="jdate_column" id="jdate_column">
                <option value="0">emp_code</option>
                <option value="1">emp_name</option>
                <option value="2">emp_department</option>
                <option value="3">emp_dob</option>
                <option value="4">emp_joiningdate</option>
                </select>
                </div>
                <input type="file" name="file" />
                <input type="submit" class="btn btn-primary" name="importSubmit" value="IMPORT">
            </form>
            <table class="table table-bordered">
                <thead>
                    <tr>
                      <th>Employee Code</th>
                      <th>Employee Name</th>
                      <th>Department</th>
                      <th>Age</th>
                      <th>Experience in the organization</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //get rows query
                    $query = $this->db->query("SELECT * FROM emp_details ORDER BY emp_name")->result();
                    if(count($query)>0){
                    foreach($query as $row){ ?>
                    <tr>
                      <td><?php echo $row->emp_code; ?></td>
                      <td><?php echo $row->emp_name; ?></td>
                      <td><?php echo $row->emp_department; ?></td>
                      <td><?php 
                      $dob=$row->emp_dob;
                      $diff = (date('Y') - date('Y',strtotime($dob)));
                      echo $diff;
                      ?></td>
                      
                      <td><?php 
                      $jdate =  $row->emp_joiningdate;
                      $from = strtotime($jdate);
                      $today = time();
                      $diff = abs($today - $from); 
                      $years = floor($diff / (365*60*60*24));  
                      $months = floor(($diff - $years * 365*60*60*24)/ (30*60*60*24)); 
                      $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24)); 
                      printf("%d years, %d months, %d days", $years, $months,$days);    
                      ?></td>  

                    </tr>
                    <?php } }else{ ?>
                    <tr><td colspan="5">No Employee found.....</td></tr>
                    <?php } ?>
                </tbody>
            </table>            
        </div>
    </div>
</div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
        
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Add Employee Details</h4>
            </div>
            <div class="modal-body">
                  <form action="<?php echo base_url("Welcome/add");?>" method="post" id="form1"  class="forms-sample">
                  <div class="form-group">
                  <label>Employee Code</label>	
                  <input type="text" class="form-control" placeholder="Employee Code" name="employee_code"  required="required" id="employee_code" value="" >
                      <?php echo form_error('employee_code');  ?>
                  </div>
                  <div class="form-group">
                  <label>Employee Name</label>	
                  <input type="text" class="form-control" placeholder="Employee Name" name="employee_name"  required="required" id="employee_name" value="" >
                      <?php echo form_error('employee_name');  ?>
                  </div>
                  <div class="form-group">
                  <label>Employee Department</label>	
                  <input type="text" class="form-control" placeholder="Employee Department" name="employee_department"  required="required" id="employee_department" value="" >
                      <?php echo form_error('employee_department');  ?>
                  </div>
                  <div class="form-group">
                  <label>Employee DOB</label>	
                  <input type="date" class="form-control" placeholder="Employee DOB" name="employee_dob"  required="required" id="employee_dob" value="" >
                      <?php echo form_error('employee_dob');  ?>
                  </div>
                  <div class="form-group">
                  <label>Employee Joining Date</label>	
                  <input type="date" class="form-control" placeholder="Employee Joining Date" name="employee_jdate"  required="required" id="employee_jdate" value="" >
                      <?php echo form_error('employee_jdate');  ?>
                  </div>
                  <div class="form-group">
                  <input type="submit" class="btn btn-primary" value="Submit" id="submit" >
                  </div>
            </div>
            <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          
        </div>
      </div>
<script> 
        setTimeout(function() {
            $('.alert-danger').hide('fast');
        }, 2000);
</script>
</body>
</html>