<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>The Flora Shop</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-rich-black { background-color: #171A21; }
        .bg-paynes-gray { background-color: #617073; }
        .bg-air-superiority-blue { background-color: #7A93AC; }
        .bg-jordy-blue { background-color: #92BCEA; }
        .bg-periwinkle { background-color: #AFB3F7; }
    </style>
</head>
<body class="bg-air-superiority-blue text-gray-700 font-sans">
    <header class="bg-rich-black text-white py-5 text-center flex justify-between px-4">
        <h1 class="text-3xl font-bold">The Flora Shop</h1>
        <!-- Right Side Menu -->
        <nav class="flex space-x-4">
            <button class="bg-jordy-blue px-4 py-2 rounded text-white" onclick="showSearchHistory()">Search History</button>
            <?php
            // Check if user is authenticated
            if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']) {
                // User is authenticated, hide login button and show logout button
                $logout = 'logout.php';
                echo "<button class='bg-jordy-blue px-4 py-2 rounded text-white' id='logoutBtn'><a href='logout.php'>Logout</a></button>";

            } else {
                // User is not authenticated, show login button and hide logout button
                $login = 'login.php';
                echo "<button class='bg-jordy-blue px-4 py-2 rounded text-white' id='loginBtn'>Login</button>";
            }
            ?>
            <!--<button class="bg-jordy-blue px-4 py-2 rounded text-white" id="loginBtn" onclick="location.href='login.php'">Login</button>
            <button class="bg-jordy-blue px-4 py-2 rounded text-white" id="logoutBtn" onclick="location.href='logout.php'">Logout</button>-->
            <button class="bg-jordy-blue px-4 py-2 rounded text-white" onclick="location.href='my-profile.php'">My Profile</button>
            <button class="bg-jordy-blue px-4 py-2 rounded text-white" onclick="location.href='cart.php'">Cart</button>
        </nav>
    </header>    
    <div class="search-bar mt-8">
        <form id="searchForm" class="flex justify-center" action="display.php" method="POST">
            <input type="text" id="searchInput" name="searchInput" placeholder="Search for a flower..." class="px-4 py-2 border-2 border-gray-300 rounded-l-lg focus:outline-none focus:border-jordy-blue" />
            <button type="submit" class="px-6 py-2 border-2 border-l-0 border-jordy-blue bg-jordy-blue text-white rounded-r-lg">Search</button>
        </form>
    </div>
    
    <div id="searchResults" class="container mx-auto mt-8 hidden">
        <p class="text-gray-700">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam.</p>
    </div>
    
    <!--<script>
      // Function to show search results
        /*document.getElementById('searchForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var input = document.getElementById('searchInput').value;
        
        // If the input is not empty, show the search results
        if(input.trim() !== '') {
          document.getElementById('searchResults').classList.remove('hidden');
        } else {
          document.getElementById('searchResults').classList.add('hidden');
        }
      });*/
    </script>-->
    
    <div class="flex justify-center mt-8 relative">
        <div id="gallery" class="flex overflow-hidden w-full">
          <!-- Flower items will be inserted here using JS -->
        </div>
        <button id="prevButton" onclick="scrollGallery(-1)" class="absolute left-0 z-10 bg-gray-800 bg-opacity-75 text-white p-2 rounded-full hover:bg-opacity-100 transition-all duration-300">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </button>
        <button id="nextButton" onclick="scrollGallery(1)" class="absolute right-0 z-10 bg-gray-800 bg-opacity-75 text-white p-2 rounded-full hover:bg-opacity-100 transition-all duration-300">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
        </button>
      </div>
      
   
      

    <footer class="bg-rich-black text-jordy-blue py-3 text-center">
        <p>&copy; All Rights Reserved
        </p>
    </footer>

    <script src="scripts.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var loginBtn = document.getElementById('loginBtn');
            var logoutBtn = document.getElementById('logoutBtn');

            // Add event listener for login button click
            loginBtn.addEventListener('click', function() {
                // Redirect to login page
                window.location.href = 'login.php';
            });

            // Add event listener for logout button click
            logoutBtn.addEventListener('click', function() {
                // Perform logout operation, e.g., redirect to logout script
                window.location.href = 'logout.php';
            });

            // Check if user is logged in and toggle button visibility
            <?php
            if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']) {
                echo 'loginBtn.style.display = "none";';
                echo 'logoutBtn.style.display = "block";';
            } else {
                echo 'loginBtn.style.display = "block";';
                echo 'logoutBtn.style.display = "none";';
            }
            ?>
        });
    </script>



</body>
</html>

<script>
    function showSearchHistory() {
      // Retrieve the search history from localStorage
      let history = localStorage.getItem('searchHistory');
      if (history) {
        // Parse the stored string into an array
        history = JSON.parse(history);
        // Create a string that lists the search terms from user inputs
        let historyHTML = '<ul>' + history.map(term => `<li>${term}</li>`).join('') + '</ul>';
        // Show the search history section
        alert("Search History:\n" + historyHTML);
      } else {
        alert("No search history found.");
      }
    }
</script>
  