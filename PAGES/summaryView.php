
<?php 
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['fullname']) && $_SESSION['role'] == 'student')
{
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Summary View</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link rel="stylesheet" href="../CSS/styles.css" />
    <style>
      body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
      }
      h1, h2 {
          font-size: 1.5em;
                color: #0066cc;
                margin-bottom: 20px;
            }
            p {
                font-size: 18px;
                font-family: Arial, sans-serif;
                font-weight: 600;
                margin-bottom: 15px;
            }
            pre, code {
                font-family: 'Courier New', Courier, monospace;
                background-color: #f0f0f0;
                padding: 8px;
                border-radius: 5px;
                font-size: 0.9em;
                margin-bottom: 15px;
                overflow-x: auto; /* Enable horizontal scroll */
            }
            ul {
                list-style-type: disc;
                margin-bottom: 15px;
                padding-left: 20px;
            }
            li {
                margin-bottom: 5px;
            }
            strong {
                font-size: 1.4em;
                padding-top:20px;
                color: #009900;
                font-weight: bold;
            }
      #content {
        margin: 15px 25px 5px 25px;}
      .container {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 1150px;
        width: 100%;
        margin: 20px auto;
        min-height: 525px;
      }
      #content {
        margin-bottom: 20px;
      }
      #content h2 {
        color: #28a745;
        font-size: 24px;
        margin-bottom: 10px;
      }
      #content p {
        color: #555;
        margin-bottom: 8px;
        font-size: 16px;
        line-height: 1.5;
      }
      .btns {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 20px;
      }
      .Download-button,
      .courses-button {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        display: block;
        margin-bottom: 5px;
        background-color: #320943e3;
        color: white;
        width: 200px;
      }
      .courses-button:hover,
      .Download-button:hover {
        background-color: #d6d6de;
        color: #000;
      }
      .search-container {
        position: absolute;
        display: flex;
        flex-direction: column;
        align-items: center;
        right: 280px;
        top: 31px;
      }
      #search-icon {
        cursor: pointer;
        width: 40px;
        border-radius: 50%;
      }
      #search-input {
        width: 500px;
        padding: 10px;
        border: 1px solid #d1d1d1;
        border-radius: 10px;
        display: none;
        position: absolute;
        top: 76px;
        background: #d1d1d1;
        box-shadow: #8b8b8b, -10px -10px 20px #ffffff;
        font-size: large;
      }
      .highlight {
        background-color: yellow;
      }
      .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        display: none;
      }
      .spinner {
        border: 4px solid rgba(0, 0, 0, 0.1);
        width: 36px;
        height: 36px;
        border-radius: 50%;
        border-top-color: #28a745;
        animation: spin 1s ease-in-out infinite;
      }
      @keyframes spin {
        to {
          transform: rotate(360deg);
        }
      }
    </style>
  </head>
  <body>
    <nav>
      <div class="logo2">
        <img src="../images/logo.png" class="logo">
        <div class="logo-text">
          <p>Student Assistant</p>
        </div>
      </div>
      <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="course.php">Courses</a></li>
        <li><a href="quiz.php">Quizzes</a></li>
        <li><a href="summary.php" class="active">Summary</a></li>
        <li><a href="GPA.php">GPA Calculator</a></li>
      </ul>
      <div class="notification" onclick="toggleNotifi()">
        <img src="../images/notification.jpg" alt=""> <span>2</span>
      </div>
      <div class="notifi-box" id="notificationBox">
        <div class="notifi-item">
          <img src="../images/profile.png">
          <div class="text">
            <h4>Student Assistant</h4>
            <p>Feb 12, 2022</p>
            <p>Welcome to Student Assistant, we wish you all the best on your journey!</p>
          </div>
        </div>
        <div class="notifi-item" onclick="openModal()">
          <img src="../images/profile.png">
          <div class="text">
            <h4>Ali Ahmed</h4>
            <p>Feb 12, 2022</p>
          </div>
        </div>
      </div>
      <img src="../images/profile.png" onclick="ToggleMenu()" class="user-pic">
      <div class="sub-menu-wrap" id="subMenu">
        <div class="sub-menu">
          <div class="user-info">
            <?php if(isset($_SESSION['profile_image'])): ?>
              <img src="data:image/jpeg;base64,<?php echo $_SESSION['profile_image']; ?>">
            <?php endif; ?>
            <h3><?php echo $_SESSION['fullname']; ?></h3>
          </div>
          <hr>
          <a href="profile.php" class="sub-menu-link">
            <img src="../images/edit.png">
            <p>Profile</p>
            <span>></span>
          </a>
          <hr>
          <a class="sub-menu-link" id="dark-mode-toggle" style="cursor: pointer;">
            <img src="../images/swich.jpg">
            <p>Swich</p>
          </a>
          <hr>
          <a href="../php/logout.php" class="sub-menu-link">
            <img src="../images/logout.png">
            <p>Logout</p>
            <span>></span>
          </a>
        </div>
      </div>
      <div id="myModal" class="modal">
        <div class="modal-content">
          <span class="close">&times;</span>
          <h4>Ail Ahmed</h4>
          <p>Date: 12-12-2023</p>
          <p>Hi, Can i fix you?</p>
          <textarea id="responseMessage" placeholder="Write your response here..."></textarea>
          <button id="sendResponseBtn">Send Response</button>
          <p id="successMessage" class="success-message">Response sent successfully!</p>
        </div>
      </div>
    </nav>
    <div class="container" id="capture">
      <div id="content">
        <h2>A Comprehensive Summary of Data Warehousing Concepts</h2>
<p></p>
This document delves into the intricate world of data warehousing, providing a detailed overview of its principles, architecture, design methodologies, and key components. 
<p></p>
<strong>Understanding the Essence of Data Warehousing</strong>
<p></p>
Data warehousing is a fundamental concept in modern data management, serving as a repository for vast amounts of historical data from various sources.  Its core purpose is to facilitate analysis and decision-making by providing a unified and comprehensive view of business information.
<p></p>
<strong>Key Concepts and Terminology</strong>
<ul><li><strong>Data Warehouse:</strong> A central repository for storing historical data from multiple sources, organized for analysis and decision support.</li></ul>
<p>* <strong>Operational Database (OLTP):</strong> Designed for real-time transaction processing, focused on efficiency and speed, primarily used for day-to-day operations.</p>
<ul><li><strong>Online Analytical Processing (OLAP):</strong> A software technology that enables analysis of data from multiple perspectives, facilitating insights and decision-making.</li></ul>
<p>* <strong>Data Mart:</strong> A smaller, focused subset of a data warehouse, typically catering to specific departments or business units.</p>
<ul><li><strong>Extract, Transform, Load (ETL):</strong> A process that extracts data from various sources, transforms it into a consistent format, and loads it into the data warehouse.</li></ul>
<p>* <strong>Metadata:</strong> Data about data, providing information about the structure, content, and origins of data stored within the data warehouse.</p>
<ul><li><strong>Dimensional Modeling:</strong> A data modeling approach used in OLAP systems, employing fact tables and dimension tables to organize data for efficient analysis.</li></ul>
<p>* <strong>Fact Table:</strong> Contains numerical data (facts) representing business events, often linked to dimension tables.</p>
<ul><li><strong>Dimension Table:</strong>  Describes characteristics or attributes of the facts, providing contextual information for analysis.</li></ul>
<p>* <strong>Hierarchy:</strong> A tree-like structure representing relationships between dimensional attributes, enabling multi-level analysis.</p>
<ul><li><strong>Data Cube:</strong> A multidimensional representation of data, allowing analysis from different perspectives.</li></ul>
<p></p>
<strong>The Importance of Data Warehousing</strong>
<p></p>
Data warehousing is essential for numerous reasons:
<ul><li><strong>Strategic Decision Making:</strong> Data warehouses provide historical data for analyzing trends, patterns, and anomalies, empowering informed decision-making.</li></ul>
<p>* <strong>Customer Focus:</strong>  Understanding customer behavior through data analysis can lead to improved customer experience and targeted marketing campaigns.</p>
<ul><li><strong>Business Process Optimization:</strong> Data warehouses enable the identification of bottlenecks, inefficiencies, and opportunities for improvement within business processes.</li></ul>
<p>* <strong>Competitive Advantage:</strong>  Leveraging data insights can help businesses anticipate market trends, identify new opportunities, and stay ahead of competition.</p>

<p><strong>Data Warehouse Architectures: A Multi-layered Approach</strong></p>

<p>Data warehouse architectures are designed to efficiently store, manage, and deliver data for analysis. These architectures are typically categorized based on their structure and how they address enterprise-wide or departmental needs.</p>
<ul><li><strong>Structure-Oriented Architectures:</strong></li></ul>
<p>    * <strong>Single-Tier:</strong>  The simplest architecture, where operational data is directly used for analytical purposes, lacking separation between transactional and analytical processes.</p>
<ul><li><strong>Two-Tier:</strong>  Separates data sources from the data warehouse, allowing for better data quality control and improved analytical capabilities.</li></ul>
<p>    * <strong>Three-Tier:</strong>  Adds a Reconciled Layer between the source data and the data warehouse, creating a centralized and consistent data source for analysis.</p>
<ul><li><strong>Enterprise-Oriented Architectures:</strong></li></ul>
<p>    * <strong>Independent Data Marts:</strong>  Departmental data marts are built separately, offering flexibility but potentially leading to data inconsistencies and lack of enterprise-wide visibility.</p>
<ul><li><strong>Bus Architecture:</strong>  Addresses data consistency issues in Independent Data Marts by using shared dimension tables and facts tables across different data marts.</li></ul>
<p>    * <strong>Hub-and-Spoke Architecture:</strong>  Emphasizes scalability and extensibility, using a central Reconciled Layer to feed multiple data marts, enabling enterprise-wide analysis.</p>
<ul><li><strong>Centralized Architecture:</strong>  Combines the Reconciled Layer and data marts into a single repository, simplifying management but potentially increasing complexity.</li></ul>
<p>    * <strong>Federated Architecture:</strong>  Allows for a distributed data warehouse across multiple systems, enhancing scalability and flexibility.</p>

<p><strong>Data Warehouse Design Methodology: A Systematic Approach</strong></p>

<p>Designing a data warehouse requires a systematic approach to ensure effective data storage, retrieval, and analysis. The following steps are crucial:</p>

<p>1. <strong>Defining Business Requirements:</strong>  Clearly define the business objectives and analytical needs that the data warehouse should support.</p>
2. <strong>Identifying Data Sources:</strong> Determine the various sources of data that are relevant to the business requirements.
<p>3. <strong>Data Modeling:</strong>  Create a conceptual, logical, and physical data model to represent the structure and relationships within the data warehouse.</p>
4. <strong>Choosing the Grain:</strong>  Decide the level of detail that each record in the fact table will represent.
<p>5. <strong>Identifying and Confirming Dimensions:</strong>  Define the dimensions that provide context and detail for the facts stored in the data warehouse.</p>
6. <strong>Choosing the Duration of the Database:</strong>  Determine how long the data should be stored in the data warehouse, considering data retention policies and business needs.
<p>7. <strong>Deciding Query Priorities and Modes:</strong>  Define the types of queries that will be most frequently used and optimize the data warehouse for efficient query performance.</p>
8. <strong>ETL Process Design:</strong>  Design the ETL process to extract, transform, and load data from various sources into the data warehouse.
<p>9. <strong>Metadata Management:</strong>  Establish a robust metadata system to track and manage data about the data stored in the warehouse.</p>

<p><strong>Data Warehouse Components: A Vital Ecosystem</strong></p>

<p>The data warehouse ecosystem comprises several key components working together to facilitate data storage, analysis, and delivery.</p>
<ul><li><strong>Source Data:</strong>  The various sources of data, including operational databases, external sources, and internal data repositories.</li></ul>
<p>* <strong>Staging Area:</strong>  A temporary area where data is transformed and prepared before being loaded into the data warehouse.</p>
<ul><li><strong>Data Warehouse/Data Storage:</strong>  The core component where data is stored and managed, organized for efficient retrieval and analysis.</li></ul>
<p>* <strong>Information Delivery:</strong>  Provides mechanisms for making data accessible to users through reports, dashboards, and analytical tools.</p>

<p><strong>Challenges and Considerations</strong></p>

<p>Data warehousing presents several challenges, requiring careful consideration during implementation:</p>
<ul><li><strong>Data Integration Complexity:</strong>  Integrating data from diverse sources requires handling inconsistencies, varying data formats, and data quality issues.</li></ul>
<p>* <strong>ETL Process Development:</strong> Designing and implementing a robust ETL process is crucial for data accuracy, consistency, and efficient loading.</p>
<ul><li><strong>Performance Optimization:</strong>  Optimizing data warehouse performance to handle large volumes of data and complex queries is a key consideration.</li></ul>
<p>* <strong>Data Governance and Security:</strong>  Establishing strong data governance policies and ensuring data security are essential for protecting sensitive information.</p>

<p><strong>The Future of Data Warehousing</strong></p>

<p>Data warehousing continues to evolve with the advent of new technologies and approaches. Some key trends include:</p>
<ul><li><strong>Cloud-Based Data Warehousing:</strong>  Leveraging cloud computing platforms for data storage, processing, and analytics provides scalability, cost-effectiveness, and flexibility.</li></ul>
<p>* <strong>Big Data Analytics:</strong>  Data warehouses are expanding to accommodate massive datasets generated by social media, sensors, and other sources, enabling new insights and opportunities.</p>
<ul><li><strong>Real-Time Analytics:</strong>  Developing real-time analytics capabilities allows organizations to make decisions based on the most up-to-date information.</li></ul>
<p></p>
<strong>Conclusion</strong>
<p></p>
Data warehousing plays a critical role in empowering organizations with data-driven decision-making. By understanding its concepts, architecture, design methodologies, and key components, organizations can effectively implement data warehousing solutions to extract meaningful insights from their data, driving improved business outcomes and competitive advantage. 

      </div>
    </div>
    <div class="btns">
      <button class="Download-button" onclick="downloadPDF()">Download</button>
      <button class="courses-button" onclick="location.href='summary.php';">Back to Summary</button>
    </div>
    <div id="loading" class="loading-overlay">
      <div class="spinner"></div>
    </div>
    <footer>
      <div class="row">
        <div class="col">
          <img src="../images/logo.png" class="logo-footer">
          <h1>Student Assistant</h1>
          <h4>From study materials to assessments, we've got you covered.</h4>
          <div class="social">
            <i class="fa fa-facebook-f"></i>
            <i class="fa fa-twitter"></i>
            <i class="fa fa-instagram"></i>
            <i class="fa fa-linkedin"></i>
          </div>
        </div>
        <div class="col">
          <h3>Product</h3><br>
          <div class="line">
            <a href="course.php">Course management</a>
            <br><br>
            <a href="quiz.php">Quiz management</a>
            <br><br>
            <a href="summary.php">Summary</a>
            <br><br>
            <a href="GPA.php">GPA Calculator</a>
          </div>
        </div>
        <div class="col">
          <h3>Company</h3><br>
          <div class="line">
            <a href="aboutUs.php">About Us</a>
          </div>
        </div>
        <div class="col">
          <h3>Resources</h3><br>
          <div class="line">
            <a href="contactUs.php">Contact Us</a>
          </div>
        </div>
        <div class="copy">
          <p>Copyright �2023-2024</p>
        </div>
      </div>
    </footer>
    <script src="../JS/main.js"></script>
    <script>
      function downloadPDF() {
        const { jsPDF } = window.jspdf;
        const contentElement = document.getElementById("capture");
        const loadingOverlay = document.getElementById("loading");

        loadingOverlay.style.display = "flex";

        html2canvas(contentElement, {
          scale: 2,
        }).then((canvas) => {
          const imgData = canvas.toDataURL("image/png");
          const pdf = new jsPDF("p", "mm", "a4");
          const pdfWidth = pdf.internal.pageSize.getWidth();
          const pdfHeight = pdf.internal.pageSize.getHeight();
          const imgProps = pdf.getImageProperties(imgData);
          const imgWidth = imgProps.width;
          const imgHeight = imgProps.height;

          const ratio = imgWidth / imgHeight;
          const newHeight = pdfWidth / ratio;

          if (newHeight > pdfHeight) {
            const newWidth = pdfHeight * ratio;
            pdf.addImage(
              imgData,
              "PNG",
              (pdfWidth - newWidth) / 2,
              0,
              newWidth,
              pdfHeight
            );
          } else {
            pdf.addImage(imgData, "PNG", 0, 0, pdfWidth, newHeight);
          }

          pdf.save("download.pdf");
          loadingOverlay.style.display = "none";
        }).catch(() => {
          loadingOverlay.style.display = "none";
        });
      }

      document.addEventListener("DOMContentLoaded", function () {
        const loadingOverlay = document.getElementById("loading");
        loadingOverlay.style.display = "flex";

        // Simulated JSON data for demonstration
        const jsonData = {
          summarized_text: `
            **Heading 1**
            This is a paragraph of content.

            *Bullet point 1*
            *Bullet point 2*
          `
        };

        const contentElement = document.getElementById("content");
        const lines = jsonData.summarized_text.split("\n");

        lines.forEach((line) => {
          if (line.startsWith("**")) {
            const header = document.createElement("h2");
            header.textContent = line.replace(/\*\*/g, "");
            contentElement.appendChild(header);
          } else if (line.startsWith("*")) {
            const paragraph = document.createElement("p");
            paragraph.textContent = line.replace(/\*/g, "");
            contentElement.appendChild(paragraph);
          } else if (line.trim() === "") {
            const br = document.createElement("br");
            contentElement.appendChild(br);
          }
        });

        loadingOverlay.style.display = "none";
      });

      document.getElementById("search-input").addEventListener("input", function () {
        const searchTerm = this.value.trim();
        const contentElement = document.getElementById("content");

        const highlightedElements = contentElement.querySelectorAll(".highlight");
        highlightedElements.forEach(element => {
          element.classList.remove("highlight");
          element.innerHTML = element.textContent;
        });

        if (searchTerm !== "") {
          const regex = new RegExp(`({searchTerm})`, "gi");

          const textNodes = getTextNodes(contentElement);
          let firstMatchFound = false;

          textNodes.forEach(node => {
            const matches = node.textContent.match(regex);
            if (matches) {
              const newNode = document.createElement("span");
              newNode.innerHTML = node.textContent.replace(regex, '<span class="highlight">$1</span>');
              node.parentNode.replaceChild(newNode, node);

              if (!firstMatchFound) {
                newNode.scrollIntoView({ behavior: "smooth", block: "center" });
                firstMatchFound = true;
              }
            }
          });
        }
      });

      function getTextNodes(element) {
        const textNodes = [];
        function recursiveSearch(node) {
          if (node.nodeType === Node.TEXT_NODE) {
            textNodes.push(node);
          } else if (node.nodeType === Node.ELEMENT_NODE) {
            node.childNodes.forEach(child => recursiveSearch(child));
          }
        }
        recursiveSearch(element);
        return textNodes;
      }

      window.toggleSearchBar = function () {
        const searchInput = document.getElementById("search-input");
        if (searchInput.style.display === "none" || searchInput.style.display === "") {
          searchInput.style.display = "block";
        } else {
          searchInput.style.display = "none";
        }
      };
    </script>
  </body>
</html>
<?php 
 
} else {
  header("Location: index.php");
  exit();
} 
?>
