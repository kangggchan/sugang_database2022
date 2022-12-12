<?php
    // connect to mysql db
    require_once 'dbconfig.php';
?>


<!DOCTYPE html>
<html lang="kr">

<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=5">
    <link href="https://sugang.knu.ac.kr/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://sugang.knu.ac.kr/views/sugang/css/icommon.css" rel="stylesheet">
    <link href="https://sugang.knu.ac.kr/views/sugang/css/style.css" rel="stylesheet">


</head>

<body>
  
  <!-- top header -->
  <div class="top-sub">
        <div class="container">
            <div class="layout top-sub-layout">
                <div class="ly-item">
                    <ul>
                        <li>
                          <span class="top-sub-link-login">[2022-2, COMP322-6 Database] Personal project #1   ||   Author: 배복캉 (2021117446)</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
  
  <br>
  <!-- KNU logo -->
  <div class="container">
    <div class="layout between top-main-layout">
      <div class="ly-item">
        <h1 class="site-title"> <a class="site-link" href="#"> <img class="site-logo" src="https://sugang.knu.ac.kr/views/sugang/images/logo.svg" alt="경북대학교"></a> </h1>
      </div>
    </div>
  </div>
  <br>
  <!-- Login box-->
  <div class="sub-container container">

    <div id="content" class="course-login">
        <div class="box-lg-auto">
          <div class="login-box">
            <div class="login-box-header">
              <h2 class="login-box-title">온라인 수강신청</h2>
            </div>
            
            <div class="login-box-body">

              <!-- Pass login information (Name, Std Number) to sugang.php -->
              <form action="sugang.php" method="post">

                  <div class="form-group">
                    <label for="e_StdName">이름</label>
                    <input class="form-control" name="e_StdName" placeholder="이름을 입력하세요 (e.g., 배복캉)">
                  </div>

                  <div class="form-group">
                    <label for="e_StdNo">학번</label>
                    <input class="form-control" name="e_StdNo" placeholder="학번을 입력하세요 (e.g., 2021117446)">
                  </div>

                  <br>

                  <input type="submit" class="col btn btn-primary" formaction="sugang.php" value="로그인">

                </form>
            </div>
          </div>
        </div>     
    </div>
  </div>


</body>

</html>
