<script src="https://cdn.tailwindcss.com"></script>
<link href="dist/output.css?<?php echo time(); ?>" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nokora:wght@100;300;400;700;900&display=swap" rel="stylesheet">
<script>
  function logout() {
    window.location.replace('logout.php');
  }

  function indexme() {
    window.location.replace('index.php');
  }
</script>
<style>
  .nokora {
    font-family: "Nokora", sans-serif;
  }
  body{
    font-family: "Nokora", sans-serif;
  }
</style>
<header class="nokora h-24 shadow-lg text-gray-600 body-font sticky top-0 z-50  bg-gray-50 dark:bg-[#0E0E0E]"
  style=" background-size:cover; background-repeat:no-repeat;">
  <div class="container mx-auto flex items-center justify-between h-full">
    <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
      <img onclick="indexme()" class="h-24 w-24 bg-black-500 rounded-full cursor-pointer"
        src="../assects/images/defaults/logo.png" alt="Logo">
    </a>
    <nav class="md:ml-auto flex flex-wrap items-center text-base justify-center"></nav>

    <!-- <button id="darkModeToggle" onclick="toggleDarkMode()"
          class="text-gray-900  hover:text-gray-900 focus:outline-none py-2 px-2 flex justify-center items-center hover:bg-gray-100 dark:hover:bg-gray-700">
        
          <svg id="sunIcon" class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 5V3m0 18v-2M7.05 7.05 5.636 5.636m12.728 12.728L16.95 16.95M5 12H3m18 0h-2M7.05 16.95l-1.414 1.414M18.364 5.636 16.95 7.05M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" />
          </svg>


          <svg id="moonIcon" class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 21a9 9 0 0 1-.5-17.986V3c-.354.966-.5 1.911-.5 3a9 9 0 0 0 9 9c.239 0 .254.018.488 0A9.004 9.004 0 0 1 12 21Z" />
          </svg>

        </button> -->

    <button onclick="logout()"
      class="inline-flex items-center  px-8 py-2 rounded-full bg-[#E50914]  text-white focus:ring-2  hover:shadow-xl transition duration-200">
      ចេញពី <?php echo isset($_SESSION["usr_nam"]) ? htmlspecialchars($_SESSION["usr_nam"]) : "Unknown User"; ?>
      <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
        class="w-4 h-4 ml-1" viewBox="0 0 24 24">
        <path d="M5 12h14M12 5l7 7-7 7"></path>
      </svg>
    </button>
  </div>
</header>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Attach the toggleMenu function to the button
    const menuButton = document.getElementById("menuIcon");
    if (menuButton) {
      menuButton.addEventListener("click", toggleMenu);
    }

    // Dark mode toggle function
    function toggleDarkMode() {
      const moonIcon = document.getElementById("moonIcon");
      const sunIcon = document.getElementById("sunIcon");

      // Toggle dark mode
      if (document.documentElement.classList.contains("dark")) {
        document.documentElement.classList.remove("dark");
        localStorage.setItem("theme", "light");
      } else {
        document.documentElement.classList.add("dark");
        localStorage.setItem("theme", "dark");
      }

      // Toggle icons visibility
      moonIcon.classList.toggle("hidden");
      sunIcon.classList.toggle("hidden");
    }

    // Set initial theme based on local storage or system preference
    const savedTheme = localStorage.getItem("theme");
    const moonIcon = document.getElementById("moonIcon");
    const sunIcon = document.getElementById("sunIcon");

    if (savedTheme) {
      if (savedTheme === "dark") {
        document.documentElement.classList.add("dark");
        moonIcon.classList.add("hidden");
        sunIcon.classList.remove("hidden");
      } else {
        document.documentElement.classList.remove("dark");
        moonIcon.classList.remove("hidden");
        sunIcon.classList.add("hidden");
      }
    } else {
      const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
      if (prefersDark) {
        document.documentElement.classList.add("dark");
        moonIcon.classList.add("hidden");
        sunIcon.classList.remove("hidden");
      } else {
        document.documentElement.classList.remove("dark");
        moonIcon.classList.remove("hidden");
        sunIcon.classList.add("hidden");
      }
    }

    // Attach the dark mode toggle functionality to the button
    const darkModeButton = document.getElementById("darkModeToggle");
    if (darkModeButton) {
      darkModeButton.addEventListener("click", toggleDarkMode);
    }

    const navLinks = document.querySelectorAll("#navMenu a");

    // Check the current URL
    const currentUrl = window.location.pathname.split("/").pop();

    navLinks.forEach(link => {
      if (link.getAttribute("href") === currentUrl) {
        link.classList.add("bg-secondcolor", "text-white", "rounded-full", "p-3", "hover:text-white");
      }

      link.addEventListener("click", () => {
        navLinks.forEach(nav => nav.classList.remove("text-white", "rounded-full", "px-4", "py-2"));
        link.classList.add("text-white", "rounded-full", "px-4", "py-2", "transition", "duration-300", "ease-in-out");
      });
    });
  });
</script>