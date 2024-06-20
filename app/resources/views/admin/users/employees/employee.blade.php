@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{ url('/') }}/admin"><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item"><a href="{{ url('/') }}/admin/users-and-permissions">Users & Permissions</a></li>
					<li class="breadcrumb-item"><a href="{{ url('/') }}/admin/users-and-permissions/employees">{{$PageTitle}}</a></li>
					<li class="breadcrumb-item">@if($isEdit) Update @else Create @endif</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<div class="container-fluid mt-40">
	<div class="row d-flex justify-content-center">
		<div class="col-sm-7">
			<div class="row">
				<div class="col-sm-12">
					<div class="card">
						<div class="card-header text-center">
							<div class="form-row align-items-center">
								<div class="col-md-4">	</div>
								<div class="col-md-4 my-2">
									<h5>{{$PageTitle}}</h5>
								</div>
								<div class="col-md-4 my-2 text-right text-md-right"></div>
							</div>
						</div>
						<div class="card-body">
                            <div class="row  d-flex justify-content-center">
                                <div class="col-sm-4">
                                    <input type="file" id="txtProfileImage" class="imageScrop" data-remove="0" data-is-profile-image="1" data-default-file="<?php if($isEdit==true){if($EditData[0]->ProfileImage !=""){ echo url('/')."/".$EditData[0]->ProfileImage;}}?>"  data-allowed-file-extensions="jpeg jpg png gif bmp webp" />
                                    <span class="errors" id="txtProfileImage-err"></span>
                                </div>
                            </div>
                            <div class="row mt-20">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="txtFirstName">First Name <span class="required">*</span></label>
                                        <input type="text" id="txtFirstName" class="form-control" placeholder="First Name" value="<?php if($isEdit==true){ echo $EditData[0]->FirstName;} ?>">
                                        <span class="errors err-sm" id="txtFirstName-err"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="txtLastName">Last Name </label>
                                        <input type="text" id="txtLastName" class="form-control " placeholder="Last Name" value="<?php if($isEdit==true){ echo $EditData[0]->LastName;} ?>">
                                        <span class="errors  err-sm" id="txtLastName-err"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="txtAddress">Address </label>
                                        <textarea class="form-control" placeholder="Address" id="txtAddress" name="Address" rows="3" ><?php if($isEdit==true){ echo $EditData[0]->Address;} ?></textarea>
                                        <span class="errors err-sm" id="txtAddress-err"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lstCountry">Country <span class="required">*</span></label>
                                        <select class="form-control select2" id="lstCountry" data-selected="<?php if($isEdit){echo $EditData[0]->CountryID;}else{ echo $Company['CountryID'];} ?>">
                                            <option value="">Select a Country</option>
                                        </select>
                                        <span class="errors err-sm" id="lstCountry-err"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lstState">State <span class="required">*</span></label>
                                        <select class="form-control select2" id="lstState"  data-selected="<?php if($isEdit){echo $EditData[0]->StateID;}else{ echo $Company['StateID'];} ?>">
                                            <option value="">Select a State</option>
                                        </select>
                                        <span class="errors err-sm" id="lstState-err"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lstCity">City <span class="required">*</span></label>
                                        <select class="form-control select2" id="lstCity" data-selected="<?php if($isEdit){ echo $EditData[0]->CityID;}else{echo $Company['CityID'];} ?>">
                                            <option value="">Select a City</option>
                                        </select>
                                        <span class="errors err-sm" id="lstCity-err"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lstPostalCode">Postal Code <span class="required">*</span></label>
                                        <select class="form-control select2Tag" id="lstPostalCode"  data-selected="<?php if($isEdit){echo $EditData[0]->PostalCodeID;}else{echo $Company['PostalCodeID'];} ?>">
                                            <option value="">Select a Postal Code Or enter</option>
                                        </select>
                                        <span class="errors err-sm" id="lstPostalCode-err"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lstGender">Gender {{-- <span class="required">*</span> --}}</label>
                                        <select class="form-control select2" id="lstGender" data-selected="<?php if($isEdit){ echo $EditData[0]->GenderID;} ?>">
                                            <option value="">Select a Gender</option>
                                        </select>
                                        <span class="errors err-sm" id="lstGender-err"></span>
                                    </div>
                                </div><div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dtpDOB">D.O.B </label>
                                        <input type="date" id="dtpDOB" class="form-control" value="<?php if($isEdit==true){ echo $EditData[0]->DOB;} ?>">
                                        <span class="errors err-sm" id="dtpDOB-err"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lstUserRole">Role <span class="required">*</span></label>
                                        <select class="form-control select2" id="lstUserRole" data-selected="<?php if($isEdit){ echo $EditData[0]->RoleID;} ?>">
                                            <option value="">Select a Role</option>
                                        </select>
                                        <span class="errors err-sm" id="lstUserRole-err"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lstDept">Deparment <span class="required">*</span></label>
                                        <select class="form-control select2" id="lstDept" data-selected="<?php if($isEdit){ echo $EditData[0]->DeptID;} ?>" @if($isEdit && $EditData[0]->Dept == 'CEO') disabled @endif>
                                            @if($isEdit && $EditData[0]->Dept == 'CEO')
                                                <option value="{{$EditData[0]->DeptID}}">CEO</option>
                                            @endif
                                        </select>
                                        <span class="errors err-sm" id="lstDept-err"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lstDesignation">Designation <span class="required">*</span></label>
                                        <select class="form-control select2" id="lstDesignation" data-selected="<?php if($isEdit){ echo $EditData[0]->Designation;} ?>" @if($isEdit && $EditData[0]->Dept == 'CEO') disabled @endif>
                                            @if($isEdit && $EditData[0]->Dept == 'CEO')
                                                <option value="CEO">CEO</option>
                                            @endif
                                        </select>
                                        <span class="errors err-sm" id="lstDesignation-err"></span>
                                    </div>
                                </div>
                                {{-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lstLevel">Level <span class="required">*</span></label>
                                        <select class="form-control select2" id="lstLevel" data-selected="<?php if($isEdit){ echo $EditData[0]->Level;} ?>">
                                            @if($isEdit && $EditData[0]->Designation == 'CEO') 
                                                <option value="1" selected >1</option> 
                                            @else
                                                <option value="2" @if($isEdit && $EditData[0]->Level == '2') selected @endif>2</option>
                                                <option value="3" @if($isEdit && $EditData[0]->Level == '3') selected @endif>3</option>
                                                <option value="4" @if($isEdit && $EditData[0]->Level == '4') selected @endif>4</option>
                                                <option value="5" @if($isEdit && $EditData[0]->Level == '5') selected @endif>5</option>
                                                <option value="6" @if($isEdit && $EditData[0]->Level == '6') selected @endif>6</option>
                                            @endif
                                        </select>
                                        <span class="errors err-sm" id="lstLevel-err"></span>
                                    </div>
                                </div> --}}
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="txtEmail">Email <span class="fs-10 fw-500" style="color:#ab9898">(User Name) </span> <span class="required">*</span></label>
                                        <input type="email" id="txtEmail" class="form-control" placeholder="E-Mail" value="<?php if($isEdit==true){ echo $EditData[0]->EMail;} ?>">
                                        <span class="errors err-sm" id="txtEmail-err"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="txtMobileNumber"> MobileNumber <span class="required">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text" id="CallCode">+91</span></div>
                                            <input type="number" id="txtMobileNumber" class="form-control" data-length="0" placeholder="Mobile Number enter without country code"  value="<?php if($isEdit==true){ echo $EditData[0]->MobileNumber;} ?>">
                                        </div>
                                        
                                        <span class="errors err-sm" id="txtMobileNumber-err"></span>
                                    </div>
                                </div>
                                @if($isEdit==false)
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="txtPassword">Password <span class="required">*</span></label>
                                        <input type="password" id="txtPassword" class="form-control" placeholder="Password" value="<?php if($isEdit==true){ echo $EditData[0]->EMail;} ?>">
                                        <span class="errors err-sm" id="txtPassword-err"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="txtConfirmPassword">Confirm Password <span class="required">*</span></label>
                                        <input type="password" id="txtConfirmPassword" class="form-control" placeholder="Confirm Password" value="<?php if($isEdit==true){ echo $EditData[0]->EMail;} ?>">
                                        <span class="errors err-sm" id="txtConfirmPassword-err"></span>
                                    </div>
                                </div>
                                @endif
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="lstLoginStatus">Login Status</label>
                                        <select class="form-control select2" id="lstLoginStatus" data-minimum-results-for-search="Infinity">
                                            <option value="1" @if($isEdit==true) @if($EditData[0]->isLogin=="1") selected @endif @endif >Enabled</option>
                                            <option value="0" @if($isEdit==true) @if($EditData[0]->isLogin=="0") selected @endif @endif>Disabled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lstActiveStatus">User Status</label>
                                        <select class="form-control" id="lstActiveStatus">
                                            <option value="1" @if($isEdit==true) @if($EditData[0]->ActiveStatus=="1") selected @endif @endif >Active</option>
                                            <option value="0" @if($isEdit==true) @if($EditData[0]->ActiveStatus=="0") selected @endif @endif>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
						</div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12 text-right">
                                    @if($crud['view']==1)
                                        <a href="{{ url('/') }}/admin/users-and-permissions/employees" class="btn btn-sm btn-outline-dark mr-10">Cancel</a>
                                    @endif
                                    @if($crud['edit']==1 || $crud['add']==1)
                                        <button class="btn btn-sm btn-outline-success btn-air-success" id="btnSave">@if($isEdit) Update @else Create @endif </button>
                                    @endif
                                </div>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Image Crop Script Start -->
<script>
    $(document).ready(function() {
        var uploadedImageURL;
        var URL = window.URL || window.webkitURL;
        var $dataRotate = $('#dataRotate');
        var $dataScaleX = $('#dataScaleX');
        var $dataScaleY = $('#dataScaleY');
        var options = {
            aspectRatio: 500 / 600, 
            preview: '.img-preview'
        };
        var $image = $('#ImageCrop').cropper(options);
        $('#ImgCrop').modal({backdrop: 'static',keyboard: false});
        $('#ImgCrop').modal('hide');
        $(document).on('change', '.imageScrop', function() {
            let id = $(this).attr('id');
            $('#'+id).attr('data-remove',0); 
            if($('#'+id).attr('data-aspect-ratio')!=undefined){
                options.aspectRatio=$('#'+id).attr('data-aspect-ratio')
            }
            $image.attr('data-id', id);
            $('#ImgCrop').modal('show');
            var files = this.files;
            if (files && files.length) {
                file = files[0];
                if (/^image\/\w+$/.test(file.type)) {
                    uploadedImageName = file.name;
                    uploadedImageType = file.type;
                    if (uploadedImageURL) {
                        URL.revokeObjectURL(uploadedImageURL);
                    }
                    uploadedImageURL = URL.createObjectURL(file); console.log(options)
                    $image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
                } else {
                    window.alert('Please choose an image file.');
                }
            }
        });
        $('.docs-buttons').on('click', '[data-method]', function() {
            var $this = $(this);
            var data = $this.data();
            var cropper = $image.data('cropper');
            var cropped;
            var $target;
            var result;
            if (cropper && data.method) {
                data = $.extend({}, data);
                if (typeof data.target !== 'undefined') {
                    $target = $(data.target);
                    if (typeof data.option === 'undefined') {
                        try {
                            data.option = JSON.parse($target.val());
                        } catch (e) {
                            console.log(e.message);
                        }
                    }
                }
                cropped = cropper.cropped;
                switch (data.method) {
                    case 'rotate':
                        if (cropped && options.viewMode > 0) {
                            $image.cropper('clear');
                        }
                        break;
                    case 'getCroppedCanvas':
                        if (uploadedImageType === 'image/jpeg') {
                            if (!data.option) {
                                data.option = {};
                            }
                            data.option.fillColor = '#fff';
                        }
                        break;
                }
                result = $image.cropper(data.method, data.option, data.secondOption);
                switch (data.method) {
                    case 'rotate':
                        if (cropped && options.viewMode > 0) {
                            $image.cropper('crop');
                        }
                        break;
                    case 'scaleX':
                    case 'scaleY':
                        $(this).data('option', -data.option);
                        break;
                    case 'getCroppedCanvas':
                        if (result) {
                            $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);
                            if (!$download.hasClass('disabled')) {
                                download.download = uploadedImageName;
                                $download.attr('href', result.toDataURL(uploadedImageType));
                            }
                        }
                        break;
                }
            }
        });
        $('#inputImage').change(function() {
            var files = this.files;
            var file;
            if (!$image.data('cropper')) {
                return;
            }
            if (files && files.length) {
                file = files[0];
                if (/^image\/\w+$/.test(file.type)) {
                    uploadedImageName = file.name;
                    uploadedImageType = file.type;
                    if (uploadedImageURL) {
                        URL.revokeObjectURL(uploadedImageURL);
                    }
                    uploadedImageURL = URL.createObjectURL(file);
                    $image.cropper('destroy').attr('src', uploadedImageURL).cropper(options);
                    $('#inputImage').val('');
                } else {
                    window.alert('Please choose an image file.');
                }
            }
        });
        $(document).on('click', '#btnUploadImage', function() {
            $('#inputImage').trigger('click')
        });
        $("#btnCropApply").on('click', function() {
            btnLoading($('#btnCropApply'));
            setTimeout(() => {
                var base64 = $image.cropper('getCroppedCanvas').toDataURL();
                var id = $image.attr('data-id');
                $('#' + id).attr('src', base64);
                $('#' + id).parent().find('img').attr('src', base64)
                $('#ImgCrop').modal('hide');
                setTimeout(() => {
                    btnReset($('#btnCropApply'));
                }, 100);
            }, 100);
        });
        $(document).on('click','#btnCropModelClose',function(){
            var id = $image.attr('data-id');
            $('#' + id).val("");
            $('#' + id).attr('src', "");
            $('#' + id).parent().find('img').attr('src', "");
            $('#' + id).parent().find('.dropify-clear').trigger('click');
            $('#ImgCrop').modal('hide');
        });
    });
</script>
<!-- Image Crop Script End -->
<script>
    $(document).ready(function(){
        const appInit=async()=>{
			getCountry();
			getGender();
			getUserRoles();
            @if(!($isEdit && $EditData[0]->Dept == 'CEO'))
                getDept();
                getDesignation();
            @endif
            $('#txtProfileImage').dropify({
                showRemove: false
            });
		}
        const getUserRoles=async()=>{
            $.ajax({
                type:"post",
                url:"{{url('/')}}/admin/users-and-permissions/employees/get/user-roles",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    $('#lstUserRole').select2('destroy');
                    $('#lstUserRole option').remove();
                    $('#lstUserRole').append('<option value="" selected>Select a Role</option>');
                    for(let Item of response){
                        let selected="";
                        if(Item.RoleID==$('#lstUserRole').attr('data-selected')){selected="selected";}
                        $('#lstUserRole').append('<option '+selected+' value="'+Item.RoleID+'">'+Item.RoleName+' </option>');
                    }
                    $('#lstUserRole').select2();
                }
            });
        }
        const getDept=async()=>{
            $.ajax({
                type:"post",
                url:"{{url('/')}}/admin/users-and-permissions/employees/get/dept",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    $('#lstDept').select2('destroy');
                    $('#lstDept option').remove();
                    $('#lstDept').append('<option value="" selected>Select a Department</option>');
                    for(let Item of response){
                        if(Item.Dept && Item.Dept !='CEO'){
                            let selected="";
                            if(Item.DeptID==$('#lstDept').attr('data-selected')){selected="selected";}
                            $('#lstDept').append('<option '+selected+' value="'+Item.DeptID+'">'+Item.Dept+' </option>');
                        }
                    }
                    $('#lstDept').select2();
                }
            });
        }
        const getDesignation=async()=>{
            $.ajax({
                type:"post",
                url:"{{url('/')}}/admin/users-and-permissions/employees/get/designation",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    $('#lstDesignation').select2('destroy');
                    $('#lstDesignation option').remove();
                    $('#lstDesignation').append('<option value="" selected>Select or Enter a Designation</option>');
                    for(let Item of response){
                        if(Item.Designation && Item.Designation !='CEO'){
                            let selected="";
                            if(Item.Designation==$('#lstDesignation').attr('data-selected')){selected="selected";}
                            $('#lstDesignation').append('<option '+selected+' value="'+Item.Designation+'">'+Item.Designation+' </option>');
                        }
                    }
                    $('#lstDesignation').select2({tags: true});
                }
            });
        }
        const getGender=async()=>{
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/gender",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    $('#lstGender').select2('destroy');
                    $('#lstGender option').remove();
                    $('#lstGender').append('<option value="" selected>Select a Gender</option>');
                    for(let Item of response){
                        let selected="";
                        if(Item.GID==$('#lstGender').attr('data-selected')){selected="selected";}
                        $('#lstGender').append('<option '+selected+' value="'+Item.GID+'">'+Item.Gender+' </option>');
                    }
                    $('#lstGender').select2();
                }
            });
        }
        const getCountry=async()=>{
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/country",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    $('#lstCountry').select2('destroy');
                    $('#lstCountry option').remove();
                    $('#lstCountry').append('<option value="" selected>Select a Country</option>');
                    for(let Item of response){
                        let selected="";
                        if(Item.CountryID==$('#lstCountry').attr('data-selected')){selected="selected";}
                        $('#lstCountry').append('<option '+selected+' data-phone-code="'+Item.PhoneCode+'" data-phone-length="'+Item.PhoneLength+'" value="'+Item.CountryID+'">'+Item.CountryName+' ( '+Item.sortname+' ) '+' </option>');
                    }
                    $('#lstCountry').select2();
                    if($('#lstCountry').val()!=""){
                        $('#lstCountry').trigger('change');
                    }
                }
            });
        }
        const getStates=async()=>{
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/states",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                data:{CountryID:$('#lstCountry').val()},
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    $('#lstState').select2('destroy');
                    $('#lstState option').remove();
                    $('#lstState').append('<option value="" selected>Select a State</option>');
                    for(let Item of response){
                        let selected="";
                        if(Item.StateID==$('#lstState').attr('data-selected')){selected="selected";}
                        $('#lstState').append('<option '+selected+'  value="'+Item.StateID+'">'+Item.StateName+' </option>');
                    }
                    $('#lstState').select2();
                    if($('#lstState').val()!=""){
                        $('#lstState').trigger('change');
                    }
                }
            });
        }
        const getCity=async()=>{
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/city",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                data:{CountryID:$('#lstCountry').val(),StateID:$('#lstState').val()},
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    $('#lstCity').select2('destroy');
                    $('#lstCity option').remove();
                    $('#lstCity').append('<option value="" selected>Select a City</option>');
                    for(let Item of response){
                        let selected="";
                        if(Item.CityID==$('#lstCity').attr('data-selected')){selected="selected";}
                        $('#lstCity').append('<option '+selected+'  value="'+Item.CityID+'">'+Item.CityName+' </option>');
                    }
                    $('#lstCity').select2();
                }
            });
        }
        const getPostalCode=async()=>{
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/postal-code",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                data:{CountryID:$('#lstCountry').val(),StateID:$('#lstState').val()},
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    $('#lstPostalCode').select2('destroy');
                    $('#lstPostalCode option').remove();
                    $('#lstPostalCode').append('<option value="" selected>Select a Postal Code or Enter</option>');
                    for(let Item of response){
                        let selected="";
                        if(Item.PID==$('#lstPostalCode').attr('data-selected')){selected="selected";}
                        $('#lstPostalCode').append('<option '+selected+'  value="'+Item.PID+'">'+Item.PostalCode+' </option>');
                    }
                    $('#lstPostalCode').select2({tags: true});
                }
            });
        }
        const formValidation=()=>{
            $('.errors').html('');
            let FirstName=$('#txtFirstName').val();
			let LastName=$('#txtLastName').val();
            let Gender=$('#lstGender').val();
            let Password=$('#txtPassword').val();
            let ConfirmPassword=$('#txtConfirmPassword').val();
            let UserRole=$('#lstUserRole').val();
            let Dept=$('#lstDept').val();
            let Designation=$('#lstDesignation').val();
			let EMail=$('#txtEmail').val();

            let Address=$('#txtAddress').val();
            let Country=$('#lstCountry').val();
            let State=$('#lstState').val();
            let City=$('#lstCity').val();
            let PostalCode=$('#lstPostalCode').val();
            let MobileNumber=$('#txtMobileNumber').val();
            let PhoneLength=$('#lstCountry option:selected').attr('data-phone-length');
            let status=true;
            if(FirstName==""){
                $('#txtFirstName-err').html('First Name is required');status=false;
            }else if(FirstName.length<2){
                $('#txtFirstName-err').html('The First Name is must be greater than 2 characters.');status=false;
            }else if(FirstName.length>50){
                $('#txtFirstName-err').html('The First Name is not greater than 50 characters.');status=false;
            }
            if(!EMail){
                $('#txtEmail-err').html('E-Mail is required');status=false;
            }else if(EMail.isValidEMail()==false){
                $('#txtEmail-err').html('E-Mail is not valid');status=false;
            }
            if(LastName==""){
				if(LastName.length>50){
					$('#txtLastName-err').html('The Last Name is not greater than 50 characters.');status=false;
				}
			}
            /* if(Gender==""){
                $('#lstGender-err').html('Gender is required');status=false;
            } */
            if(UserRole==""){
                $('#lstUserRole-err').html('User Role is required');status=false;
            }
            if(Country==""){
                $('#lstCountry-err').html('Country is required');status=false;
            }
            if(State==""){
                $('#lstState-err').html('State is required');status=false;
            }
            if(City==""){
                $('#lstCity-err').html('City is required');status=false;
            }
            if(!Dept){
                $('#lstDept-err').html('Deparment is required');status=false;
            }
            if(!Designation){
                $('#lstDesignation-err').html('Designation is required');status=false;
            }
            if(PostalCode==""){
                $('#lstPostalCode-err').html('Postal Code is required');status=false;
            }
            if(MobileNumber==""){
                $('#txtMobileNumber-err').html('Mobile Number is required');status=false;
            }else if($.isNumeric(MobileNumber)==false){
                $('#txtMobileNumber-err').html('Mobile Number is must be numeric value');status=false;
            }else if((parseInt(PhoneLength)>0)&&(parseInt(PhoneLength)!=MobileNumber.length)){
                $('#txtMobileNumber-err').html('Mobile Number is not valid');status=false;
            }
            @if($isEdit==false)
				if(Password==""){
					$('#txtPassword-err').html('Password is required');status=false;
				}else if(Password.length<3){
					$('#txtPassword-err').html('Password must be at least 4 characters');status=false;
				}
				if(ConfirmPassword==""){
					$('#txtConfirmPassword-err').html('Confirm Password is required');status=false;
				}else if(ConfirmPassword.length<4){
					$('#txtConfirmPassword-err').html('Confirm Password must be at least 4 characters');status=false;
				}else if(Password!==ConfirmPassword){
					$('#txtConfirmPassword-err').html('Confirm Password does not match with password');status=false;
				}
            @endif
            return status;
        }
		const getData=async()=>{
            let tmp=await UploadImages();
			let formData=new FormData();
			formData.append('FirstName',$('#txtFirstName').val());
			formData.append('LastName',$('#txtLastName').val());
			formData.append('Gender',$('#lstGender').val());
			formData.append('UserRole',$('#lstUserRole').val());
			formData.append('ActiveStatus',$('#lstActiveStatus').val());
            formData.append('DOB',$('#dtpDOB').val());
            formData.append('DeptID',$('#lstDept').val());
            formData.append('Designation',$('#lstDesignation').val());
            formData.append('Level',$('#lstLevel').val());
			formData.append('LoginStatus',$('#lstLoginStatus').val());
			formData.append('Address',$('#txtAddress').val());
			formData.append('City',$('#lstCity').val());
			formData.append('StateID',$('#lstState').val());
			formData.append('CountryID',$('#lstCountry').val());
			formData.append('PostalCodeID',$('#lstPostalCode').val());
			formData.append('PostalCode',$('#lstPostalCode option:selected').text());
			formData.append('EMail',$('#txtEmail').val());
			formData.append('MobileNumber',$('#txtMobileNumber').val());
            @if($isEdit==false)
                formData.append('Password',$('#txtPassword').val());
                formData.append('ConfirmPassword',$('#txtConfirmPassword').val());
            @endif
			if(tmp.profileImage.uploadPath!=""){
                formData.append('ProfileImage', JSON.stringify(tmp.profileImage));
            }
			return formData;
		}
        $(document).on('change','#lstCountry',function(){
            getStates();
			let CallCode=$('#lstCountry option:selected').attr('data-phone-code');
			if(CallCode!=""){
				$('#CallCode').html(" ( +"+CallCode+" )");
			}
        });
        $(document).on('change','#lstState',function(){
            getCity();
            getPostalCode();
        });
        $(document).on('click','#btnSave',function(){
            let status=formValidation();
            if(status){
                swal({
                    title: "Are you sure?",
                    text: "You want @if($isEdit==true)Update @else Save @endif this User!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, @if($isEdit==true)Update @else Save @endif it!",
                    closeOnConfirm: false
                },async function(){
                    swal.close();
                    btnLoading($('#nextBtn'));
                    const formData=await getData();
                    @if($isEdit) let posturl="{{url('/')}}/admin/users-and-permissions/employees/edit/{{$UserID}}"; @else let posturl="{{url('/')}}/admin/users-and-permissions/employees/create"; @endif
                    $.ajax({
                        type:"post",
                        url:posturl,
                        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                        data:formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        xhr: function() {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function(evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = (evt.loaded / evt.total) * 100;
                                    percentComplete=parseFloat(percentComplete).toFixed(2);
                                    $('#divProcessText').html(percentComplete+'% Completed.<br> Please wait for until upload process complete.');
                                    //Do something with upload progress here
                                }
                            }, false);
                            return xhr;
                        },
                        beforeSend: function() {
                            ajaxIndicatorStart("Please wait Upload Process on going.");
                            var percentVal = '0%';
                            setTimeout(() => {
                            $('#divProcessText').html(percentVal+' Completed.<br> Please wait for until upload process complete.');
                            }, 100);
                        },
                        error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                        complete: function(e, x, settings, exception){btnReset($('#nextBtn'));ajaxIndicatorStop();},
                        success:function(response){
                            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
                            if(response.status==true){
                                swal({
                                    title: "SUCCESS",
                                    text: response.message,
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonClass: "btn-outline-success",
                                    confirmButtonText: "Okay",
                                    closeOnConfirm: false
                                },function(){
                                    @if($isEdit==true)
                                        window.location.replace("{{url('/')}}/admin/users-and-permissions/employees/");
                                    @else
                                        window.location.reload();
                                    @endif
                                });    
                            }else{
                                toastr.error(response.message, "Failed", {
                                    positionClass: "toast-top-right",
                                    containerId: "toast-top-right",
                                    showMethod: "slideDown",
                                    hideMethod: "slideUp",
                                    progressBar: !0
                                })
                                if(response['errors']!=undefined){
                                    $('.errors').html('');
                                    $.each( response['errors'], function( KeyName, KeyValue ) {
                                        var key=KeyName;
                                        if(key=="FirstName"){$('#txtFirstName-err').html(KeyValue);}
                                        if(key=="LastName"){$('#txtLastName-err').html(KeyValue);}
                                        if(key=="Gender"){$('#lstGender-err').html(KeyValue);}
                                        if(key=="UserRole"){$('#lstUserRole-err').html(KeyValue);}
                                        if(key=="Address"){$('#txtAddress-err').html(KeyValue);}
                                        if(key=="City"){$('#lstCity-err').html(KeyValue);}
                                        if(key=="State"){$('#lstState-err').html(KeyValue);}
                                        if(key=="Country"){$('#lstCountry-err').html(KeyValue);}
                                        if(key=="PostalCode"){$('#lstPostalCode-err').html(KeyValue);}
                                        if(key=="EMail"){$('#txtEmail-err').html(KeyValue);}
                                        if(key=="MobileNumber"){$('#txtMobileNumber-err').html(KeyValue);}
                                        if(key=="ProfileImage"){$('#txtProfileImage-err').html(KeyValue);}
                                        if(key=="ActiveStatus"){$('#lstActiveStatus-err').html(KeyValue);}
                                    });
                                }
                            }
                        }
                    });
                });
            }
        });
        appInit();
    });
</script>
@endsection