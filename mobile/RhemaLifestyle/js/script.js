/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

                var continent =null;
		var country = null;
                var branchid = null; 
                var username =null;
                
                
                $(document).ready(function (){
                    
                  //  alert('here my friend');
                    
                    $('.messagelist').each(function(item,e){
                        
                       $(item).click(function (){
                           alert('sdffd');
                       });
                        
                    });
                   
                });
                
                
                //This is going to be used to hide some values from displaying on the page
                // $('.messageid').hide(); $('.scripture').hide(); $('.responsestate').hide(); $('.preacher').hide();
                
                
                createDatabase();
                
               
			
			$(document).on('pageinit','#location',function (){
                            
                            //console($.mobile.activePage);
			
				$('#continent').change(function (){
					var value = $(this).val();
                                        
                                        data = "continent="+value;
					
					//$d('select').selectmenu('refresh', true);
					$.mobile.loading('show');
					
                                        
						  $.ajax({
							url: '../../webservice/CollectCountries.php',  
                                                        data:data,
                                                        type:"GET",
							dataType: "json",
                                                        async:true,
							success: function(data){
                                                        // alert(data);
									 // $('#list').html(data.Firstname);
									// $('#country').selectmenu('refresh', true);
								//populateCountrybox(data);
								 $.mobile.loading('hide');
								ajax.parseJSONP(data);
									 
							},
							error: function (request,error) {
								alert('Network error has occurred please try again!');
							}
						  });
                       });
					
                                     //This method would be used to populate the country select box from the json container
                                 var ajax = {                                     
                        parseJSONP: function (data){
                                        var content ="<option value=''>Choose Your Country</option>";
					//$('#country').html();
					
                                        for(var k=0; k<data.length; k++){
                                            content +='<option value="'+data[k].Country +'">'+data[k].Country+"</option>";
                                            console.log(data[k].Country);
                                        }
                                        
                                        $('#country').html(content);
                                        $('#country').selectmenu('refresh', true);
                                        $('#country').selectedIndex = 1;
                                     }
                                }
								
					
					$('#locationNext').click(function (e){
						e.preventDefault();
						
						continent = $('#continent').val();
						country = $('#country').val();
						//var ismember = $('.radio-choice-h-2').val();
                                                
                                                
                                                
       var ismember = $("input:radio[name='radio-choice-h-2']:checked").attr('value');
//alert('Selected radio button value = ' + radioVal);
						
						var error = "Correct the following errors";
						var state = true;
						
						if(continent == null || continent.length == 0){
							state = false;
							error += "\nSelect a continent";
						}
						
						if(country == null || country.length == 0){
							state = false;
							error += "\nSelect a country";
						}
						
						if(state == false){
							alert(error);
						}
						else
						{
                                                   // alert(ismember);
                                                    
                                                    if(ismember != null)
							if(ismember == "A Member")
                                                            $.mobile.changePage('#choosebranch', {transition:'slide'});
                                                        else{ 
                                                            branchid = 0; //This is going to set the branchiid to zero since the user is not a member
                                                            $.mobile.changePage('#register', {transition:'slide'});
                                                        }
						}
					});
				
			});
			
                        
			
			$(document).on("pageinit","#register",function (){
			
				$('#submitregister').on('click', function (){
				
				//alert('asfdsadf');
				var name = $('#name').val();username = $('#username').val();var phone = $('#phone').val();var email = $('#email').val();
				var ismember = $('.radio-choice-h-2').val();
                                
                                                               
                                var error = "Correct the following errors: \n";
                                var test = true;
                                //we are going to performing validation on the values
                                if(name.length < 1)
                                {
                                    error+="Enter your name\n";
                                    test=false;
                                }
                                 if(username.length < 1){
                                    error+="Enter your username\n";
                                    test = false;
                                }
                                 if(phone.length < 1){
                                    error += "Enter your phone\n";
                                    test = false;
                                }
                                if(email.length < 1){
                                    error += "Enter your email\n";
                                    test = false;
                                }
						
                                 if(test == false){
                                     alert(error);
                                     
                                 }
				else{
                                    ////we are going to create the json object
					//var jsonObject = "{'Name':'"+name+"', "+ "'Username': '"+username+"', "+ "'Phone': '"+phone+"', "+" 'Email': '"+email+"', "+" 'BranchID': "+" '1', "+" 'Continent' : '"+continent+"', "+" 'Country' : "+"'"+country+"'"+ "}";
                                        
                                        
                                        
                                        var state = 0;
                                       if(ismember == "Not a member"){
                                           state = 0;
                                          // branchid = 0;
                                       }
                                       else{
                                           state = 1;
                                            //branchid = $('#branch').val();
                                       }
                                           
									
					var data = "Continent="+continent+"&Country="+country+"&BranchID="+branchid+"&Name="+name+"&Username="+username+"&Phone="+phone+"&Email="+email+"&MemberState="+state+"&submit=submit";
					
                                         console.log(data);
					//var obj =  JSON.stringify(jsonObject);
					$.mobile.loading('show');
					
                                        //
					$.ajax({
						url:"../../jqueryWebservice/RegisterMember.php",
						data:data,
						type:"POST",
						dataType:"json",
						success: function (result){
							$.mobile.loading('hide');
							//alert(result);
                                                        console.log("success");
                                                        directToHome(result);
						},
						error: function (errorMesg){
							$.mobile.loading('hide');
                                                       // console.log("failed");
							alert("There was an error connecting to the server. \n Check your internet connection !!");
                                                        
						}
					});
					
                                   }
                			
				});
                                
                                
                            //This function is going to redirect the page from this view
                                function directToHome(data){
                                    if(data.Submit=="Submit"){
                                        $.mobile.changePage("#home",{transition:"slide"});
                                        
                                        fillTable(data);
                                    }
                                    else{
                                        alert("Please register again. The username as been taken !!");
                                    }
                                }
                         
                                
                                //This method is going to be used to create database
                                function fillTable(data){
                                    
                                    var db = null;
          var fillQuery = "insert into Member ( username, name, phone, email, branchid, memberstate) values (?,?,?,?,?,?) ";

                                    
                                    if(window.openDatabase){
                                   //This is going to open and create the database
                                   db = window.openDatabase('mydb','1.0' ,'My First Database', 2* 1024*1024);

                                        
                                  //document.write("33333333333");
                                  db.transaction(function (tx){
                                   

                                    tx.executeSql(fillQuery,["'"+data.Username+"'", "'"+data.Name+"'", "'"+data.Phone+"'", "'"+data.Email+"'", "'"+data.BranchID+"'", "'"+data.MemberState+"'" ], function (){  //alert('done'); 
                                        
                                    });
                                  },

                                    function (error){
                                            console.log(error.message);
                                    }
                                    );

                                        
                                    }
                                }
				
			});
                        
		
                
                  
                        $(document).on("pageshow","#choosebranch",function(){
                        
                            //alert('asdfsdf');
                            function loadBranches(){
                                                                                          
                             //    $('select #branches').selectmenu('refresh', true);
                             var data = "country="+country;
                                $.ajax({
                                    url:"../../webservice/Collectbranches.php",                                 
                                    data:data,
                                    type:"GET",
                                    dataType:"json",
                                    success:function (response){
                                        fillBranches(response);                                       
                                    },
                                    error:function (err){
                                        
                                    }
                                });
                                
                            }
                            
                            loadBranches();
                            //THis method is going to fill the select box with json content
                            function fillBranches(data){
                                var content = null;
                                 content = "<option value=''>Select Branch</option>";
                                for(var k=0; k<data.length; k++){
                                    
                                  
                                    content += "<option value='"+data[k].ID+"'>"+data[k].Branch+"</option>";                                      
                                  //  console.log(data[k].Branch);
                                }
                                
                               // content += "<option value='3'>Other Branch</option>";
                            
                                console.log(content);
                                $('#branch').html(content);
                                $('#branch').selectmenu('refresh', true);
                            }
                            
                            
                            $('#showregister').click(function (){
                                
                                 branchid = $('#branch').val();
                                
                                if(branchid.length >0)
                                   $.mobile.changePage('#register', {transition:'slide'});
                               else
                                   alert("Select your branch");
                                
                            });
                        
                        });
                        
                        
                         $(document).on("pageinit","#feedback",function (){
                    
                            $('.success').hide();
                         });
		
                
                $(document).on("pageshow","#feedback",function (){
                                        
                    $('#title #comment').click(function (){
                        
                        $('.success').hide();
                    });
                    
                                        
                     $("#sendfeedback").bind("click",function (){
                         
                         var title = $('#title').val();
                         var comment = $('#comment').val();
                         
                         var error = "Correct the following errors\n";
                         var test = true;
                         
                         if(title.length < 1){
                             error += "Enter the title\n";
                             test = false;
                         }
                         if(comment.length < 2){
                             error += "Enter the comment";
                             test = false;
                         }
                         
                         if(test == false){
                             
                             alert(error);
                         }
                         else {
                           var data = "Username="+username+"&BranchID="+branchid+"&Title="+title+"&Message="+comment+"&submit=submit";

                            $.ajax({
                                url:"../../jqueryWebservice/RegisterFeedback.php",
                                data:data,
                                type:"POST",
                                dataType:"json",
                                success: function (response){
                                   checkFeedbackresponse(response);
                                },
                                error: function (err){

                                }
                            });
                         }
                     });
                    
                    
                    //This method is giong to check if the feedback was a success
                    function checkFeedbackresponse(data){
                        
                        if(data.Response  == "Submitted"){
                            $('.success').show();
                            $('#title').val('');
                            $('#comment').val('');
                        }
                        else
                            {
                                alert("Feedback was not sent. Please try again !!");
                            }
                    }
                    
                });
                
                
               $(document).on("pageinit","#pastormessage",function (){
                  
                 // $('#mdate').date('date');
                 
           
                   $('#getmessage').bind('click',function (){
                       
                       var url = "";
                       
                       var date = $('#mdate').val();
                       
                       var values = date.split("-");
                       
                      var dateformat = values[0]+"-"+values[1]+"-"+values[2];
                       // var branchid = collectBranchid();
                      
                      var data  = "messagedate="+dateformat+"&branchid="+branchid;
                                         
                      var url = "../../webservice/CollectSermons.php";
                      
                      console.log(branchid);
                      
                    //  alert(branchid);
                      
                      $.mobile.loading('show');
                      $.ajax({
                          url:url,
                          data:data,
                          type:"GET",
                          async:true,
                          dataType:"json",
                          success:function (response){
                              
                              ajaxMessage.parseJSONP(response);
                              
                              $.mobile.loading('hide');
                          },
                          error:function (err){
                                                            
                          }                          
                      });
                
                      
                  //This method would be used to populate the country select box from the json container
                     var ajaxMessage = {
                        parseJSONP: function (data){
                            
                                
                                        var content ="";
					//$('#country').html(); 
					 content += "";
                                         
                                        for(var k=0; k<data.length; k++){
                                       
                                           if(data[k].Message != "Failed"){
                                            content+="  <li><a href='#' class='messagelist' data.title='"+data[k].Title+"' data.messsageid = '"+data[k].MessageID+"'  data.scripture= '"+data[k].Scriptures+"'  data.message='"+data[k].Message+"' data.preacher='"+data[k].Preacher+"' data.responsestate='"+data[k].ResponseState+"' >"+data[k].Title+" ("+data[k].Preacher+") ";

                                            content += "</a></li>";
                                          }
                                        }
                                        
                                           content += "";
                                        $('#pmessages').html(content);                                       
                                     }
                                }
		                         
                   });
                   
                   
                  
                   
               });


//This is going to collect the letchat information and display to the user
 $(document).on("pageinit","#letchat",function (){
    
        $('#getmessage1').bind('click',function (){
            
                       var url = "";
                       
                       var date = $('#mdate1').val();
                       
                       var values = date.split("-");
                       
                      var dateformat = values[0]+"-"+values[1]+"-"+values[2];
                       // var branchid = collectBranchid();
                      
                      var data  = "messagedate="+dateformat+"&branchid="+branchid;
                                         
                      var url = "../../webservice/CollectLetchatinfo.php";
                      
                      console.log(branchid);
                      
                    //  alert(branchid);
                      
                      $.mobile.loading('show');
                      $.ajax({
                          url:url,
                          data:data,
                          type:"GET",
                          async:true,
                          dataType:"json",
                          success:function (response){
                              
                              letchatResponse.parseJSONP(response);
                              
                              $.mobile.loading('hide');
                          },
                          error:function (err){
                                                            
                          }
                      });
                      
                      
                      letchatResponse = {
                        parseJSONP: function (data){
                            
                            var content = "";
                            
                            content += "";
                            
                            for(var k=0; k<data.length; k++){
                                
                                
                                
                            }                            
                            
                            $("letchatmsg").html(content);
                        }
                     }
            
            
        });
    });