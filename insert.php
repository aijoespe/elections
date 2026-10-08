<?php
include 'db.php';

/* Show a message, then send the student back to the form */
function reject($message) {
    echo "<script>alert(" . json_encode($message) . ");
          window.location.href = 'index.php';</script>";
    exit();
}

/* Show an animated checkmark, then redirect to the landing page */
function success($redirectTo = 'landingpage.php', $delayMs = 2500) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="refresh" content="<?= ceil($delayMs / 1000) + 1 ?>;url=<?= htmlspecialchars($redirectTo) ?>">
        <title>Vote Submitted</title>
        <style>
            * { box-sizing: border-box; }
            body {
                margin: 0;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                background: radial-gradient(1200px 600px at -10% -10%, #e6f0ff 0%, transparent 60%),
                radial-gradient(900px 500px at 110% 10%, #e6f3ff 0%, transparent 60%),
                linear-gradient(180deg, #ffffff 0%, #f7fbff 100%);;
                font-family: system-ui, -apple-system, "Segoe UI", sans-serif;
                color: #163969;
            }
            .check { width: 140px; height: 140px; animation: pop .5s ease-out .9s both; }
            .check circle {
                fill: none;
                stroke: #104baa;
                stroke-width: 6;
                stroke-linecap: round;
                stroke-dasharray: 314;
                stroke-dashoffset: 314;
                transform-origin: center;
                transform: rotate(-90deg);
                animation: draw .8s ease-out forwards;
            }
            .check path {
                fill: none;
                stroke: #104baa;
                stroke-width: 7;
                stroke-linecap: round;
                stroke-linejoin: round;
                stroke-dasharray: 60;
                stroke-dashoffset: 60;
                animation: draw .5s ease-out .7s forwards;
            }
            h1 { margin: 24px 0 4px; font-size: 1.8rem; animation: fade .6s ease-out 1.2s both; }
            p  { margin: 0; color: #163969; animation: fade .6s ease-out 1.4s both; }

            @keyframes draw { to { stroke-dashoffset: 0; } }
            @keyframes pop {
                0%   { transform: scale(1); }
                50%  { transform: scale(1.15); }
                100% { transform: scale(1); }
            }
            @keyframes fade {
                from { opacity: 0; transform: translateY(8px); }
                to   { opacity: 1; transform: translateY(0); }
            }
            @media (prefers-reduced-motion: reduce) {
                * { animation-duration: .01s !important; animation-delay: 0s !important; }
            }
        </style>
    </head>
    <body>
        <svg class="check" viewBox="0 0 120 120" aria-hidden="true">
            <circle cx="60" cy="60" r="50"/>
            <path d="M38 62 L54 78 L84 44"/>
        </svg>
        <h1>Vote Submitted!</h1>
        <p>Thank you for voting. Redirecting...</p>

        <script>
            setTimeout(function () {
                window.location.href = <?= json_encode($redirectTo) ?>;
            }, <?= (int)$delayMs ?>);
        </script>
    </body>
    </html>
    <?php
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

$lastName   = trim($_POST['ln'] ?? '');
$firstName  = trim($_POST['fn'] ?? '');
$middleName = trim($_POST['mn'] ?? '');
$lrn        = trim($_POST['LRN'] ?? '');
$section    = $_POST['section'] ?? '';
$vote1      = $_POST['g7rep1'] ?? '';
$vote2      = $_POST['g7rep2'] ?? '';

$fullName = $lastName . ', ' . $firstName;

/* 1. Format check: exactly 12 digits */
if (!preg_match('/^[0-9]{12}$/', $lrn)) {
    reject('Invalid LRN. It must be exactly 12 digits (numbers only).');
}

/* 2. Look up the LRN in the official list */
$find = $conn->prepare("SELECT section FROM lrn_list WHERE lrn = ?");
$find->bind_param("s", $lrn);
$find->execute();
$find->bind_result($rosterSection);

if (!$find->fetch()) {
    reject('Invalid LRN');                          // LRN doesn't exist
}
$find->close();

/* 2b. LRN exists, but does it belong to the entered section? */
if (strcasecmp(trim($rosterSection), $section) !== 0) {
    reject('LRN invalid, section mismatch. Check your section.');          // section mismatch
}
$section = trim($rosterSection);

/* 3. Has this LRN already voted? */
$check = $conn->prepare("SELECT id FROM voters WHERE lrn = ?");
$check->bind_param("s", $lrn);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    reject('This LRN has already been used to vote.');
}
$check->close();

/* 4. Validate the ballot values */
foreach ([$vote1, $vote2] as $v) {
    if ($v !== 'Abstain' && !ctype_digit($v)) {
        reject('Invalid ballot selection.');
    }
}
if ($vote1 !== 'Abstain' && intval($vote1) === intval($vote2)) {
    reject('You cannot choose the same candidate twice.');
}

/* 5. Save voter + votes together (all or nothing) */
try {
    $conn->begin_transaction();

    $save = $conn->prepare(
        "INSERT INTO voters (lastName, firstName, middleName, lrn, section) VALUES (?, ?, ?, ?, ?)");
    $save->bind_param("sssss", $lastName, $firstName, $middleName, $lrn, $section);
    $save->execute();

    foreach ([$vote1, $vote2] as $v) {
        if ($v !== 'Abstain') {
            $candidate_id = intval($v);
            $vote = $conn->prepare("UPDATE candidates SET votes = votes + 1 WHERE id = ?");
            $vote->bind_param("i", $candidate_id);
            $vote->execute();
            if ($vote->affected_rows !== 1) {
                throw new mysqli_sql_exception('Unknown candidate');
            }
        }
    }

    $conn->commit();
} catch (mysqli_sql_exception $e) {
    $conn->rollback();
    if ($e->getCode() == 1062) {
        reject('This LRN has already been used to vote.');
    }
    reject('Something went wrong saving your ballot. Please try again.');
}

/* Only reached if the vote was saved successfully */
success('landingpage.php', 2500);