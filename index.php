<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,700,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="resources/fonts/icomoon/style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="resources/css/bootstrap.min.css">
    <!-- Style -->
    <link rel="stylesheet" href="resources/css/style.css">
    <title>Get Latitude & Longitude data from OSM & GOOGLE Maps </title>
  </head>
  <body>
  <div class="content">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-10">
          <div class="row align-items-center">
            <div class="col-lg-7 mb-5 mb-lg-0">
              <h3 class="mb-7">Fill the address to get. <br> latitude longitude details.</h3>
             <!-- Prints the form -->
              <form class="pr-5 mb-5 lin">
                <div class="row">
                  <div class="col-md-12 form-group">
                    <input type="text" class="form-control address" id="address" placeholder="Enter Address">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <input type="button" value="Get It" class="submit btn btn-primary rounded-0 py-2 px-4">
                    <span class="submitting"></span>
                  </div>
                </div>
              </form>
             <!-- End of Form -->
             <div id="form-message-warning mt-4" class="warning"></div> 
              <div id="form-message-success">
                Your message was sent, thank you!
              </div>
            </div>
            <div class="col-lg-4 ml-auto resDiv" style="display:none;">
              <h3 class="mb-4">OSM Data</h3>
              <div class="ml-auto osmdata">
              </div>
             
              <h3 class="mb-4">Google Data</h3>
              <div class="ml-auto gdata">
              </div>
            </div>
          </div>
        </div>  
        </div>
      </div>
  </div>
  </body>  
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
        $(document).ready(function() {
          $('.resDiv').hide();

                  $(".address").keypress(function() {
                      $('.resDiv').hide('slow'); 
                      $('.lin').removeClass('border-right');      
                  });

                $(document).on('click','.submit', function(){
                    var address  =  $('.address').val();
                    if(address==''){
                      $('.warning').html("<p>Address field can't be empty</p>")
                      $('.resDiv').hide();
                    }
                    else{
                      $('.warning').html("<p>Fecthing data...</p>")
                    $.ajax({
                                url: "controller/task.php",
                                type: 'GET',
                                data:{'address':address},
                                dataType: 'json',
                                success: function(res){
                                            var obj='';
                                            if(res.odata!=null) {  
                                                obj+="<p>Latitude :"+res.odata['lat']+"</p>";
                                                obj+="<p>Longitude :"+res.odata['lon']+"</p>";
                                            }
                                            else{
                                                  obj+="<p>No Data Found</p>";
                                            }
                                            var obj1='';
                                            if(res.gdata!=null) {  
                                                obj1+="<p>Latitude :"+res.gdata['lat']+"</p>";
                                                obj1+="<p>Longitude :"+res.gdata['lon']+"</p>";
                                            } else{
                                                  obj1+="<p>No Data Found</p>";
                                            }
                                            $(".osmdata").html(obj);  
                                            $(".gdata").html(obj1);  
                                            $('.lin').addClass('border-right');
                                            $('.resDiv').show('slow');
                                            $('.warning').empty()
                                          
                                          }
                                            // END OF SUCCESS
                    });  // END OF AJAX

                   }
                })  // END OF CLICK
        }); // END OF DOCUMENT
</script>
</html>