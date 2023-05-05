<!--If having trouble with styling due to improper tags or something like that, lmk-->

<!DOCTYPE html>
<html>
  <head>
    <title>My Map</title>
    <link rel="stylesheet" type="text/css" href="../css/ridenow.css">
  </head>
  <body>
    <header>
      <div class="logo">Libér</div>
      <nav>
                <ul class="navlinks">
                    <li><a href="#">About us</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Services</a></li>
                </ul>
       </nav>
    </header>

    <?php 
    include '../config/database.php'; 
    $dropoff = $pickup = '';
    session_start();
    echo "Welcome " . $_SESSION ['name'] . ", <br>";
    $ridername = $_SESSION ['name'];
    $rideremail = $_SESSION ['useremail'];
    $riderphone = '9820083218';
    //echo "GAYYYYYY : $_POST";
    if(isset($_POST['submit']))
    {
      if(empty($_POST['pickup']))
      {
        echo "Please enter pickup location";
      }
      else
      {
        $pickup = filter_input(INPUT_POST, 'pickup', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        echo "$pickup<br>";
      }

      if(empty($_POST['dropoff']))
      {
        echo "Please enter dropoff location";
      }
      else
      {
        $dropoff = filter_input(INPUT_POST, 'dropoff', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        echo "$dropoff<br>";
      }
      // $query = " SELECT email from driver ;";
      // $queryResult = @mysqli_query($conn,$query);
      // $driveremails = mysqli_fetch_all($queryResult, MYSQLI_NUM);
      

      require '../PHPMailer-master/src/PHPMailer.php';
      $mail = new PHPMailer\PHPMailer\PHPMailer();
      $mail->isSMTP();
      $mail->SMTPSecure = 'ssl';
      $mail->SMTPAuth = true;
      $mail->Host = 'smtp.gmail.com';
      $mail->Port = 465;
      $mail->Username = 'ahaan.kotianstudent@gmail.com';
      $mail->Password = '2003MARGAR@23';
      $mail->setFrom('ahaan.kotianstudent@gmail.com');
      $mail->addAddress('ahaan.kotian@somaiya.edu');
      $mail->Subject = 'Libér: Cab booking email';
      $s1 = "Please contact rider if interested. Rider details: \n" . PHP_EOL;
      $s2 = "Name: $ridername" . PHP_EOL;
      $s3 = "Email: $rideremail" . PHP_EOL;
      $s4 = "Phone: $riderphone" . PHP_EOL;
      $s5 = "Pickup location : $pickup" . PHP_EOL;
      $s6 = " DropOff location : $dropoff";
      $s1.= $s2.=$s3.=$s4.=$s5.=$s6;
      $txt = $s1;
      $mail->Body = "$txt";
      echo "$mail->Body";
      $b = $mail->send();
      //send the message, check for errors
      if (!$mail->send()) 
      {
          echo "ERROR: " . $mail->ErrorInfo;
      } 
      else 
      {
          echo "SUCCESS";
      }



      // $to = "ahaan.kotianstudent@gmail.com";
      // $subject = "Libér: Cab booking email";
      // $s1 = "Please contact rider if interested. Rider details: \n" . PHP_EOL;
      // $s2 = "Name: $ridername" . PHP_EOL;
      // $s3 = "Email: $rideremail" . PHP_EOL;
      // $s4 = "Phone: $riderphone" . PHP_EOL;
      // $s5 = "Pickup location : $pickup" . PHP_EOL;
      // $s6 = " DropOff location : $dropoff";
      // $s1.= $s2.=$s3.=$s4.=$s5.=$s6;
      // $txt = $s1;
      // echo "$txt";

      // $headers = "From: ahaan.kotian@icloud.com" ;

      // if(mail($to,$subject,$txt,$headers))
      // {
      //   echo "Email has been successfully";
      // }
      // else
      // {
      //   echo "Email sending failed";
      // }

  }
  ?>

    <div class="container">
      <div class = sections>
        <div class="leftsec">
           <form action="ridenow.php" class="address-form" method="POST" >
             <a class="title">Get a Ride!</a>
             
             <input class="input" name="pickup" id="pu-text" placeholder="Pickup Location"><br><br>

             <input class="input" name="dropoff" id="d-text" placeholder="Dropoff Location"><br><br>

             <input type="submit" name="submit" class="search-btn" value="SEARCH"/>
             
              <!--<input type="submit" name="submit" class="submit-btn" value="Submit">-->
                <!--<div class="icon">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path fill="none" d="M0 0h24v24H0z"></path>
                    <path fill="currentColor" d="M16.172 11l-5.364-5.364 1.414-1.414L20 12l-7.778 7.778-1.414-1.414L16.172 13H4v-2z"></path>
                  </svg>
                </div>
              </button>-->
            
             
          </form>
        </div>
          
        <div class="rightsec">
           <div class="map"></div>
           <div class="dispResult"></div> <!-- displays distance and time of trip. -->
           <script src="../js/ridenow.js"></script>
           <!-- Google maps and marker -->
           <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDOixmPLBhxBQt_X-ZvU2NIbYnNyBAcv4o&libraries=places&callback=initMap&solution_channel=GMP_QB_addressselection_v1_cAB" async defer></script>
        </div>
          
      </div> 
    </div>
  </body>
</html>
