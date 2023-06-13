<?php
include 'connect.php';
include 'header.php';


echo '<h3>Συνδεμένος</h3>';

if(isset($_SESSION['signed_in']) && $_SESSION['signed_in'] == true)
{
    echo 'Έχετε ήδη συνδεθεί, μπορείτε να κάνετε <a href="signout.php">sign out</a> αν θέλετε.';
}
else
{
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        
        echo '<form method="post" action="">
             Ονομα : <input type="text" name="user_name" />
            <br>
            Κωδικός: <input type="password" name="user_pass">
            <br>
            <input type="submit" value="Συνδεθείτε" />
         </form>';
    }
    else
    {
       
        $errors = array(); 

        if(!isset($_POST['user_name']))
        {
            $errors[] = 'Το πεδίο ονόματος χρήστη δεν πρέπει να είναι κενό.';
        }

        if(!isset($_POST['user_pass']))
        {
            $errors[] = 'ο πεδίο κωδικού πρόσβασης δεν πρέπει να είναι κενό.';
        }

        if(!empty($errors)) 
        {
            echo 'Mερικά πεδία δεν έχουν συμπληρωθεί σωστά..';
            echo '<ul>';
            foreach($errors as $key => $value) 
            {
                echo '<li>' . $value . '</li>'; 
            }
            echo '</ul>';
        }
        else
        {
            
            $sql = "SELECT
                        user_id,
                        user_name,
                        user_level
                    FROM
                        users
                    WHERE
                        user_name = '" . mysqli_real_escape_string($conn, $_POST['user_name']) . "'
                    AND
                        user_pass = '" . sha1($_POST['user_pass']) . "'";

            $result = mysqli_query($conn, $sql);
            if(!$result)
            {
               
                echo 'Παρουσιάστηκε κάποιο πρόβλημα κατά τη σύνδεση. Δοκιμάστε ξανά αργότερα.';
               
            }
            else
            {
               
                if(mysqli_num_rows($result) == 0)
                {
                    echo 'Έχετε δώσει λάθος όνομα/κωδικού πρόσβασης. παρακαλω προσπαθησε ξανα.';
                }
                else
                {
               
                    $_SESSION['signed_in'] = true;

                    
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $_SESSION['user_id']    = $row['user_id'];
                        $_SESSION['user_name']  = $row['user_name'];
                        $_SESSION['user_level'] = $row['user_level'];
                    }

                    echo 'Καλώς ορίσατε!, ' . $_SESSION['user_name'] . '. <a href="indexx.php"> Προχωρήστε στην επισκόπηση του φόρουμ </a>.';
                }
            }
        }
    }
}

include 'footer.php';
?>