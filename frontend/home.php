<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css" />

  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
    crossorigin="anonymous"
  />
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
      <!-- Logo & Brand -->
      <img src="img/LOGO UNPAM 1.png" alt="Logo UNPAM" width="100px" />
      <a class="navbar-brand fw-bold" href="#">KELAS 02SIFE007</a>

      <!-- Toggler Button -->
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#offcanvasDarkNavbar"
        aria-controls="offcanvasDarkNavbar"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Sidebar (Offcanvas) -->
      <div
        class="offcanvas offcanvas-end text-bg-dark"
        tabindex="-1"
        id="offcanvasDarkNavbar"
        aria-labelledby="offcanvasDarkNavbarLabel"
      >
        <div class="offcanvas-header">
          <img src="img/LOGO UNPAM 1.png" alt="Logo UNPAM" width="60px" />
          <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">02SIFE007</h5>
          <button
            type="button"
            class="btn-close btn-close-white"
            data-bs-dismiss="offcanvas"
            aria-label="Close"
          ></button>
        </div>

        <div class="offcanvas-body">
          <!-- Navigation Links -->
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="home.php">
                <i class="bi bi-house-door-fill me-3"></i>Home
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="profil.php">
                <i class="bi bi-person-lines-fill me-3"></i>Profil
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="presensi.php">
                <i class="bi bi-clipboard2-check-fill me-3"></i>Presensi
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">
                <i class="bi bi-door-open-fill me-3"></i>Logout
              </a>
            </li>
          </ul>

          <!-- Dark Mode Toggle -->
          <div class="form-check form-switch mt-4 text-white">
            <input class="form-check-input" type="checkbox" id="modeToggle" />
            <label class="form-check-label" for="modeToggle">Dark Mode</label>
          </div>

          <!-- Search Form -->
          <form class="d-flex mt-3" role="search">
            <input
              class="form-control me-2"
              type="search"
              placeholder="Search"
              aria-label="Search"
            />
            <button class="btn btn-success" type="submit">Search</button>
          </form>
        </div>
      </div>
    </div>
  </nav>

  <!-- JavaScript -->
  <script src="script.js"></script>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
    crossorigin="anonymous"
  ></script>
</body>
</html>
