<div class="table-responsive">
    <table class="table table-hover" data-table-type="handson">
        <thead>
            <tr class="table-primary">
                <th scope="col" class="delete-column"></th>
                <th scope="col" class="sticky-id">ID</th>
                <th scope="col" class="sticky-name">Name</th>
                <th scope="col">Sex</th>
                <th scope="col">Province</th>
                <th scope="col">Date of Examination</th>
                <th scope="col">Exam Venue</th>
                <th scope="col">Date of Notification</th>
                <th class="hide" scope="col" colspan="4" class="text-center">Score</th>
                <th scope="col">Proctor</th>
                <th scope="col">Status</th>
                <th class="hide" scope="col">Email</th>
                <th class="hide" scope="col">Contact Number</th>
                <th class="hide" scope="col">Attached Form</th>
            </tr>
            <tr class="hide text-center table-primary">
                <th class="hide" scope="col" class="delete-column"></th>
                <th class="hide" scope="col" class="sticky-id"></th>
                <th class="hide" scope="col" class="sticky-name"></th>
                <th class="hide" scope="col"></th>
                <th class="hide" scope="col"></th>
                <th class="hide" scope="col"></th>
                <th class="hide" scope="col"></th>
                <th class="hide" scope="col"></th>
                <th class="hide" scope="col" class="align-top">Part 1</th>
                <th class="hide" scope="col" class="align-top">Part 2</th>
                <th class="hide" scope="col" class="align-top">Part 3</th>
                <th class="hide" scope="col" class="align-top">Total Score</th>
                <th class="hide" scope="col"></th>
                <th class="hide" scope="col"></th>
                <th class="hide" scope="col"></th>
                <th class="hide" scope="col"></th>
                <th class="hide" scope="col"></th>
            </tr>
        </thead>
        <tbody id="applicant-table-body">

            <?php if (empty($applicant_record)) : ?>
                <tr>
                    <td class="delete-column">
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button class="btn btn-danger invisible" type="button" disabled><i class="bi bi-trash"></i></button>
                            <button class="btn btn-secondary invisible" type="button" disabled><i class="bi bi-pencil-square text-white"></i></button>
                        </div>
                    </td>
                    <td colspan="16" class="text-center">No records found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($applicant_record as $applicant) : ?>
                    <?php
                    // Check if handson ID is present for this applicant
                    $handsonFound = false;
                    foreach ($applicanthandson as $handson) {
                        if ($handson['applicantID'] === $applicant['applicantID']) {
                            $handsonFound = true;
                            break;
                        }
                    }
                    ?>

                    <?php if ($handsonFound) : ?>
                        <tr data-applicant-id="<?= htmlspecialchars($applicant['applicantID']) ?>">
                            <td class="delete-column">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button onclick="deletexid(<?php echo $applicant['applicantID'] ?>)" type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteApplicantModal" data-applicantid="<?php echo $applicant['applicantID']; ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <button class="btn btn-secondary edit-applicant-btn" type="button" data-table-type="handson" data-toggle="modal" data-target="#editApplicantModal"
    data-id="<?php echo htmlspecialchars($applicant['applicantID']); ?>"
    data-fname="<?php echo htmlspecialchars($applicant['firstname']); ?>"
    data-mname="<?php echo htmlspecialchars($applicant['middlename']); ?>"
    data-lname="<?php echo htmlspecialchars($applicant['lastname']); ?>"
    data-sex="<?php echo htmlspecialchars($applicant['sex']); ?>"
    data-province="<?php echo htmlspecialchars($applicant['province']); ?>"
    data-contact="<?php echo htmlspecialchars($applicant['contact_number']); ?>"
    data-email="<?php echo htmlspecialchars($applicant['email_address']); ?>"
    data-notification="<?php echo htmlspecialchars($applicant['date_of_notification']); ?>"
    data-exam-date="<?php echo htmlspecialchars($applicant['date_of_examination']); ?>"
    data-exam-venue="<?php echo htmlspecialchars($applicant['exam_venue']); ?>"
    data-proctor="<?php echo htmlspecialchars($applicant['proctor']); ?>"
    data-status="<?php echo htmlspecialchars($applicant['status']); ?>"
    <?php if (isset($scores[$applicant['applicantID']])) : ?>
        <?php $score = $scores[$applicant['applicantID']]; ?>
        data-score1="<?php echo htmlspecialchars($score['score1']); ?>"
        data-score2="<?php echo htmlspecialchars($score['score2']); ?>"
        data-score3="<?php echo htmlspecialchars($score['score3']); ?>"
        data-total="<?php echo htmlspecialchars($score['total']); ?>"
        data-handson="<?php echo htmlspecialchars($score['hands_on']); ?>"
        data-handson2 = "<?php echo htmlspecialchars($score['hands_on']); ?>"
    <?php else : ?>
        data-score1="" data-score2="" data-score3="" data-total=""
    <?php endif; ?>
    data-application-form="<?php echo !empty($applicant['application_form']); ?>"
    data-handson-exam-date="<?php echo htmlspecialchars($handson['date_of_examination']); ?>"
    data-handson-notification="<?php echo htmlspecialchars($handson['date_of_notification']); ?>"
    data-handson-status="<?php echo htmlspecialchars($handson['handson_status']); ?>"
    data-handson-exam-venue="<?php echo htmlspecialchars($handson['exam_venue']); ?>"
    data-handson-proctor="<?php echo htmlspecialchars($handson['proctor']); ?>"
>
    <i class="bi bi-pencil-square text-white"></i>
</button>

                                </div>
                            </td>
                            <td class="sticky-id applicant-id"><?= htmlspecialchars($applicant['applicantID']) ?></td>
                            <td class="sticky-name applicant-name"><?= htmlspecialchars($applicant['firstname'] . ' ' . strtoupper($applicant['middlename'][0]) . '. ' . $applicant['lastname']) ?></td>
                            <td class="applicant-sex"><?= htmlspecialchars($applicant['sex']) ?></td>
                            <td class="applicant-province"><?= htmlspecialchars($applicant['province']) ?></td>
                            <td class="applicant-exam-date"><?= htmlspecialchars((new DateTime($handson['date_of_examination']))->format('M d Y')) ?></td>
                            <td class="applicant-exam-venue"><?= htmlspecialchars($handson['exam_venue']) ?></td>
                            <td class="applicant-notification-date"><?= htmlspecialchars((new DateTime($handson['date_of_notification']))->format('M d Y')) ?></td>

                            <?php if (isset($scores[$applicant['applicantID']])) : ?>
                                <?php $score = $scores[$applicant['applicantID']]; ?>
                                <td class="score applicant-score1 hide"><?= htmlspecialchars($score['score1']) ?></td>
                                <td class="score applicant-score2 hide"><?= htmlspecialchars($score['score2']) ?></td>
                                <td class="score applicant-score3 hide"><?= htmlspecialchars($score['score3']) ?></td>
                                <td class="score total-score hide"><?= htmlspecialchars($score['total']) ?></td>
                                <td class="score handson hide"><?= htmlspecialchars($score['hands_on']) ?></td>
                            <?php else : ?>
                                <td colspan="4">No scores found</td>
                            <?php endif; ?>

                            <td class="proctor"><?= htmlspecialchars($handson['proctor']) ?></td>
                            <td class="status"><?= htmlspecialchars($handson['handson_status']) ?></td>
                            <td class="email-address hide"><a href="mailto:<?= htmlspecialchars($applicant['email_address']) ?>"><?= htmlspecialchars($applicant['email_address']) ?></a></td>
                            <td class="contact-number hide"><?= htmlspecialchars($applicant['contact_number']) ?></td>
                            <td class="attachment hide"><a target="_blank" href="applicant-form.php?id=<?= $applicant['applicantID'] ?>">attachment</a></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
