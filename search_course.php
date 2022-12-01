<?php
    // connect to mysql db
    require_once 'dbconfig.php';

    $e_courseCode = mysqli_real_escape_string($link, $_REQUEST['e_courseCode']);
    $e_StdNo = mysqli_real_escape_string($link, $_REQUEST['e_StdNo']);

    if (empty($e_courseCode) || empty($e_StdNo)) {			
        echo "<script>
            alert('Empty input is not allowed!'); 
            location.href='index.php';
        </script>";
	}

    $sql = "INSERT IGNORE INTO SUGANG.COURSE_SEARCHING VALUES ('$e_courseCode','e_StdNo');";

    $result = mysqli_query($link, $sql);
    
?>

<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densitydpi=medium-dpi" />
    <title>sugang</title>
    <link href="https://sugang.knu.ac.kr/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://sugang.knu.ac.kr/views/sugang/css/icommon.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
  
</head>
<body>

<div id="divNoData01" class="mt-3 pt-4 mb-3 pb-4 border border-dark border-left-0 border-right-0" style="">
	        <div class="non-page board">
	            <h3>조회된 목록이 없습니다</h3>
	        </div>
</div>
    <!--
<div class="table-responsive mt-1">
                    <table class="table table-line text-break text-center" summary="과목 검색 목록 표입니다">
                        <caption>this is a grid caption.</caption>
                        <thead>
                        <tr>
                            <th scope="col">No.</th>
                            <th scope="col">신청</th>
                            <th scope="col">교과목코드</th>
                            <th scope="col">교과목명</th>
                            <th scope="col">분반</th>
                            <th scope="col">교과구분</th>
                            <th scope="col">학점</th>
                            <th scope="col">재이수년도</th>
                            <th scope="col">재이수학기</th>
                            <th scope="col">강의시간</th>
                            <th scope="col">제한인원</th>
                            <th scope="col">수강인원</th>
                        </tr>
                    </thead>
                        <tbody id="grid02">
                        <tr>
                            <td>1</td>
                            <td>
                                <a href="#none" onclick="$.scwin.fn_goReqAdd(0);" class="btn btn-sm btn-primary">신청</a>
                            </td>
                            <td class="text-nowrap">ITEC0425</td>
                            <td class="text-nowrap">컴퓨터게임제작</td>
                            <td>001</td>
                            <td>공학전공</td>
                            <td>3</td>
                            <td></td>
                            <td></td>
                            <td class="text-nowrap">월 13:00 ~ 14:00,월 14:00 ~ 15:00,월 15:00 ~ 16:00,화 13:00 ~ 14:00,화 14:00 ~ 15:00,화 15:00 ~ 16:00,수 13:00 ~ 14:00,수 14:00 ~ 15:00,수 15:00 ~ 16:00,목 13:00 ~ 14:00,목 14:00 ~ 15:00,목 15:00 ~ 16:00,금 13:00 ~ 14:00,금 14:00 ~ 15:00,금 15:00 ~ 16:00</td>
                            <td>60</td>
                            <td>53</td>
                        </tr>
                    </tbody>
                    </table>
                    <div id="divNoData02" class="mt-3 pt-4 mb-3 pb-4 border border-dark border-left-0 border-right-0" style="display:none;">
	                    <div class="non-page board">
	                        <h3>조회된 목록이 없습니다</h3>
	                    </div>
	                </div>
                </div> -->
</body>
</html>