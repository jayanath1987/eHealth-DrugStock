
<?php
/*
--------------------------------------------------------------------------------
HHIMS - Hospital Health Information Management System
Copyright (c) 2011 Information and Communication Technology Agency of Sri Lanka
<http: www.hhims.org/>
----------------------------------------------------------------------------------
This program is free software: you can redistribute it and/or modify it under the
terms of the GNU Affero General Public License as published by the Free Software 
Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,but WITHOUT ANY 
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR 
A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along 
with this program. If not, see <http://www.gnu.org/licenses/> 




---------------------------------------------------------------------------------- 
Date : June 2016
Author: Mr. Jayanath Liyanage   jayanathl@icta.lk

Programme Manager: Shriyananda Rathnayake
URL: http://www.govforge.icta.lk/gf/project/hhims/
----------------------------------------------------------------------------------
*/

	include_once("header.php");	///loads the html HEAD section (JS,CSS)

?>
<?php echo Modules::run('menu'); //runs the available menu option to that usergroup ?>
<script language="javascript"> 

                    function add_stock(drug_count_id){
                        
                        var inpdrgi = parseInt($(String("#inpdrgi_"+drug_count_id)).val());
                        var hdrug = parseInt($(String("#hdrug")).val());     
                        var AddCount = parseInt($(String("#inp_"+drug_count_id)).val());
			var who_drug_count = parseInt($(String("#inp_"+drug_count_id)).val());
                        var who_remain_count = parseInt($(String("#inp_"+drug_count_id)).val());
			var current_count = $("#cell_"+drug_count_id).html();
                        var remain_count = $("#ajxcell_"+drug_count_id).html();
                        var ajremain;
                        var hdrug_S = parseInt($(String("#hdrug_"+drug_count_id)).val());
                        var pid = parseInt($(String("#pid_"+drug_count_id)).val());
                        
			if (current_count==""){
				current_count =0;
			}
                        if (remain_count==""){
				remain_count =0;
			}
                        
                        if(AddCount <= 0){
                            alert("Invalid Add Stock Amount");
                            return false;
                        }
                        
                        if(hdrug != 1){
                        if(remain_count < AddCount ){
                            alert("Invalid Add Stock Amount");
                            return false;
                        }
                        
                             ajremain = parseInt(parseInt(remain_count) - parseInt(AddCount));
                             
                        }
                        else{
                            ajremain = parseInt(parseInt(remain_count) + parseInt(AddCount));
                             
                        }
                        
			if (who_drug_count){
				who_drug_count = parseInt(parseInt(+who_drug_count)+parseInt(+current_count));
                                //remain_count = parseInt(parseInt(+who_remain_count)+parseInt(+remain_count));
                                
				var request = $.ajax({
					url: "<?php echo base_url(); ?>index.php/drug_stock/add_stock/",
					type: "post",
					data:{"drug_count_id":drug_count_id,"who_drug_count":who_drug_count,"who_remain_count":remain_count, "hdrug" : hdrug, "AddCount":AddCount, "inpdrgi":inpdrgi, "hdrug_S":hdrug_S,"pid":pid}
				});
				request.done(function (response, textStatus, jqXHR){
                                    if(response == drug_count_id){
                                            //console.log(ajremain);
						$("#cell_"+response).html(who_drug_count).removeClass("label-warning").addClass("label-success");
                                                $("#ajxcell_"+response).html(ajremain).removeClass("label-warning").addClass("label-success");
						$("#inp_"+response).val("");
					}
				});
			}
		}
                
                
                
                function remove_stock(drug_count_id){
                        var inpdrgi = parseInt($(String("#inpdrgi_"+drug_count_id)).val());
                        var hdrug = parseInt($(String("#hdrug")).val());     
                        var AddCount = parseInt($(String("#inp2_"+drug_count_id)).val());
			var who_drug_count = parseInt($(String("#inp2_"+drug_count_id)).val());
                        var who_remain_count = parseInt($(String("#inp2_"+drug_count_id)).val());
			var current_count = $("#cell_"+drug_count_id).html();
                        var remain_count = $("#ajxcell_"+drug_count_id).html();
                        var hdrug_S = parseInt($(String("#hdrug_"+drug_count_id)).val());
                        
			if (current_count==""){
				current_count =0;
			}
                        if (remain_count==""){
				remain_count =0;
			}
                        
			if (who_drug_count){
				who_drug_count = parseInt(parseInt(+who_drug_count)+parseInt(+current_count));
                                //remain_count = parseInt(parseInt(+who_remain_count)+parseInt(+remain_count));
                                
				var request = $.ajax({
					url: "<?php echo base_url(); ?>index.php/drug_stock/remove_stock/",
					type: "post",
					data:{"drug_count_id":drug_count_id,"who_drug_count":who_drug_count,"who_remain_count":remain_count, "hdrug" : hdrug, "AddCount":AddCount, "inpdrgi":inpdrgi, "hdrug_S":hdrug_S}
				});
				request.done(function (response, textStatus, jqXHR){
					if(response == drug_count_id){
						$("#cell_"+response).html(who_drug_count).removeClass("label-warning").addClass("label-success");
                                                $("#ajxcell_"+response).html(remain_count).removeClass("label-warning").addClass("label-success");
						$("#inp_"+response).val("");
					}
				});
			}
		}
                
                function add_stock_active(drug_count_id){
                        var dcid = drug_count_id;
                        
			var who_drug_count = parseInt($(String("#inp_"+dcid)).val());
			//var current_count = $("#chk_"+drug_count_id).html();
                        var flage = 0;
                        if (document.getElementById("chk_"+dcid).checked){
                            flage = 1;
                        }    
                   			//who_drug_count = parseInt(parseInt(+who_drug_count)+parseInt(+current_count));
				var request = $.ajax({
					url: "<?php echo base_url(); ?>index.php/drug_stock/add_stock_active/",
					type: "post",
					data:{"drug_count_id":dcid,"flage":flage}
				});
				 request.done(function (response, textStatus, jqXHR){
					if(response == drug_count_id){
						$("#cell_"+response).html(who_drug_count).removeClass("label-warning").addClass("label-success");
						$("#inp_"+response).val("");
					}
				}); 
			
		} 
                
	</script>
	<div class="container" style="width:95%;">
		<div class="row" style="margin-top:55px;">
		  <div class="col-md-2 ">
			<?php //echo Modules::run('leftmenu/questionnaire'); //runs the available left menu for preferance ?>
			<?php 
					echo Modules::run('leftmenu/preference'); //runs the available left menu for preferance 
			?>
		  </div>
                    
		  <div class="col-md-10 ">
		  		<?php 
					if (isset($error)){
						echo '<div class="alert alert-danger"><b>ERROR:</b>'.$error.'</div>';
						exit;
					}
					
				?>		  
				<div class="panel panel-default"  >
					<div class="panel-heading"><b>Stock Management </b>
					</div>
					<div class="well well-sm">
						<?php
							if ( empty($drug_stock_list)) {
									echo 'No stock available. <a href="'.site_url("form/create/drug_stock?CONTINUE=drug_stock/view").'">Add a new stock</a>';
							}
							else{
								echo '<b>Available stocks</b>';
                                                               if($this->session->userdata['UserGroup']=='Programmer') echo '<a class="pull-right btn-xs btn-warning" href="'.site_url("form/create/drug_stock?CONTINUE=drug_stock/view").'">Add new</a>';
								if ($this->config->item('purpose') !="PP"){
									echo '<br><br> Please select one of the below stock to see the drugs inventory detail.';
								}else{
									echo '<br><br> OPD drugs inventory detail.';
								}
								echo '<div>';
								for ($i =0; $i<count($drug_stock_list); ++$i){
									echo '<a class=" btn ';
									if (isset($drug_stock_info) && ($drug_stock_info["drug_stock_id"]==$drug_stock_list[$i]["drug_stock_id"]) ){
										echo ' btn-success ';
									}
									else{
										echo ' btn-default ';
									}
									echo ' "';
									echo ' href="'.site_url("drug_stock/view/".$drug_stock_list[$i]["drug_stock_id"]).'">'.$drug_stock_list[$i]["name"].'</a>&nbsp;';
								}
								echo '</div>';
							}
							
						?>
						
					</div>
				</div>
                      
				<div class="panel panel-default"  >
                                    <input  id="hdrug" type="hidden" value='<?php echo $drug_count_list[$i]["drug_stock_id"]; ?>' >
					<div class="panel-heading"><b>
					<?php
						if (isset($drug_stock_info)){                                                                                                                                                     // drug_stock_id                                             
							echo $drug_stock_info["name"].'&nbsp;';
                                                        echo 'Stock inventory </b>';
                                                        //echo '<b style="float:right;color:red;" > This will show only Active Drugs &nbsp &nbsp<a class="pull-right btn-xs btn-warning" href="'.site_url("drug_stock/viewall/".$drug_count_list[$i]["drug_stock_id"]).'">Load All</a></b>';
						}
                                                
					?>
					
					</div>
					<?php
						if (!empty($drug_count_list)){
                                                        echo '<input id="searchInput" value="Type To Filter"   style="width: 950px; border-color: #9ecaed; box-shadow: 0 0 10px #9ecaed;" >';
							echo '<table class="table table-condensed table-bordered table-striped table-hover">';
								echo '<tr>';
									echo '<th style="font-weight:bold">';
									echo 'Drug Name';
									echo '</th>';
									echo '<th style="font-weight:bold">';
									echo 'Stock';
									echo '</th>';
                                                                        
                                                                        //if($drug_count_list[$i]["drug_stock_id"] == "1"){
                                                                        echo '<th style="font-weight:bold">';
									echo 'Remain Stock';
									echo '</th>';
                                                                       
                                                                       /* }else{
                                                                        echo '<th>';
									echo 'Return Stock';
									echo '</th>';    
                                                                        echo '<th>';
									echo 'Add Stock';
									echo '</th>';    
                                                                        }*/
                                                                        
									//echo '<th>';
									//echo 'Option';
									//echo '</th>';
                                                                        //if($drug_count_list[$i]["drug_stock_id"] != "1"){
                                                                        //echo '<th style="font-weight:bold">';
									//echo 'Return Stock';
									//echo '</th>';
                                                                        //}
                                                                         echo '<th style="font-weight:bold">';
									echo 'Add Stock';
									echo '</th>';
                                                                        echo '<th style="font-weight:bold">';
									echo 'Active';
									echo '</th>';
								//$dataNumRows = isset($drug_count_list['counts']) ? $drug_count_list['counts']:0;
                                                                echo '<tbody id="fbody">';
								for ($i=0; $i < count($drug_count_list) && $i < count($drug_count_list_remain); $i++){
                                                                    
                                                                    //if(isset($drug_count_list['counts']) ? $drug_count_list['counts']:0){
									echo '<tr>';
									echo '<td>';
									echo $drug_count_list[$i]["name"];
									echo '-';
									echo $drug_count_list[$i]["formulation"];
									echo '-';
									echo $drug_count_list[$i]["dose"];
									echo '</td>';
									 
                                                                      //  if($drug_count_list[$i]["drug_stock_id"] == "1"){
                                                                        echo '<td >';
										echo '<span id="cell_'.$drug_count_list[$i]["drug_count_id"].'"  ';
											if ($drug_count_list[$i]["who_drug_count"] > $this->config->item('drug_alert_count')){
												echo ' class="label label-success">';
											}
											else{
												echo ' class="label label-warning">';
											}
												echo $drug_count_list[$i]["who_drug_count"];
										echo '</span>';
									echo '</td>'; 
                                                                       
                                                                        echo '<td>';
                                                                       
                                                                            echo '<input  id="hdrug_'.$drug_count_list[$i]["drug_count_id"].'" type="hidden" value='.$drug_count_list_remain[$i]["drug_count_id"]. ' >';
                                                                            echo '<span id="ajxcell_'.$drug_count_list[$i]["drug_count_id"].'"  class="label label-success">';                                                                                                                                                      
                                                                            echo $drug_count_list_remain[$i]["who_drug_remain"];
                                                                            echo '</span>';
                                                               
                                                                        echo '</td>';
                                                                        
                                                                
                                                                        //if($drug_count_list[$i]["drug_stock_id"] != "1"){                              
                                                                        // echo '<td >';
									//	echo ' <input  id="inp2_'.$drug_count_list[$i]["drug_count_id"].'" type="number" class=""  min=0 step=100 value="" style="width: 100px;" >';
									//	echo ' <input  id="btn2_'.$drug_count_list[$i]["drug_count_id"].'" type="button" onclick=remove_stock('.$drug_count_list[$i]["drug_count_id"].') class="btn btn-default btn-sm" value="Return" >';
									//echo '</td>';
                                                                        //}
									echo '<td >';
                                                                                echo ' <input  id="inpdrgi_'.$drug_count_list[$i]["drug_count_id"].'" type="hidden" class=""  value="'.$drug_count_list[$i]["who_drug_id"].'" style="width: 100px;" >';
										echo ' <input  id="inp_'.$drug_count_list[$i]["drug_count_id"].'" type="number" class=""  min=0 step=100 value="" style="width: 100px;" >';
										echo ' <input  id="btn_'.$drug_count_list[$i]["drug_count_id"].'" type="button" onclick=add_stock('.$drug_count_list[$i]["drug_count_id"].') class="btn btn-default btn-sm" value="Add" >';
									echo '</td>';
                                                                        echo '<td >';
                                                                                echo ' <input  id="chk_'.$drug_count_list[$i]["drug_count_id"].'" type="checkbox" class=""   step=100 onclick=add_stock_active("'.$drug_count_list[$i]["drug_count_id"].'") '; if($drug_count_list[$i]["Active"]== "1"){ echo 'checked=checked;'; } echo '>';
										//echo ' <input  id="btn_'.$drug_count_list[$i]["drug_count_id"].'" type="button" onclick=add_stock("'.$drug_count_list[$i]["drug_count_id"].'") class="btn btn-default btn-sm" value="Add" >';
									echo '</td>';
								echo '</tr>';
                                                                //}
								}
                                                                
							echo "</tbody></table>";
                                                        
						}
						
					?>
				</div>
			</div>
		</div>
	</div>
	
<script type="text/javascript">
            
            $("#searchInput").keyup(function () { 
    //split the current value of searchInput
    var data = this.value.split(" ");
    //create a jquery object of the rows
    var jo = $("#fbody").find("tr");
    if (this.value == "") {
        jo.show();
        return;
    }
    //hide all the rows
    jo.hide();

    //Recusively filter the jquery object to get results.
    jo.filter(function (i, v) {
        var $t = $(this);
        for (var d = 0; d < data.length; ++d) {
            if ($t.is(":contains('" + data[d] + "')")) {
                return true;
            }
        }
        return false;
    })
    //show the rows that match.
    .show();
}).focus(function () {
    this.value = "";
    $(this).css({
        "color": "black"
    });
    $(this).unbind('focus');
}).css({
    "color": "#C0C0C0"
});
            
        </script>    	