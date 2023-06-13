<?php
include 'connect.php';
include 'header.php';

echo '<h2>Δημιουργία κατηγορίας</h2>';

if (isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true) {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        echo "<form method='post' action=''>
            Όνομα κατηγορίας: <input type='text' name='cat_name' />
            Περιγραφή κατηγορίας: <textarea name='cat_description'></textarea>
            <input type='submit' value='Προσθήκη κατηγορίας' />
         </form>";
    } else {
        $cat_name = mysqli_real_escape_string($conn, $_POST['cat_name']);
        $cat_description = mysqli_real_escape_string($conn, $_POST['cat_description']);
        $sql = "INSERT INTO categories(cat_name, cat_description)
               VALUES('" . $cat_name . "', '" . $cat_description . "')";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            echo 'Σφάλμα κατά την εισαγωγή της κατηγορίας. Παρακαλώ δοκιμάστε ξανά αργότερα.';
        } else {
            echo 'Η νέα κατηγορία προστέθηκε με επιτυχία.';
        }
    }
} else {
    echo 'Λυπούμαστε, πρέπει να είστε <a href="signin.php">συνδεδεμένος</a> για να προσθέσετε μια κατηγορία.';
}

if (isset($_SESSION['user_level']) && $_SESSION['user_level'] == 1) {
    echo '<h2>Διαγραφή κατηγορίας</h2>';
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
        // Display list of categories with delete links
        $sql = "SELECT cat_id, cat_name FROM categories";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            echo '<ul>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<li>' . $row['cat_name'] . ' - <a href="your_delete_category_page.php?cat_id=' . $row['cat_id'] . '">Delete</a></li>';
            }
            echo '</ul>';
        } else {
            echo 'Δεν υπάρχουν διαθέσιμες κατηγορίες προς διαγραφή.';
        }
    }
}

include 'footer.php';
?>
