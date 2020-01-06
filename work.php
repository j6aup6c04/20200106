<?php
    header("Content-Type:text/html; charset=utf-8");
    
    $host = "localhost";
    $user = "root";
    $passwd = "";
    //$database = "nfu";

    $connect = mysqli_connect($host,$user,$passwd/*,$database*/);

    //刪除 會員資料庫
    //mysqli_query($connect,"DROP DATABASE IF EXISTS login");
    
    //會員資料庫
    //判斷 有沒有 會員資料庫 沒有 就創建一個 
    // if not exists = 如果不存在
    if(mysqli_query($connect,"create database if not exists `login`;")) {
        #更新連結位置
        $connect = mysqli_connect($host,$user,$passwd,"login");

        //NOT NULL = 不是空的  AUTO_INCREMENT = 自動增加 = 表格上的AI
        //PRIMARY KEY = 主鍵    nick = 找有沒有缺少的
        $sql =  "CREATE TABLE IF NOT EXISTS login (
                id int NOT NULL AUTO_INCREMENT,
                name text,
                email text, 
                password text,
                PRIMARY KEY (id));";
        mysqli_query($connect,$sql);
        }

    //註冊的認證
    // empty = 檢查有沒有填寫
    if(isset($_POST["registered"])==true) {

        if(empty($_POST["username"])==true || empty($_POST["userpassword"])==true || empty($_POST["userpassword2"])==true || empty($_POST["useremail"])==true){
            print '<script>alert("尚未填寫完畢，請重新註冊")</script>';

        }
    
        //確認都填寫了
        if(isset($_POST["registered"])==true && empty($_POST["userpassword"])==false && empty($_POST["userpassword2"])==false && empty($_POST["useremail"])==false){
            
            $host = "localhost";
            $user = "root";
            $passwd = "";
            
            $connect = mysqli_connect($host,$user,$passwd,"login");
            
            //用e-mail檢查有沒有重複
            $sql = mysqli_query($connect,"SELECT * FROM login WHERE email='$_POST[useremail]'");
            $row= mysqli_fetch_array($sql);
            if($row["email"]==$_POST["useremail"]){
                print '<script>alert("此信箱已註冊，請 登入 或 重新註冊")</script>';
            } else {
                $sql = mysqli_query($connect,"INSERT INTO login (id,name, email, password) VALUES('','$_POST[username]','$_POST[useremail]','$_POST[userpassword]')");
                if(!$sql){
                    print '<script>alert("註冊失敗")</script>';
                } else {
                    print '<script>alert("註冊成功")</script>';
                }
            }
        }

    }

    //登入的認證 
    
    if(isset($_POST["login"])==true) {

        $host = "localhost";
        $user = "root";
        $passwd = "";
        
        $connect = mysqli_connect($host,$user,$passwd,"login");

        $sql = mysqli_query($connect,"SELECT * FROM login");
        while($row = mysqli_fetch_array($sql)){
            if (empty($_POST["useremail"]==false && empty($_POST["userpassword"])==false)){
                
                //防止BUG
                $useremail = $_POST["useremail"];
                $useremail = mysqli_real_escape_string($connect,$useremail);
                $userpassword = $_POST["userpassword"];
                $userpassword = mysqli_real_escape_string($connect,$userpassword);
                
                //找有沒有一樣
                if($row["email"]==$_POST["useremail"]){
                    if($row["password"]==$_POST["userpassword"]){
                        session_start();
                        $_SESSION["email"] = $_POST["useremail"];
                        $_SESSION["password"] = $_POST["userpassword"];
                        $_SESSION["name"] = $row["name"];
                        $_SESSION["id"] = $row["id"];
                        sleep(1);
                        header('Location: login.php');
                        //$url="<a href="."\"login.php\">下一頁</a>";
                        //print $url;
                    } else {
                        print '<script>alert("密碼錯誤! 請重新登入")</script>';
                        break;
                    }
                } else {
                    print '<script>alert("沒有找到此帳號，請重新輸入")</script>';
                }
            } else {

            }
        }
    }
    
    //偵測有沒有登入使用購物車 沒有就提示
    if(isset($_POST["nologin"])==true) {
        print '<script>alert("無法使用! 請登入後再進行")</script>';
    }
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>兔兔小舖</title>
  </head>

  <body style="background-color:#000000;">
    <!-- 菜單 -->
    <nav class="navbar navbar-expand-lg navbar-light bg-danger">
        <a class="navbar-brand" href="work.php"><h1><font color="#ffffff">兔兔小舖</font></h1></a>
        <div class="ml-auto">
            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#login">
                登入
            </button>
        </div>

        <div class="ml-2">
            <button name="" type="button" name="registered" class="btn btn-info" data-toggle="modal" data-target="#registered">
                註冊
            </button>
        </div>
    </nav>

    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
            
        <a class="navbar-brand" href="work.php">首頁</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="work.php" onclick='alert("無法使用! 請登入後再進行")'><font face="微軟正黑體">手環</font></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="work.php" onclick='alert("無法使用! 請登入後再進行")'><font face="微軟正黑體">戒指</font></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="work.php" onclick='alert("無法使用! 請登入後再進行")'><font face="微軟正黑體">項鍊</font></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="work.php" onclick='alert("無法使用! 請登入後再進行")'><font face="微軟正黑體">耳環</font></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="work.php" onclick='alert("無法使用! 請登入後再進行")'><font face="微軟正黑體">髮夾</font></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="work.php" onclick='alert("無法使用! 請登入後再進行")'><font face="微軟正黑體">其他</font></a>
                </li>
            </ul>
        </div>
        
    </nav>

    <!-- 把菜單置頂 -->
    <nav class="fixed-top">
        <nav class="navbar navbar-expand-lg navbar-light bg-danger">
            <a class="navbar-brand" href="work.php"><h1><font face="微軟正黑體" color="#ffffff">兔兔小舖</font></h1></a>
            <div class="ml-auto">
                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#login">
                    <font face="微軟正黑體">
                        會員
                    </font>
                </button>
            </div>

            <div class="ml-2">
                <button type="button" name="registered" class="btn btn-dark" data-toggle="modal" data-target="#registered">
                    <font face="微軟正黑體">
                        註冊
                    </font>
                </button>
            </div>
        </nav>

        <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
            
            <a class="navbar-brand" href="work.php"><font face="微軟正黑體">首頁</font></a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="work.php" onclick='alert("無法使用! 請登入後再進行")'><font face="微軟正黑體">手環</font></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="work.php" onclick='alert("無法使用! 請登入後再進行")'><font face="微軟正黑體">戒指</font></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="work.php" onclick='alert("無法使用! 請登入後再進行")'><font face="微軟正黑體">項鍊</font></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="work.php" onclick='alert("無法使用! 請登入後再進行")'><font face="微軟正黑體">耳環</font></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="work.php" onclick='alert("無法使用! 請登入後再進行")'><font face="微軟正黑體">髮夾</font></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="work.php" onclick='alert("無法使用! 請登入後再進行")'><font face="微軟正黑體">其他</font></a>
                    </li>
                </ul>
            </div>
            
        </nav>
    </nav>
    <!-- 圖 跟 商品資訊 -->
    <div class="container">
        <h1 class="mt-4 mb-3"><font face="微軟正黑體" color="#ffffff">最新活動</font></h1>
            
        <div class="bd-example mt-4 mb-3">
            <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                    <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="img/1.jpg" class="d-block w-100" width="1000" height="600" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="img/2.jpg" class="d-block w-100" width="1000" height="600" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="img/3.jpg" class="d-block w-100" width="1000" height="600" alt="...">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>

        <h2 class="mt-4 mb-3"><font face="微軟正黑體" color="#ffffff">活動商品</font></h2>
        
        <div class="row">
            <!-- 顯示產品 與 紀錄 -->
            <?php
                for ($i=1; $i<21; $i++){
                    $price = rand(100,1000);
                    print '<div class="col-lg-3 col-md-4 col-sm-6 mb-4">'.PHP_EOL;
                    print '<div class="card text-center">';
                    print '<a href="#" data-toggle="modal" data-target="#exampleModalScrollable'.$i.'">';
                    $img = "http://placeimg.com/250/25". $i%10 ."/any";
                    print '<img class="card-img-top" src="'. $img .'" alt="">';
                    print '</a>';
                    print '<div class="card-body">';
                    print '<h5 class="card-title"><font face="微軟正黑體">Product Name'. $i .'</font></h5>';
                    print '<p class="card-text text-danger">$'. $price .'</p>';
                    print '</div>';
                    print '<div class="card-footer text-muted">';
                    print '<button id=#p'."$i".'  type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalScrollable'.$i.'">查看商品</button>';
                    print '</div>';
                    print '</div>';
                    print '</div>';
                };
            ?>
        </div>
    </div>

    <!-- 查看商品 -->
    <?php
        //$text = array(range(1,20,1));
        for ($i=1; $i<21; $i++){
            //偵測有沒有登入
            print '<form action="work.php" method="post">';

            print '<div class="modal fade" id="exampleModalScrollable'.$i.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">'.PHP_EOL;
            print '<div class="modal-dialog modal-dialog-scrollable" role="document">';
            print '<div class="modal-content">';
            print '<div class="modal-header">';  
            print '<h5 class="modal-title" id="exampleModalScrollableTitle"><font face="微軟正黑體">商品' . $i . '</font></h5>';
            print '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';        
            print '<span aria-hidden="true">&times;</span>';
            print '</button>';       
            print '</div>';
            
            print '<div class="modal-body">';
            print '<div class="container">';
            
            print '<div class="row">';
            print '<div class="col-sm-12 col-lg-6 mb-4">';
            $img = "http://placeimg.com/250/25". $i%10 ."/any";
            print '<img src="'. $img .'" alt="" class="img-fluid rounded">';
            print '</div>';

            print '<div class="col-sm-12 col-lg-6 mb-4">';
            print '<p><font face="微軟正黑體">';
            print '文字敘述 '. $i .'';
            print '</font></p>';
            print '</div>';
            print '</div>';
            
            print '</div>';
            print '</div>';

            print '<div class="modal-footer">';
            print '<button type="submit" name="nologin" class="btn btn-primary"><font face="微軟正黑體">加入購物車</font></button>';
            print '<button type="button" class="btn btn-secondary" data-dismiss="modal"><font face="微軟正黑體">再繼續逛</font></button>';
            print '</div>';
            print '</div>';
            print '</div>';   
            print '</div>';

            print '</form>';

        }
    ?>

    <!-- 登入 -->
    <!-- 要換頁成功 要記得填寫 action -->
    <form action="work.php" method="post">
        <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><font face="微軟正黑體">登入</font></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                    <!-- cellpadding = 表格內的間隔 -->
                        <table align="center" cellpadding="5" >
                            <tr>
                                <td>
                                    <font face="微軟正黑體"><h3>E-mail:</h3></font>
                                </td>
                                <td>
                                    <input type="text" name="useremail">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <font face="微軟正黑體"><h3>密碼:</h3></font>
                                </td>
                                <td>
                                    <input type="password" name="userpassword">
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" name="login" class="btn btn-primary"><font face="微軟正黑體">登入</font></button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><font face="微軟正黑體">取消</font></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
    <!-- 註冊 -->
    <form action="work.php" method="post">
        <div class="modal fade" id="registered" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><font face="微軟正黑體">註冊</font></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                    <!-- cellpadding = 表格內的間隔 -->
                        <table align="center" cellpadding="5" >
                            <tr>
                                <td>
                                    <font face="微軟正黑體"><h3>e-mail:</h3></font>
                                </td>
                                <td>
                                    <input type="email" name="useremail">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <font face="微軟正黑體"><h3>姓名:</h3></font>
                                </td>
                                <td>
                                    <input type="text" name="username">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <font face="微軟正黑體"><h3>密碼:</h3></font>
                                </td>
                                <td>
                                    <input type="password" name="userpassword">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <font face="微軟正黑體"><h3>確認密碼:</h3></font>
                                </td>
                                <td>
                                    <input type="password" name="userpassword2">
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" name="registered" class="btn btn-primary"><font face="微軟正黑體">確認註冊</font></button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><font face="微軟正黑體">取消</font></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>