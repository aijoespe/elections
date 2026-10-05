<?php
include 'db.php';

$lastName    = $_POST['ln'];
$firstName    = $_POST['fn'];
$middleName    = $_POST['mn'];
$lrn     = $_POST['LRN'];
$section = $_POST['Section'];
$vote1 = $_POST['g7rep1'];
$vote2 = $_POST['g7rep2'];

/* Check if this student already voted */
$check = $conn->prepare("SELECT id FROM voters WHERE lrn = ?");
$check->bind_param("s", $lrn);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo "<script>alert('You already voted.');</script>";
    echo "<script>window.location.href = 'landingpage.php';</script>";
    exit();
}

/* Save voter */
$save = $conn->prepare(
    "INSERT INTO voters (lastName, firstName, middleName, lrn, section)
     VALUES (?, ?, ?, ?, ?)"
);

$save->bind_param("sssss", $lastName, $firstName, $middleName, $lrn, $section);
$save->execute();


/* Add vote for Representative No. 1 */
if ($vote1 !== "Abstain") {

    $vote = $conn->prepare(
        "UPDATE candidates
         SET votes = votes + 1
         WHERE id = ?"
    );

    $candidate_id = intval($vote1);

    $vote->bind_param("i", $candidate_id);
    $vote->execute();
    echo "<script>window.location.href = 'landingpage.php';</script>";
}


/* Add vote for Representative No. 2 */
if ($vote2 !== "Abstain") {

    $vote = $conn->prepare(
        "UPDATE candidates
         SET votes = votes + 1
         WHERE id = ?"
    );

    $candidate_id = intval($vote2);

    $vote->bind_param("i", $candidate_id);
    $vote->execute();
    echo "<script>window.location.href = 'landingpage.php';</script>";
}


?>