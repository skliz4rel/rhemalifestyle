<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of chat
 *
 * @author skliz
 */
class chat {
    //put your code here
}

?>




<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <title>Chatbox</title>
    <link href="http://localhost:54886/Content/site.css" rel="stylesheet"/>

    <script src="http://localhost:54886/Scripts/modernizr-2.5.3.js"></script>
    
    <style>

        #display {

    padding-left:10px;
    padding-right:10px;
    margin-left:10px;
    margin-right:10px;
    width:500px;
    height:300px;
    border:1px solid black;
}
       </style>
</head>
<body>
    

<h2>Chatbox</h2>

<form action="http://localhost:54886/Home/Chatbox" method="post">   <table>

       <tr><td><div id="display"></div></td></tr>

        <tr><td><label for="Chatname">Chatname</label> <input id="Chatname" name="Chatname" type="text" value="" /></td></tr>

       <tr><td><label for="Message">Message</label> <input id="Message" name="Message" type="text" value="" /></td></tr>

      
       
       <tr><td><input type="button" value="send" id="send"/><input type="reset" value="reset"></td></tr>
    
    </table>
</form>

    <script src="http://localhost:54886/Scripts/jquery-1.7.1.js"></script>

    
    <script src="http://localhost:54886/Scripts/jquery.signalR-2.0.1.min.js"></script>
     <script src="http://localhost:54886/signalr/hubs"></script>
    <script>
        
      
$(document).ready(function (){
    
    
//set the connection url.
$.connection.hub.url = 'http://localhost:54886/signalr/hubs';

var hub = $.connection.RhemaHub;


clientMethods(hub);

$.connection.hub.start().done(function () {

    serverMethods(hub);
});


function clientMethods(hub) {

    hub.client.ShowMessage = function (messageObj) {

        var name = messageObj.Chatname;
        var message = messageObj.Message;
        $('#display').append(name +" : "+message+"<br/>");
    };


}


function serverMethods(hub) {

    $('#send').click(function () {

    ///    alert('clicked here');

        var message = $('#Message').val();

        var chatname = $('#Chatname').val();

        hub.server.sendMessage(chatname, message);

        $('#Message').val('');
        $('Chatname').val('');
    });
    
}

    
});
  
        
       </script>
</body>
</html>

