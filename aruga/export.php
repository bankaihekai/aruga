<!-- ========== BOOTSTRAP ========== -->
<link rel="stylesheet" href="css/bootstrap.min.css">

<!-- ========== CSS ========== -->
<link rel="stylesheet" href="css/index.css">
<!-- <link rel="stylesheet" href="css/index2.css"> FOR STICKY TOPBAR-->

<?php
include("connect.php");
date_default_timezone_set('Asia/Manila');
$output = '';
$post_percent = array();
$total_post = null;

$page = $_GET['page'];

echo "<style>
            #table-header   {background-color:#EC878F}
            #sub-header     {background-color:#F74473}
            th,tr,td        {border: 1px solid black} 
            td,th           {padding:5px;}
            td              {color:black}
            th              {color:#fff;text-align:center}
            table           {border-collapse:collapse;background-color:#fff}
          </style>";


// JOB POST REPORT

if ($page == 'job') {

    // EXPORTING CONTENT INTO EXCEL/DOCUMENT FILE

    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename=jobpost-report.xls');

    echo "<div class='d-flex w-100 p-3'>";

    echo "  <div class='w-20 px-3'>";

    $count_query = "SELECT COUNT(*) as total_count from post";
    $count_result = mysqli_query($connect, $count_query);
    if ($count_result->num_rows > 0) {
        echo '
                        <table>
                            <tr id="sub-header" class=" text-center text-white">
                                <th colspan="3">Aruga</th>
                            </tr>
                            <tr id="table-header" class=" text-center text-white">
                                <th colspan="3">Job Post Report</th>
                            </tr>
                            ';

        while ($row = $count_result->fetch_assoc()) {
            $total_post = $row['total_count'];
            echo '
                        <tr> 
                            <td colspan="2">Date Generated</td>
                            <td>' . date("m-d-y h:i:s") . '</td>
                        </tr>
                        <tr> 
                            <td colspan="2">Total Job Post</td>
                            <td> ' . $row['total_count'] . '</td>
                        </tr>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr id="table-header" class=" text-white">
                            <th>Job Post Date</th>
                            <th>Count</th>
                            <th>Percentage</th>
                        </tr>
                        ';
        }
    }

    $job_query = "select count(jobpost_date) as count, month(jobpost_date) as date from post group by date asc";
    $job_result = mysqli_query($connect, $job_query);

    if (mysqli_num_rows($job_result) > 0) {

        while ($row = mysqli_fetch_assoc($job_result)) {

            $monthNum = $row['date'];
            $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));

            $post_percent = round((($row['count'] / $total_post) * 100), 2);
            echo '
                        <tr> 
                            <td> ' . $monthName . '</td>
                            <td> ' . $row['count'] . '</td>
                            <td> ' . $post_percent . ' %</td>
                        </tr>';
        }

        echo '<tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>';
    }

    $status_query = "select (select count(jobpost_status) from post) as total_status,jobpost_status, count(jobpost_status) as jobpost_count  from post group by jobpost_status";
    $status_result = mysqli_query($connect, $status_query);

    if (mysqli_num_rows($status_result) > 0) {

        echo '<tr id="table-header" class=" text-white">
                        <th>Job Status</th>
                        <th>Count</th>
                        <th>Percentage</th>
                    </tr>
                        ';

        while ($row = mysqli_fetch_assoc($status_result)) {

            echo '
                        <tr> 
                            <td> ' . $row['jobpost_status'] . '</td>
                            <td> ' . $row['jobpost_count'] . '</td>
                            <td> ' . round((($row['jobpost_count'] / $row['total_status']) * 100), 2) . ' %</td>
                        </tr>';
        }

        echo '<tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    </table>';
    }
    echo "</div>
          <div class='w-80 px-3'>
          <table></table>
          </div>
    </div>";
}

// BLOG POST REPORT

if ($page == 'blog') {


    // EXPORTING CONTENT INTO EXCEL/DOCUMENT FILE

    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename=blogpost-report.xls');

    echo "<div class='d-flex w-100 p-3'>";

    echo "  <div class='w-20 px-3'>";

    $count_query = "SELECT COUNT(*) as total_count from blog";
    $count_result = mysqli_query($connect, $count_query);
    if ($count_result->num_rows > 0) {
        echo '
                        <table>
                            <tr id="sub-header" class=" text-center text-white">
                                <th colspan="3">Aruga</th>
                            </tr>
                            <tr id="table-header" class=" text-center text-white">
                                <th colspan="3">Blog Post Report</th>
                            </tr>
                            ';

        while ($row = $count_result->fetch_assoc()) {
            $total_post = $row['total_count'];
            echo '
                        <tr> 
                            <td colspan="2">Date Generated</td>
                            <td>' . date("m-d-y h:i:s") . '</td>
                        </tr>
                        <tr> 
                            <td colspan="2">Total Job Post</td>
                            <td> ' . $row['total_count'] . '</td>
                        </tr>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr id="table-header" class=" text-white">
                            <th>Blog Post Date</th>
                            <th>Count</th>
                            <th>Percentage</th>
                        </tr>
                        ';
        }
    }

    $blog_query = "select count(blog_id) as blog_count, month(blog_postdate) as date from blog group by date asc";
    $blog_result = mysqli_query($connect, $blog_query);

    if (mysqli_num_rows($blog_result) > 0) {

        while ($row = mysqli_fetch_assoc($blog_result)) {

            $monthNum = $row['date'];
            $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));

            $post_percent = round((($row['blog_count'] / $total_post) * 100), 2);
            echo '
                        <tr> 
                            <td> ' . $monthName . '</td>
                            <td> ' . $row['blog_count'] . '</td>
                            <td> ' . $post_percent . ' %</td>
                        </tr>';
        }

        echo '<tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>';
    }

    $status_query = "select (select count(blog_deleted) from blog) as total_status, blog_deleted, count(blog_deleted) as blog_count  from blog group by blog_deleted";
    $status_result = mysqli_query($connect, $status_query);

    if (mysqli_num_rows($status_result) > 0) {

        echo '<tr id="table-header" class=" text-white">
                            <th>Blog Post Status</th>
                            <th>Count</th>
                            <th>Percentage</th>
                        </tr>
                        ';

        while ($row = mysqli_fetch_assoc($status_result)) {

            echo '
                        <tr> 
                            <td> ' . $row['blog_deleted'] . '</td>
                            <td> ' . $row['blog_count'] . '</td>
                            <td> ' . round((($row['blog_count'] / $row['total_status']) * 100), 2) . ' %</td>
                        </tr>';
        }

        echo '<tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    </table>';
    }

    echo "</div>
          <div class='w-80 px-3'>
          <table></table>
          </div>
    </div>";
}

// REVIEW REPORT

if ($page == 'review') {

    // EXPORTING CONTENT INTO EXCEL/DOCUMENT FILE

    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename=review-report.xls');

    echo "<div class='d-flex w-100 p-3'>";

    echo "  <div class='w-20 px-3'>";

    $ranking = 0;
    $count_query = "SELECT COUNT(*) as total_count from reviews";
    $count_result = mysqli_query($connect, $count_query);
    if ($count_result->num_rows > 0) {
        echo '
                        <table>
                            <tr id="sub-header" class=" text-center text-white">
                                <th colspan="3">Aruga</th>
                            </tr>
                            <tr id="table-header" class=" text-center text-white">
                                <th colspan="3">Review Report</th>
                            </tr>
                            ';

        while ($row = $count_result->fetch_assoc()) {
            $total_review = $row['total_count'];
            echo '
                        <tr> 
                            <td colspan="2">Date Generated</td>
                            <td>' . date("m-d-y h:i:s") . '</td>
                        </tr>
                        <tr> 
                            <td colspan="2">Total Reviews</td>
                            <td> ' . $row['total_count'] . '</td>
                        </tr>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr id="table-header" class=" text-white">
                            <th>Reviews Date</th>
                            <th>Count</th>
                            <th>Percentage</th>
                        </tr>
                        ';
        }
    }

    $review_query = "select count(review_date) as review_count , month(review_date) as date from reviews group by date asc";
    $review_result = mysqli_query($connect, $review_query);

    if (mysqli_num_rows($review_result) > 0) {

        while ($row = mysqli_fetch_assoc($review_result)) {

            $monthNum = $row['date'];
            $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));

            $review_percent = round((($row['review_count'] / $total_review) * 100), 2);
            echo '
                        <tr> 
                            <td> ' . $monthName . '</td>
                            <td> ' . $row['review_count'] . '</td>
                            <td> ' . $review_percent . ' %</td>
                        </tr>';
        }

        echo '<tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>';
    }

    $status_query = "select review_ratings, count(review_ratings) as review_count  from reviews group by review_ratings desc";
    $status_result = mysqli_query($connect, $status_query);

    if (mysqli_num_rows($status_result) > 0) {

        echo '<tr id="table-header" class=" text-white">
                            <th>Review Ratings</th>
                            <th>Count</th>
                            <th>Percentage</th>
                        </tr>
                        ';

        while ($row = mysqli_fetch_assoc($status_result)) {

            echo '
                        <tr> 
                            <td> ' . $row['review_ratings'] . ' Stars</td>
                            <td> ' . $row['review_count'] . '</td>
                            <td> ' . round((($row['review_count'] / $total_review) * 100), 2) . ' %</td>
                        </tr>';
        }

        echo '<tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>';
    }

    $top_user_query = "SELECT DISTINCT 
                            users.lastname,
                            users.firstname,
                            round(sum(reviews.review_ratings)/count(review_ratings),1) AS rating
                        FROM 
                            users,babysitter_account,reviews 
                        WHERE 
                            users.user_id = babysitter_account.user_id 
                        AND 
                            reviews.babysitter_id = babysitter_account.babysitter_id
                        GROUP BY 
                            lastname,firstname
                        ORDER BY
                            rating DESC";

    $top_user = mysqli_query($connect, $top_user_query);
    if (mysqli_num_rows($top_user) > 0) {

        echo '
                    <tr>
                        <th id="sub-header" colspan="3" class=" text-center text-white">Top Babysitters</th>
                    </tr>
                    <tr id="table-header" class=" text-white">
                        <th>Ranking</th>
                        <th>Name</th>
                        <th>Ratings</th>
                    </tr>
                    ';

        while ($row = mysqli_fetch_assoc($top_user)) {

            $ranking += 1;

            echo '
                        <tr> 
                            <td> ' . $ranking . '</td>
                            <td> ' . $row['firstname'] . " " . $row['lastname'] . '</td>
                            <td> ' . $row['rating'] . ' stars</td>
                        </tr>';
        }

        echo '<tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    </table>';
    }
    echo "</div>
          <div class='w-80 px-3'>
          <table></table>
          </div>
    </div>";
}

// JOB APPLICATION REPORT

if ($page == 'application') {

    // EXPORTING CONTENT INTO EXCEL/DOCUMENT FILE

    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename=blogpost-report.xls');

    echo "<div class='d-flex w-100 p-3'>";

    echo "  <div class='w-20 px-3'>";

    $count_query = "SELECT COUNT(*) as total_count from `application`";
    $count_result = mysqli_query($connect, $count_query);

    if ($count_result->num_rows > 0) {
        echo '
                        <table>
                            <tr id="sub-header" class=" text-center text-white">
                                <th colspan="3">Aruga</th>
                            </tr>
                            <tr id="table-header" class=" text-center text-white">
                                <th colspan="3">Job Application Report</th>
                            </tr>
                            ';

        while ($row = $count_result->fetch_assoc()) {
            $total_post = $row['total_count'];
            echo '
                        <tr> 
                            <td colspan="2">Date Generated</td>
                            <td>' . date("m-d-y h:i:s") . '</td>
                        </tr>
                        <tr> 
                            <td colspan="2">Total Job Post</td>
                            <td> ' . $total_post . '</td>
                        </tr>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr id="table-header" class=" text-white">
                            <th>Application Date</th>
                            <th>Count</th>
                            <th>Percentage</th>
                        </tr>
                        ';
        }
    }

    $application_query = "select count(apply_date) as apply_count , month(apply_date) as date from application group by date asc";
    $application_result = mysqli_query($connect, $application_query);

    if (mysqli_num_rows($application_result) > 0) {
        while ($row = mysqli_fetch_assoc($application_result)) {

            $monthNum = $row['date'];
            $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));

            $application_percent = round((($row['apply_count'] / $total_post) * 100), 2);
            echo '
                        <tr> 
                            <td> ' . $monthName . '</td>
                            <td> ' . $row['apply_count'] . '</td>
                            <td> ' . $application_percent . ' %</td>
                        </tr>';
        }

        echo '<tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>';
    }

    $status_query = "select apply_status, count(apply_status) as apply_count  from application group by apply_status desc";
    $status_result = mysqli_query($connect, $status_query);

    if (mysqli_num_rows($status_result) > 0) {

        echo '<tr id="table-header" class=" text-white">
                        <th>Application Status</th>
                        <th>Count</th>
                        <th>Percentage</th>
                    </tr>
                        ';

        while ($row = mysqli_fetch_assoc($status_result)) {

            echo '
                        <tr> 
                            <td> ' . $row['apply_status'] . '</td>
                            <td> ' . $row['apply_count'] . '</td>
                            <td> ' . round((($row['apply_count'] / $total_post) * 100), 2) . ' %</td>
                           
                        </tr>';
        }

        echo '<tr>
                        <td colspan="3">&nbsp;</td>
                    </tr></table>';
    }
    echo "</div>
          <div class='w-80 px-3'>
          <table></table>
          </div>
    </div>";
}


// Subscription REPORT

if ($page == 'subscription') { 

    // EXPORTING CONTENT INTO EXCEL/DOCUMENT FILE

    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename=subscription-report.xls');

    echo "<div class='d-flex w-100 p-3'>";

    echo "  <div class='w-20 px-3'>";
    $count_query = "SELECT COUNT(*) as total_count from `subscription`";
    $count_result = mysqli_query($connect, $count_query);

    if ($count_result->num_rows > 0) {
        echo '
                        <table>
                            <tr id="sub-header" class=" text-center text-white">
                                <th colspan="3">Aruga</th>
                            </tr>
                            <tr id="table-header" class=" text-center text-white">
                                <th colspan="3">Subscription Report</th>
                            </tr>
                            ';

        while ($row = $count_result->fetch_assoc()) {
            $total_post = $row['total_count'];
            echo '
                        <tr> 
                            <td colspan="2">Date Generated</td>
                            <td>' . date("m-d-y h:i:s") . '</td>
                        </tr>
                        <tr> 
                            <td colspan="2">Total Job Post</td>
                            <td> ' . $total_post . '</td>
                        </tr>
                        <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                        <tr id="table-header" class=" text-white">
                            <th>Status</th>
                            <th>Count</th>
                            <th>Percentage</th>
                        </tr>
                        ';
        }
    }

    $subs_query = "select status, count(status) as status_count  from subscription group by status desc";
    $subs_result = mysqli_query($connect, $subs_query);

    if (mysqli_num_rows($subs_result) > 0) {
        while ($row = mysqli_fetch_assoc($subs_result)) {

            $subs_percent = round((($row['status_count'] / $total_post) * 100), 2);
            echo '
                        <tr> 
                            <td> ' . $row['status'] . '</td>
                            <td> ' . $row['status_count'] . '</td>
                            <td> ' . $subs_percent . ' %</td>
                        </tr>';
        }

        echo '<tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>';
    }

    $date_sql = "select count(date_start) as start_count, month(date_start) as date_start, count(date_ended) as end_count, month(date_ended) as date_ended from subscription group by date_start order by date_start asc";
    $date_query = mysqli_query($connect, $date_sql);

    if (mysqli_num_rows($date_query) > 0) {

        echo '
                    <tr>
                        <th colspan="3" id="sub-header">Subscription Started</th>
                    </tr>
                    <tr id="table-header" class=" text-white">
                        <th>Month</th>
                        <th>Count</th>
                        <th>Percentage</th>
                    </tr>
                        ';

        while ($row = mysqli_fetch_assoc($date_query)) {

            $monthNum = $row['date_start'];
            $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));

            echo '
                        <tr> 
                            <td> ' . $monthName . '</td>
                            <td> ' . $row['start_count'] . '</td>
                            <td> ' . round((($row['start_count'] / $total_post) * 100), 2) . ' %</td>
                           
                        </tr>';
        }

        mysqli_free_result($date_query);
        echo '<tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>';
    }

    // EXPIRED SUBSCRIPTION

    $date_sql = "select count(date_start) as start_count, month(date_start) as date_start, count(date_ended) as end_count, month(date_ended) as date_ended from subscription group by date_start order by date_ended asc";
    $date_query = mysqli_query($connect, $date_sql);

    if (mysqli_num_rows($date_query) > 0) {

        echo '
                    <tr>
                        <th colspan="3" id="sub-header">Subscription Ended</th>
                    </tr>
                    <tr id="table-header" class=" text-white">
                        <th>Month</th>
                        <th>Count</th>
                        <th>Percentage</th>
                    </tr>
                    ';

        while ($row = mysqli_fetch_array($date_query)) {

            $monthNum1 = $row['date_ended'];
            $monthName1 = date("F", mktime(0, 0, 0, $monthNum1, 10));

            echo '
                        <tr> 
                            <td> ' . $monthName1 . '</td>
                            <td> ' . $row['end_count'] . '</td>
                            <td> ' . round((($row['end_count'] / $total_post) * 100), 2) . ' %</td>
                            
                        </tr>';
        }

        echo '<tr>
                        <td colspan="3">&nbsp;</td>
                    </tr>
                    </table>';
    }
    echo "</div>
          <div class='w-80 px-3'>
          <table></table>
          </div>
    </div>";
}

// VIEW ALL REPORT---------------------------------------

if ($page == 'home') {
    // EXPORTING CONTENT INTO EXCEL/DOCUMENT FILE

    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename=all-report.xls');

    echo "<div class='d-flex w-100 '>";
    echo "<div class='w-20 px-3'>";
    // JOB POST REPORT
    $count_query = "SELECT COUNT(*) as total_count from post";
    $count_result = mysqli_query($connect, $count_query);
    if ($count_result->num_rows > 0) {
        echo '
                            <table>
                                <tr id="sub-header" class=" text-center text-white"> 
                                    <th colspan="3">Aruga</th>
                                </tr>
                                <tr> 
                                    <td colspan="2">Date Generated</td>
                                    <td>' . date("m-d-y h:i:s") . '</td>
                                </tr>
                                <tr id="sub-header" class=" text-center text-white">
                                    <th colspan="3">Job Post Report</th>
                                </tr>
                                ';

        while ($row = $count_result->fetch_assoc()) {
            $total_post = $row['total_count'];
            echo '
                            
                            <tr> 
                                <td colspan="2">Total Job Post</td>
                                <td> ' . $row['total_count'] . '</td>
                            </tr>
                            <tr>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr id="table-header" class=" text-white">
                                <th>Job Post Date</th>
                                <th>Count</th>
                                <th>Percentage</th>
                            </tr>
                            ';
        }
    }

    $job_query = "select count(jobpost_date) as count, month(jobpost_date) as date from post group by date asc";
    $job_result = mysqli_query($connect, $job_query);

    if (mysqli_num_rows($job_result) > 0) {

        while ($row = mysqli_fetch_assoc($job_result)) {

            $monthNum = $row['date'];
            $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));

            $post_percent = round((($row['count'] / $total_post) * 100), 2);
            echo '
                            <tr> 
                                <td> ' . $monthName . '</td>
                                <td> ' . $row['count'] . '</td>
                                <td> ' . $post_percent . ' %</td>
                            </tr>';
        }

        echo '<tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>';
    }

    $status_query = "select (select count(jobpost_status) from post) as total_status,jobpost_status, count(jobpost_status) as jobpost_count  from post group by jobpost_status";
    $status_result = mysqli_query($connect, $status_query);

    if (mysqli_num_rows($status_result) > 0) {

        echo '<tr id="table-header" class=" text-white">
                            <th>Job Status</th>
                            <th>Count</th>
                            <th>Percentage</th>
                        </tr>
                            ';

        while ($row = mysqli_fetch_assoc($status_result)) {

            echo '
                        <tr> 
                             <td> ' . $row['jobpost_status'] . '</td>
                             <td> ' . $row['jobpost_count'] . '</td>
                            <td> ' . round((($row['jobpost_count'] / $row['total_status']) * 100), 2) . ' %</td>
                        </tr>';
        }

        echo '      <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>';
    }
    // BLOG POST REPORT

    $count_query = "SELECT COUNT(*) as total_count from blog";
    $count_result = mysqli_query($connect, $count_query);
    if ($count_result->num_rows > 0) {
        echo '
                                <tr id="sub-header" class=" text-center text-white">
                                    <th colspan="3">Blog Post Report</th>
                                </tr>
                                ';

        while ($row = $count_result->fetch_assoc()) {
            $total_post = $row['total_count'];
            echo '
                            <tr> 
                                <td colspan="2">Total Job Post</td>
                                <td> ' . $row['total_count'] . '</td>
                            </tr>
                            <tr>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr id="table-header" class=" text-white">
                                <th>Blog Post Date</th>
                                <th>Count</th>
                                <th>Percentage</th>
                            </tr>
                            ';
        }
    }

    $blog_query = "select count(blog_id) as blog_count, month(blog_postdate) as date from blog group by date asc";
    $blog_result = mysqli_query($connect, $blog_query);

    if (mysqli_num_rows($blog_result) > 0) {

        while ($row = mysqli_fetch_assoc($blog_result)) {

            $monthNum = $row['date'];
            $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));

            $post_percent = round((($row['blog_count'] / $total_post) * 100), 2);
            echo '
                            <tr> 
                                <td> ' . $monthName . '</td>
                                <td> ' . $row['blog_count'] . '</td>
                                <td> ' . $post_percent . ' %</td>
                            </tr>';
        }

        echo '<tr>
                                <td colspan="3">&nbsp;</td>
                            </tr>';
    }

    $status_query = "select (select count(blog_deleted) from blog) as total_status, blog_deleted, count(blog_deleted) as blog_count  from blog group by blog_deleted";
    $status_result = mysqli_query($connect, $status_query);

    if (mysqli_num_rows($status_result) > 0) {

        echo '<tr id="table-header" class=" text-white">
                                <th>Blog Post Status</th>
                                <th>Count</th>
                                <th>Percentage</th>
                            </tr>
                            ';

        while ($row = mysqli_fetch_assoc($status_result)) {

            echo '
                            <tr> 
                                <td> ' . $row['blog_deleted'] . '</td>
                                <td> ' . $row['blog_count'] . '</td>
                                <td> ' . round((($row['blog_count'] / $row['total_status']) * 100), 2) . ' %</td>
                            </tr>';
        }

        echo '         <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                    </table>';
    }
    echo "</div>";
    echo "<div class='w-20 px-3'>";
    // REVIEW REPORT

    $ranking = 0;
    $count_query = "SELECT COUNT(*) as total_count from reviews";
    $count_result = mysqli_query($connect, $count_query);
    if ($count_result->num_rows > 0) {
        echo '
                            <table>
                                <tr id="sub-header" class=" text-center text-white">
                                    <th colspan="3">Review Report</th>
                                </tr>
                                ';

        while ($row = $count_result->fetch_assoc()) {
            $total_review = $row['total_count'];
            echo '
                            <tr> 
                                <td colspan="2">Total Reviews</td>
                                <td> ' . $row['total_count'] . '</td>
                            </tr>
                            <tr>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr id="table-header" class=" text-white">
                                <th>Reviews Date</th>
                                <th>Count</th>
                                <th>Percentage</th>
                            </tr>
                            ';
        }
    }

    $review_query = "select count(review_date) as review_count , month(review_date) as date from reviews group by date asc";
    $review_result = mysqli_query($connect, $review_query);

    if (mysqli_num_rows($review_result) > 0) {

        while ($row = mysqli_fetch_assoc($review_result)) {

            $monthNum = $row['date'];
            $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));

            $review_percent = round((($row['review_count'] / $total_review) * 100), 2);
            echo '
                            <tr> 
                                <td> ' . $monthName . '</td>
                                <td> ' . $row['review_count'] . '</td>
                                <td> ' . $review_percent . ' %</td>
                            </tr>';
        }

        echo '<tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>';
    }

    $status_query = "select review_ratings, count(review_ratings) as review_count  from reviews group by review_ratings desc";
    $status_result = mysqli_query($connect, $status_query);

    if (mysqli_num_rows($status_result) > 0) {

        echo '<tr id="table-header" class=" text-white">
                                <th>Review Ratings</th>
                                <th>Count</th>
                                <th>Percentage</th>
                            </tr>
                            ';

        while ($row = mysqli_fetch_assoc($status_result)) {

            echo '
                            <tr> 
                                <td> ' . $row['review_ratings'] . ' Stars</td>
                                <td> ' . $row['review_count'] . '</td>
                                <td> ' . round((($row['review_count'] / $total_review) * 100), 2) . ' %</td>
                            </tr>';
        }

        echo '<tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>';
    }

    $top_user_query = "SELECT DISTINCT 
                                users.lastname,
                                users.firstname,
                                round(sum(reviews.review_ratings)/count(review_ratings),1) AS rating
                            FROM 
                                users,babysitter_account,reviews 
                            WHERE 
                                users.user_id = babysitter_account.user_id 
                            AND 
                                reviews.babysitter_id = babysitter_account.babysitter_id
                            GROUP BY 
                                lastname,firstname
                            ORDER BY
                                rating DESC";

    $top_user = mysqli_query($connect, $top_user_query);
    if (mysqli_num_rows($top_user) > 0) {

        echo '
                        <tr>
                            <th id="sub-header" colspan="3" class=" text-center text-white">Top Babysitters</th>
                        </tr>
                        <tr id="table-header" class=" text-white">
                            <th>Ranking</th>
                            <th>Name</th>
                            <th>Ratings</th>
                        </tr>
                        ';

        while ($row = mysqli_fetch_assoc($top_user)) {

            $ranking += 1;

            echo '
                            <tr> 
                                <td> ' . $ranking . '</td>
                                <td> ' . $row['firstname'] . " " . $row['lastname'] . '</td>
                                <td> ' . $row['rating'] . ' stars</td>
                            </tr>';
        }

        echo '       <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>';
    }
    // JOB APPLICATION REPORT

    $count_query = "SELECT COUNT(*) as total_count from `application`";
    $count_result = mysqli_query($connect, $count_query);

    if ($count_result->num_rows > 0) {
        echo '
                                <tr id="sub-header" class=" text-center text-white">
                                    <th colspan="3">Job Application Report</th>
                                </tr>
                                ';

        while ($row = $count_result->fetch_assoc()) {
            $total_post = $row['total_count'];
            echo '
                            <tr> 
                                <td colspan="2">Total Job Post</td>
                                <td> ' . $total_post . '</td>
                            </tr>
                            <tr>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr id="table-header" class=" text-white">
                                <th>Application Date</th>
                                <th>Count</th>
                                <th>Percentage</th>
                            </tr>
                            ';
        }
    }

    $application_query = "select count(apply_date) as apply_count , month(apply_date) as date from application group by date asc";
    $application_result = mysqli_query($connect, $application_query);

    if (mysqli_num_rows($application_result) > 0) {
        while ($row = mysqli_fetch_assoc($application_result)) {

            $monthNum = $row['date'];
            $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));

            $application_percent = round((($row['apply_count'] / $total_post) * 100), 2);
            echo '
                            <tr> 
                                <td> ' . $monthName . '</td>
                                <td> ' . $row['apply_count'] . '</td>
                                <td> ' . $application_percent . ' %</td>
                            </tr>';
        }

        echo '<tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>';
    }

    $status_query = "select apply_status, count(apply_status) as apply_count  from application group by apply_status desc";
    $status_result = mysqli_query($connect, $status_query);

    if (mysqli_num_rows($status_result) > 0) {

        echo '<tr id="table-header" class=" text-white">
                            <th>Application Status</th>
                            <th>Count</th>
                            <th>Percentage</th>
                        </tr>
                            ';

        while ($row = mysqli_fetch_assoc($status_result)) {

            echo '
                            <tr> 
                                <td> ' . $row['apply_status'] . '</td>
                                <td> ' . $row['apply_count'] . '</td>
                                <td> ' . round((($row['apply_count'] / $total_post) * 100), 2) . ' %</td>
                               
                            </tr>';
        }

        echo '      <tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                    </table>';
    }
    echo "</div>";
    echo "<div class='w-20 px-3'>";
    // Subscription REPORT

    $count_query = "SELECT COUNT(*) as total_count from `subscription`";
    $count_result = mysqli_query($connect, $count_query);

    if ($count_result->num_rows > 0) {
        echo '
                            <table>
                                <tr id="sub-header" class=" text-center text-white">
                                    <th colspan="3">Subscription Report</th>
                                </tr>
                                ';

        while ($row = $count_result->fetch_assoc()) {
            $total_post = $row['total_count'];
            echo '
                            <tr> 
                                <td colspan="2">Date Generated</td>
                                <td>' . date("m-d-y h:i:s") . '</td>
                            </tr>
                            <tr> 
                                <td colspan="2">Total Job Post</td>
                                <td> ' . $total_post . '</td>
                            </tr>
                            <tr>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr id="table-header" class=" text-white">
                                <th>Status</th>
                                <th>Count</th>
                                <th>Percentage</th>
                            </tr>
                            ';
        }
    }

    $subs_query = "select status, count(status) as status_count  from subscription group by status desc";
    $subs_result = mysqli_query($connect, $subs_query);

    if (mysqli_num_rows($subs_result) > 0) {
        while ($row = mysqli_fetch_assoc($subs_result)) {

            $subs_percent = round((($row['status_count'] / $total_post) * 100), 2);
            echo '
                            <tr> 
                                <td> ' . $row['status'] . '</td>
                                <td> ' . $row['status_count'] . '</td>
                                <td> ' . $subs_percent . ' %</td>
                            </tr>';
        }

        echo '<tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>';
    }

    $date_sql = "select count(date_start) as start_count, month(date_start) as date_start, count(date_ended) as end_count, month(date_ended) as date_ended from subscription group by date_start order by date_start asc";
    $date_query = mysqli_query($connect, $date_sql);

    if (mysqli_num_rows($date_query) > 0) {

        echo '
                        <tr>
                            <th colspan="3" id="sub-header">Subscription Started</th>
                        </tr>
                        <tr id="table-header" class=" text-white">
                            <th>Month</th>
                            <th>Count</th>
                            <th>Percentage</th>
                        </tr>
                            ';

        while ($row = mysqli_fetch_assoc($date_query)) {

            $monthNum = $row['date_start'];
            $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));

            echo '
                            <tr> 
                                <td> ' . $monthName . '</td>
                                <td> ' . $row['start_count'] . '</td>
                                <td> ' . round((($row['start_count'] / $total_post) * 100), 2) . ' %</td>
                               
                            </tr>';
        }

        mysqli_free_result($date_query);
        echo '<tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>';
    }

    // EXPIRED SUBSCRIPTION

    $date_sql = "select count(date_start) as start_count, month(date_start) as date_start, count(date_ended) as end_count, month(date_ended) as date_ended from subscription group by date_start order by date_ended asc";
    $date_query = mysqli_query($connect, $date_sql);

    if (mysqli_num_rows($date_query) > 0) {

        echo '
                        <tr>
                            <th colspan="3" id="sub-header">Subscription Ended</th>
                        </tr>
                        <tr id="table-header" class=" text-white">
                            <th>Month</th>
                            <th>Count</th>
                            <th>Percentage</th>
                        </tr>
                        ';

        while ($row = mysqli_fetch_array($date_query)) {

            $monthNum1 = $row['date_ended'];
            $monthName1 = date("F", mktime(0, 0, 0, $monthNum1, 10));

            echo '
                            <tr> 
                                <td> ' . $monthName1 . '</td>
                                <td> ' . $row['end_count'] . '</td>
                                <td> ' . round((($row['end_count'] / $total_post) * 100), 2) . ' %</td>
                                
                            </tr>';
        }

        echo '<tr>
                            <td colspan="3">&nbsp;</td>
                        </tr>
                    </table>';
    }



    echo "</div>";
    echo "</div>";
}
