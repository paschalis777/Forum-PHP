<?php
include 'connect.php';
include 'header.php';



$sql = "SELECT
        topic_id,
        topic_subject,
        topic_by
        FROM
        topics
        WHERE
        topics.topic_id = " . mysqli_real_escape_string($conn, $_GET['id']);

$result = mysqli_query($conn, $sql);

if (!$result) {
    echo 'Δεν ήταν δυνατή η εμφάνιση του θέματος, δοκιμάστε ξανά αργότερα.' . mysqli_error($conn);
} else {
    if (mysqli_num_rows($result) == 0) {
        echo 'Αυτό το θέμα δεν υπάρχει.';
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            $topicCreatorID = $row['topic_by'];
            $sql = "SELECT user_name FROM users WHERE user_id = " . mysqli_real_escape_string($conn, $topicCreatorID);
            $userResult = mysqli_query($conn, $sql);
            $userRow = mysqli_fetch_assoc($userResult);
            echo '<h2>Posts in ' . $row['topic_subject'] . ' topic</h2>';
            echo 'Topic created by: ' . $userRow['user_name'] . '<br><br>';
        }

        $sql = "SELECT
                posts.post_id,
                posts.post_topic,
                posts.post_content,
                posts.post_date,
                posts.post_by,
                users.user_id,
                users.user_name
                FROM
                posts
                LEFT JOIN
                users
                ON
                posts.post_by = users.user_id
                WHERE
                posts.post_topic = " . mysqli_real_escape_string($conn, $_GET['id']);

        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo 'Δεν ήταν δυνατή η εμφάνιση του θέματος, δοκιμάστε ξανά αργότερα.';
        } else {
            if (mysqli_num_rows($result) == 0) {
                echo 'Αυτό το θέμα είναι κενό.';
            } else {
                echo '<table border="1">
                      <tr>
                        <th>Post</th>
                        <th>Date and user name</th>
                      </tr>';

                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td class="leftpart">';
                    echo $row['post_content'];
                    echo '</td>';
                    echo '<td class="rightpart">';
                    echo date('d-m-Y', strtotime($row['post_date']));
                    echo "\n";
                    echo $row['user_name'];
                    echo '</td>';
                    echo '</tr>';
                }

                echo '<form method="post" action="reply.php?id=' . $_GET['id'] . '">
                    <textarea name="reply-content"></textarea>
                    <input type="submit" value="Submit reply" />
                </form>';
            }
        }
    }
}

include 'footer.php';
?>

