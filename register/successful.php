<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">    <meta http-equiv="refresh" content="3;url=../cand/dashboard.php">
    <style>
    .contai{
     display:flex;
     flex-direction: row;
     justify-content: space-around;
     border-bottom:1px solid rgb(202, 202, 202);
     background-color: white;
     margin:0;
     padding: 10px;
     background-color:whitesmoke;
     }
     body{
        background-color:white;
     }
     .container{
        width:600px;
        margin:auto;
     }
     button{
        padding:10px 20px;
        border:none;
        border-radius:20px;
        background-color:#d4265f;
        color:white;
        font-size:larger;
        margin:20px 0;
        display:block;
     }
     p{
        font-size:large;
     }
     button:hover{
        opacity:0.8;
     }
     img{
        text-align:center;
     }
     .thumb{
        margin:0 80px;
     }
    </style>
</head>
<body>
   <div class="contai">
      <div class="logo">
         <img src="../images/logoW.jpg" alt="logo du site techjob" width="100px" height="auto">
      </div>  
   </div>
<div class="container mt-5">
        <div class="row">
          <h1>Please wait while we redirect you</h1>
          <p>You will be redirected shortly please standby this will only take a few seconds</p>
        </div>
      </div>
      <div class="d-flex justify-content-center">
       <div class="spinner-border" role="status">
         <span class="sr-only">Loading...</span>
       </div>
      </div>
</body>
</html>
