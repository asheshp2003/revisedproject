<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Anupam</title>
    <link rel="stylesheet" href="./css/all.min.css" />
    <link rel="stylesheet" href="./css/style.css" />
  </head>
  <body>
    <header class="page-header">
      <div class="wrapper">
      <nav class="main-nav">
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#footer">Contact</a></li>
            <li><a href="signup.php">Sign-Up / Sign-In</a></li>

          </ul>
        </nav>
      </div>
    </header>

    <main>
      <div class="banner"></div>

      <div class="articles" id="about">
        <div class="wrapper">
          <article>
            <h2>Anupam Foodland and Banquet</h2>
            <p class="quote">Welcome to Anupam Foodland and Banquet</p>
            <p class="text">
              Located in the vibrant heart of Nepal, Anupam Foodland and Banquet
              stands as a beacon of culinary excellence and unparalleled event
              experiences. Since our inception, we have been committed to
              redefining hospitality with a seamless blend of exquisite
              cuisines, warm ambiance, and meticulous service. Whether it's a
              cherished family gathering, an elegant wedding, or a corporate
              milestone, we take pride in being the preferred choice for
              unforgettable celebrations.
            </p>
            <p class="text">
              Anupam Foodland has successfully hosted over 100s of anniversary
              events with 5-star customer satisfaction. As an ISO 22000:2018
              food management and safety standards banquet, we maintain the
              highest of standards ensuring your wedding events are truly
              memorable and mesmerizing.
            </p>
          </article>

          <article>
            <h2>Our Venues</h2>
            <div class="carousel-container">
              <div class="carousel" id="carousel">
                <?php
                include 'connect.php'; 
                $query = "SELECT name, capacity, description, image_path FROM venue";
                $result = $conn->query($query);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                  <div class="carousel-slide">
                    <div class="card">
                      <img
                        src="<?php echo htmlspecialchars($row['image_path']); ?>"
                        alt="Venue Image"
                        class="card-image"
                      />
                      <div class="card-content">
                        <h3 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h3>
                        <h4 class="card-subtitle">Capacity - <?php echo htmlspecialchars($row['capacity']); ?> pax</h4>
                        <p class="card-description">
                          <?php echo htmlspecialchars($row['description']); ?>
                        </p>
                      </div>
                    </div>
                  </div>
                <?php
                    }
                } else {
                    echo "<p>No venues available at the moment.</p>";
                }
                ?>
              </div>
              <button class="carousel-button carousel-button-prev" onclick="document.getElementById('carousel').scrollBy(-300, 0)">
                &#10094;
              </button>
              <button class="carousel-button carousel-button-next" onclick="document.getElementById('carousel').scrollBy(300, 0)">
                &#10095;
              </button>
            </div>
          </article>
        </div>
      </div>
    </main>

    <footer class="page-footer" id="footer">
      <div class="wrapper">
        <div style="display: flex; justify-content: space-between">
          <div class="footer-col" style="margin-bottom: 24px">
            <h3>Contact Us</h3>
            <ul>
              <li>Phone: 9828884062</li>
              <li>Email: anupamfoodland@gmail.com</li>
              <li>Old Baneshwor, Kathmandu</li>
            </ul>
          </div>
          <div class="footer-col social">
            <h3>Social</h3>
            <ul>
              <li>
                <a href="#" class="fb"><i class="fab fa-facebook"></i></a>
              </li>
              <li>
                <a href="#" class="tw"><i class="fab fa-twitter"></i></a>
              </li>
              <li>
                <a href="#" class="gp"><i class="fab fa-google"></i></a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>

  
  </body>
</html>