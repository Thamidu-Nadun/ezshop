<?php
if (isset($_POST['student_id']) and isset($_POST['new_status'])) {

    $student_id = $_POST['student_id'];
    $new_status = $_POST['new_status'];

    try {
        $statement = $pdo->prepare('UPDATE student_course SET status = :new_status WHERE id = :student_id');
        $statement->bindParam(':new_status', $new_status);
        $statement->bindParam(':student_id', $student_id);
        $statement->execute();

        try{
            echo '<script>location.reload();</script>';
        }catch(Exception){
            echo 'Can not refresh page automatically try it manually';
        }
    } catch (PDOException $e) {
        echo 'An error occurred';
    }
}


?>

<div class="col-lg-6 m-b30">
    <div class="widget-box">
        <div class="wc-title">
            <h4>Orders</h4>
        </div>
        <div class="widget-inner">
            <div class="orders-list">
                <ul>
                    <?php
                    $statement = $pdo->prepare("
                    SELECT student_course.*, student.name AS student_name, student.email AS student_email
                    FROM student_course 
                    INNER JOIN student ON student_course.student_id = student.id;
                ");                
                    $statement->execute();
                    $result = $statement->fetchAll();
                    foreach ($result as $row) {
                        $id = $row['id'];
                        $course_id = $row['course_id'];
                        $student_id = $row['student_id'];
                        $student_name = $row['student_name'];
                        $student_email = $row['student_email'];
                        $batch_id = $row['batch_id'];
                        $status = $row['status'];
                        $date = $row['date'];

                        ?>
                        <li>
                            <span class="orders-title">
                                <a href="#" class="orders-title-name"><?php echo $student_name.' <small>( '.$student_email.' )</small>'; ?> </a>
                                <span class="orders-info">Order #<?php echo $id; ?> | Date <?php echo $date; ?></span>
                            </span>
                            <span class="orders-btn">
                                <?php
                                if ($status == 'Paid') {
                                    echo '<a href="#" class="btn button-sm green" onclick="updateStatus(' . $id . ', \'Unpaid\')">Paid</a>';
                                } elseif ($status == 'Unpaid') {
                                    echo '<a href="#" class="btn button-sm red" onclick="updateStatus(' . $id . ', \'Paid\')">Unpaid</a>';
                                } elseif ($status == 'Pending') {
                                    echo '<a href="#" class="btn button-sm yellow" onclick="updateStatus(' . $id . ', \'Paid\')">Pending</a>';
                                } else {
                                    echo '<a href="#" class="btn button-sm orange">UnKnown Error!</a>';
                                }

                                ?>
                            </span>
                            <script>
                                function updateStatus(studentCourseId, newStatus) {
                                    // AJAX request
                                    var xhr = new XMLHttpRequest();
                                    xhr.open('POST', '.', true);
                                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                                    xhr.onload = function () {
                                        if (xhr.status == 200) {
                                            location.reload();
                                        } else {
                                            console.error('Error updating status');
                                        }
                                    };
                                    xhr.onerror = function () {
                                        console.error('Request failed');
                                    };
                                    // Send the request
                                    xhr.send('student_id=' + studentCourseId + '&new_status=' + newStatus);
                                }
                            </script>
                        </li>
                        <?php
                    } ?>
                </ul>
            </div>
        </div>
    </div>
</div>