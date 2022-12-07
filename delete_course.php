<?php
    // connect to mysql db
    require_once 'dbconfig.php';

    //Get required data from sugang.php
    $e_courseCode = mysqli_real_escape_string($link, $_POST['e_courseCode']);
    $e_StdNo = mysqli_real_escape_string($link, $_POST['e_StdNo']);
    $e_StdName = mysqli_real_escape_string($link, $_POST['e_StdName']);

    // delete record
    $sql = "DELETE FROM COURSE_REGISTRATION WHERE (ReCourseNo = '$e_courseCode' AND ReStdNo = '$e_StdNo');";
    $result = mysqli_query($link, $sql);


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

</body>
</html>