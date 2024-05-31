@extends('layouts.app')
@section('content')
<div class="container-fluid">
	<div class="page-header">
		<div class="row">
			<div class="col-sm-12">
				<ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}/admin"><i class="f-16 fa fa-home"></i></a></li>
					<li class="breadcrumb-item">Settings</li>
					<li class="breadcrumb-item">{{$PageTitle}}</li>
				</ol>
			</div>
		</div>
	</div>
</div>

<div class="container-fluid mt-40">
	<div class="row d-flex justify-content-center">
		<div class="col-sm-10 col-12 col-md-7">
			<div class="row">
				<div class="col-sm-12">
					<div class="card">
						<div class="card-header text-center">
							<div class="form-row align-items-center">
								<div class="col-md-4">	</div>
								<div class="col-md-4 my-2">
									<h5>{{$PageTitle}}</h5>
								</div>
								<div class="col-md-4 my-2 text-right text-md-right">
								</div>
							</div>
						</div>
						<div class="card-body " >
                            <div class="row d-flex justify-content-center">
                                <div class="col-sm-4 col-8">
                                    <label for="txtCLogo">Dark Logo</label>
                                    <input type="file" id="txtCLogo" class="dropify" data-max-file-size="{{$Settings['upload-limit']}}" data-default-file="<?php if($Company['Logo'] !=""){ echo url('/')."/".$Company['Logo'];}?>"  data-allowed-file-extensions="jpeg jpg png gif" />
                                    <span class="errors" id="txtCLogo-err"></span>
                                </div>
                                <div class="col-sm-4 col-8">
                                    <label for="txtCLogo">Light Logo</label>
                                    <input type="file" id="txtCLogoLight" class="dropify" data-max-file-size="{{$Settings['upload-limit']}}" data-default-file="<?php if($Company['Logo-Light'] !=""){ echo url('/')."/".$Company['Logo-Light'];}?>"  data-allowed-file-extensions="jpeg jpg png gif" />
                                    <span class="errors" id="txtCLogoLight-err"></span>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="txtCompanyName">Company Name <span class="required"> * </span></label>
                                        <input type="text" class="form-control" id="txtCompanyName" value="{{$Company['Name']}}" >
                                        <div class="errors company-info text-sm" id="txtCompanyName-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Address <span class="required"> * </span></label>
                                        <textarea class="form-control" id="txtCAddress" rows=1>{{$Company['Address']}}</textarea>
                                        <div class="errors company-info text-sm" id="txtCAddress-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="lstCCountry">Country <span class="required"> * </span></label>
                                        <select class="form-control select2" id="lstCCountry" data-selected="{{$Company['CountryID']}}"  @if($crud['edit']==false) disabled @endif>
                                        <option value="">Select a Country</option>
                                        </select>
                                        <div class="errors company-info text-sm" id="lstCCountry-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="lstCState">State <span class="required"> * </span></label>
                                        <select class="form-control select2" id="lstCState" data-selected="{{$Company['StateID']}}"  @if($crud['edit']==false) disabled @endif>
                                        <option value="">Select a State</option>
                                        </select>
                                        <div class="errors company-info text-sm" id="lstCState-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="lstCCity">City <span class="required"> * </span></label>
                                        <select class="form-control select2" id="lstCCity" data-selected="{{$Company['CityID']}}"  @if($crud['edit']==false) disabled @endif>
                                        <option value="">Select a City</option>
                                        </select>
                                        <div class="errors company-info text-sm" id="lstCCity-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="lstCPostalCode">Postal Code <span class="required"> * </span></label>
                                        <select class="form-control select2Tag" id="lstCPostalCode" data-selected="{{$Company['PostalCodeID']}}"  @if($crud['edit']==false) disabled @endif>
                                        <option value="">Select a Postal code or enter</option>
                                        </select>
                                        <div class="errors company-info text-sm" id="lstCPostalCode-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="txtCEmail">Email <span class="required"> * </span></label>
                                        <input type="email" class="form-control" id="txtCEmail" value="{{$Company['Email']}}">
                                        <div class="errors company-info text-sm" id="txtCEmail-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="txtCGSTNo">GST No </label>
                                        <input type="text" class="form-control" id="txtCGSTNo" value="{{$Company['GSTNo']}}">
                                        <div class="errors company-info text-sm" id="txtCGSTNo-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="txtCMobileNumber">Mobile Number <span class="required"> * </span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text" id="callingCode">+91</span></div>
                                            <input type="text" class="form-control" id="txtCPhoneNumber" value="{{$Company['Phone-Number']}}">

                                        </div>
                                        <div class="errors company-info text-sm" id="txtCMobileNumber-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="txtCPhoneNumber">Alternate Number </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend"><span class="input-group-text" id="callingCode1">+91</span></div>
                                            <input type="text" class="form-control" id="txtCMobileNumber" value="{{$Company['Mobile-Number']}}">
                                        </div>
                                        <div class="errors company-info text-sm" id="txtCPhoneNumber-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="txtFacebook">Facebook</label>
                                        <input type="text" class="form-control" id="txtFacebook" value="{{$Company['facebook']}}">
                                        <div class="errors" id="txtFacebook-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="txtInstagram">Instagram</label>
                                        <input type="text" class="form-control" id="txtInstagram" value="{{$Company['instagram']}}">
                                        <div class="errors" id="txtInstagram-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="txtYoutube">Youtube</label>
                                        <input type="text" class="form-control" id="txtYoutube" value="{{$Company['youtube']}}">
                                        <div class="errors" id="txtYoutube-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="txtTwitter">Twitter</label>
                                        <input type="text" class="form-control" id="txtTwitter" value="{{$Company['twitter']}}">
                                        <div class="errors" id="txtTwitter-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="txtLinkedIn">Linked In</label>
                                        <input type="text" class="form-control" id="txtLinkedIn" value="{{$Company['linkedin']}}">
                                        <div class="errors" id="txtLinkedIn-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="lstContactUsEmail">Enable Contact enquiry in Mail <span class="required"> * </span></label>
                                        <select class="form-control" id="lstContactUsEmail"   @if($crud['edit']==false) disabled @endif>
                                            <option value="1" @if($Company['enable-mail-contact-us']==true) selected @endif>Enable</option>
                                            <option value="0" @if($Company['enable-mail-contact-us']==false) selected @endif>Disable</option>
                                        </select>
                                        <div class="errors company-info text-sm" id="lstContactUsEmail-err"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="txtContactEmail">Contact Enquiry Mail Address<span class="required"> * </span></label>
                                        <input type="email" class="form-control" id="txtContactEmail" value="{{$Company['contact-us-email']}}">
                                        <div class="errors company-info text-sm" id="txtContactEmail-err"></div>
                                    </div>
                                </div>
                            </div>
						</div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12 text-right">
                                    <button class="btn btn-sm btn-outline-success btn-air-success" id="btnUpdate">Update</button>
                                </div>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
    $(document).ready(function(){
        const appInit=()=>{
            getCountry();
            ContactMail();
        }
        //Company
        const getCountry=async()=>{
            $('#lstCCountry').select2('destroy');
            $('#lstCCountry option').remove();
            $('#lstCCountry').append('<option value="" selected>Select a Country</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/country",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.CountryID==$('#lstCCountry').attr('data-selected')){selected="selected";}
                        $('#lstCCountry').append('<option '+selected+' data-phone-code="'+Item.PhoneCode+'" data-phone-length="'+Item.PhoneLength+'" value="'+Item.CountryID+'">'+Item.CountryName+' ( '+Item.sortname+' ) '+' </option>');
                    }
                    if($('#lstCCountry').val()!=""){
                        $('#lstCCountry').trigger('change');
                    }
                }
            });
            $('#lstCCountry').select2();
        }
        const getStates=async()=>{
            $('#lstCState').select2('destroy');
            $('#lstCState option').remove();
            $('#lstCState').append('<option value="" selected>Select a State</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/states",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                data:{CountryID:$('#lstCCountry').val()},
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.StateID==$('#lstCState').attr('data-selected')){selected="selected";}
                        $('#lstCState').append('<option '+selected+'  value="'+Item.StateID+'">'+Item.StateName+' </option>');
                    }
                    if($('#lstCState').val()!=""){
                        $('#lstCState').trigger('change');
                    }
                }
            });
            $('#lstCState').select2();
        }
        const getCity=async()=>{
            $('#lstCCity').select2('destroy');
            $('#lstCCity option').remove();
            $('#lstCCity').append('<option value="" selected>Select a City</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/city",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                data:{CountryID:$('#lstCCountry').val(),StateID:$('#lstCState').val()},
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.CityID==$('#lstCCity').attr('data-selected')){selected="selected";}
                        $('#lstCCity').append('<option '+selected+'  value="'+Item.CityID+'">'+Item.CityName+' </option>');
                    }
                }
            });
            $('#lstCCity').select2();
        }
        const getPostalCode=async()=>{
            $('#lstCPostalCode').select2('destroy');
            $('#lstCPostalCode option').remove();
            $('#lstCPostalCode').append('<option value="">Select a Postal Code or Enter</option>');
            $.ajax({
                type:"post",
                url:"{{url('/')}}/get/postal-code",
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') },
                dataType:"json",
                data:{CountryID:$('#lstCCountry').val(),StateID:$('#lstCState').val()},
                async:true,
                error:function(e, x, settings, exception){ajaxErrors(e, x, settings, exception);},
                complete: function(e, x, settings, exception){},
                success:function(response){
                    for(let Item of response){
                        let selected="";
                        if(Item.PID==$('#lstCPostalCode').attr('data-selected')){selected="selected";}
                        $('#lstCPostalCode').append('<option '+selected+'  value="'+Item.PID+'">'+Item.PostalCode+' </option>');
                    }
                }
            });
            $('#lstCPostalCode').select2({tags: true});
        }
        const getData=()=>{
            let formData=new FormData();
            formData.append('Name',$('#txtCompanyName').val());
            formData.append('Address',$('#txtCAddress').val());
            formData.append('CountryID',$('#lstCCountry').val());
            formData.append('StateID',$('#lstCState').val());
            formData.append('CityID',$('#lstCCity').val());
            formData.append('PostalCodeID',$('#lstCPostalCode').val());
            formData.append('PostalCode',$('#lstCPostalCode option:selected').text());
            formData.append('Email',$('#txtCEmail').val());
            formData.append('facebook',$('#txtFacebook').val());
            formData.append('instagram',$('#txtInstagram').val());
            formData.append('youtube',$('#txtYoutube').val());
            formData.append('twitter',$('#txtTwitter').val());
            formData.append('linkedin',$('#txtLinkedIn').val());
            formData.append('Phone-Number',$('#txtCPhoneNumber').val());
            formData.append('Mobile-Number',$('#txtCMobileNumber').val());
            formData.append('GSTNo',$('#txtCGSTNo').val());
            formData.append('enable-mail-contact-us',$('#lstContactUsEmail').val());
            formData.append('contact-us-email',$('#txtContactEmail').val());
            if($('#txtCLogo').val()!=""){
                formData.append('Logo', $('#txtCLogo')[0].files[0]);
            }
            if($('#txtCLogoLight').val()!=""){
                formData.append('Logo-Light', $('#txtCLogoLight')[0].files[0]);
            }
            return formData;
        }
        const formValidation=()=>{
            let status=true;
            $('.errors').html('')
            let companyName=$('#txtCompanyName').val();
            let address=$('#txtCAddress').val();
            let country=$('#lstCCountry').val();
            let state=$('#lstCState').val();
            let city=$('#lstCCity').val();
            let postalCode=$('#lstCPostalCode').val();
            let email=$('#txtCEmail').val();
            let gstNo=$('#txtCGSTNo').val();
            let mobileNumber=$('#txtCMobileNumber').val();
            let PhoneNumber=$('#txtCPhoneNumber').val();

            if(companyName==""){
                $('#txtCompanyName-err').html('Company name is required');status=false;
            }else if(companyName.length<3){
                $('#txtCompanyName-err').html('The company name is must be greater than 2 characters.');status=false;
            }else if(companyName.length>100){
                $('#txtCompanyName-err').html('The company name is not greater than 100 characters.');status=false;
            }
            if(address==""){
                $('#txtCAddress-err').html('address is required');status=false;
            }else if(address.length<10){
                $('#txtCAddress-err').html('The address is must be greater than 10 characters.');status=false;
            }
            if(country==""){
                $('#lstCCountry-err').html('Country is required');status=false;
            }
            if(state==""){
                $('#lstCState-err').html('state is required');status=false;
            }
            if(city==""){
                $('#lstCCity-err').html('city is required');status=false;
            }
            if(postalCode==""){
                $('#lstCPostalCode-err').html('postal code is required');status=false;
            }
            if(email==""){
                $('#txtCEmail-err').html('email is required');status=false;
            }
            if(mobileNumber==""){
                $('#txtCMobileNumber-err').html('mobile number is required');status=false;
            }else if(mobileNumber.length != 10){
                $('#txtCMobileNumber-err').html('mobile number must be 10 digits.');status=false;
            }
            if(PhoneNumber && PhoneNumber.length != 10){
                $('#txtCPhoneNumber-err').html('alternate number must be 10 digits.');status=false;
            }
            if(gstNo!=""){
                if(gstNo.isValidGSTNumber()==false){
                    $('#txtCGSTNo-err').html('GST No is not valid');status=false;
                }
            }
            return status;
        }
        const ContactMail=async()=>{
            if($('#lstContactUsEmail').val()==1){
                $('#txtContactEmail').removeAttr('disabled')
            }else{
                $('#txtContactEmail').attr('disabled','disabled')
            }
        }
        $(document).on('change','#lstContactUsEmail',function(){ContactMail();});
        $(document).on('change','#lstCCountry',function(){
            getStates();

			let CallCode=$('#lstCCountry option:selected').attr('data-phone-code');
			if(CallCode!=""){
				$('#callingCode').html(" ( +"+CallCode+" )");
				$('#callingCode1').html(" ( +"+CallCode+" )");
			}
        });
        $(document).on('change','#lstCState',async function(){getCity();getPostalCode();});
        $(document).on('click','#btnUpdate',function(){
            
			let formData= getData();
            let status=formValidation();
            if(status){
                swal({
                    title: "Are you sure?",
                    text: "Do you want update this settings!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-outline-success",
                    confirmButtonText: "Yes, Update it!",
                    closeOnConfirm: false
                },
                function(){
                    swal.close();
                    btnLoading($('#btnUpdate'));
                    $.ajax({
                        type:"post",
                        url:"{{url('/')}}/admin/settings/company",
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
                        complete: function(e, x, settings, exception){btnReset($('#btnUpdate'));ajaxIndicatorStop();},
                        success:function(response){
                            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
                            if(response.status==true){
                                
                                toastr.success(response.message, "Success", {
                                    positionClass: "toast-top-right",
                                    containerId: "toast-top-right",
                                    showMethod: "slideDown",
                                    hideMethod: "slideUp",
                                    progressBar: !0
                                })   
                            }else{
                                toastr.error(response.message, "Failed", {
                                    positionClass: "toast-top-right",
                                    containerId: "toast-top-right",
                                    showMethod: "slideDown",
                                    hideMethod: "slideUp",
                                    progressBar: !0
                                })
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