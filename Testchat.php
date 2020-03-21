<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Testchat
 *
 * @author skliz
 */
class Testchat {
    //put your code here
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <title>TestHub</title>
    <link href="http://localhost:50231/Content/site.css" rel="stylesheet"/>

    
    <script src="http://localhost:50231/Scripts/modernizr-2.5.3.js"></script>

   
     
</head>
<body>
    <div id="container">

        <header>

            <div id="logo"></div>

            <nav>
                <ul id="menu">
                    <li><a href="http://localhost:50231/">Home</a></li>

                    <li><a href="http://localhost:50231/Home/About">About</a></li>

                    <li><a href="http://localhost:50231/Home/Company">The Company</a></li>

                     <li><a href="http://localhost:50231/Account/InitialLoginPage">Admin Login</a></li>

                     <li><a href="http://localhost:50231/Blog/BlogHome">Our Blog</a></li>

                     <li><a href="http://localhost:5023/Home/AllPackages">Register</a></li>                  

                    <li><a href="http://localhost:5023/ContactUs/Contact">Contact</a></li>                  

                </ul>
            </nav>
        </header>
        
    

<style type="text/css">

    #result {
        width:300px;
        height:300px;
        border:1px solid black;
        margin-left:5px;
    }

</style>

<h2>TestHub</h2>




<div id="content">

    <div id="result"></div>

    <input type="text" name="message" id="message" value="">

    <input type="button" id="send" value="send"/>

</div>

    </div>

    <script src="http://localhost:50231/Scripts/jquery-1.7.1.js"></script>
    
    <script src="http://localhost:50231/Scripts/jquery-ui-1.8.20.min.js"></script>
    <script src="http://localhost:50231/Scripts/json2.js"></script>   
 
    <script src="http://localhost:50231/Scripts/jquery.signalR-1.0.1.min.js"></script>
    <script src="http://localhost:50231/signalr/hubs"></script>
    <script>
       
    $(document).ready(function (){
    
   // alert("This is the main thing");
 $.connection.hub.url = 'http://localhost:50231/signalr/hubs';
 
    var myhub = $.connection.Usehub;

    //we are going to create the client methods here
    clientMethods();

    $.connection.hub.start().done(function (){

        myhub.server.connectUser();


        $('#send').click(function () {

            var message = $('#message').val();

            myhub.server.sendMessage(message);

        });

    });
    

    function clientMethods(){

        
        myhub.client.onConnected = function (ConnectionID) {
            alert(ConnectionID);
        };


        myhub.client.publicMessage = function (message) {

            var value = "<li>" + message + "</li>";
            $('#result').append(value);

            $('#message').val('');
        }
    }

});
    
    </script>
 
</body>
</html>

