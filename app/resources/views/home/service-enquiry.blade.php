 <div class="contact service-enquiry">
     <form action="#" id="frmServiceEnquiry" method="post" role="form" class="php-email-form p-3 p-md-4">
         <div class="row">
             <div class="col-12 col-sm-12 col-xl-12 d-none">
                 <!-- Service Name -->
                 <div class="form-group">
                     <input type="text" class="form-control" id="txtServiceName" placeholder="Service Name"
                         value="{{ $ServiceName }}" disabled>
                     <input type="hidden" class="form-control" id="txtServiceID" value="{{ $ServiceID }}">
                     <div class="errors err-sm" id="txtServiceName-err"></div>
                 </div>
             </div>
             <div class="col-12 col-sm-4 col-xl-4">
                 <!-- Your Name -->
                 <div class="form-group">
                     <input type="text" class="form-control" id="txtName" placeholder="Your Name" required>
                     <div class="errors err-sm" id="txtName-err"></div>
                 </div>
             </div>
             <div class="col-12 col-sm-4 col-xl-4">
                 <!-- Your Email -->
                 <div class="form-group">
                     <input type="email" class="form-control" id="txtEmail" placeholder="Your Email" required>
                     <div class="errors err-sm" id="txtEmail-err"></div>
                 </div>
             </div>
             <div class="col-12 col-sm-4 col-xl-4">
                 <!-- Your Mobile Number -->
                 <div class="form-group">
                     <input type="text" class="form-control" id="txtMobileNumber" placeholder="Your Mobile Number"
                         required>
                     <div class="errors err-sm" id="txtMobileNumber-err"></div>
                 </div>
             </div>
         </div>
         <div class="row">
             <div class="col-12 col-sm-12 col-xl-12">
                 <!-- Subject -->
                 <div class="form-group">
                     <input type="text" class="form-control" id="txtSubject" placeholder="Subject" required>
                     <div class="errors err-sm" id="txtSubject-err"></div>
                 </div>
             </div>
         </div>
         <div class="row">
             <div class="col-12 col-sm-12 col-xl-12">
                 <!-- Message -->
                 <div class="form-group">
                     <textarea class="form-control" id="txtMessage" rows="5" placeholder="Message" required></textarea>
                     <div class="errors err-sm" id="txtMessage-err"></div>
                 </div>
             </div>
         </div>
         <div class="text-center"><button id="submit" type="submit">Submit</button></div>
     </form>
 </div>
 <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>

 <script>
     // Function to validate the form
     function validateForm() {
         let valid = true;

         // Validation for each field
         if ($('#txtName').val() == "") {
             $('#txtName-err').html('Please enter your name.');
             valid = false;
         } else {
             $('#txtName-err').html('');
         }

         let email = $('#txtEmail').val().trim();
         if (email == "") {
             $('#txtEmail-err').html('Please enter your email address.');
             valid = false;
         } else if (!isValidEmail(email)) {
             $('#txtEmail-err').html('Please enter a valid email address.');
             valid = false;
         } else {
             $('#txtEmail-err').html('');
         }

         let mobileNumber = $('#txtMobileNumber').val().trim();
        if (mobileNumber == "") {
            $('#txtMobileNumber-err').html('Please enter your mobile number.');
            valid = false;
        } else if (!isValidMobileNumber(mobileNumber)) {
            $('#txtMobileNumber-err').html('Please enter a valid mobile number between 10 and 15 digits.');
            valid = false;
        } else {
            $('#txtMobileNumber-err').html('');
        }

         if ($('#txtSubject').val() == "") {
             $('#txtSubject-err').html('Please enter the subject.');
             valid = false;
         } else {
             $('#txtSubject-err').html('');
         }

         if ($('#txtMessage').val() == "") {
             $('#txtMessage-err').html('Please enter your message.');
             valid = false;
         } else {
             $('#txtMessage-err').html('');
         }

         return valid;
     }

     function isValidEmail(email) {
    // Regular expression for email validation
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
    }

    // Function to check if mobile number is valid
    function isValidMobileNumber(mobileNumber) {
        // Regular expression for mobile number validation
        let mobileNumberRegex = /^\d{10,15}$/;
        return mobileNumberRegex.test(mobileNumber);
    }

     // Submit event listener for the form
     $('#frmServiceEnquiry').submit(function(event) {
         if (!validateForm()) {
             event.preventDefault(); // Prevent form submission if validation fails
         }
     });
 </script>
