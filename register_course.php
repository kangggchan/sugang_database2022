<?php
    // connect to mysql db
    require_once 'dbconfig.php';

    // Get data from sugang.php
    $e_courseCode = mysqli_real_escape_string($link, $_POST['e_courseCode']);
    $e_StdNo = mysqli_real_escape_string($link, $_POST['e_StdNo']);
    $e_StdName = mysqli_real_escape_string($link, $_POST['e_StdName']);


    $sql = "INSERT INTO COURSE_REGISTRATION VALUES ('$e_courseCode','$e_StdNo');";
    $result = mysqli_query($link, $sql);

    if (mysqli_errno($link) == 1644 ) {
        echo "<script>
        alert('ERROR: You can only register for maximum 24 credits and 3 Liberal Arts courses!');
        </script>";
    }

    // once course registered, delete from searching list
    $sql2 = "DELETE FROM COURSE_SEARCHING WHERE (SearchCourseNo = '$e_courseCode' AND SearchStdNo = '$e_StdNo');";
    $result2 = mysqli_query($link, $sql2);

    


?>

<!--  Go back to sugang.php and pass login information to avoid logging out  -->

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
