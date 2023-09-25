<!DOCTYPE html>
<html>
<head>
<title>Home Page</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
<link rel="stylesheet" href="Style/home.css">
</head>
<body>
  <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>

  <!-- Navbar (sit on top) -->
  <div class="w3-top">
    <div class="w3-bar w3-white w3-card" id="myNavbar">
      <a href="#home" class="w3-bar-item w3-button w3-wide">FOLIA</a>
      <!-- Right-sided navbar links -->
      <div class="w3-right w3-hide-small">
        <a href="#about" class="w3-bar-item w3-button">ABOUT</a>
        <a href="#plant" class="w3-bar-item w3-button"> PLANT</a>
        <a href="growth.php" class="w3-bar-item w3-button"></i>GROWTH</a>
        <a href="loginpage.php" class="w3-bar-item w3-button"><i class="fa fa-th"></i> SIGNOUT</a>
<script>
function myFunction() {
  var x = document.getElementById("Demo");
  if (x.className.indexOf("w3-show") == -1) { 
    x.className += " w3-show";
  } else {
    x.className = x.className.replace(" w3-show", "");
  }
}
</script>
        </div>
      </div>
      <!-- Hide right-floated links on small screens and replace them with a menu icon -->

      <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="w3_open()">
        <i class="fa fa-bars"></i>
      </a>
    </div>
  </div>

  <!-- Sidebar on small screens when clicking the menu icon -->
  <nav class="w3-sidebar w3-bar-block w3-black w3-card w3-animate-left w3-hide-medium w3-hide-large" style="display:none" id="mySidebar">
    <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button w3-large w3-padding-16">Close ×</a>
    <a href="#about" onclick="w3_close()" class="w3-bar-item w3-button">ABOUT</a>
    <a href="#plant" onclick="w3_close()" class="w3-bar-item w3-button">PLANT</a>
    <a href="#growth" onclick="w3_close()" class="w3-bar-item w3-button">GROWTH</a>
  </nav>

<!-- Header with full-height image -->
<header class="bgimage w3-display-container w3-grayscale-min" id="home">
  <div class="w3-display-left w3-text-white" style="padding:48px">
    <h1 class="One">Start something that matters</h1><br>
    <h6>Stop wasting valuable time with projects that just isn't you.</h6>
    <p><a href="#about" class="w3-button w3-white w3-padding-large w3-large w3-margin-top w3-opacity w3-hover-opacity-off">Learn more about the website application</a></p>
  </div>
</header>

<!-- About Section -->
<div class="w3-container" style="padding:128px 16px" id="about">
  <h3 class="w3-center">ABOUT THE APPLICATION</h3>
  <p class="w3-center w3-large">Key features of our application</p>
  <div class="w3-row-padding w3-center" style="margin-top:64px">
    <div class="w3-quarter">
      <i class="fa fa-desktop w3-margin-bottom w3-jumbo w3-center"></i>
      <p class="w3-large">Responsive</p>
      <p>Will adjust the layout and elements to fit the screen it is being viewed on, whether it is a desktop, tablet, phone. This allows for a better user experience as the website is easily readable and navigable on any design.</p>
    </div>
    <div class="w3-quarter">
      <i class="fa fa-heart w3-margin-bottom w3-jumbo"></i>
      <p class="w3-large">Life of Plant</p>
      <p>You can easily see the life of the plant that is currently on your hardware. This app will display the temperature, humidity and the growth of your plant.</p>
    </div>
    <div class="w3-quarter">
      <i class="fa fa-diamond w3-margin-bottom w3-jumbo"></i>
      <p class="w3-large">Design</p>
      <p>By using a clean and simple layouts, in focus on functionality and usability. The goal is to present the user with only the most essential elements, and to eliminate any unnecessary clutter or distractions. </p>
    </div>
    <div class="w3-quarter">
      <i class="fa fa-cog w3-margin-bottom w3-jumbo"></i>
      <p class="w3-large">Support</p>
      <p>In support to the additional hardware provided. This application can support by allowing the user to view what is happening inside the hardware and how it functions 24/7</p>
    </div>
  </div>
</div>

<!-- Promo Section - "We know design" -->
<div class="w3-container w3-light-grey" style="padding:128px 16px" id="plant">
  <div class="w3-row-padding">
    <div class="w3-col m6">
      <h3>Your plant</h3>
      <p>Click the button that will walk to a page where you can see your plants status.</p>
      <p><a href="plant.php" class="w3-button w3-black"><i class="fa fa-th"></i> View Your Plant</a></p>
    </div>
    <div align="center" class="w3-col m6">
      <img class="plant-img" src="https://c1.wallpaperflare.com/preview/297/539/696/plant-leaf-minimal-botanical.jpg" alt="Buildings" width="700" height="394">
    </div>
  </div>
</div>


<!-- Footer -->
<footer class="w3-center w3-black w3-padding-64">
  <a href="#home" class="w3-button w3-light-grey"><i class="fa fa-arrow-up w3-margin-right"></i>To the top</a>
  <div class="w3-xlarge w3-section">
  </div>
  <p> (c) Cruz, Lazaro, Peralta</p>
</footer>

<div class="loader-wrapper">
  <span class="loader"><span class="loader-inner"></span></span>
</div>

<script>
// Toggle between showing and hiding the sidebar when clicking the menu icon
var mySidebar = document.getElementById("mySidebar");

function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
  } else {
    mySidebar.style.display = 'block';
  }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
}
</script>

</body>
</html>
