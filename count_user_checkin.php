<?php 
require_once'connectDB.php';

function count_user_checkin_this_month($name) {
    $first_day = date('Y-m-01');
    $last_day = date('Y-m-t');
    return count_user_checkin_between($name, $first_day, $last_day);
}

// fungsi untuk menghitung checkin antara $start dan $end
// format $start dan $end harus Y-m-d ( tahun-bulan-tanggal )
function count_user_checkin_between($name, $start, $end) {
    global $conn;
    $sql = "SELECT COALESCE(SUM(users_logs.checkindate BETWEEN DATE(?) and DATE(?)),0) AS COUNT FROM users_logs WHERE username=?";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
        echo $sql."<br/>";
        print_r(mysqli_error_list($conn));
        echo '<p class="error">SQL Error</p>';
    }
    else{
        mysqli_stmt_bind_param($result, 'sss',$start,$end, $name);
        //echo $start."<br/>".$end."<br/>";
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ( $resultl ) {
            if (mysqli_num_rows($resultl) > 0){
                $row = mysqli_fetch_assoc($resultl);
                return $row["COUNT"];
            }
        }
        return 0;
    }
}

// contoh ngambil bulan kemaren
// echo count_user_checkin_between('dika', date('Y-m-01', strtotime('-1 month')), date('Y-m-t', strtotime('-1 month')));
?>
