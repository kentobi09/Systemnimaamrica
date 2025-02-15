<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/css/datepicker-bs5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/datepicker-full.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <style>
        .modal-custom-size {
            max-width: 800px;
            font-size: 16px;
        }

        .modal-header {
            background-color: #007bff;
            color: white;   

        }
    </style>
</head>

<body>
<div class="container px-0">
    <!-- Add Modal -->
    <div class="modal fade" id="addApplicantModal" tabindex="-1" role="dialog" aria-labelledby="addApplicantModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addApplicantModalLabel">Add Applicant</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="examTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="diagnostic-tab" data-bs-toggle="tab" data-bs-target="#diagnostic" type="button" role="tab" aria-controls="diagnostic" aria-selected="true">Diagnostic Exam</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="hands-on-tab" data-bs-toggle="tab" data-bs-target="#handson" type="button" role="tab" aria-controls="handson" aria-selected="false">Hands-on Exam</button>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content mt-3" id="examTabsContent">
                        <!-- Diagnostic Exam Tab -->
                        <div class="tab-pane fade show active" id="diagnostic" role="tabpanel" aria-labelledby="diagnostic-tab">
                            <form method="post" action="insert.php" enctype="multipart/form-data">
                                <div class="row">
                                    <!-- Left column for Personal and Examination Details -->
                                    <div class="col-md-6 section">
                                        <h4 class="section-title"><b>Personal Details</b></h4>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Firstname" required>
                                            <input type="text" class="form-control my-3" id="middlename" name="middlename" placeholder="Middlename">
                                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Lastname" required>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" id="sex" name="sex" required>
                                                <option value="">Select Sex</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" id="province" name="province" required>
                                                <option value="">Select Province</option>
                                                <option value="Batanes">Batanes</option>
                                                <option value="Cagayan">Cagayan</option>
                                                <option value="Isabela">Isabela</option>
                                                <option value="Nueva Vizcaya">Nueva Vizcaya</option>
                                                <option value="Quirino">Quirino</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <input type="tel" class="form-control" id="contact_number" name="contact_number" placeholder="Contact Number" pattern="\d{11}" title="Phone number must be 11 digits">

                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="email_address" name="email_address" placeholder="Email Address">
                                        </div>
                                    </div>
                                    <div class="col-md-6 section">
                                        <h4 class="section-title"><b>Examination Details</b></h4>
                                        <div class="form-group">
                                            <span><b>Date of Notification</b></span>
                                            <input type="text" class="form-control" id="notificationDate" name="date_of_notification" placeholder="mm/dd/yyyy" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <span><b>Date of Examination</b></span>
                                            <input type="text" class="form-control" id="examDate" name="date_of_examination" placeholder="mm/dd/yyyy" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">

                                            <select class="form-control" id="examVenue" name="exam_venue" required>
                                                <option value="">Select Exam Venue</option>
                                                <option value="hall-a">Hall A</option>
                                                <option value="hall-b">Hall B</option>
                                                <option value="hall-c">Hall C</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="proctorName" name="proctor" placeholder="Proctor" required>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" id="examStatus" name="status" required>
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
                                            <input type="text" class="form-control" id="exam1Score" name="exam1Score" placeholder="Diagnostic Exam 1" oninput="calculateTotal()" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="exam2Score" name="exam2Score" placeholder="Diagnostic Exam 2" oninput="calculateTotal()" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="exam3Score" name="exam3Score" placeholder="Diagnostic Exam 3" oninput="calculateTotal()" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="totalScore" name="totalScore" placeholder="Diagnostic Exam Total:" readonly>
                                        </div>
                                    </div>
                                    <!-- Attached File -->
                                    <div class="col-md-6 section">
                                        <h4 class="section-title"><b>Attached File</b></h4>
                                        <div class="form-group">
                                            <input type="file" class="form-control-file" id="applicantForm" name="applicant_form" accept=".pdf" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" id="fileName" name="file_name" placeholder="File Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </div>
                            </form> 
                        </div>
                    </div>

                    <!-- Hands-on Exam Tab -->
                    <div class="tab-pane fade" id="handson" role="tabpanel" aria-labelledby="hands-on-tab">
                        <form method="post" action="hands-on-insert.php" enctype="multipart/form-data">
                            <div class="row">
                                <!-- Left column for Hands-on Examination Details -->
                                <div class="col-md-6 section">
                                <div class="form-group">
                                            <input type="search" class="form-control" id="add-ID" name="add-ID" placeholder="Input Id or Name" autocomplete="off" >
                                        </div>
                                        <h4 class="section-title"><b>Examination Details</b></h4>
                                        <div class="form-group">
                                            <span><b>Date of Notification</b></span>
                                            <input type="text" class="form-control" id="handson-notificationDate" name="handson-date_of_notification" placeholder="mm/dd/yyyy" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">
                                            <span><b>Date of Examination</b></span>
                                            <input type="text" class="form-control" id="handson-examDate" name="handson-date_of_examination" placeholder="mm/dd/yyyy" autocomplete="off" required>
                                        </div>
                                        <div class="form-group">

                                            <select class="form-control" id="handson-examVenue" name="handson-exam_venue" required>
                                                <option value="">Select Exam Venue</option>
                                                <option value="hall-a">Hall A</option>
                                                <option value="hall-b">Hall B</option>
                                                <option value="hall-c">Hall C</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="handson-proctorName" name="handson-proctorName" placeholder="Proctor" required>
                                        </div>
                                        <div class="form-group">
                                            <select class="form-control" id="handson-status" name="handson-status" required>
                                                <option value="">Select Status</option>
                                                <option value="Failed">Failed</option>
                                                <option value="Passed">Passed</option>
                                                <option value="Pending">Pending</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 section">
                                        <h4 class="section-title"><b>Score Details</b></h4>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="add-handsonscore" name="add-handsonscore" placeholder="Hands-on Exam">
                                        </div>
                                    </div>
                            </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>






<script>
document.addEventListener('DOMContentLoaded', function() {
    var notificationDatepicker = new Datepicker(document.getElementById('handson-notificationDate'), {
        format: 'yyyy-mm-dd', 
        autohide: true,
        minDate: new Date(2020, 0, 1), // January 1, 2020
    });

    var examDatepicker = new Datepicker(document.getElementById('handson-examDate'), {
        format: 'yyyy-mm-dd', 
        autohide: true,
        minDate: new Date(2020, 0, 1), // January 1, 2020
    });
}); 
document.addEventListener('DOMContentLoaded', function() {
    var notificationDatepicker = new Datepicker(document.getElementById('notificationDate'), {
        format: 'yyyy-mm-dd', 
        autohide: true,
        minDate: new Date(2020, 0, 1), // January 1, 2020
    });

    var examDatepicker = new Datepicker(document.getElementById('examDate'), {
        format: 'yyyy-mm-dd', 
        autohide: true,
        minDate: new Date(2020, 0, 1), // January 1, 2020
    });
}); 


                function calculateTotal() {
                    let exam1 = parseFloat(document.getElementById('exam1Score').value) || 0;
                    let exam2 = parseFloat(document.getElementById('exam2Score').value) || 0;
                    let exam3 = parseFloat(document.getElementById('exam3Score').value) || 0;
                    let total = exam1 + exam2 + exam3;
                    document.getElementById('totalScore').value = "Total : " + total.toFixed(0);
                    document.getElementById('total_score').value = total.toFixed(0);
                }
            document.addEventListener('DOMContentLoaded', function() {
                var modal = document.getElementById('applicantModal');
                modal.addEventListener('show.bs.modal', function() {
                    document.body.classList.add('modal-open');
                });
                modal.addEventListener('hide.bs.modal', function() {
                    document.body.classList.remove('modal-open');
                });
            });

            function addApplicant() {
                // Fetch values from the form
                const isDiagnostic = btn.getAttribute('data-table-type') == 'diagnostic';
                console.log(isDiagnostic);
                let name = document.getElementById('name').value;
                let sex = document.getElementById('sex').value;
                let province = document.getElementById('province').value;
                let examVenue = document.getElementById('examVenue').value;
                let dateOfExam = document.getElementById('dateOfExam').value;
                let dateOfNotification = document.getElementById('dateOfNotification').value;
                let proctor = document.getElementById('proctor').value;
                let status = document.getElementById('status').value;
                let file = document.getElementById('file').files[0];
                let contactNumber = document.getElementById('contactNumber').value;
                let emailAddress = document.getElementById('emailAddress').value;

                // You can perform validation here if needed

                // Construct FormData object
                let formData = new FormData();
                formData.append('name', name);
                formData.append('sex', sex);
                formData.append('province', province);
                formData.append('examVenue', examVenue);
                formData.append('dateOfExam', dateOfExam);
                formData.append('dateOfNotification', dateOfNotification);
                formData.append('proctor', proctor);
                formData.append('status', status);
                formData.append('file', file);
                formData.append('contactNumber', contactNumber);
                formData.append('emailAddress', emailAddress);

                // You can now submit this FormData object using AJAX to your server-side script
                // Example using jQuery AJAX
                $.ajax({
                    url: 'process_add_applicant.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Handle success response
                        console.log('Applicant added successfully.');
                        // Optionally, you can update your table or perform other actions here
                    },
                    error: function(error) {
                        // Handle error response
                        console.error('Error adding applicant:', error);
                    }
                });

                // Close the modal
                $('#applicantModal').modal('hide');
            }
            
        </script>
</body>

</html>

<script>
document.getElementById('contact_number').addEventListener('input', function (e) {
    e.target.value = e.target.value.replace(/\D/g, ''); // Replace non-digit characters with an empty string
});
document.getElementById('exam1Score').addEventListener('input', function (e) {
    e.target.value = e.target.value.replace(/\D/g, ''); // Replace non-digit characters with an empty string
});
document.getElementById('exam2Score').addEventListener('input', function (e) {
    e.target.value = e.target.value.replace(/\D/g, ''); // Replace non-digit characters with an empty string
});
document.getElementById('exam3Score').addEventListener('input', function (e) {
    e.target.value = e.target.value.replace(/\D/g, ''); // Replace non-digit characters with an empty string
});
document.getElementById('hands-onScore').addEventListener('input', function (e) {
    e.target.value = e.target.value.replace(/\D/g, ''); // Replace non-digit characters with an empty string
});

</script>
