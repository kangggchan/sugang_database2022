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

    //Check validate login information
    $sql ="SELECT StdName FROM SUGANG.STUDENT WHERE '$e_StdNo' = StdNo";
    $result = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($result);

    //Go back to login page if login failed
    if (strcmp($row['StdName'], $e_StdName) != 0){
        echo "<script>
        alert('Wrong information!');
        window.history.back();
        </script>";
    }

    

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
                    <div class="b-con-box"> IT대학 컴퓨터학부 </div>
                </div>
                <div class="b-row-item">
                    <div class="b-title-box">
                        <label for="allLmttnCrdit"> 수강신청학점 </label>
                    </div>
                    <div class="b-con-box" id="allLmttnCrdit"></div>
                </div>
            </div>
        </div>

        <br>
        <br>

        <div class="b-table-box flex-col-4">
            <div class="b-row-box">
                <div class="b-row-item">
                    <div class="b-title-box text-danger"> 강좌번호<br>(12자리) </div>
                    <form action="search_course.php" method="post" class="b-row-item">
                    <div class="b-con-box"> 
                        <input type="text" class="form-control" name="e_courseCode" placeholder="교과목 코드를 입력하세요 (e.g., CLTR0003-005)"> 
                    </div>
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
                </div>
            </div><!-- tab1 -->
        </div>

        <br>
        

        <div class="title-box">
            <div class="row">
                <div class="col-md-auto">
                    <h3 class="tit-h3">수강꾸러미 신청현황 <small id="grid03cnt">0건</small></h3>
                </div>
                <div class="col-md mt-2 mt-md-0">
                    <div class="text-right">
                        <a href="#none" class="btn btn-primary" id="btnSave" style="display:none;" onclick="$.scwin.fn_goReqSave();">저장</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive mt-1">
            <table class="table table-line text-break text-center" summary="수강신청 목록 표입니다">
                <caption>this is a grid caption.</caption>
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">삭제</th>
                        <th scope="col">교과목코드</th>
                        <th scope="col">교과목명</th>
                        <th scope="col">분반</th>
                        <th scope="col">교과구분</th>
                        <th scope="col">학점</th>
                        <th scope="col">재이수년도</th>
                        <th scope="col">재이수학기</th>
                        <th scope="col">강의시간</th>
                    </tr>
                </thead>
                <tbody id="grid03">
                    <tr>
                        <td>1</td>
                        <td>
                            <a href="#none" onclick="$.scwin.fn_goReqDel(0);" class="btn btn-sm btn-primary">삭제</a>
                        </td>
                        <td class="text-nowrap">ITEC0425</td>
                        <td class="text-nowrap">컴퓨터게임제작</td>
                        <td>001</td>
                        <td><select class="form-control form-control-sm w-100" disabled=""><option value="">선택</option><option value="STCU000800001">교양</option><option value="STCU000800002">전공기초</option><option value="STCU000800004" selected="">전공</option><option value="STCU000800005">부전공</option><option value="STCU000800006">복수전공</option><option value="STCU000800007">교직</option><option value="STCU000800012">전공필수</option><option value="STCU000800010">연계전공</option><option value="STCU000800023">융합전공</option><option value="STCU000800024">전공심화</option><option value="STCU000800025">일반선택</option><option value="STCU000800026">공학전공</option><option value="STCU000800027">전공기반</option><option value="STCU000800028">기본소양</option></select></td>
                        <td>3</td>
                        <td></td>
                        <td></td>
                        <td>월 13:00 ~ 14:00,월 14:00 ~ 15:00,월 15:00 ~ 16:00,화 13:00 ~ 14:00,화 14:00 ~ 15:00,화 15:00 ~ 16:00,수 13:00 ~ 14:00,수 14:00 ~ 15:00,수 15:00 ~ 16:00,목 13:00 ~ 14:00,목 14:00 ~ 15:00,목 15:00 ~ 16:00,금 13:00 ~ 14:00,금 14:00 ~ 15:00,금 15:00 ~ 16:00</td>
                    </tr>
                </tbody>
            </table>
            <div id="divNoData03" class="mt-3 pt-4 mb-3 pb-4 border border-dark border-left-0 border-right-0" style="display:none;">
                <div class="non-page board">
                    <h3>조회된 목록이 없습니다</h3>
                </div>
            </div>
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