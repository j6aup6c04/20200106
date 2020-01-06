<?php
    //讀出會員資料
    session_start();
    
    //檢查有沒有讀取到
    if(isset($_SESSION["name"])==FALSE) {
        header("Location: work.php");
    }

    //偵測登出
    if(isset($_POST["signout"])==true) {
        //print '<script>alert("已登出，將在1秒後回到首頁")</script>';
        sleep(1);
        header("Location: work.php");
    }

    header("Content-Type:text/html; charset=utf-8");

    //付款方式
    if(isset($_POST["pay"])==true) {
        print '<script>alert("由於沒有付款方式，所以沒有製作")</script>';
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
    <form action="" method="post">
        <nav class="navbar navbar-expand-lg navbar-light bg-danger">
            <a class="navbar-brand" href="login.php"><h1><font face="微軟正黑體">兔兔小舖</font></h1></a>
            <div class="ml-auto">
                <button type="submit" name="signout" class="btn btn-info">
                    <font face="微軟正黑體">
                        登出
                    </font>
                </button>
            </div>
        </nav>

        <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
                
            <a class="navbar-brand" href="login.php">首頁</a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="wristband.php"><font face="微軟正黑體">手環</font></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ring.php"><font face="微軟正黑體">戒指</font></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="necklace.php"><font face="微軟正黑體">項鍊</font></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="earring.php"><font face="微軟正黑體">耳環</font></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="hairpin.php"><font face="微軟正黑體">髮夾</font></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="other.php"><font face="微軟正黑體">其他</font></a>
                    </li>
                </ul>
            </div>
            
        </nav>
    </form>
    

    <!-- 把菜單置頂 -->
    <form action="" method="post">
        <nav class="fixed-top">
            <nav class="navbar navbar-expand-lg navbar-light bg-danger">
                <a class="navbar-brand" href="login.php"><h1><font face="微軟正黑體" color="#ffffff">兔兔小舖</font></h1></a>
                <div class="ml-auto">
                    <button type="submit" name="signout" class="btn btn-dark">
                        <font face="微軟正黑體">
                            登出
                        </font>
                    </button>
                </div>
            </nav>

            <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
                
                <a class="navbar-brand" href="login.php"><font face="微軟正黑體">首頁</font></a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="wristband.php"><font face="微軟正黑體">手環</font></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="ring.php"><font face="微軟正黑體">戒指</font></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="necklace.php"><font face="微軟正黑體">項鍊</font></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="earring.php"><font face="微軟正黑體">耳環</font></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="hairpin.php"><font face="微軟正黑體">髮夾</font></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="other.php"><font face="微軟正黑體">其他</font></a>
                        </li>
                    </ul>
                </div>
                
            </nav>
        </nav>
    </form>
    
    <div class="container mt-5">
        <div class="row">
            <?php
                $host = "localhost";
                $user = "root";
                $passwd = "";
                
                $connect = mysqli_connect($host,$user,$passwd,"cart");

                $sql = mysqli_query($connect,"SELECT * FROM cart");
                $num = mysqli_num_rows($sql);

                for ($i=0; $i<$num; $i++){

                    $sql = mysqli_query($connect,"SELECT * FROM cart WHERE num = ($i+1);");
                    $row= mysqli_fetch_array($sql);
                    $imgurl = $row["imgurl"];
                    $price = $row["price"];
                    $id = $row["id"];
                    $type = $row["type"];
                    
                    print '<div align="center" class="col-lg-3 col-sm-3 mb-5">'.PHP_EOL;
                    print '<h4 class="md-5"><font face="微軟正黑體" color="#ffffff">第 '.($i+1).' 件商品</font></h4>';
                    print '</div>';
                    print '<div align="left" class="col-lg-5 col-sm-5 mb-5">';
                    print '<img class="img-fluid rounded" src="'. $imgurl .'" alt="">';
                    print '</div>';
                    print '<div align="left" class="col-lg-4 col-sm-4 mb-5">';
                    print '<h2>';
                    print '<font face="微軟正黑體" color="#ffffff">'. $type .' 類</font>';
                    print '<br><br>';
                    print '<font face="微軟正黑體" color="#ffffff">Product Name '.$id.'</font>';
                    print '<br><br>';
                    print '<font face="微軟正黑體" color="#ffffff">價格: '.$price.'</font>';
                    print '</h2>';
                    print '</div>';
                }
            ?>
        </div>
    </div>

    <div style="height:100px"></div>
    
    <form action="checkout.php" method="post">
        <footer class="navbar fixed-bottom">            
            <?php
                $sql = mysqli_query($connect,"SELECT SUM(price) as total FROM cart");
                $row = mysqli_fetch_array($sql);
                $sum = $row['total'];
                
                print '<table align="center">';
                print '<tr>';
                print '<td>';
                print '<h4>';
                print '<font face="微軟正黑體" color="#ffffff">總計: </font>';
                print '<font face="微軟正黑體" color="#ffffff">'.$sum.'元</font>';
                print '</h4>';
                print '</td>';
                print '</tr>';
                print '<tr>';
                print '<td>';
                print '<button type="submit" name="pay" class="btn btn-primary"><font face="微軟正黑體">選擇付款方式</font></button>';
                print '</td>';
                print '</tr>';
                print '</table>';
            ?>
        </footer>
    </form>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>