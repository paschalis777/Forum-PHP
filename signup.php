<?php
include 'connect.php';
include 'header.php';

echo '<h3>Εγγραφείτε</h3>';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    
    echo '<form method="post" action="">
        Ονομα : <input type="text" name="user_name" />
        <br>
        Κωδικός: <input type="password" name="user_pass">
        <br>
        Επιβεβαίωση Κωδικού : <input type="password" name="user_pass_check">
        <br>
        E-mail: <input type="email" name="user_email">
        <br>
        <input type="submit" value="Εγγραφείτε" />
     </form>';
}
else
{
    
    
    $errors = array(); 

    if(isset($_POST['user_name']))
    {
        
        if(!ctype_alnum($_POST['user_name']))
        {
            $errors[] = 'Το όνομα χρήστη μπορεί να περιέχει μόνο γράμματα και ψηφία.';
        }
        if(strlen($_POST['user_name']) > 30)
        {
            $errors[] = 'Το όνομα χρήστη δεν μπορεί να είναι μεγαλύτερο από 30 χαρακτήρες.';
        }
    }
    else
    {
        $errors[] = 'Το πεδίο ονόματος χρήστη δεν πρέπει να είναι κενό.';
    }


    if(isset($_POST['user_pass']))
    {
        if($_POST['user_pass'] != $_POST['user_pass_check'])
        {
            $errors[] = 'Οι δύο κωδικοί πρόσβασης δεν ταίριαζαν.';
        }
    }
    else
    {
        $errors[] = 'Το πεδίο κωδικού πρόσβασης δεν μπορεί να είναι κενό.';
    }

    if(!empty($errors)) 
    {
        echo 'Ορισμένα πεδία δεν έχουν συμπληρωθεί σωστά..';
        echo '<ul>';
        foreach($errors as $key => $value) 
        {
            echo '<li>' . $value . '</li>'; 
        }
        echo '</ul>';
    }
    else
    {
        
        $sql = "INSERT INTO
                    users(user_name, user_pass, user_email ,user_date, user_level)
                VALUES('" . mysqli_real_escape_string($conn, $_POST['user_name']) . "',
                       '" . sha1($_POST['user_pass']) . "',
                       '" . mysqli_real_escape_string($conn, $_POST['user_email']) . "',
                        NOW(),
                        0)";

        $result = mysqli_query($conn ,$sql);
        if(!$result)
        {
            
            echo 'Κάτι πήγε στραβά κατά την εγγραφή. Παρακαλώ δοκιμάστε ξανά αργότερα.';
            echo mysqli_error($conn); 
        }
        else
        {
            echo 'Η εγγραφή έγινε με επιτυχία. Μπορείς τώρα <a href="signin.php">sign in</a> να αρχίσετε να δημοσιεύετε! :-)';
        }
    }
}

include 'footer.php';
?>