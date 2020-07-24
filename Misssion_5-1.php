<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_5-1</title>
    </head>
    <body>
        <?php
        //データベースに接続
        $dsn = 'データベース名';
        $user = 'ユーザー名';
        $password = 'パスワード';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        //テーブル作成
        $sql = "CREATE TABLE IF NOT EXISTS tbmission_5_1"
        ."("
        ."id INT AUTO_INCREMENT PRIMARY KEY,"
        ."name char(32),"
        ."comment TEXT,"
        ."date datetime,"
        ."password char(32)"
        .");";
        $stmt = $pdo->query($sql);
        ?>
        <form action=""method="POST">
            <input type="number"name="num2"placeholder="編集対象番号">
            <input type="password"name="password0"placeholder="パスワード">
            <input type="submit"name="submit3"value="編集">
        </form>
        <?php
        if(!empty($_POST["num2"])&&!empty($_POST["password0"])){
            $num2=$_POST["num2"];
            $pass0=$_POST["password0"];
            $sql = 'SELECT * FROM tbmission_5_1';
	        $stmt = $pdo->query($sql);
	        $results = $stmt->fetchAll();
	        foreach ($results as $row){//$rowの中にはテーブルのカラム名が入る
                if($row['id']==$num2&&$row['password']==$pass0){
                    $kazu=$row['id'];
                    $namae=$row['name'];
                    $comment=$row['comment'];
                    $key=$row['password'];
                }
	        }
        }?>
        <form action=""method="POST">
            <input type="text"name="name"placeholder="名前"
            value="<?php if(!empty($namae)){echo $namae;}?>">
            <input type="text"name="str"placeholder="コメント"
            value="<?php if(!empty($comment)){echo $comment;}?>">
            <input type="password"name="password"placeholder="パスワード"
            value="<?php if(!empty($key)){echo $key;}?>">
            <input type="submit"name="submit"><br>
            <input type="number"name="num"placeholder="削除対象番号">
            <input type="password"name="password1"placeholder="パスワード">
            <input type="submit"name="submit2"value="削除">
            <input type="hidden"name="hidden"
            value="<?php if(!empty($kazu)){echo $kazu;
            }else{echo "0";}?>">
        </form>
        <?php
        if(!empty($_POST["name"]&&$_POST["str"]&&$_POST["password"])){
            $name0=$_POST["name"];
            $str=$_POST["str"];
            $date0=date("Y/m/d/H:i:s");
            $pass=$_POST["password"];
            $kazu2=$_POST["hidden"];
        }
        if(empty($_POST["num"])&&empty($_POST["num2"])){
            if(empty($_POST["str"])||empty($_POST["name"])||empty($_POST["password"])){
                echo "未入力です。<br>";
            }else{
                if($kazu2==0){
                    //データ入力
                    $sql = $pdo -> prepare("INSERT INTO tbmission_5_1 (name, comment,date,password) VALUES (:name, :comment,:date,:password)");
	                $sql -> bindParam(':name', $name, PDO::PARAM_STR);
                    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                    $sql -> bindParam(':date', $date, PDO::PARAM_STR);
                    $sql -> bindParam(':password', $password, PDO::PARAM_STR);
	                $name=$name0;
                    $comment=$str; 
                    $date=$date0;
                    $password=$pass;
	                $sql -> execute();
                }else{
                    $id=$kazu2; //変更する投稿番号
	                $name=$name0;
                    $comment=$str; 
                    $password=$pass;
	                $sql='UPDATE tbmission_5_1 SET name=:name,comment=:comment,password=:password WHERE id=:id';
	                $stmt = $pdo->prepare($sql);
	                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                    $stmt->bindParam(':password', $password, PDO::PARAM_STR);
	                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	                $stmt->execute();
                }
            }
        }elseif(empty($_POST["num2"])){
            $pass1=$_POST["password1"];
            $num=$_POST["num"];
            $id=$num;
            $sql='delete from tbmission_5_1 where id=:id';
	        $stmt=$pdo->prepare($sql);
	        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        }
        //テーブルの中身表示
        $sql = 'SELECT * FROM tbmission_5_1';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){//$rowの中にはテーブルのカラム名が入る
            echo $row['id'].'<>'.$row['name'].'<>'.$row['comment'].'<>'.$row['date'].'<br>';
        }
	    ?>
    </body>
</html>