<?php
    // connect to mysql db
    require_once 'dbconfig.php';

    // Get data passed from sugang.php
    $e_courseCode = mysqli_real_escape_string($link, $_REQUEST['e_courseCode']);
    $e_StdNo = mysqli_real_escape_string($link, $_POST['e_StdNo']);
    $e_StdName = mysqli_real_escape_string($link, $_POST['e_StdName']);

    //Check empty input
    if (empty($e_courseCode)) {			
        echo "<script>
            alert('Empty input is not allowed!'); 
            window.history.back();
        </script>";
	}


    //Check number of registered students of searching course
    $sql_count = "SELECT count(*) FROM COURSE_REGISTRATION WHERE ReCourseNo = '$e_courseCode';";
    $resul_count = mysqli_query($link, $sql_count);
    $resul_count = $resul_count->fetch_array();
    $count = intval($resul_count[0]);

    if ($count == 2) {
        echo "<script>
            alert('Number of student exceeded!');
            </script>";
    }

    //insert if there're available seat
    else{
    $sql = "INSERT IGNORE INTO COURSE_SEARCHING VALUES ('$e_courseCode','$e_StdNo');";
    $result = mysqli_query($link, $sql);
    }


?>

<!--  Go back to sugang.php and pass login information to avoid logging out  -->

<!DOCTYPE html>
<head>
</head>
<body>

<form action="sugang.php" method="post" id="pass" name="pass">
  <input type="hidden" class="form-control" name="e_StdName" value="<?php echo $_POST['e_StdName'] ?>">
  <input type="hidden" class="form-control" name="e_StdNo" value="<?php echo $_POST['e_StdNo'] ?>">
</form>

<script type="text/javascript">
    window.onload=function(){
        var auto = setTimeout(function(){ autoRefresh(); }, 10);

        function submitform(){
          document.forms["pass"].submit();
        }

        function autoRefresh(){
           clearTimeout(auto);
           auto = setTimeout(function(){ submitform(); autoRefresh(); }, 10);
        }
    }
</script>

</body>
</html>
