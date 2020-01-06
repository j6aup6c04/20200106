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
    
    $host = "localhost";
    $user = "root";
    $passwd = "";
    $connect = mysqli_connect($host,$user,$passwd);

    //刪除 產品資料庫
    //mysqli_query($connect,"DROP DATABASE IF EXISTS product");

    //判斷 有沒有 產品 資料庫 沒有 就創建一個 
    // if not exists = 如果不存在
    if(mysqli_query($connect,"create database if not exists `product`;")) {
        #更新連結位置
        $connect = mysqli_connect($host,$user,$passwd,"product");
        
        //創建 ring 表
        //NOT NULL = 不是空的  AUTO_INCREMENT = 自動增加 = 表格上的AI
        //PRIMARY KEY = 主鍵
        $sql =  "CREATE TABLE IF NOT EXISTS ring (
                id int NOT NULL AUTO_INCREMENT,
                type nvarchar(100),
                page int,
                imgurl nvarchar(100), 
                price int,
                PRIMARY KEY (id));";
        mysqli_query($connect,$sql);
    }

    //刪除 購物車資料庫
    //mysqli_query($connect,"DROP DATABASE IF EXISTS cart");

    //判斷 有沒有 cart 資料庫 沒有 就創建一個 
    // if not exists = 如果不存在
    if(mysqli_query($connect,"create database if not exists `cart`;")) {
        #更新連結位置
        $connect = mysqli_connect($host,$user,$passwd,"cart");

        //NOT NULL = 不是空的  AUTO_INCREMENT = 自動增加 = 表格上的AI
        //PRIMARY KEY = 主鍵
        $sql =  "CREATE TABLE IF NOT EXISTS cart (
                num int NOT NULL AUTO_INCREMENT,
                id int,
                type nvarchar(100),
                page int,
                imgurl nvarchar(100), 
                price int,
                PRIMARY KEY (num));";
        mysqli_query($connect,$sql);
    }

    //加入購物車
    
    for ($i=1; $i<21; $i++) {

        if(isset($_POST["send$i"])==true){
        $id = $_POST["product$i"];

        $host = "localhost";
        $user = "root";
        $passwd = "";
        
        $connect = mysqli_connect($host,$user,$passwd,"product");

        $sql = mysqli_query($connect,"SELECT * FROM ring WHERE id='$id'");
        $row= mysqli_fetch_array($sql);

        $type = $row["type"];
        $page = $row["page"];
        $imgurl = $row["imgurl"];
        $price = $row["price"];

        $connect = mysqli_connect($host,$user,$passwd,"cart");

        $sql = "INSERT INTO `cart`(`num`,`id`,`type`,`page`,`imgurl`,`price`) VALUES (DEFAULT,$id,'$type',$page,'$imgurl',$price);";
        mysqli_query($connect,$sql);

        }
        
    }
    
    //移除 購物車內的全部商品
    $host = "localhost";
    $user = "root";
    $passwd = "";
    
    $connect = mysqli_connect($host,$user,$passwd,"cart");
    
    if(isset($_POST["remove"])==true){
        //清空
        mysqli_query($connect,"DROP DATABASE IF EXISTS cart");
        //重新建立
        if(mysqli_query($connect,"create database if not exists `cart`;")) {
            #更新連結位置
            $connect = mysqli_connect($host,$user,$passwd,"cart");
    
            //NOT NULL = 不是空的  AUTO_INCREMENT = 自動增加 = 表格上的AI
            //PRIMARY KEY = 主鍵
            $sql =  "CREATE TABLE IF NOT EXISTS cart (
                    num int NOT NULL AUTO_INCREMENT,
                    id int,
                    type nvarchar(100),
                    page int,
                    imgurl nvarchar(100), 
                    price int,
                    PRIMARY KEY (num));";
            mysqli_query($connect,$sql);
        }
        
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
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#cart">
                    <font face="微軟正黑體">
                        購物車
                    </font>
                </button>
            </div>

            <div class="ml-2">
                <button type="submit" name="signout" class="btn btn-info">
                    <font face="微軟正黑體">
                        登出
                    </font>
                </button>
            </div>
        </nav>

        <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
                
            <a class="nav-link" href="login.php"><font face="微軟正黑體" color="#949494">首頁</font></a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="wristband.php"><font face="微軟正黑體">手環</font></a>
                    </li>
                    <li class="nav-item">
                        <a class="navbar-brand" href="ring.php"><font face="微軟正黑體">戒指</font></a>
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
                    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#cart">
                        <font face="微軟正黑體">
                            購物車
                        </font>
                    </button>
                </div>

                <div class="ml-2">
                    <button type="submit" name="signout" class="btn btn-dark">
                        <font face="微軟正黑體">
                            登出
                        </font>
                    </button>
                </div>
            </nav>

            <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
                
                <a class="nav-link" href="login.php"><font face="微軟正黑體" color="#949494">首頁</font></a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="wristband.php"><font face="微軟正黑體">手環</font></a>
                        </li>
                        <li class="nav-item">
                            <a class="navbar-brand" href="ring.php"><font face="微軟正黑體">戒指</font></a>
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
    

    <!-- 圖 跟 商品資訊 -->
    <div class="container">

        <h2 class="mt-4 mb-3"><font face="微軟正黑體" color="#ffffff">兔兔戒指區</font></h2>
        
        <div class="row">
            <!-- 顯示產品 與 紀錄 -->
            <?php
                $host = "localhost";
                $user = "root";
                $passwd = "";
                
                $connect = mysqli_connect($host,$user,$passwd,"product");

                //先判斷 資料庫內有沒有資料了
                //有   就讀取資料庫
                //沒有 就隨機生成20筆
                $sql = mysqli_query($connect,"SELECT * FROM ring WHERE type='戒指'");
                $num = mysqli_num_rows($sql);
                if($num < 1){
                    for ($i=1; $i<21; $i++){
                    $price = rand(100,1000);
                    print '<div class="col-lg-3 col-md-4 col-sm-6 mb-4">'.PHP_EOL;
                    print '<div class="card text-center">';
                    print '<a href="#" data-toggle="modal" data-target="#exampleModalScrollable'.$i.'">';
                    $img = "http://placeimg.com/250/25". $i%10 ."/architecture";
                    print '<img class="card-img-top" src="'. $img .'" alt="">';
                    print '</a>';
                    print '<div class="card-body">';
                    print '<h5 class="card-title"><font face="微軟正黑體">Product Name'. $i .'</font></h5>';
                    print '<p class="card-text text-danger">$'. $price .'</p>';
                    print '</div>';
                    print '<div class="card-footer text-muted">';
                    print '<button id=#p'."$i".'  type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalScrollable'.$i.'"><font face="微軟正黑體">查看商品</font></button>';
                    print '</div>';
                    print '</div>';
                    print '</div>';
                    $imgurl = $img;
                    $sql = "INSERT INTO `ring`(`id`,`type`,`page`,`imgurl`,`price`) VALUES ($i,'戒指',1,'$imgurl',$price);";
                    mysqli_query($connect,$sql);
                    }
                }else{

                    for ($i=1; $i<21; $i++){
                        print '<div class="col-lg-3 col-md-4 col-sm-6 mb-4">'.PHP_EOL;
                        print '<div class="card text-center">';
                        print '<a href="#" data-toggle="modal" data-target="#exampleModalScrollable'.$i.'">';
                        $sql = mysqli_query($connect,"SELECT * FROM ring WHERE id='$i'");
                        $row= mysqli_fetch_array($sql);
                        $img = $row["imgurl"];

                        print '<img class="card-img-top" src="'. $img .'" alt="">';
                        print '</a>';
                        print '<div class="card-body">';
                        print '<h5 class="card-title"><font face="微軟正黑體">Product Name'. $i .'</font></h5>';
                        $price = $row["price"];
                        print '<p class="card-text text-danger"><font face="微軟正黑體">$'. $price .'</font></p>';
                        print '</div>';
                        print '<div class="card-footer text-muted">';
                        print '<button id=#p'."$i".'  type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalScrollable'.$i.'">查看商品</button>';
                        print '</div>';
                        print '</div>';
                        print '</div>';
                    };
                };

                
            ?>
        </div>
    </div>

    <!-- 查看商品 -->
    <?php
        $host = "localhost";
        $user = "root";
        $passwd = "";
        
        $connect = mysqli_connect($host,$user,$passwd,"product");
        //$text = array(range(1,20,1));

        print '<form action="ring.php" method="post">';
        for ($i=1; $i<21; $i++){

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

            $sql = mysqli_query($connect,"SELECT * FROM ring WHERE id='$i'");
            $row= mysqli_fetch_array($sql);
            $img = $row["imgurl"];
            print '<img src="'. $img .'" alt="" class="img-fluid rounded">';
            print '</div>';

            print '<div class="col-sm-12 col-lg-6 mb-4">';
            print '<p>';
            print '<font face="微軟正黑體">文字敘述 '. $i .'</font>';
            print '<br>';
            $text = $row["price"];
            print '<font face="微軟正黑體">價格:' . $text . '</font>';
            print '</p>';
            print '</div>';
            print '</div>';
            
            print '</div>';
            print '</div>';

            print '<div class="modal-footer">';
            print '<input type="hidden" name="product'.$i.'" value="'.$i.'">';
            print '<button type="submit" name="send'.$i.'" class="btn btn-primary"><font face="微軟正黑體">加入購物車</font></button>';
            print '<button type="button" class="btn btn-secondary" data-dismiss="modal"><font face="微軟正黑體">再繼續逛</font></button>';
            print '</div>';
            print '</div>';   
            print '</div>';   
            print '</div>';
        
        }

        print '</form>';
    ?>

    <!-- 購物車 -->
    <div class="modal fade" id="cart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
                <table>
                    <tr>
                        <td>
                            <?php
                                print '<font face="微軟正黑體">';
                                print $_SESSION['name'];
                                print '</font>';
                            ?>
                        </td>
                        <td>
                            <font face="微軟正黑體">
                                的購物車
                            </font>
                        </td>
                    </tr>
                </table>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            
            <?php
                $host = "localhost";
                $user = "root";
                $passwd = "";
                
                $connect = mysqli_connect($host,$user,$passwd,"cart");

                $sql = mysqli_query($connect,"SELECT * FROM cart");
                $num = mysqli_num_rows($sql);

                print '<form action="" method="post">';
                print '<div class="container">';
                print '<div class="row">';

                for ($i=0; $i<$num; $i++){

                    $sql = mysqli_query($connect,"SELECT * FROM cart WHERE num = ($i+1);");
                    $row= mysqli_fetch_array($sql);
                    $imgurl = $row["imgurl"];
                    $price = $row["price"];
                    $id = $row["id"];
                    $type = $row["type"];

                    print '<div class="col-lg-12">';
                    print '<table>';
                    print '<tr>';
                    print '<td>';
                    print '<h4 class="md-5"><font face="微軟正黑體">第'.($i+1).'件商品</font></h4>';
                    print '</td>';
                    print '</tr>';
                    print '<tr>';
                    print '<td>';
                    print '<img class="img-fluid rounded" src="'. $imgurl .'" alt="">';
                    print '</td>';
                    print '<td>';
                    print '<h5>';
                    print '<font face="微軟正黑體">'. $type .'</font>';
                    print '</h5>';
                    print '<h5>';
                    print '<font face="微軟正黑體">Product Name '.$id.'</font>';
                    print '</h5>';
                    print '<h2>';
                    print '<font face="微軟正黑體">價格:'.$price.'</font>';
                    print '</h2>';
                    print '</td>';
                    print '</tr>';
                    print '</table>';
                    print '</div>';

                    
                }
                print '</div>';
                print '</div>';
                
                $sql = mysqli_query($connect,"SELECT SUM(price) as total FROM cart");
                $row = mysqli_fetch_array($sql);
                $sum = $row['total'];

                print '<table align="center">';
                print '<tr>';
                print '<td>';
                print '<h4><font face="微軟正黑體">總計:</font></h4>';
                print '</td>';
                print '<td>';
                print '<h4>';
                print '<font face="微軟正黑體">'.$sum.'元</font>';
                print '</h4>';
                print '</td>';
                print '</tr>';
                print '<tr>';
                print '<td>';
                print '<button type="submit" name="remove" class="btn btn-primary"><font face="微軟正黑體">清空購物車</font></button>';
                print '</td>';
                print '</tr>';
                print '</table>';

                print '</form>';
            ?>
        </div>
        <div class="modal-footer">
            <a href="checkout.php"><button type="button" class="btn btn-primary"><font face="微軟正黑體">結帳</font></button></a>
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><font face="微軟正黑體">再繼續逛</font></button>
        </div>
        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>