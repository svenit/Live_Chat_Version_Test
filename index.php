<?php
  include("connect.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
    <p id="count-user-online"></p>
    <p id="show"></p>
    <div id="box-chat">
      <input type="text" name="message" id="message">
      <button type="submit" name="submit" id="send" onclick="send()">Send</button>
    </div>
    <script>
         function display(){
          var action = 'display';
          $.ajax({
              url: "controller.php",
              method: "POST",
              data:{action:action},
              success:function(data){
                 $('#show').html(data);
              }
          });
       }
       setInterval(function(){
           display();
       },30);
       function send(){
         var message = $('#message').val();
         var action = "send";
         $.ajax({
             url:"controller.php",
             method:"POST",
             data:{action:action,message:message},
             success:function(data){
                 $('#message').val('');
             }
         });
       }
       function online(){
           var action = "userOnline";
           $.ajax({
               url:"controller.php",
               method:"POST",
               data:{action:action},
               success:function(data){
                   $('#count-user-online').html(data);
               }
           });
       }
       setInterval(function(){
           online();
       },30);
    </script>
</body>
</html>
