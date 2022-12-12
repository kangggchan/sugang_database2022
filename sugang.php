<?php
    // connect to mysql db
    require_once 'dbconfig.php';

    

    //Get StdName and StdNo from Login
    $e_StdName = mysqli_real_escape_string($link, $_REQUEST['e_StdName']);
    $e_StdNo = mysqli_real_escape_string($link, $_REQUEST['e_StdNo']);

    // check for empty input
	if (empty($e_StdName) || empty($e_StdNo)) {			
        echo "<script>
            alert('Empty input is not allowed!'); 
            location.href='index.php';
        </script>";
	}

    //Add student informations into database if it does not exist
    $sql = "INSERT IGNORE INTO SUGANG.STUDENT VALUES ('$e_StdName', '$e_StdNo', 'IT대학', '컴퓨터학부 글로벌소프트웨어융합전공');";
    $result = mysqli_query($link, $sql);

    //Check valid login information
    $sql ="SELECT StdName, StdCollege, StdDepartment FROM SUGANG.STUDENT WHERE '$e_StdNo' = StdNo";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    //Go back to login page if login failed
    if (strcmp($row['StdName'], $e_StdName) != 0){
        echo "<script>
        alert('Wrong information!');
        window.history.back();
        </script>";
    }
    


    // Display searching course 
    $sql = "SELECT CourseCode, CourseName, Lecturer, Type, Credit, CourseTime2, StudQuota FROM COURSE
    WHERE CourseCode IN (SELECT DISTINCT SearchCourseNo FROM COURSE_SEARCHING WHERE SearchStdNo = '$e_StdNo');";
    $result = mysqli_query($link, $sql);


    // Display registered course 
    $sql2 = "SELECT CourseCode, CourseName, Lecturer, Type, Credit, CourseTime2, StudQuota FROM COURSE
    WHERE CourseCode IN (SELECT DISTINCT ReCourseNo FROM COURSE_Registration WHERE ReStdNo = '$e_StdNo');";
    $result2 = mysqli_query($link, $sql2);


    //Calculate to display sum of registered credits 
    $sql_sum ="SELECT COALESCE(SUM(Credit),0) FROM COURSE WHERE courseCode IN
    (SELECT ReCourseNo FROM COURSE_REGISTRATION WHERE ReStdNo = '$e_StdNo');";
    $result_sum = mysqli_query($link, $sql_sum);
    $result_sum = $result_sum->fetch_array();
    $sum = intval($result_sum[0]);

    

?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densitydpi=medium-dpi" />
    <title>sugang</title>
    <link href="https://sugang.knu.ac.kr/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://sugang.knu.ac.kr/views/sugang/css/icommon.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
  
</head>
<body>
<div id="header">
    <!-- top sub -->
    <div class="top-sub">
        <div class="container">
            <div class="layout top-sub-layout">
                <div class="ly-item">
                    <ul>
                        <li><span class="top-sub-link-login">[2022-2, COMP322-6 Database] Personal project #1   ||   Author: 배복캉 (2021117446)</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- top main -->
    <div class="top-main">
        <div class="container">
            <div class="layout between top-main-layout">
                <div class="ly-item">
                    <h1 class="site-title"> <a class="site-link" href="#"> <img class="site-logo" src="https://sugang.knu.ac.kr/views/sugang/images/logo.svg" alt="경북대학교"></a> </h1>
                </div>
                <div class="ly-item">
                    <h2>수강꾸러미 신청</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="sub-container container">
    <div id="content">
        <div class="b-table-box flex-col-4">
            <!-- Display student's information -->
            <div class="b-row-box">
                <div class="b-row-item">
                    <div class="b-title-box"> 학번 </div>
                    <div class="b-con-box"> <?php print $e_StdNo ?></div>
                </div>
                <div class="b-row-item">
                    <div class="b-title-box">
                        <label for="bb"> 성명 </label>
                    </div>
                    <div class="b-con-box"> <?php print $e_StdName ?> </div>
                </div>
                <div class="b-row-item">
                    <div class="b-title-box">
                        <label for="bb"> 소속 </label>
                    </div>
                    <div class="b-con-box"> <?php echo $row['StdCollege']; echo " ", $row['StdDepartment'];?> </div>
                </div>
                <div class="b-row-item">
                    <div class="b-title-box">
                        <label for="allLmttnCrdit"> 수강신청학점 </label>
                    </div>
                    <div class="b-con-box"> <?php print $sum?></div>
                </div>
            </div>
        </div>

        <br>
        <br>

        <div class="b-table-box flex-col-4">
            <div class="b-row-box">
                <!-- Pass searching course code and login information to search_course.php for implementation  -->
                <div class="b-row-item">
                    <div class="b-title-box text-danger"> 강좌번호<br>(12자리) </div>

                    <form action="search_course.php" method="post" class="b-row-item">

                    <div class="b-con-box"> 
                        <input type="text" class="form-control" name="e_courseCode" placeholder="교과목 코드를 입력하세요 (e.g., CLTR0003-005)"> 
                    </div>
                    <input type="hidden" name="e_StdNo" value="<?php echo $_POST['e_StdNo'] ?>">
                    <input type="hidden" name="e_StdName" value="<?php echo $_POST['e_StdName'] ?>">
                    <div class="b-con-box">
                        <button type="submit" class="btn btn-danger" formaction="search_course.php">조회</button>
                        
                    </div>
                    
                    </form>
                    
                </div>
            </div>
        </div>

        <br>
        <br>

        <div class="nav-tabs-style02">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item"> <a class="nav-link active show" id="tabs1" data-toggle="tab" href="#tabs1-1" role="tab" aria-controls="tabs1-1" aria-selected="true">과목 검색</a> </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade active show" id="tabs1-1" role="tabpanel">
                <!--  Display searching course (searching history)  -->
                <h3 class="sr-only">과목 검색</h3>
                <br>
                <br>

                <div class="table-responsive mt-1">
                <table class="table table-line text-break text-center" summary="과목 검색 목록 표입니다">
                        <caption>this is a grid caption.</caption>
                        <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">신청</th>
                            <th scope="col">교과목코드</th>
                            <th scope="col">교과목명</th>
                            <th scope="col">담당교수</th>
                            <th scope="col">교과구분</th>
                            <th scope="col">학점</th>
                            <th scope="col">강의시간</th>
                            <th scope="col">제한인원</th>
                        </tr>
                    </thead>
                        <tbody id="grid02">
                        <?php
                            // LOOP TILL END OF DATA

                            $rows = array();
                            while ($row =  mysqli_fetch_assoc($result)){
                                $rows[] = $row;
                            }
                            foreach($rows as $key=>$value)   
                        {
                        ?>

                        <tr>
                            <td><?php echo $key+1;?></td>
                            <td>
                            <form action="register_course.php" method="post">
                                <input type="hidden" class="form-control" name="e_courseCode" value="<?php echo $value['CourseCode']?>">
                                <input type="hidden" class="form-control" name="e_StdNo" value="<?php echo $_POST['e_StdNo'] ?>">
                                <input type="hidden" name="e_StdName" value="<?php echo $_POST['e_StdName'] ?>">
                                <input type="hidden" name="e_Credit" value="<?php echo $value['Credit'];?>">
                                <input type="hidden" name="e_Type" value="<?php echo $value['Type'];?>">

                                <button type="submit" class="btn btn-sm btn-primary" formaction="register_course.php">신청</button>
                            </form>
                            </td>
                            <td class="text-nowrap"><?php echo $value['CourseCode'];?></td>
                            <td class="text-nowrap"><?php echo $value['CourseName'];?></td>
                            <td class="text-nowrap"><?php echo $value['Lecturer'];?></td>
                            <td><?php echo $value['Type'];?></td>
                            <td><?php echo $value['Credit'];?></td>
                            <td class="text-nowrap"><?php echo $value['CourseTime2'];?></td>
                            <td><?php echo $value['StudQuota'];?></td>
                        </tr>

                        <?php
                        }
                        ?>
                    </tbody>
                    </table><?php
                    if (mysqli_num_rows($result) == 0){
                        ?>
                        <div class="mt-3 pt-4 mb-3 pb-4 border border-dark border-left-0 border-right-0">
                            <div class="non-page board">
                                <h3>조회된 과목이 없습니다</h3>
                            </div>
                        </div>
                    <?php  }  ?>
                </div>
            </div>
        </div>

        <br>
        
        <!--  Display registered courses  -->
        <div class="title-box">
            <div class="row">
                <div class="col-md-auto">
                    <h3 class="tit-h3">수강꾸러미 신청현황 <small id="grid03cnt"><?php echo mysqli_num_rows($result2)?>건</small></h3>
                </div>
            </div>
        </div>

        <div class="table-responsive mt-1">
            <table class="table table-line text-break text-center" summary="과목 검색 목록 표입니다">
                        <caption>this is a grid caption.</caption>
                        <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">신청</th>
                            <th scope="col">교과목코드</th>
                            <th scope="col">교과목명</th>
                            <th scope="col">담당교수</th>
                            <th scope="col">교과구분</th>
                            <th scope="col">학점</th>
                            <th scope="col">강의시간</th>
                            <th scope="col">제한인원</th>
                        </tr>
                    </thead>
                        <tbody id="grid02">
                        <?php
                            // LOOP TILL END OF DATA
                            $rows2 = array();
                            while ($row2 =  mysqli_fetch_assoc($result2)){
                                $rows2[] = $row2;
                            }
                            foreach($rows2 as $key=>$value)    
                        {
                        ?>

                        <tr>
                            <td><?php echo $key+1;?></td>
                            <td>

                            <form action="delete_course.php" method="post">
                                <input type="hidden" class="form-control" name="e_courseCode" value="<?php echo $value['CourseCode']?>">
                                <input type="hidden" class="form-control" name="e_StdNo" value="<?php echo $_POST['e_StdNo'] ?>">
                                <input type="hidden" name="e_StdName" value="<?php echo $_POST['e_StdName'] ?>">
                                <button type="submit" class="btn btn-sm btn-primary" formaction="delete_course.php">삭제</button>
                            </form>
                                
                            </td>
                            <td class="text-nowrap"><?php echo $value['CourseCode'];?></td>
                            <td class="text-nowrap"><?php echo $value['CourseName'];?></td>
                            <td class="text-nowrap"><?php echo $value['Lecturer'];?></td>
                            <td><?php echo $value['Type'];?></td>
                            <td><?php echo $value['Credit'];?></td>
                            <td class="text-nowrap"><?php echo $value['CourseTime2'];?></td>
                            <td><?php echo $value['StudQuota'];?></td>
                        </tr>

                        <?php
                        }
                        ?>
                    </tbody>
                    </table><?php
                    if (mysqli_num_rows($result2) == 0){
                        ?>
                        <div class="mt-3 pt-4 mb-3 pb-4 border border-dark border-left-0 border-right-0">
                            <div class="non-page board">
                                <h3>신천된 과목이 없습니다</h3>
                            </div>
                        </div>
                    <?php  }  ?>
        </div>
    </div>
    <div id="footer">
        <div class="container">
  	        <div class="footer-menu">
	            <ul>
	                <li><a href="#">개인정보처리방침</a></li>
	            </ul>
	        </div>
	        <address>
	            <span>41566 대구광역시 북구 대학로 80 (산격동, 경북대학교)</span>
	            <span>학교 안내전화 <a href="tel:053-950-5114">053-950-5114</a></span>
	            <span>당직실 <a href="tel:053-950-6000">053-950-6000</a></span>
	            <span>정보화본부 IT서비스팀 <a href="tel:053-950-4000">053-950-4000</a></span>
	        </address>
		</div>
    </div>
</div>

</body>
</html>
