
<?php
include 'connect.php';
include 'header.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo 'Αυτό το αρχείο δεν μπορεί να κληθεί απευθείας.';
} else {
    if (!isset($_SESSION['signed_in']) || !$_SESSION['signed_in']) {
        echo 'Πρέπει να είστε συνδεδεμένοι για να δημοσιεύσετε μια απάντηση.';
    } else {
        $sql = "INSERT INTO posts(post_content, post_date, post_topic, post_by)
                VALUES ('" . mysqli_real_escape_string($conn, $_POST['reply-content']) . "', NOW(), " . mysqli_real_escape_string($conn, $_GET['id']) . ", " . $_SESSION['user_id'] . ")";

        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo 'Η απάντησή σας δεν έχει αποθηκευτεί, δοκιμάστε ξανά αργότερα.';
        } else {
            echo 'Η απάντησή σας έχει αποθηκευτεί, ελέγξτε <a href="topic.php?id=' . htmlentities($_GET['id']) . '">το θέμα</a>.';
        }
    }
}
include 'footer.php';
?>