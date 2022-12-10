<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
    <style>
        .inner{
            margin-top: 0;
            padding: 10px;
            background-color: #F96666;
            width: 255px;
            height: 115px;
            border-radius: 10px 10px 0 0;
            margin-bottom: 75px;
        }
        .course-name{
            margin-top: 0;
            color:white;
        }
        .number{
            color:white;
        }
        .one{
            margin:25px;
            width: 275px;
            height: 250px;
            border:1px solid #B7C4CF;
            border-radius: 10px;
        }
        .flex{
            display: flex;
        
            flex-wrap: wrap;
            align-items: flex-start;
            align-content: space-between;
        }
    </style>
</head>
<body onload="color()">
<h1 id="hi">HII</h1>
    <div class='flex'>
    <div class='one'>
        <div class='inner'>
        <h2 class='course-name'>CS 213: Software Systems Lab</h2>
        <h3 class='number'>69 students</h3>
        </div>
        <a href='#' title='Upload assignments' style='cursor:pointer'><img src='./images/564793.png' width='35px' height='35px'></a>
        <a href='#' title='Create test' style='cursor:pointer'><img src='./images/test.png' width='35px' height='35px'></a>
    </div>
    <script>
        colors = ["#C6EBC5","#F96666","#87A2FB","#8758FF","#5F6F94","#F7A76C","#73A9AD","#7858A6","#8CC0DE","#B4FF9F"];
        var elements = document.getElementsByClassName('inner'); 
        for(var i = 0; i < elements.length; i++){
		    elements[i].style.backgroundColor = colors[i];
	    }
    </script>
</body>
</html>