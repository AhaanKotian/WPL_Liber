<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Libér.com</title>
        <link rel="stylesheet" href="../css/driverui.css">
        <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet"/>
        <link rel="stylesheet" href="../css/swiper-bundle.min.css" />
        
    </head>
    <body>
        <header>
            <div class="logo">Libér</div>
            <nav>
                <ul class="navlinks">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Our Policy</a></li>
                    <li><a href="#">About Us</a></li>
                </ul>
            </nav>
            
            <a href="#"><button class="loginbtn" >
              Sign In</button></a>


            <!--replace sign in with sign out-->
            <!-- <% if (typeof user != 'undefined') { %> 
              <form action="/riders/logout"><button type="submit" id="logoutbtn">Sign Out</button></form>
            <%} %> -->


            <!--Sign in PHP starts-->
            <?php
              include '../config/database.php'; 
              $name = $pwd = $email = '';
              //get password and e-mail passed from client
              if (isset($_POST['submit_sigin'])) 
              {
                $email = strtolower($_POST['input_email_SI']);	
                $pwd = filter_input(INPUT_POST, 'input_pass_SI', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                //check whether the user input the password and email
                if (empty($pwd) or empty($email)) {
                echo "Please fill in your email and password.<br>";
                  } 
                //validate email
                elseif (filter_var($email, FILTER_VALIDATE_EMAIL) == true && $pwd) 
                {
                  //echo "GAYYY11<br>";
                  //access date to database and search by email
                  $SQLstring = "SELECT * from driver where email = '$email'";
                  $queryResult = @mysqli_query($conn, $SQLstring);
                  // Or die ("<p>Unable to query the table.</p>"."<p>Error code ".
                  // mysqli_errno($DBConnect). ": ".mysqli_error($DBConnect)). "</p>";
                  $row= mysqli_fetch_row($queryResult);
                  $name = $row[1];
                  if ($email !== $row[2]) 
                  { // check email whether the member is exist
                    echo "The member does not exist. Please register.<br>";
                  }
                  elseif ($pwd == $row[3]) 
                  { 
                    session_start();

                    echo "<h1>The log-in is success.<h1>"; 
                    sleep(3);
                    
                    $_SESSION ['useremail'] =  $email;
                    $_SESSION ['name'] = $name;
                    //session_write_close();	
                    //print_r($_SESSION);
                    $URL="drivenow.php";  
                    header ("Location: $URL"); 
                  //       exit; 
                      // }
                  //NEED APPROPRIATE HOMEPAGE DISPLAY.
                  } 
                  else 
                  {
                    echo "The password is incorrect. Please try again.<br>";
                  }
                } 
                else { echo "Please input a valid email and try again.<br>";}
                //mysqli_close($DBConnect);	
              }

            
            ?>

            <!--Modal Starts-->
            <dialog class="modal" id="modal">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="form_container" method="POST">
                    <div class="logo_container closex">&#10006;</div>
                    <div class="title_container">

                      <!--if signup is successful do thing-->
                      <p class="title" >Login to your Account</p>

                      
                      <span class="subtitle">Get started with our app, just create an account and enjoy the experience.</span>
                    </div>
                    <br>


                    <!--error message-->
                    <!-- <ul <% if (typeof SI_err != 'undefined' ) {%> class = "error" id ="SIerror" <%} %>>
                      <% if ( typeof SI_err != 'undefined') { %> <% SI_err.forEach(error => { %> 
                      <li><%= error %></li>
                      <% }) %> <% } %>
                    </ul> -->


                    <div class="input_container">
                      <label class="input_label" for="email_field">Email</label>
                      <svg fill="none" viewBox="0 0 24 24" height="24" width="24" xmlns="http://www.w3.org/2000/svg" class="iconEmail">
                        <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5" stroke="#141B34" d="M7 8.5L9.94202 10.2394C11.6572 11.2535 12.3428 11.2535 14.058 10.2394L17 8.5"></path>
                        <path stroke-linejoin="round" stroke-width="1.5" stroke="#141B34" d="M2.01577 13.4756C2.08114 16.5412 2.11383 18.0739 3.24496 19.2094C4.37608 20.3448 5.95033 20.3843 9.09883 20.4634C11.0393 20.5122 12.9607 20.5122 14.9012 20.4634C18.0497 20.3843 19.6239 20.3448 20.7551 19.2094C21.8862 18.0739 21.9189 16.5412 21.9842 13.4756C22.0053 12.4899 22.0053 11.5101 21.9842 10.5244C21.9189 7.45886 21.8862 5.92609 20.7551 4.79066C19.6239 3.65523 18.0497 3.61568 14.9012 3.53657C12.9607 3.48781 11.0393 3.48781 9.09882 3.53656C5.95033 3.61566 4.37608 3.65521 3.24495 4.79065C2.11382 5.92608 2.08114 7.45885 2.01576 10.5244C1.99474 11.5101 1.99475 12.4899 2.01577 13.4756Z"></path>
                      </svg>
                      <input placeholder="name@mail.com" title="Inpit title" name="input_email_SI" type="text" class="input_field" id="email_field_sign_in">
                      <div class="errorDispEmail"></div>
                    </div>
                    <div class="input_container">
                      <label class="input_label" for="password_field">Password</label>
                      <svg fill="none" viewBox="0 0 24 24" height="24" width="24" xmlns="http://www.w3.org/2000/svg" class="iconPass">
                        <path stroke-linecap="round" stroke-width="1.5" stroke="#141B34" d="M18 11.0041C17.4166 9.91704 16.273 9.15775 14.9519 9.0993C13.477 9.03404 11.9788 9 10.329 9C8.67911 9 7.18091 9.03404 5.70604 9.0993C3.95328 9.17685 2.51295 10.4881 2.27882 12.1618C2.12602 13.2541 2 14.3734 2 15.5134C2 16.6534 2.12602 17.7727 2.27882
                         18.865C2.51295 20.5387 3.95328 21.8499 5.70604 21.9275C6.42013 21.9591 7.26041 21.9834 8 22"></path>
                        <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5" stroke="#141B34" d="M6 9V6.5C6 4.01472 8.01472 2 10.5 2C12.9853 2 15 4.01472 15 6.5V9"></path>
                        <path fill="#141B34" d="M21.2046 15.1045L20.6242 15.6956V15.6956L21.2046 15.1045ZM21.4196 16.4767C21.7461 16.7972 22.2706 16.7924 22.5911 16.466C22.9116 16.1395 22.9068 15.615 22.5804 15.2945L21.4196 16.4767ZM18.0228 15.1045L17.4424 14.5134V14.5134L18.0228 15.1045ZM18.2379 18.0387C18.5643 18.3593 19.0888 18.3545 19.4094 18.028C19.7299 17.7016 19.7251 17.1771 19.3987 16.8565L18.2379 18.0387ZM14.2603
                         20.7619C13.7039 21.3082 12.7957 21.3082 12.2394 20.7619L11.0786
                        21.9441C12.2794 23.1232 14.2202 23.1232 15.4211 21.9441L14.2603 
                        20.7619ZM12.2394 20.7619C11.6914 20.2239 11.6914 19.358 12.2394 
                        18.82L11.0786 17.6378C9.86927 18.8252 9.86927 20.7567 11.0786 
                        21.9441L12.2394 20.7619ZM12.2394 18.82C12.7957 18.2737 13.7039 18.2737 14.2603 
                        18.82L15.4211 17.6378C14.2202 16.4587 12.2794 16.4587 11.0786 17.6378L12.2394 
                        18.82ZM14.2603 18.82C14.8082 19.358 14.8082 20.2239 14.2603 20.7619L15.4211 
                        21.9441C16.6304 20.7567 16.6304 18.8252 15.4211 17.6378L14.2603 
                        18.82ZM20.6242 15.6956L21.4196 16.4767L22.5804 15.2945L21.785 
                        14.5134L20.6242 15.6956ZM15.4211 18.82L17.8078 16.4767L16.647 
                        15.2944L14.2603 17.6377L15.4211 18.82ZM17.8078 16.4767L18.6032 
                        15.6956L17.4424 14.5134L16.647 15.2945L17.8078 16.4767ZM16.647 
                        16.4767L18.2379 18.0387L19.3987 16.8565L17.8078 15.2945L16.647 
                        16.4767ZM21.785 14.5134C21.4266 14.1616 21.0998 13.8383 20.7993 
                        13.6131C20.4791 13.3732 20.096 13.1716 19.6137 13.1716V14.8284C19.6145 
                        14.8284 19.619 14.8273 19.6395 14.8357C19.6663 14.8466 19.7183 14.8735 
                        19.806 14.9391C19.9969 15.0822 20.2326 15.3112 20.6242 15.6956L21.785 
                        14.5134ZM18.6032 15.6956C18.9948 15.3112 19.2305 
                        15.0822 19.4215 14.9391C19.5091 14.8735 19.5611 14.8466 19.5879 
                        14.8357C19.6084 14.8273 19.6129 14.8284 19.6137 14.8284V13.1716C19.1314 
                        13.1716 18.7483 13.3732 18.4281 13.6131C18.1276 13.8383 17.8008 14.1616 
                        17.4424 14.5134L18.6032 15.6956Z"></path>
                      </svg>
                      <input placeholder="Password" title="Inpit title" name="input_pass_SI" type="password" class="input_field" id="password_field_sign_in">
                      <div class="errorDispPass"></div>
                      <input type="submit" class="sign-in_btn" name="submit_sigin" value="Sign In">
                      </button>
                    </div>
                    
                  
                    <div class="separator">
                      <hr class="line">
                      <span>Or</span>
                      <hr class="line">
                    </div>
                    <button title="Sign In" type="submit" class="sign-in_ggl">
                      <svg height="18" width="18" viewBox="0 0 32 32" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                          <path d="M44.5 20H24v8.5h11.8C34.7 33.9 30.1 37 24 37c-7.2 0-13-5.8-13-13s5.8-13 13-13c3.1 0 5.9 1.1 8.1 2.9l6.4-6.4C34.6 4.1 29.6 2 24 2 11.8 2 2 11.8 2 24s9.8 22 22 22c11 0 21-8 21-22 0-1.3-.2-2.7-.5-4z" id="A"></path>
                        </defs>
                        <clipPath id="B">
                          
                        </clipPath>
                        <g transform="matrix(.727273 0 0 .727273 -.954545 -1.45455)">
                          <path fill="#fbbc05" clip-path="url(#B)" d="M0 37V11l17 13z"></path>
                          <path fill="#ea4335" clip-path="url(#B)" d="M0 11l17 13 7-6.1L48 14V0H0z"></path>
                          <path fill="#34a853" clip-path="url(#B)" d="M0 37l30-23 7.9 1L48 0v48H0z"></path>
                          <path fill="#4285f4" clip-path="url(#B)" d="M48 48L17 24l-4-3 35-10z"></path>
                        </g>
                      </svg>
                      <span>Sign In with Google</span>
                    </button>
                    <p class="note">Don't have an account? <a href="#" class="signupbtn">Sign Up</a></p>
                  </form>
            </dialog>
            <!--Modal Ends-->


            <!--Sign up PHP starts-->
            <?php
              include '../config/database.php';
              $name = $pwd = $Cpwd = $email = $vno = $vmodel = '';
              $name_err = $pwd_err = $Cpwd_err = $email_err = '';
              $count = 0;
              if (isset($_POST['submit_signup'])) 
              {
                //echo " GAYYY222";
                //validate the name
                if (empty($_POST['input_name'])) {
                $name_err = 'Name is required';
                  } else {
                $name = filter_input(INPUT_POST, 'input_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                ++$count;
                }

                //validate the password
                if (empty($_POST['input_pass'])) {
                $pwd_err = 'Password is required';
                    } else {
                $pwd = filter_input(INPUT_POST, 'input_pass', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                ++$count;
                }

                //validate the confirm_password
                if (empty($_POST['input_pass2'])) {
                $Cpwd_err = 'Name is required';
                    } else {
                $Cpwd = filter_input(INPUT_POST, 'input_pass2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                ++$count;
                }
              
                //validate password & confirm password for equality
                if ($pwd !== $Cpwd) {
                echo "The passwords do not match. Please enter again.<br>";
                } else {
                  $pwd = $Cpwd;
                  ++$count;
                }

                $vno = $_POST['vno'];
                $vmodel = $_POST['vmodel'];
                $phone = $_POST['phone'];

                $email = $_POST['input_email'];
              
                //validate email for no duplicates 
                if (empty($email)) {
                echo "Please fill in a valid e-mail address.<br>";
                } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) == true)   {
                  //access data in database
                  $SQLstring = "SELECT email from driver where email = '$email';";
                  $queryResult = mysqli_query($conn, $SQLstring)
                  Or die ("<p>1.Unable to query the table.</p>"."<p>Error code ".mysqli_errno($conn). ": ".mysqli_error($conn)). "</p>";		
                  if (mysqli_num_rows($queryResult) !== 0)
                      { --$count;
                      echo "This email is already registered. Please use another email address.<br>";
                      } else {
                      $email=strtolower($_POST['input_email']);
                      ++$count;
                      }
                } else { 
                echo "Please fill in a valid e-mail address.<br>";
                }


                //write to database of customer table
                if ($count == 5) 
                {
                  $query = "INSERT INTO driver ( name, email, password, phone, vno, vmodel) VALUES  ('$name','$email','$pwd', '$phone', '$vno', '$vmodel');";
                  //$result= mysqli_query($conn,$query);
                  if(mysqli_query($conn,$query))
                  {
                    echo " Sign up done<br>";
                  }
                  else
                  {
                    echo "Error : " . mysqli_error($conn);
                  }
                  //die ("<p>2.Unable to query the table.</p>"."<p>Error code ".mysqli_errno($conn). ": ".mysqli_error($conn). "</p>");
                  
                }
                if (mysqli_affected_rows($conn) == 1)
                {
                  //remover sign in button from homepage
                  
                  echo "<h1>Thank you. The registration is now complete.<h1>"; 
                }
                //mysqli_close($DBConnect);
              }

            ?>
            <!--Sign up PHP ends-->

            
            <!--Sign Up Modal-->
            <!--Modal Starts-->
            <dialog class="modal1" id="modal1">
              <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="form_container" method="POST">
                  <div class="logo_container signupclosex">&#10006;</div>
                  <div class="title_container">
                    <p class="title">Create Account</p>
                  </div>
                  <br>
                  
                  <!--error message-->
                  <!-- <ul <% if (typeof errors != 'undefined') { %> class = "error" id ="SUerror" <%} %>>
                    <% if (typeof errors != 'undefined') { %> <% errors.forEach(error => { %> 
                    <li><%= error.message %></li>
                    <% }) %> <% } %>
                  </ul> -->


                  <div class="input_container">
                    <label class="input_label" for="name_field">Name</label>
                    <svg fill="none" viewBox="0 0 24 24" height="24" width="24" xmlns="http://www.w3.org/2000/svg" class="iconEmail">
                      <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5" stroke="#141B34" d="M7 8.5L9.94202 10.2394C11.6572 11.2535 12.3428 11.2535 14.058 10.2394L17 8.5"></path>
                      <path stroke-linejoin="round" stroke-width="1.5" stroke="#141B34" d="M2.01577 13.4756C2.08114 16.5412 2.11383 18.0739 3.24496 19.2094C4.37608 20.3448 5.95033 20.3843 9.09883 20.4634C11.0393 20.5122 12.9607 20.5122 14.9012 20.4634C18.0497 20.3843 19.6239 20.3448 20.7551 19.2094C21.8862 18.0739 21.9189 16.5412 21.9842 13.4756C22.0053 12.4899 22.0053 11.5101 21.9842 10.5244C21.9189 7.45886 21.8862 5.92609 20.7551 4.79066C19.6239 3.65523 18.0497 3.61568 14.9012 3.53657C12.9607 3.48781 11.0393 3.48781 9.09882 3.53656C5.95033 3.61566 4.37608 3.65521 3.24495 4.79065C2.11382 5.92608 2.08114 7.45885 2.01576 10.5244C1.99474 11.5101 1.99475 12.4899 2.01577 13.4756Z"></path>
                    </svg>
                    <input placeholder="Full Name" title="Inpit title" name="input_name" type="text" class="input_field" id="name_field">
                  </div>
                  <div class="input_container">
                    <label class="input_label" for="email_field">Email</label>
                    <svg fill="none" viewBox="0 0 24 24" height="24" width="24" xmlns="http://www.w3.org/2000/svg" class="iconEmail">
                      <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5" stroke="#141B34" d="M7 8.5L9.94202 10.2394C11.6572 11.2535 12.3428 11.2535 14.058 10.2394L17 8.5"></path>
                      <path stroke-linejoin="round" stroke-width="1.5" stroke="#141B34" d="M2.01577 13.4756C2.08114 16.5412 2.11383 18.0739 3.24496 19.2094C4.37608 20.3448 5.95033 20.3843 9.09883 20.4634C11.0393 20.5122 12.9607 20.5122 14.9012 20.4634C18.0497 20.3843 19.6239 20.3448 20.7551 19.2094C21.8862 18.0739 21.9189 16.5412 21.9842 13.4756C22.0053 12.4899 22.0053 11.5101 21.9842 10.5244C21.9189 7.45886 21.8862 5.92609 20.7551 4.79066C19.6239 3.65523 18.0497 3.61568 14.9012 3.53657C12.9607 3.48781 11.0393 3.48781 9.09882 3.53656C5.95033 3.61566 4.37608 3.65521 3.24495 4.79065C2.11382 5.92608 2.08114 7.45885 2.01576 10.5244C1.99474 11.5101 1.99475 12.4899 2.01577 13.4756Z"></path>
                    </svg>
                    <input placeholder="name@mail.com" title="Inpit title" name="input_email" type="text" class="input_field" id="email_field">
                    <div class="errorDispEmail"></div>
                  </div>

                  <div class="input_container">
                    <label class="input_label" for="vehicleno_field">Vehicle Number</label>
                    <svg fill="none" viewBox="0 0 24 24" height="24" width="24" xmlns="http://www.w3.org/2000/svg" class="iconEmail">
                      <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5" stroke="#141B34" d="M7 8.5L9.94202 10.2394C11.6572 11.2535 12.3428 11.2535 14.058 10.2394L17 8.5"></path>
                      <path stroke-linejoin="round" stroke-width="1.5" stroke="#141B34" d="M2.01577 13.4756C2.08114 16.5412 2.11383 18.0739 3.24496 19.2094C4.37608 20.3448 5.95033 20.3843 9.09883 20.4634C11.0393 20.5122 12.9607 20.5122 14.9012 20.4634C18.0497 20.3843 19.6239 20.3448 20.7551 19.2094C21.8862 18.0739 21.9189 16.5412 21.9842 13.4756C22.0053 12.4899 22.0053 11.5101 21.9842 10.5244C21.9189 7.45886 21.8862 5.92609 20.7551 4.79066C19.6239 3.65523 18.0497 3.61568 14.9012 3.53657C12.9607 3.48781 11.0393 3.48781 9.09882 3.53656C5.95033 3.61566 4.37608 3.65521 3.24495 4.79065C2.11382 5.92608 2.08114 7.45885 2.01576 10.5244C1.99474 11.5101 1.99475 12.4899 2.01577 13.4756Z"></path>
                    </svg>
                    <input placeholder="MHXX0000" title="Inpit title" name="vno" type="text" class="input_field" id="vehicleno_field">
                    <div class="errorDispVno"></div>
                  </div>

                  <div class="input_container">
                    <label class="input_label" for="vehiclemodel_field">Vehicle Model</label>
                    <svg fill="none" viewBox="0 0 24 24" height="24" width="24" xmlns="http://www.w3.org/2000/svg" class="iconEmail">
                      <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5" stroke="#141B34" d="M7 8.5L9.94202 10.2394C11.6572 11.2535 12.3428 11.2535 14.058 10.2394L17 8.5"></path>
                      <path stroke-linejoin="round" stroke-width="1.5" stroke="#141B34" d="M2.01577 13.4756C2.08114 16.5412 2.11383 18.0739 3.24496 19.2094C4.37608 20.3448 5.95033 20.3843 9.09883 20.4634C11.0393 20.5122 12.9607 20.5122 14.9012 20.4634C18.0497 20.3843 19.6239 20.3448 20.7551 19.2094C21.8862 18.0739 21.9189 16.5412 21.9842 13.4756C22.0053 12.4899 22.0053 11.5101 21.9842 10.5244C21.9189 7.45886 21.8862 5.92609 20.7551 4.79066C19.6239 3.65523 18.0497 3.61568 14.9012 3.53657C12.9607 3.48781 11.0393 3.48781 9.09882 3.53656C5.95033 3.61566 4.37608 3.65521 3.24495 4.79065C2.11382 5.92608 2.08114 7.45885 2.01576 10.5244C1.99474 11.5101 1.99475 12.4899 2.01577 13.4756Z"></path>
                    </svg>
                    <input placeholder="Car Model" title="Inpit title" name="vmodel" type="text" class="input_field" id="vehiclemodel_field">
                    <div class="errorDispVmo"></div>
                  </div>

                  <div class="input_container">
                    <label class="input_label" for="phoneno_field">Phone Number</label>
                    <svg fill="none" viewBox="0 0 24 24" height="24" width="24" xmlns="http://www.w3.org/2000/svg" class="iconEmail">
                      <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5" stroke="#141B34" d="M7 8.5L9.94202 10.2394C11.6572 11.2535 12.3428 11.2535 14.058 10.2394L17 8.5"></path>
                      <path stroke-linejoin="round" stroke-width="1.5" stroke="#141B34" d="M2.01577 13.4756C2.08114 16.5412 2.11383 18.0739 3.24496 19.2094C4.37608 20.3448 5.95033 20.3843 9.09883 20.4634C11.0393 20.5122 12.9607 20.5122 14.9012 20.4634C18.0497 20.3843 19.6239 20.3448 20.7551 19.2094C21.8862 18.0739 21.9189 16.5412 21.9842 13.4756C22.0053 12.4899 22.0053 11.5101 21.9842 10.5244C21.9189 7.45886 21.8862 5.92609 20.7551 4.79066C19.6239 3.65523 18.0497 3.61568 14.9012 3.53657C12.9607 3.48781 11.0393 3.48781 9.09882 3.53656C5.95033 3.61566 4.37608 3.65521 3.24495 4.79065C2.11382 5.92608 2.08114 7.45885 2.01576 10.5244C1.99474 11.5101 1.99475 12.4899 2.01577 13.4756Z"></path>
                    </svg>
                    <input placeholder="+91XXXXXXXXXX" title="Inpit title" name="phone" type="text" class="input_field" id="phoneno_field">
                    <div class="errorDispPno"></div>
                  </div>

                  <div class="input_container">
                    <label class="input_label" for="password_field">Password</label>
                    <svg fill="none" viewBox="0 0 24 24" height="24" width="24" xmlns="http://www.w3.org/2000/svg" class="iconPass">
                      <path stroke-linecap="round" stroke-width="1.5" stroke="#141B34" d="M18 11.0041C17.4166 9.91704 16.273 9.15775 14.9519 9.0993C13.477 9.03404 11.9788 9 10.329 9C8.67911 9 7.18091 9.03404 5.70604 9.0993C3.95328 9.17685 2.51295 10.4881 2.27882 12.1618C2.12602 13.2541 2 14.3734 2 15.5134C2 16.6534 2.12602 17.7727 2.27882
                       18.865C2.51295 20.5387 3.95328 21.8499 5.70604 21.9275C6.42013 21.9591 7.26041 21.9834 8 22"></path>
                      <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5" stroke="#141B34" d="M6 9V6.5C6 4.01472 8.01472 2 10.5 2C12.9853 2 15 4.01472 15 6.5V9"></path>
                      <path fill="#141B34" d="M21.2046 15.1045L20.6242 15.6956V15.6956L21.2046 15.1045ZM21.4196 16.4767C21.7461 16.7972 22.2706 16.7924 22.5911 16.466C22.9116 16.1395 22.9068 15.615 22.5804 15.2945L21.4196 16.4767ZM18.0228 15.1045L17.4424 14.5134V14.5134L18.0228 15.1045ZM18.2379 18.0387C18.5643 18.3593 19.0888 18.3545 19.4094 18.028C19.7299 17.7016 19.7251 17.1771 19.3987 16.8565L18.2379 18.0387ZM14.2603
                       20.7619C13.7039 21.3082 12.7957 21.3082 12.2394 20.7619L11.0786
                      21.9441C12.2794 23.1232 14.2202 23.1232 15.4211 21.9441L14.2603 
                      20.7619ZM12.2394 20.7619C11.6914 20.2239 11.6914 19.358 12.2394 
                      18.82L11.0786 17.6378C9.86927 18.8252 9.86927 20.7567 11.0786 
                      21.9441L12.2394 20.7619ZM12.2394 18.82C12.7957 18.2737 13.7039 18.2737 14.2603 
                      18.82L15.4211 17.6378C14.2202 16.4587 12.2794 16.4587 11.0786 17.6378L12.2394 
                      18.82ZM14.2603 18.82C14.8082 19.358 14.8082 20.2239 14.2603 20.7619L15.4211 
                      21.9441C16.6304 20.7567 16.6304 18.8252 15.4211 17.6378L14.2603 
                      18.82ZM20.6242 15.6956L21.4196 16.4767L22.5804 15.2945L21.785 
                      14.5134L20.6242 15.6956ZM15.4211 18.82L17.8078 16.4767L16.647 
                      15.2944L14.2603 17.6377L15.4211 18.82ZM17.8078 16.4767L18.6032 
                      15.6956L17.4424 14.5134L16.647 15.2945L17.8078 16.4767ZM16.647 
                      16.4767L18.2379 18.0387L19.3987 16.8565L17.8078 15.2945L16.647 
                      16.4767ZM21.785 14.5134C21.4266 14.1616 21.0998 13.8383 20.7993 
                      13.6131C20.4791 13.3732 20.096 13.1716 19.6137 13.1716V14.8284C19.6145 
                      14.8284 19.619 14.8273 19.6395 14.8357C19.6663 14.8466 19.7183 14.8735 
                      19.806 14.9391C19.9969 15.0822 20.2326 15.3112 20.6242 15.6956L21.785 
                      14.5134ZM18.6032 15.6956C18.9948 15.3112 19.2305 
                      15.0822 19.4215 14.9391C19.5091 14.8735 19.5611 14.8466 19.5879 
                      14.8357C19.6084 14.8273 19.6129 14.8284 19.6137 14.8284V13.1716C19.1314 
                      13.1716 18.7483 13.3732 18.4281 13.6131C18.1276 13.8383 17.8008 14.1616 
                      17.4424 14.5134L18.6032 15.6956Z"></path>
                    </svg>
                    <input placeholder="Password" title="Inpit title" name="input_pass" type="password" class="input_field" id="password_field">
                    <svg fill="none" viewBox="0 0 24 24" height="24" width="24" xmlns="http://www.w3.org/2000/svg" class="iconPass">
                      <path stroke-linecap="round" stroke-width="1.5" stroke="#141B34" d="M18 11.0041C17.4166 9.91704 16.273 9.15775 14.9519 9.0993C13.477 9.03404 11.9788 9 10.329 9C8.67911 9 7.18091 9.03404 5.70604 9.0993C3.95328 9.17685 2.51295 10.4881 2.27882 12.1618C2.12602 13.2541 2 14.3734 2 15.5134C2 16.6534 2.12602 17.7727 2.27882
                       18.865C2.51295 20.5387 3.95328 21.8499 5.70604 21.9275C6.42013 21.9591 7.26041 21.9834 8 22"></path>
                      <path stroke-linejoin="round" stroke-linecap="round" stroke-width="1.5" stroke="#141B34" d="M6 9V6.5C6 4.01472 8.01472 2 10.5 2C12.9853 2 15 4.01472 15 6.5V9"></path>
                      <path fill="#141B34" d="M21.2046 15.1045L20.6242 15.6956V15.6956L21.2046 15.1045ZM21.4196 16.4767C21.7461 16.7972 22.2706 16.7924 22.5911 16.466C22.9116 16.1395 22.9068 15.615 22.5804 15.2945L21.4196 16.4767ZM18.0228 15.1045L17.4424 14.5134V14.5134L18.0228 15.1045ZM18.2379 18.0387C18.5643 18.3593 19.0888 18.3545 19.4094 18.028C19.7299 17.7016 19.7251 17.1771 19.3987 16.8565L18.2379 18.0387ZM14.2603
                       20.7619C13.7039 21.3082 12.7957 21.3082 12.2394 20.7619L11.0786
                      21.9441C12.2794 23.1232 14.2202 23.1232 15.4211 21.9441L14.2603 
                      20.7619ZM12.2394 20.7619C11.6914 20.2239 11.6914 19.358 12.2394 
                      18.82L11.0786 17.6378C9.86927 18.8252 9.86927 20.7567 11.0786 
                      21.9441L12.2394 20.7619ZM12.2394 18.82C12.7957 18.2737 13.7039 18.2737 14.2603 
                      18.82L15.4211 17.6378C14.2202 16.4587 12.2794 16.4587 11.0786 17.6378L12.2394 
                      18.82ZM14.2603 18.82C14.8082 19.358 14.8082 20.2239 14.2603 20.7619L15.4211 
                      21.9441C16.6304 20.7567 16.6304 18.8252 15.4211 17.6378L14.2603 
                      18.82ZM20.6242 15.6956L21.4196 16.4767L22.5804 15.2945L21.785 
                      14.5134L20.6242 15.6956ZM15.4211 18.82L17.8078 16.4767L16.647 
                      15.2944L14.2603 17.6377L15.4211 18.82ZM17.8078 16.4767L18.6032 
                      15.6956L17.4424 14.5134L16.647 15.2945L17.8078 16.4767ZM16.647 
                      16.4767L18.2379 18.0387L19.3987 16.8565L17.8078 15.2945L16.647 
                      16.4767ZM21.785 14.5134C21.4266 14.1616 21.0998 13.8383 20.7993 
                      13.6131C20.4791 13.3732 20.096 13.1716 19.6137 13.1716V14.8284C19.6145 
                      14.8284 19.619 14.8273 19.6395 14.8357C19.6663 14.8466 19.7183 14.8735 
                      19.806 14.9391C19.9969 15.0822 20.2326 15.3112 20.6242 15.6956L21.785 
                      14.5134ZM18.6032 15.6956C18.9948 15.3112 19.2305 
                      15.0822 19.4215 14.9391C19.5091 14.8735 19.5611 14.8466 19.5879 
                      14.8357C19.6084 14.8273 19.6129 14.8284 19.6137 14.8284V13.1716C19.1314 
                      13.1716 18.7483 13.3732 18.4281 13.6131C18.1276 13.8383 17.8008 14.1616 
                      17.4424 14.5134L18.6032 15.6956Z"></path>
                    </svg>
                    <input placeholder="Confirm Password" title="Inpit title" name="input_pass2" type="password" class="input_field" id="password_field2">
                    <div class="errorDispPass"></div>

                    <input type="submit" class="sign-up_btn" name="submit_signup" value="Sign-up"/>
                  </div>
                  
                
                  <div class="separator">
                    <hr class="line">
                    <span>Or</span>
                    <hr class="line">
                  </div>
                  <button title="Sign In" type="submit" class="sign-in_ggl">
                    <svg height="18" width="18" viewBox="0 0 32 32" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg">
                      <defs>
                        <path d="M44.5 20H24v8.5h11.8C34.7 33.9 30.1 37 24 37c-7.2 0-13-5.8-13-13s5.8-13 13-13c3.1 0 5.9 1.1 8.1 2.9l6.4-6.4C34.6 4.1 29.6 2 24 2 11.8 2 2 11.8 2 24s9.8 22 22 22c11 0 21-8 21-22 0-1.3-.2-2.7-.5-4z" id="A"></path>
                      </defs>
                      <clipPath id="B">
                        
                      </clipPath>
                      <g transform="matrix(.727273 0 0 .727273 -.954545 -1.45455)">
                        <path fill="#fbbc05" clip-path="url(#B)" d="M0 37V11l17 13z"></path>
                        <path fill="#ea4335" clip-path="url(#B)" d="M0 11l17 13 7-6.1L48 14V0H0z"></path>
                        <path fill="#34a853" clip-path="url(#B)" d="M0 37l30-23 7.9 1L48 0v48H0z"></path>
                        <path fill="#4285f4" clip-path="url(#B)" d="M48 48L17 24l-4-3 35-10z"></path>
                      </g>
                    </svg>
                    <span>Sign Up with Google</span>
                  </button>
                </form>
          </dialog>

        </header>
                    
            <!-- HOME PAGE -->
            <section class="home">
                <div class="textbox">

                    <h1>Enjoy hassle-free <br> bookings and
                         <br> travel smoothly.</h1>
                    <p>Local | Reliable | Safe</p> 
                    <button class="ridenow" >
                        <span class="circle" aria-hidden="true">
                        <span class="icon arrow"></span>
                        </span>
                        <span class="button-text">Drive now</span>
                    </button>    
                </div>
                <div class="imgbox">
                    <img class="taxi" src="../images/taxiicon.jpg" alt="pls add image on github">
                </div>
            </section>


            
            <div class="container">
              <section class="panel aboutus">
                
                <p class="heading1">How Libér Works</p>
                <p class="subheading1">Open our web-app from any search engine , create account <br> and enter your details. Voila!</p>
                <div class="radio-inputs">
                  <label class="radio">
                    <input type="radio" name="radio" checked="">
                    <span class="name">Passenger</span>
                  </label>
                
                      
                  <label class="radio">
                    <input type="radio" name="radio">
                    <span class="name">Driver</span>
                  </label>
                </div>
              
                <div class="homerow">

                  <div class="col1">
                    <div class="step1">
                      <button class="button">
                        1
                      </button>
                      <h3>Request a Trip</h3>
                      <p>Choose your pick-up & drop-off<br>location, and the trip type that<br>meets your needs.<br></p>

                    </div>

                   
                    <div class="step3">
                      <button class="button">
                        3
                      </button>
                      <h3>Enjoy Your Trip</h3>
                      <p>Meet your driver with the help of<br>our real GPS services and<br>enjoy your trip!<br></p>
                    </div>

                  </div>
                    

                  <div class="col2">
                    <img class="phone" src="../images/phone.png" alt="pls add image on github"> 
                  </div>

                  <div class="col3">
                    <div class="step2">
                      <button class="button">
                        2
                      </button>
                      <h3>Match with a Driver</h3>
                      <p>Liber will match you with the<br>nearest available driver.</p>

                    </div>

                   
                    <div class="step4">
                      <button class="button">
                        4
                      </button>
                      <h3>Pay and Rate</h3>
                      <p>Pay with cash or card and rate<br>your driver.</p>
                    </div>
                    
                   
                  </div>
                </div>

                
               
              </section>


              <section class="panel services">
                
                <h2>Services</h2>
                <p>
                  SITE UNDER CONSTRUCTION
                </p>
              </section>
            </div>

            <section class="footer">
              
              <h2>Testimonials</h2>
              <p>
                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Animi labore
                eius cum perferendis consectetur culpa laboriosam quam, sed ea nihil,
                suscipit, quidem est expedita. Nihil enim obcaecati deleniti eaque sed.
              </p>
            </section>


            <script src="../js/swiper-bundle.min.js"></script>
            <script
              src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"
              integrity="sha512-f8mwTB+Bs8a5c46DEm7HQLcJuHMBaH/UFlcgyetMqqkvTcYg4g5VXsYR71b3qC82lZytjNYvBj2pf0VekA9/FQ=="
              crossorigin="anonymous"
              referrerpolicy="no-referrer"
            ></script>
            <script
              src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/ScrollTrigger.min.js"
              integrity="sha512-A64Nik4Ql7/W/PJk2RNOmVyC/Chobn5TY08CiKEX50Sdw+33WTOpPJ/63bfWPl0hxiRv1trPs5prKO8CpA7VNQ=="
              crossorigin="anonymous"
              referrerpolicy="no-referrer"
            ></script>

            <script src="../js/liberscript.js"></script>
    </body>
    
</html>