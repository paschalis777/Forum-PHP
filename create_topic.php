<?php
include 'connect.php';
include 'header.php';

echo '<h2>Δημιουργία θέματος</h2>';

if (!isset($_SESSION['signed_in'])) {
    echo 'Λυπούμαστε, πρέπει να είστε <a href="signin.php">συνδεδεμένος</a> για να δημιουργήσετε ένα θέμα.';
} else {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        $sql = "SELECT
                    cat_id,
                    cat_name,
                    cat_description
                FROM
                    categories";

        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo 'Σφάλμα κατά την ανάκτηση δεδομένων από τη βάση. Παρακαλώ δοκιμάστε ξανά αργότερα.';
        } else {
            if (mysqli_num_rows($result) == 0) {
                echo 'Δεν υπάρχουν διαθέσιμες κατηγορίες. Μπορείτε να δημιουργήσετε μια νέα κατηγορία.';
            } else {
                echo '<form method="post" action="">
                    Θέμα: <input type="text" name="topic_subject" /><br />
                    Κατηγορία:';

                echo '<select name="topic_cat">';
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<option value="' . $row['cat_id'] . '">' . $row['cat_name'] . '</option>';
                }
                echo '</select>';

                echo '<br />Μήνυμα: <textarea name="post_content"></textarea><br />
                    <input type="submit" value="Δημιουργία θέματος" />
                 </form>';
            }
        }
    } else {
        $query = "BEGIN WORK;";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            echo 'Παρουσιάστηκε σφάλμα κατά τη δημιουργία του θέματος. Παρακαλώ δοκιμάστε ξανά αργότερα.';
        } else {
            $sql = "INSERT INTO topics(topic_subject, topic_date, topic_cat, topic_by)
                    VALUES('" . mysqli_real_escape_string($conn, $_POST['topic_subject']) . "', NOW(), " . mysqli_real_escape_string($conn, $_POST['topic_cat']) . ", " . $_SESSION['user_id'] . ")";

            $result = mysqli_query($conn, $sql);
            if (!$result) {
                echo 'Παρουσιάστηκε σφάλμα κατά την εισαγωγή των δεδομένων σας. Παρακαλώ δοκιμάστε ξανά αργότερα.' . mysqli_error($conn);
                $sql = "ROLLBACK;";
                $result = mysqli_query($conn, $sql);
            } else {
                $topicid = mysqli_insert_id($conn);
                $topic_category = mysqli_real_escape_string($conn, $_POST['topic_cat']);

                $sql = "INSERT INTO posts(post_content, post_date, post_topic, post_by)
                        VALUES('" . mysqli_real_escape_string($conn, $_POST['post_content']) . "', NOW(), " . $topicid . ", " . $_SESSION['user_id'] . ")";

                $result = mysqli_query($conn, $sql);

                if (!$result) {
                    echo 'Παρουσιάστηκε σφάλμα κατά την εισαγωγή της ανάρτησής σας. Παρακαλώ δοκιμάστε ξανά αργότερα.' . mysqli_error($conn);
                    $sql = "ROLLBACK;";
                    $result = mysqli_query($conn, $sql);
                } else {
                    $sql = "COMMIT;";
                    $result = mysqli_query($conn, $sql);

                    echo 'Έχετε δημιουργήσει με επιτυχία <a href="category.php?id=' . $topic_category . '">το νέο σας θέμα</a>.';
                }
            }
        }
    }
}

if (isset($_SESSION['user_level']) && $_SESSION['user_level'] == 1) {
    echo '<h2>Διαγραφή θέματος</h2>';
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
        $sql = "SELECT topic_id, topic_subject FROM topics";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            echo '<ul>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<li>' . $row['topic_subject'] . ' - <a href="your_delete_topic_page.php?topic_id=' . $row['topic_id'] . '">Delete</a></li>';
            }
            echo '</ul>';
        } else {
            echo 'Δεν υπάρχουν διαθέσιμα θέματα προς διαγραφή.';
        }
    }
}

include 'footer.php';
?>

