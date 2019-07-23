<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ID CHECK</title>
</head>
<body>
    
    <?php
    // error_reporting(0); //遮掉warning
    
    echo "ID: ".$_POST["ID"]."<br/>";
    $ID = $_POST["ID"];
    $alphabet = array("A"=>"10","B"=>"11","C"=>"12","D"=>"13","E"=>"14","F"=>"15","G"=>"16","H"=>"17","I"=>"34",
    "J"=>"18","K"=>"19","L"=>"20","M"=>"21","N"=>"22","O"=>"35","P"=>"23","Q"=>"24","R"=>"25",
    "S"=>"26","T"=>"27","U"=>"28","V"=>"29","W"=>"32","X"=>"30","Y"=>"31","Z"=>"33");
    
    $err=0; //防呆
    if(strlen($ID) != 10) //檢查字元數是否=10
        $err = "1";
    $alpha = substr($ID,0,1); //取首位字母並轉為大寫
    $alpha = strtoupper($alpha);

    $alphaNum; //用來儲存字母轉換的數值
    foreach($alphabet as $key => $value){
        // echo "字母: $key, 數值: $value".var_dump(strcmp($alpha,$key))."<br/>";
        if(strcmp($alpha,$key) == 0){ //比較字符大小，若相等回傳0
            // echo $value."<br/>";
            // echo substr($value,0,1)."<br/>"; 
            // echo substr($value,1,2)."<br/>";
            $alphaNum = substr($value,0,1)+substr($value,1,2)*9; //字母轉換數字
            // echo $alphaNum;
        }
    }
    $sex = substr($ID,1,1); //確認性別
    if($sex != 1 && $sex != 2)
        $err = "2"; //性別錯誤
    
    $sum = 0; //數字總和
    if($err == 0){
        for($i=1;$i<=8;$i++){
            // echo "i=".$i."ID第".$i."個數字是:".substr($ID,$i,1)."</br>";
            $sum += substr($ID,$i,1) * (9-$i);
            // echo substr($ID,$i,1)."*".(9-$i)."=".substr($ID,$i,1) * (9-$i)."</br>";
        }
        $sum +=substr($ID,9,1); //加上最後一個數字
    }
    $finalNum = $sum + $alphaNum; //檢查最終數字
    if($finalNum % 10 == 0) //檢查最終數字%10是否 = 0
        echo "ID認證有效";
    else
        $err = "3"; //ID錯誤
    

    // echo $err; //錯誤代碼
    switch($err){
        case"1":
            echo "字元數錯誤";
            break;
        case"2":
            echo "性別錯誤";
            break;
        case"3":
            echo "ID認證無效";
            break;
    }
    ?>

    

    <a href="id.html">再來一次</a>

</body>
</html>