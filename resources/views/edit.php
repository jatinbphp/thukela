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
        <h1>Edit Standard User <span style="float: right;">#<?php echo $user_info['id']; ?></span></h1>
    </div>
    <div class="wrapper-content">
        <form id="standarduserFormEdit" method="post" action="<?php echo base_url('standardUsers/edit/'.$user_info['id']); ?>" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $user_info['id']; ?>">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="lableTitle" for="projectId">Select Project :<span class="asterisk-sign">*</span></label>
                        <select class="form-control selectpicker" id="projectId" name="projectId[]" multiple="multiple" data-live-search="true">
                            <option value="">-- Select Project --</option>
                            <?php 
                            if(!empty($projects)){ 
                                foreach ($projects as $key => $value) { ?>
                                    <option value="<?php echo $value['id']; ?>" <?php if(in_array($value['id'], explode(",", $user_info['projectId']))){ echo "selected"; } ?>><?php echo $value['projectName']; ?></option>
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
                            <?php 
                            if(!empty($templateTypes)){ 
                                foreach ($templateTypes as $key => $value) { ?>
                                    <option value="<?php echo $value['id']; ?>" <?php if(in_array($value['id'], explode(",", $user_info['templateTypes']))){ echo "selected"; } ?>><?php echo $value['templateName']; ?></option>
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
                        <input type="text" name="firstName" class="form-control" id="firstName" placeholder="First Name" value="<?php echo $user_info['firstName']; ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="lableTitle" for="lastName">Last Name :<span class="asterisk-sign">*</span></label>
                        <input type="text" name="lastName" class="form-control" id="lastName" placeholder="Last Name" value="<?php echo $user_info['lastName']; ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="lableTitle" for="email">Email Address :<span class="asterisk-sign">*</span></label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="<?php echo $user_info['email']; ?>">
                        <input type="hidden" name="old_email" id="old_email" value="<?php echo $user_info['email']; ?>">
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
                                <option value="<?php echo $list['title']?>" <?php echo $user_info['designation'] == $list['title'] ? 'selected' : ''; ?> ><?php echo $list['title'] ?></option>
                            <?php }?>
                            <option value="other" <?php echo !in_array($user_info['designation'],$designationArr) ? 'selected' : ''; ?>>Custom Designation</option>
                        </select>                        
                    </div>
                </div>
                <div class="col-md-4" id="cutomDesignationDiv" style="display: <?php echo in_array($user_info['designation'],$designationArr) ? 'none' : 'block'; ?>;">
                    <div class="form-group">
                        <label class="lableTitle" for="cutomDesignation">Custom Designation</label>
                        <input type="text" name="cutomDesignation" class="form-control" id="cutomDesignation" placeholder="Custom Designation" value="<?php echo $user_info['designation']; ?>">
                    </div>
                </div>
                <div class="<?php echo in_array($user_info['designation'],$designationArr) ? 'col-md-6' : 'col-md-4'; ?>" id="phoneDiv">
                    <div class="form-group">
                        <label class="lableTitle" for="phoneNumber">Phone Number :<span class="asterisk-sign">*</span></label>
                        <input type="text" name="phoneNumber" class="form-control" id="phoneNumber" placeholder="Phone Number" value="<?php echo $user_info['phoneNumber']; ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="lableTitle" for="address">Address :<span class="asterisk-sign">*</span></label>
                        <!-- <textarea name="address" class="form-control" id="address" placeholder="Address" value=""><?php echo $user_info['location']; ?></textarea> -->

                        <input type="text" name="address" class="form-control" id="address" placeholder="Enter your address" value="<?php echo $user_info['location']; ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="lableTitle" for="country">Country :<span class="asterisk-sign">*</span></label>
                        <select class="form-control selectpicker" name="country" id="country" data-live-search="true">
                            <option value="">-- Select Country --</option>
                            <?php
                                if(!empty($countryList)){
                                    foreach ($countryList as $key => $value) {
                                ?>
                            <option value="<?php echo $value['country_id']; ?>" <?php echo ($user_info['country']==$value['country_id'])?"selected":''; ?>>
                                <?php echo $value['short_name']; ?>
                            </option>
                            <?php
                                    }
                                }
                                ?>
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
                        <input type="text" name="city" class="form-control" id="city" placeholder="City" value="<?php echo $user_info['city']; ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="lableTitle" for="postalCode">Postal Code :<span class="asterisk-sign">*</span></label>
                        <input type="text" name="postalCode" class="form-control" id="postalCode" placeholder="Postal Code" value="<?php echo $user_info['postalCode']; ?>">
                        <input type="hidden" name="latitude" class="form-control" id="latitude" value="<?php echo $user_info['latitude']; ?>">
                        <input type="hidden" name="longitude" class="form-control" id="longitude" value="<?php echo $user_info['longitude']; ?>">
                        <input type="hidden" name="filterByAddress" class="form-control" id="filterByAddress">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="lableTitle" for="pwd">Password :</label>
                        <input type="password" name="pwd" class="form-control" id="pwd" placeholder="Password">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="lableTitle" for="conpassword">Confirm Password :</label>
                        <input type="password" name="conpassword" class="form-control" id="conpassword" placeholder="Confirm Password">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="lableTitle" for="profilePic">User Photo :<span class="asterisk-sign">*</span></label>
                        <span>(We accept .JPG / .PNG / .GIF / .JPEG)</span>
                        <!-- <input type="file" class="form-control" name="profilePic" id="profilePic" > -->
                        <div id="dropzone" class="dropzone"></div>
                        <input type="hidden" name="fileId" id="fileId">
                        <input type="hidden" class="form-control" name="hidden_profilePic" id="hidden_image" value="<?php if (!empty($user_info['profilePic'])){ echo $user_info['profilePic']; } ?>">
                        
                        <!-- <?php
                            $img_thumnail = '';
                            if (!empty($user_info['profilePic'])){
                                $img_thumnail = base_url('uploads/users/'.$user_info['profilePic']);
                            } else {
                                $img_thumnail = base_url('assets/images/default.png');
                            } ?>
                        <img style="border: 1px solid #eee; padding: 5px;" id="thumbnail_img" width="100" height="100" src="<?php echo $img_thumnail; ?>"> -->
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="lableTitle" for="username">Active/InActive :</label>
                    <div class="form-group form-check">
                        <input type="checkbox" name="isActive" class="form-check-input" id="isActive" <?php echo ($user_info['isActive']==1)?"checked":""; ?>>
                        <label class="form-check-label" for="isActive">is Active</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-info">Update</button>
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
$(document).on('change', '#country', function() {
    var base_url = "<?php echo base_url(); ?>";
    var cid = $(this).val();

    // console.log(cid);
    $.ajax({
        type: "POST",
        // dataType:'json',
        url: base_url + "/getProviance",
        data: { 'cid': cid },
        success: function(res) {

            if($("#filterByAddress").val()==''){
                // console.log(res);
                $('#province').html(res);
                $('#province').selectpicker('refresh');
            }
        }
    });
});

function getProviance() {
    var base_url = "<?php echo base_url(); ?>";
    var cid = $('#country').val();
    var esid = "<?php echo $user_info['country']; ?>";
    // console.log(cid);
    $.ajax({
        type: "POST",
        // dataType:'json',
        url: base_url + "/getProvianceByCountry",
        data: { 'cid': cid, 'esid': esid },
        success: function(res) {
            // console.log(res);
            $('#province').html(res);
            $('#province').selectpicker('val', "<?php echo $user_info['province']; ?>");
            $('#province').selectpicker('refresh');
        }
    });
}

getProviance();

$( document ).ready(function() {
    setTimeout(function(){
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
        $('#cutomDesignation').val('');
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