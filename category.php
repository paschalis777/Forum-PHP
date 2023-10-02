<?php
include 'connect.php';
include 'header.php';




$sql = "SELECT
            cat_id,
            cat_name,
            cat_description
        FROM
            categories
        WHERE
            cat_id = " . mysqli_real_escape_string($conn, $_GET['id']);

$result = mysqli_query($conn, $sql);

if(!$result)
{
    echo 'Δεν ήταν δυνατή η εμφάνιση της κατηγορίας, δοκιμάστε ξανά αργότερα.' . mysqli_error($conn);
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo 'Αυτή η κατηγορία δεν υπάρχει.';
    }
    else
    {
       
        while($row = mysqli_fetch_assoc($result))
        {
            echo '<h2>Topics in ′' . $row['cat_name'] . '′ category</h2>';
        }

       
        $sql = "SELECT
                    topic_id,
                    topic_subject,
                    topic_date,
                    topic_cat
                FROM
                    topics
                WHERE
                    topic_cat = " . mysqli_real_escape_string($conn, $_GET['id']);

        $result = mysqli_query($conn, $sql);

        if(!$result)
        {
            echo 'Δεν ήταν δυνατή η εμφάνιση των θεμάτων, δοκιμάστε ξανά αργότερα.';
        }
        else
        {
            if(mysqli_num_rows($result) == 0)
            {
                echo 'Δεν υπάρχουν ακόμα θέματα σε αυτήν την κατηγορία.';
            }
            else
            {
                
                echo '<table border="1">
                      <tr>
                        <th>Topic</th>
                        <th>Created at</th>
                      </tr>';

                while($row = mysqli_fetch_assoc($result))
                {
                    echo '<tr>';
                        echo '<td class="leftpart">';
                            echo '<h3><a href="topic.php?id=' . $row['topic_id'] . '">' . $row['topic_subject'] . '</a><h3>';
                        echo '</td>';
                        echo '<td class="rightpart">';
                            echo date('d-m-Y', strtotime($row['topic_date']));
                        echo '</td>';
                    echo '</tr>';
                }
            }
        }
    }
}
include 'footer.php';
?>