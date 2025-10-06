// sub menu and notification box
let subMenu = document.getElementById("subMenu");


function ToggleMenu() {
  subMenu.classList.toggle("open-menu");
}

function toggleMenu() {
  document.getElementById("subMenu").classList.toggle("open-menu");
}

function toggleNotifi() {
  document.getElementById("notificationBox").classList.toggle("open-menu");
}

function openModal() {
  var modal = document.getElementById("myModal");
  modal.style.display = "block";
}

function closeModal() {
  var modal = document.getElementById("myModal");
  modal.style.display = "none";
}

function sendResponse() {
  var responseMessage = document.getElementById("responseMessage").value;
  if (responseMessage.trim() !== "") {
      document.getElementById("successMessage").style.display = "block";
      setTimeout(function() {
          document.getElementById("successMessage").style.display = "none";
          closeModal();
      }, 2000);
  } else {
      alert("Please write a response before sending.");
  }
}

document.querySelector(".close").addEventListener("click", closeModal);
document.getElementById("sendResponseBtn").addEventListener("click", sendResponse);

window.onclick = function(event) {
  var modal = document.getElementById("myModal");
  if (event.target == modal) {
      modal.style.display = "none";
  }
}


// dark mode

document.addEventListener("DOMContentLoaded", (event) => {
  const toggleButton = document.getElementById("dark-mode-toggle");

  if (localStorage.getItem("darkMode") === "enabled") {
    document.body.classList.add("dark-mode");
  }

  toggleButton.addEventListener("click", () => {
    document.body.classList.toggle("dark-mode");

    if (document.body.classList.contains("dark-mode")) {
      localStorage.setItem("darkMode", "enabled");
    } else {
      localStorage.setItem("darkMode", "disabled");
    }
  });
});
