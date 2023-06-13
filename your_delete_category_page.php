<?php
include 'connect.php';
include 'header.php';

if (isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true && $_SESSION['user_level'] == 1) {
    if (isset($_GET['cat_id'])) {
        $cat_id = $_GET['cat_id'];
        // Perform delete operation
        $sql = "DELETE FROM categories WHERE cat_id = " . mysqli_real_escape_string($conn, $cat_id);
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo 'Η κατηγορία έχει διαγραφεί επιτυχώς.';
        } else {
            echo 'Παρουσιάστηκε σφάλμα κατά τη διαγραφή της κατηγορίας. Παρακαλώ δοκιμάστε ξανά αργότερα.';
        }
    } else {
        echo 'Δεν παρέχεται κατηγορία για διαγραφή.';
    }
} else {
    echo 'Δεν έχετε τα απαιτούμενα δικαιώματα για να εκτελέσετε αυτήν την ενέργεια.';
}

include 'footer.php';
?>