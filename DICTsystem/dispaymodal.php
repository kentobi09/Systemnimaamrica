<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>
    <style>
        .display-header{
            font-size: 1.6em;
            margin-bottom: 20px;
        }
        p{
            font-size: 1.2em;
            font-weight: 400;
        }
        span{
            font-weight: 400;
        }


    </style>
</head>

<body>
 <!-- Display Modal -->
<div class="modal fade" id="applicantModal" tabindex="-1" role="dialog" aria-labelledby="applicantModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="applicantModalLabel">Applicant Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <!-- Personal Details -->
                    <div class="col-md-6">
                        <h4 class="section-title display-header"><b>Personal Details</b></h4>
                        <p><strong>Applicant ID:</strong> <span id="modal-applicantID"></span></p>
                        <p><strong>Name:</strong> <span id="modal-name"></span></p>
                        <p><strong>Sex:</strong> <span id="modal-sex"></span></p>
                        <p><strong>Province:</strong> <span id="modal-province"></span></p>
                        <p><strong>Contact Number:</strong> <span id="modal-contactNumber"></span></p>
                        <p><strong>Email Address:</strong> <span id="modal-emailAddress"></span></p>
                    </div>
                    <!-- Examination Details -->
                    <div class="col-md-6">
                        <h4 class="section-title display-header"><b>Examination Details</b></h4>
                        <p><strong>Date of Notification:</strong> <span id="modal-notificationDate"></span></p>
                        <p><strong>Date of Examination:</strong> <span id="modal-examDate"></span></p>
                        <p><strong>Exam Venue:</strong> <span id="modal-examVenue"></span></p>
                        <p><strong>Proctor:</strong> <span id="modal-proctor"></span></p>
                        <p><strong>Status:</strong> <span id="modal-status"></span></p>
                    </div>
                </div>
                <div class="row">
                    <!-- Score Details with Tabs -->
                    <div class="col-md-12">
                        <ul class="nav nav-tabs" id="scoreTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="diagnostic-tab" data-toggle="tab" href="#diagnostic" role="tab" aria-controls="diagnostic" aria-selected="true">Diagnostic Score</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="hands-on-tab" data-toggle="tab" href="#hands-on" role="tab" aria-controls="hands-on" aria-selected="false">Summary Score</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-3" id="scoreTabsContent">
                            <!-- Diagnostic Score Tab -->
                            <div class="tab-pane fade show active" id="diagnostic" role="tabpanel" aria-labelledby="diagnostic-tab">
                                <div class="row">
                                    <!-- Diagnostic Score Details -->
                                    <div class="col-md-6">
                                        <h4 class="section-title display-header"><b>Diagnostic Score Details</b></h4>
                                        <p><strong>Score Part 1 :</strong> <span id="modal-score1"></span></p>
                                        <p><strong>Score Part 2 :</strong> <span id="modal-score2"></span></p>
                                        <p><strong id="score3-title">Score Part 3 :</strong> <span id="modal-score3"></span></p>
                                        <p><strong>Total Score &nbsp;  :</strong> <span id="modal-totalScore"></span></p>
                                    </div>
                                    <!-- Attached File -->
                                    <div class="col-md-6">
                                        <h4 class="section-title display-header"><b>Attached File</b></h4>
                                        <p><strong>Application Form:</strong> <a id="modal-applicationFormLink" href="#" target="_blank">View Attachment</a></p>
                                    </div>
                                </div>
                            </div>
                            <!-- Hands-on Score Tab -->
                            <div class="tab-pane fade" id="hands-on" role="tabpanel" aria-labelledby="hands-on-tab">
                                <div class="row">
                                    <!-- Hands-on Score Details -->
                                    <div class="col-md-6">
                                        <h4 class="section-title display-header"><b>Summary Score</b></h4>
                                        <!-- Replace with hands-on score details as needed -->
                                        <p><strong>Diagnostic Score :</strong> <span id="modal-hands-on-score1"></span></p>
                                        <p><strong>Hands-on Score &nbsp;:</strong> <span id="modal-hands-on-score2"></span></p>
                                        <p><strong>Summay Score&nbsp; &nbsp; :</strong> <span id="modal-totalHandsOnScore"></span></p>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="section-title display-header"><b>Attached File</b></h4>
                                        <p><strong>Application Form:</strong> <a id="modal-applicationFormLink" href="#" target="_blank">View Attachment</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


</body>

</html>
<!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"></script> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    var score1,score2,score3,total;
    document.addEventListener('DOMContentLoaded', function() {
        const tableBody = document.getElementById('applicant-table-body');

        tableBody.addEventListener('click', function(event) {
            // Check if the click was on an edit or delete button
            if (event.target.closest('.edit-applicant-btn') || event.target.closest('.btn-danger')) {
                return; // Do nothing if clicked on an edit or delete button
            }

            // Find the closest parent <tr> element that contains the clicked element
            const row = event.target.closest('tr');

            // If no row is found or if the click was not inside a row, exit
            if (!row) {
                return;
            }

            // Extract data attributes from the row
            const applicantID = row.getAttribute('data-applicant-id');
            const name = row.cells[2].innerText.trim();
            const sex = row.cells[3].innerText.trim();
            const province = row.cells[4].innerText.trim();
            const contact = row.cells[15].innerText.trim(); // Adjust based on your table structure
            const email = row.cells[14].innerText.trim(); // Adjust based on your table structure
            const notification = row.cells[7].innerText.trim(); // Assuming this is the date_of_notification
            const examDate = row.cells[5].innerText.trim(); // Assuming this is the date_of_examination
            const examVenue = row.cells[6].innerText.trim();
            const proctor = row.cells[13].innerText.trim();
            const status = row.cells[14].innerText.trim();
            score1 = row.cells[8].innerText.trim(); // Adjust based on your table structure
            score2 = row.cells[9].innerText.trim(); // Adjust based on your table structure
            score3 = row.cells[10].innerText.trim(); // Adjust based on your table structure
            total = row.cells[11].innerText.trim(); // Adjust based on your table structure
            handson = row.cells[12].innerText.trim(); // Adjust based on your table structure
            
            const attachmentLink = row.querySelector('.attachment a').getAttribute('href');

            // Set values in the modal fields
            document.getElementById('modal-applicantID').textContent = applicantID;
            document.getElementById('modal-name').textContent = name;
            document.getElementById('modal-sex').textContent = sex;
            document.getElementById('modal-province').textContent = province;
            document.getElementById('modal-contactNumber').textContent = contact;
            document.getElementById('modal-emailAddress').textContent = email;
            document.getElementById('modal-notificationDate').textContent = notification;
            document.getElementById('modal-examDate').textContent = examDate;
            document.getElementById('modal-examVenue').textContent = examVenue;
            document.getElementById('modal-proctor').textContent = proctor;
            document.getElementById('modal-status').textContent = status;
            document.getElementById('modal-score1').textContent = score1;
            document.getElementById('modal-score2').textContent = score2;
            document.getElementById('modal-score3').textContent = score3;
            document.getElementById('modal-totalScore').textContent = total;
            document.getElementById('modal-applicationFormLink').setAttribute('href', attachmentLink);
            if (handson.trim() === '') {handson =0;}
            document.getElementById('modal-hands-on-score1').textContent = total;
            document.getElementById('modal-hands-on-score2').textContent = handson;
            document.getElementById('modal-totalHandsOnScore').textContent = parseInt(total) +parseInt(handson);
            // Open the modal
            const modal = new bootstrap.Modal(document.getElementById('applicantModal'));
            modal.show();
        });
    });



//     document.addEventListener('DOMContentLoaded', function() {
//     var showHandsOnButton = document.getElementById('showHandsOnButton');
//     var scoresVisible = false; // Variable to track visibility state

//     showHandsOnButton.addEventListener('click', function() {
//         // Toggle visibility of score elements
//         if (scoresVisible) {
//             // Hide scores
//             document.getElementById('remove').style.display = 'inline'; 
//             document.getElementById('modal-score3').style.display = 'inline'; 
//             document.getElementById('modal-score1').textContent = score1;
//             document.getElementById('modal-score2').textContent = score2;
//             document.getElementById('modal-score3').textContent = score3;
//             document.getElementById('modal-totalScore').textContent =total;

//             document.getElementById('change-title').textContent = 'Score Details';
//         } else {
//             // Show scores
//             document.getElementById('remove').style.display = 'none'; 
//             document.getElementById('modal-score3').style.display = 'none'; 
//             document.getElementById('modal-score1').textContent = 1;
//             document.getElementById('modal-score2').textContent = 2;
//             document.getElementById('change-title').textContent = 'Summary Score';
//         }

//         // Toggle the state
//         scoresVisible = !scoresVisible;
//     });
// });


</script>