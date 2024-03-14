<div class="wrapper">
    <?php if(session()->has('success')): ?>
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo session()->getFlashdata('success'); ?>
    </div>
    <?php elseif(session()->has('error')): ?>
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo session()->getFlashdata('error'); ?>
    </div>
    <?php endif; ?>
    <div class="page-title">
        <h1>Add Standard User</h1>
    </div>
    <div class="wrapper-content">
        <form id="standarduserFormAdd" method="post" action="<?php echo base_url('standardUsers/add'); ?>" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="lableTitle" for="projectId">Select Project :<span class="asterisk-sign">*</span></label>
                        <select class="form-control selectpicker" id="projectId" name="projectId[]" multiple="multiple" data-live-search="true">
                            <option value="">-- Select Project --</option>
							<option value="0" selected>None</option>
                            <?php 
                            if(!empty($projects)){ 
                                foreach ($projects as $key => $value) { ?>
                                    <option value="<?php echo $value['id']; ?>"><?php echo $value['projectName']; ?></option>
                            <?php                                                
                                }
                            } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="lableTitle" for="templateTypes">Select Templates :</label>
                        <select class="form-control selectpicker" id="templateTypes" name="templateTypes[]" multiple="multiple" data-live-search="true">
                            <option value="">-- Select Templates --</option>
							<option value="0" selected>None</option>
                            <?php 
                            if(!empty($templateTypes)){ 
                                foreach ($templateTypes as $key => $value) { ?>
                                    <option value="<?php echo $value['id']; ?>"><?php echo $value['templateName']; ?></option>
                            <?php                                                
                                }
                            } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="lableTitle" for="firstName">First Name :<span class="asterisk-sign">*</span></label>
                        <input type="text" name="firstName" class="form-control" id="firstName" placeholder="First Name">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="lableTitle" for="lastName">Last Name :<span class="asterisk-sign">*</span></label>
                        <input type="text" name="lastName" class="form-control" id="lastName" placeholder="Last Name">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="lableTitle" for="email">Email Address :<span class="asterisk-sign">*</span></label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6" id="designationDiv">
                    <div class="form-group">
                        <label class="lableTitle" for="designation">Designation :<span class="asterisk-sign"></span></label>
                        <select class="form-control selectpicker" id="designation" name="designation" data-live-search="true">
                            <option value="">-- Select Designation --</option>
                            <?php foreach($designationList as $list){?>
                                <option value="<?php echo $list['title']?>"><?php echo $list['title']?></option>
                            <?php }?>
                            <option value="other">Custom Designation</option>
                        </select>                        
                    </div>
                </div>
                <div class="col-md-4" id="cutomDesignationDiv" style="display: none;">
                    <div class="form-group">
                        <label class="lableTitle" for="cutomDesignation">Custom Designation</label>
                        <input type="text" name="cutomDesignation" class="form-control" id="cutomDesignation" placeholder="Custom Designation">
                    </div>
                </div>
                <div class="col-md-6" id="phoneDiv">
                    <div class="form-group">
                        <label class="lableTitle" for="phoneNumber">Phone Number :<span class="asterisk-sign">*</span></label>
                        <input type="text" name="phoneNumber" class="form-control" id="phoneNumber" placeholder="Phone Number">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="lableTitle" for="address">Address :<span class="asterisk-sign">*</span></label>
                        <!-- <textarea name="address" class="form-control" id="address" placeholder="Address" value=""></textarea> -->
                        <input type="text" name="address" class="form-control" id="address" placeholder="Enter your address">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="lableTitle" for="country">Country :<span class="asterisk-sign">*</span></label>
                        <select class="form-control selectpicker" name="country" id="country" data-live-search="true" onchange="getStates(this.value)">
                            <option value="">-- Select Country --</option>
                            <?php
                            $countryId = 38;
                            if(!empty($countryList)){
                                foreach ($countryList as $key => $value) { ?>
                                    <option value="<?php echo $value['country_id']; ?>" <?php echo ($countryId==$value['country_id'])?"selected":''; ?>>
                                        <?php echo $value['short_name']; ?>
                                    </option>
                            <?php
                                }
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="lableTitle" for="province">Province :<span class="asterisk-sign">*</span></label>
                        <select class="form-control selectpicker" name="province" id="province" data-live-search="true">
                            <option value="">-- Select Province --</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="lableTitle" for="city">City :<span class="asterisk-sign">*</span></label>
                        <input type="text" name="city" class="form-control" id="city" placeholder="City" value="Toronto">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="lableTitle" for="postalCode">Postal Code :<span class="asterisk-sign">*</span></label>
                        <input type="text" name="postalCode" class="form-control" id="postalCode" placeholder="Postal Code" value="">
                        <input type="hidden" name="latitude" class="form-control" id="latitude">
                        <input type="hidden" name="longitude" class="form-control" id="longitude">
                        <input type="hidden" name="filterByAddress" class="form-control" id="filterByAddress">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="lableTitle" for="pwd">Password :<span class="asterisk-sign">*</span></label>
                        <input type="password" name="pwd" class="form-control" id="pwd" placeholder="Password">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="lableTitle" for="conpassword">Confirm Password :<span class="asterisk-sign">*</span></label>
                        <input type="password" name="conpassword" class="form-control" id="conpassword" placeholder="Confirm Password">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="lableTitle" for="profilePic">User Photo :</label>
                        <span>(We accept .JPG / .PNG / .GIF / .JPEG)</span>
                        <div id="dropzone" class="dropzone"></div>
                        <input type="hidden" name="fileId" id="fileId">
                        <!-- <div class="kv-avatar">
                            <div class="file-loading">
                                <input id="profilePic" name="profilePic" type="file">
                            </div>
                            </br>
                            <?php
                                $img_thumnail = '';
                                $img_thumnail = base_url('assets/images/default.png'); ?>
                            <img style="border: 1px solid #eee; padding: 5px;" id="thumbnail_img" width="100" height="100" src="<?php echo $img_thumnail; ?>">
                        </div> -->
                        <label class="lableTitle" id="image-error" class="error" for="profilePic"></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="lableTitle" for="username">Active/InActive :</label>
                    <div class="form-group form-check">
                        <input type="checkbox" name="isActive" class="form-check-input" id="isActive">
                        <label class="form-check-label" for="isActive">is Active</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-info">Submit</button>
            <a href="<?php echo base_url('standard-users'); ?>" type="button" class="btn btn-warning">Back</a>
        </form>
    </div>
</div>
</div>
<script type="text/javascript">
$('#administrationMainMenu').addClass('activAcc');
$('#administrationSubMenu').css('display','block');
$('#standardUsersMainMenu').addClass('active');
$(document).ready(function() {
    $('#projectId').selectpicker();
});
getStates(38);
function getStates(cid){
    var base_url = "<?php echo base_url(); ?>";

    // console.log(cid);
    $.ajax({
        type: "POST",
        // dataType:'json',
        url: base_url + "/getProviance",
        data: { 'cid': cid },
        success: function(res) {
            // console.log(res);
            $('#province').html(res);
            $('select[name=province]').val(671);            
            $('#province').selectpicker('refresh');            
        }
    });
}

$( document ).ready(function() {
    setTimeout(function(){
        document.getElementById('email').value = "";
        document.getElementById('pwd').value = "";
    }, 800);
});

$('#designation').on('change', function(){
    var desOption = $(this).val();
    if(desOption == 'other'){
        $('#designationDiv').removeClass('col-md-6');
        $('#designationDiv').addClass('col-md-4');

        $('#phoneDiv').removeClass('col-md-6');
        $('#phoneDiv').addClass('col-md-4');
        $('#cutomDesignationDiv').show();
    }else{
        $('#designationDiv').removeClass('col-md-4');
        $('#designationDiv').addClass('col-md-6');

        $('#phoneDiv').removeClass('col-md-4');
        $('#phoneDiv').addClass('col-md-6');

        $('#cutomDesignationDiv').hide();
    }
});
</script>
<script src="<?php echo base_url('assets/js/adminFormValidation.js?v=').time() ?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAP_API_KEY; ?>&libraries=places"></script>