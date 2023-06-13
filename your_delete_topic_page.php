<?php
include 'connect.php';
include 'header.php';

if ($_SESSION['user_level'] != 1) {
    echo 'Δεν έχετε δικαιώματα για διαγραφή θεμάτων.';
    exit;
}

if (isset($_GET['topic_id'])) {
    $topic_id = $_GET['topic_id'];

    $sql = "DELETE FROM topics WHERE topic_id = " . mysqli_real_escape_string($conn, $topic_id);
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo 'Το θέμα έχει διαγραφεί επιτυχώς.';
    } else {
        echo 'Παρουσιάστηκε σφάλμα κατά τη διαγραφή του θέματος. Παρακαλώ δοκιμάστε ξανά αργότερα.';
    }
} else {
    echo 'Δεν παρέχεται αριθμός αναγνωριστικού θέματος.';
}
?>