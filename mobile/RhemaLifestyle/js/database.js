/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
//The first script is going to be used to create a database
function createDatabase(){
                              
                                    if(window.openDatabase){
                                   //This is going to open and create the database
                                   db = window.openDatabase('mydb','1.0' ,'My First Database', 2* 1024*1024);

                                        
                                  //document.write("33333333333");
                                  db.transaction(function (tx){
                                    tx.executeSql('DROP TABLE IF EXISTS Member;');
                                    tx.executeSql('CREATE TABLE Member (username, name, phone, email, branchid, memberstate)',[], function (){  //This is the call back go now and load the table

                                    });

                                   
                                  },

                                    function (error){
                                            console.log(error.message);
                                    }
                                    );

                                        
                                    }
                                }
            




//THis script would be used to collect the branch id from the database
function collectBranchid(){
     var branchid = "";
        if(window.openDatabase){
                                   //This is going to open and create the database
                                   db = window.openDatabase('mydb','1.0' ,'My First Database', 2* 1024*1024);

                                  
                                  //document.write("33333333333");
                                  db.transaction(function (tx){
                                      tx.executeSql("SELECT branchid from Member;"),[], function (tx,result){
                                          for(var k=0; k<result.rows.length; k++){
                                              
                                              branchid = result.rows.items(0);
                                          }
                                      }; 
                                  });
               }
               
               return branchid;
}