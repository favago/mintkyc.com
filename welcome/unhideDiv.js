// ID document expired

 $(function () {
     $('#IndVerDocValidity').change(function () {
         $('#hr_notification0').hide();
         if (this.options[this.selectedIndex].value == 'IndVerDovInvalid') {
             $('#hr_notification0').show();
         }
     });
 });

// Nationality

 $(function () {
     $('#IndNationality').change(function () {
         $('#hr_notification1').hide();
         if (this.options[this.selectedIndex].value == 'Russia') {
             $('#hr_notification1').show();
         }
     });
 });
 
 // Country (Principal place of residence)
 
  $(function () {
     $('#IndPPoRS').change(function () {
         $('#hr_notification2').hide();
         if (this.options[this.selectedIndex].value == 'Russia') {
             $('#hr_notification2').show();
         }
     });
 });
 
 // Place of Birth
 
   $(function () {
     $('#IndPoB').change(function () {
         $('#hr_notification3').hide();
         if (this.options[this.selectedIndex].value == 'Russia') {
             $('#hr_notification3').show();
         }
     });
 });
 
 // Address document expired
 
    $(function () {
     $('#IndAddressVerDocValidity').change(function () {
         $('#hr_notification4').hide();
         if (this.options[this.selectedIndex].value == 'IndAddressVerDovInvalid') {
             $('#hr_notification4').show();
         }
     });
 });

  // PEP
  
    $(function () {
     $('#IndPEPS').change(function () {
         $('#hr_notification5').hide();
         if (this.options[this.selectedIndex].value == 'IndPEP') {
             $('#hr_notification5').show();
         }
     });
 });
 
   // Sanctions
  
    $(function () {
     $('#IndSancs').change(function () {
         $('#hr_notification6').hide();
         if (this.options[this.selectedIndex].value == 'Yes') {
             $('#hr_notification6').show();
         }
     });
 }); 
 
    // Adverse News
  
    $(function () {
     $('#IndAdvNewsS').change(function () {
         $('#hr_notification7').hide();
         if (this.options[this.selectedIndex].value == 'IndAdvNewsYes') {
             $('#hr_notification7').show();
         }
     });
 }); 