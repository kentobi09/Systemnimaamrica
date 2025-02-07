<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker-bs5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Document</title>
    <style>
        .exam-subtitle {
            font-weight: 600;
            font-size: 0.9em;
            margin-block: 15px;
        }
    </style>
</head>
<body>
<!-- Edit Modal -->
<div class="modal fade" id="editApplicantModal" tabindex="-1" role="dialog" aria-labelledby="editApplicantModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editApplicantModalLabel">Edit Applicant</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editApplicantForm" method="post" action="update.php" enctype="multipart/form-data">
                    <!-- Hidden input for applicant ID -->
                    <input type="hidden" id="edit-applicantID" name="edit-applicantID">

                    <div class="row">
                        <!-- Left column for Personal and Examination Details -->
                        <div class="col-md-6 section">
                            <h4 class="section-title"><b>Personal Details</b></h4>
                            <div class="form-group">
                                <input type="text" class="form-control" id="edit-fname" name="edit-fname" placeholder="Firstname" required>
                                <input type="text" class="form-control my-3" id="edit-mname" name="edit-mname" placeholder="Middlename" required>
                                <input type="text" class="form-control" id="edit-lname" name="edit-lname" placeholder="Lastname" required>
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="edit-sex" name="edit-sex" required>
                                    <option value="">Select Sex</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="edit-province" name="edit-province" required>
                                    <option value="">Select Province</option>
                                    <option value="Batanes">Batanes</option>
                                    <option value="Cagayan">Cagayan</option>
                                    <option value="Isabela">Isabela</option>
                                    <option value="Nueva Vizcaya">Nueva Vizcaya</option>
                                    <option value="Quirino">Quirino</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="tel" class="form-control" id="edit-contactNumber" name="edit-contactNumber" placeholder="Contact Number" pattern="\d{11}" title="Phone number must be 11 digits">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" id="edit-emailAddress" name="edit-emailAddress" placeholder="Email Address">
                            </div>
                        </div>
                        <div class="col-md-6 section">
                            <h4 class="section-title"><b>Examination Details</b></h4>
                            <div class="form-group">
                                <input type="text" class="form-control" id="edit-notificationDate" name="edit-notificationDate"  required>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="edit-examDate" name="edit-examDate"   required>
                            </div>
                            <div class="form-group">
                                <select  class="form-control" id="edit-examVenue" name="edit-examVenue"required>
                                <option value="">Select Exam Venue</option>
                                            <option value="hall-a">Hall A</option>
                                            <option value="hall-b">Hall B</option>
                                            <option value="hall-c">Hall C</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="edit-proctor" name="edit-proctor" placeholder="Proctor" required>
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="edit-status" name="edit-status" required>
                                    <option value="">Select Status</option>
                                    <option value="Failed">Failed</option>
                                    <option value="Passed">Passed</option>
                                    <option value="Pending">Pending</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <!-- Score Details -->
                        <div class="col-md-6 section">
                            <h4 class="section-title"><b>Score Details</b></h4>
                            <div class="form-group">
                            <p class= "exam-subtitle" id ="exam-subtitle1"> Diagnostic Exam Part 1 </p>
                                <input type="text" class="form-control" id="edit-exam1Score" name="edit-exam1Score" placeholder="Exam 1" required>
                            </div>
                            <div class="form-group">
                             <p class= "exam-subtitle" id ="exam-subtitle2"> Diagnostic Exam Part 2 </p>
                                <input type="text" class="form-control" id="edit-exam2Score" name="edit-exam2Score" placeholder="Exam 2" required>
                            </div>
                            <div class="form-group" >
                             <p class= "exam-subtitle" id ="exam-subtitle3"> Diagnostic Exam Part 3 </p>
                                <input type="text" class="form-control" id="edit-exam3Score" name="edit-exam3Score" placeholder="Exam 3" required>
                            </div>
                            <div class="form-group">
                             <p class= "exam-subtitle" id ="exam-subtitle4"> Total Score </p>
                                <input type="text" class="form-control" id="edit-totalScore" name="edit-totalScore" placeholder="Total Score" readonly required>
                            </div>
                            <div class="form-group">
                            <p class= "exam-subtitle" id ="exam-subtitle5"> Hands-on Score </p>
                                <input type="text" class="form-control" id="edit-hands-on" name="edit-hands-on" placeholder="Hands-on Score">
                            </div>

                        </div>
                        
                        <!-- Attached File -->
                        <div class="col-md-6 section">
                            <h4 class="section-title"><b>Attached File</b></h4>
                            <div class="form-group">
    <p><strong>Application Form:</strong> 
        <a id="current-applicantForm" href="#" onclick="viewApplicationForm(event)">View Attachment</a>
    </p>
    <input type="file" class="form-control-file" id="edit-applicantForm" name="edit-applicantForm" accept=".pdf">
</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="exid" id="edid" value="1">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




</body>
</html>

<script>
    
    document.addEventListener('DOMContentLoaded', function() {
    var notificationDatepicker = new Datepicker(document.getElementById('edit-notificationDate'), {
        format: 'yyyy-mm-dd', 
        autohide: true,
        minDate: new Date(2020, 0, 1), // January 1, 2020
    });

    var examDatepicker = new Datepicker(document.getElementById('edit-examDate'), {
        format: 'yyyy-mm-dd', 
        autohide: true,
        minDate: new Date(2020, 0, 1), // January 1, 2020
    });
}); 
document.getElementById('edit-contactNumber').addEventListener('input', function (e) {
    e.target.value = e.target.value.replace(/\D/g, ''); // Replace non-digit characters with an empty string
});
    document.getElementById('edit-exam1Score').addEventListener('input', function (e) {
    e.target.value = e.target.value.replace(/\D/g, ''); // Replace non-digit characters with an empty string
});
document.getElementById('edit-exam2Score').addEventListener('input', function (e) {
    e.target.value = e.target.value.replace(/\D/g, ''); // Replace non-digit characters with an empty string
});
document.getElementById('edit-exam3Score').addEventListener('input', function (e) {
    e.target.value = e.target.value.replace(/\D/g, ''); // Replace non-digit characters with an empty string
});
document.getElementById('edit-hands-on').addEventListener('input', function (e) {
    e.target.value = e.target.value.replace(/\D/g, ''); // Replace non-digit characters with an empty string
});

    document.addEventListener('DOMContentLoaded', function () {
    // Find all edit buttons
    var editButtons = document.querySelectorAll('.edit-applicant-btn');

    // Attach click event listener to each edit button
    editButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
           const isDiagnostic = btn.getAttribute('data-table-type') == 'diagnostic';
            // Get data attributes from the button
            var id = btn.getAttribute('data-id');
            var fname = btn.getAttribute('data-fname');
            var mname = btn.getAttribute('data-mname');
            var lname = btn.getAttribute('data-lname');
            var sex = btn.getAttribute('data-sex');
            var province = btn.getAttribute('data-province');
            var contactNumber = btn.getAttribute('data-contact');
            var emailAddress = btn.getAttribute('data-email');
            var notificationDate = btn.getAttribute('data-notification');
            var examDate = btn.getAttribute('data-exam-date');
            var examVenue = btn.getAttribute('data-exam-venue');
            var proctor = btn.getAttribute('data-proctor');
            var status = btn.getAttribute('data-status');
            var score1 = btn.getAttribute('data-score1');
            var score2 = btn.getAttribute('data-score2');
            var score3 = btn.getAttribute('data-score3');
            var totalScore = btn.getAttribute('data-total');
            var handson = btn.getAttribute('data-handson');
            var hasApplicationForm = btn.getAttribute('data-application-form') === 'true';
            
            var handsonExamDate = btn.getAttribute('data-handson-exam-date');
            var handsonnotificationDate = btn.getAttribute('data-handson-notification');
            var handsonstatus = btn.getAttribute('data-handson-status');
            var handsonexamVenue = btn.getAttribute('data-handson-exam-venue');
            var handsonproctor = btn.getAttribute('data-handson-proctor');

            // Populate modal fields with data
            //------------------Modify her


            document.getElementById('edit-applicantID').value = id;
            document.getElementById('edit-fname').value = fname;
            document.getElementById('edit-mname').value = mname;
            document.getElementById('edit-lname').value = lname;
            document.getElementById('edit-sex').value = sex;
            document.getElementById('edit-province').value = province;
            document.getElementById('edit-contactNumber').value = contactNumber;
            document.getElementById('edit-emailAddress').value = emailAddress;

            document.getElementById('edit-notificationDate').value = isDiagnostic ? notificationDate : handsonnotificationDate;
            document.getElementById('edit-examDate').value = isDiagnostic ? examDate : handsonExamDate;
            document.getElementById('edit-examVenue').value = isDiagnostic ? examVenue : handsonexamVenue;
            // document.getElementById('edit-proctor').value =  isDiagnostic ? proctor : handsonproctor;
            // document.getElementById('edit-status').value = isDiagnostic ? status : handsonstatus;
            document.getElementById('edit-proctor').value = isDiagnostic ? proctor : handsonproctor;
            document.getElementById('edit-status').value =  isDiagnostic ? status : handsonstatus;



            document.getElementById('edit-exam1Score').style.display = isDiagnostic ? 'block' : 'none';
            document.getElementById('edit-exam2Score').style.display = isDiagnostic ? 'block' : 'none';
            document.getElementById('edit-exam3Score').style.display = isDiagnostic ? 'block' : 'none';
            document.getElementById('edit-totalScore').style.display = isDiagnostic ? 'block' : 'none';
            document.getElementById('exam-subtitle1').style.display = isDiagnostic ? 'block' : 'none';
            document.getElementById('exam-subtitle2').style.display = isDiagnostic ? 'block' : 'none';
            document.getElementById('exam-subtitle3').style.display = isDiagnostic ? 'block' : 'none';
            document.getElementById('exam-subtitle4').style.display = isDiagnostic ? 'block' : 'none';
            document.getElementById('exam-subtitle5').style.display = !isDiagnostic ? 'block' : 'none';
            document.getElementById('edit-hands-on').style.display = !isDiagnostic ? 'block' : 'none';


            document.getElementById('edit-exam1Score').value = score1;
            document.getElementById('edit-exam2Score').value = score2;
            document.getElementById('edit-exam3Score').value = score3;
            document.getElementById('edit-totalScore').value = totalScore;
            document.getElementById('edit-hands-on').value = handson;
            // Handle application form display or processing (e.g., displaying a link)
            var applicationFormIframe = document.getElementById('edit-applicationFormIframe');
            if (hasApplicationForm) {
                applicationFormIframe.src = 'applicant-form.php?id=' + id; // Assuming you have a link structure like this
                applicationFormIframe.style.display = 'block';
                
                
            } else {
                applicationFormIframe.src = ''; // Clear the iframe src
                applicationFormIframe.style.display = 'none';
            }
        });
    });
});

function viewApplicationForm(event) {
    event.preventDefault();
    var applicantId = document.getElementById('edit-applicantID').value;
    if (applicantId) {
        var url = 'applicant-form.php?id=' + encodeURIComponent(applicantId);
        window.open(url, '_blank');
    } else {
        alert('No application form available.');
    }
}

var id = btn.getAttribute('data-id');


            var hasApplicationForm = btn.getAttribute('data-application-form') === 'true';

            // ... existing code to populate other fields ...

            // Update the application form link visibility
            var currentApplicantFormLink = document.getElementById('current-applicantForm');
            if (hasApplicationForm) {
                currentApplicantFormLink.style.display = 'inline';
                currentApplicantFormLink.textContent = 'View Attachment';
            } else {
                currentApplicantFormLink.style.display = 'none';
                currentApplicantFormLink.textContent = 'No Attachment';
            }

            // Set the applicant ID in the hidden input
            document.getElementById('edit-applicantID').value = id;
            
</script>
