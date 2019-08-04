<?php 
$con=mysqli_connect("localhost","root","","test"); 
if (mysqli_connect_errno($con)) 
{ 
    echo "連接失敗:" . mysqli_connect_error();  //返回最近调用函数的最后一个错误代码。
} 

mysqli_set_charset($con, "utf8");
$result = mysqli_query($con,"SELECT * FROM todolist");
?>

<html>
<head>
    <link rel="stylesheet" href="todo.php">
    
    <link href="jquery-ui.css" rel="stylesheet">
    
    <script
    src="https://code.jquery.com/jquery-3.4.1.js"
    integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
    crossorigin="anonymous">
    </script>
    
    <link rel="shortcut icon" href="">

    <title>TODOLIST</title>
</head>
<body>
    <div class="container">
        <h1>ToDoList</h1>
        <div class="wrap">
            <span id="all">Clear all</span>
            <span id="done">Clear Done</span>
        </div>
        <form action = "receive.php" method="post"  class="panel" style="position: relative">
            <input type="text" id="input" name ="content" placeholder="What your doings today?">
            <input type="submit" value="+" class="btn">
        </form>
        
        
        <div id="list"> 
            <?php
            $i = 0;
            while($row=mysqli_fetch_row($result))
            {
                echo '<div class="toDos"><input type="checkbox" class="status" name = "status" value = "0" id="'.$i.'"><label for="'.$i.'">';
                echo $row[1];
                $i++;
                echo '</label><button class="delete">X</button></div>';
            }
            ?>

        </div>
    </div>

    <script src="jquery-ui.js"></script>
    <script>
        $(document).ready(function(){
            var i = 0; //i控制label的順序，明確刪除底線
            function addcontent(){ //新增事項的功能
                var inputValue = $("#input").val();
                if(inputValue.trim() == ""){ //去掉字符串首尾空格
                    $("#input").val("");
                    $("#input").focus();
                    alert("欄位不能為空");
                    $(".panel").effect("shake"); //特效放最後面才不會蓋住
                }
                else{
                    var content =
                    `<div class="toDos">
                    <button type="checkbox" class="status" id="content${i}">
                    <label for="content${i}">${inputValue}</label>
                    <button class="delete">X</button></div>`;
                    i = i+1;
                    $("#list").append(content);
                }
            }
            
            $(".btn").click(function (){  //新增事項
                addcontent();
            });

            $("#input").keydown(function(){
                if(event.keyCode ==13){
                    addcontent();
                }               
            });

            $(document).on('click','.status',function(e){ //判斷checkbox
                var status = $(this).prop("checked"); //prop回傳true false
                if(status == true){
                    $(".status").val("1"); //狀態已完成，1
                    console.log(this);
                    $(this).parent().children("label").css({"text-decoration": "line-through"});
                    $(this).parent().children(".delete").css({"background-color": "darkgray"}); //刪除按鈕一起變色
                    $(this).parent().addClass("done"); //當前的toDos加上完成特效
                }
                else{
                    $(".status").val("0"); //狀態未完成，0
                    console.log(this); 
                    $(this).parent().children("label").css({"text-decoration": "none"});
                    $(this).parent().children(".delete").css({"background-color": ""}); //刪除按鈕顏色變回來
                    $(this).parent().removeClass("done");
                }
            });
            
            $(document).on('click','.delete',function(e){ //刪除事項+特效
                $(e.currentTarget).parent().toggle("scale",function(){
                    $(e.currentTarget).parent().remove();
                });
            });

            $(document).on('click','#all',function(){ //刪除所有事項
                $("#list").empty();
            });

            $(document).on('click','#done',function(){ //刪除所有完成事項
                // $(".done").remove(); 正常版
                // $(".done").toggle("scale");
                $(".done").fadeOut();
            });
        });
    </script>
</body>
</html>