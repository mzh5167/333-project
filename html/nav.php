<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="./home.php">SPACE</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>

  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <!-- guest mode -->
      <?php if ($mode == 'guest') { ?>
        <li class="nav-item">
          <a class="nav-link" href="./login.php">Login</a>
        </li>
      <?php
      }
      ?>
      <!-- used mode -->
      <?php if ($mode == 'user') { ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle " href="#" role="button" data-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person"></i>
            Zeena
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="./edit-profile.php"><i class="bi bi-pencil"></i> Edit Profile</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="./history.php"><i class="bi bi-clock-history"></i> My History</a>
          </div>
        </li>
      <?php
      }
      ?>
      <li class="nav-item">
        <a class="nav-link" href="#">Contact Us</a>
      </li>

      <li class="nav-item dropdown">
        <div>
          <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
            <!-- Filter -->
            Filter
          </a>

          <form method="post" id="filter-form" action="./browse2.php" class="form">
            <div class="myitem" style="width:25rem;">
              <div class="dropdown-menu p-2">
                <ul class="list-group">

                  <div class="form-outline">
                    <label class="form-label" for="min"> Minimum Price</label>
                    <input type="number" name='min' id="min" class="form-control" placeholder='Minimum Price' min="1" />
                    <small style="visibility: hidden;color:orange;">please enter a number</small>
                  </div>
                  <div class="form-outline">
                    <label class="form-label" for="max"> Maximum Price</label>
                    <input type="number" name='max' id="max" class="form-control" placeholder='Maximum Price' min="1" /> <small style="visibility: hidden;color:orange;">please enter a number</small>
                  </div>

                  <div class="dropdown-divider"></div>

                  <li class="list-group-item">Categories:

                    <div class="form-check">
                      <input class="form-check-input" name='categories[]' type="checkbox" value="0#gaming" id="defaultCheck1" checked>
                      <label class="form-check-label" for="defaultCheck1">
                        PC Games
                      </label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input" name='categories[]' type="checkbox" value="1#vr" id="defaultCheck2" checked>
                      <label class="form-check-label" for="defaultCheck2">
                        VR Games
                      </label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input" name='categories[]' type="checkbox" value="2#room" id="defaultCheck3" checked>
                      <label class="form-check-label" for="defaultCheck3">
                        Rooms
                      </label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input" name='categories[]' type="checkbox" value="3#billiard" id="defaultCheck4" checked>
                      <label class="form-check-label" for="defaultCheck4">
                        Billiard
                      </label>
                    </div>
                    <small id="empty-category" style="visibility: hidden;">Choose at least one category</small>

                  </li>
                  <div class="dropdown-divider"></div>
                  <button type="submit" class="btn btn-info w-50" name="aplay" style="margin-left:auto;margin-right:auto">Apply</button>

                </ul>
              </div>
            </div>

          </form>
        </div>
      </li>
    </ul>
    <!-- Search Bar -->
    <form method="post" action="./browse2.php" class="form-inline my-2 my-lg-0">
      <div>
        <input class="form-control" name="search-val" id="live_search" type="text" placeholder="Search" aria-label="Search" style="position:relative;">
        <div class="list-group position-absolute mt-1" id="searchresult">
          <!-- search result will show here  -->
        </div>
      </div>
      <!-- orignal -->
      <input type="submit" name="submit-search" value="Search" class="btn btn-info"></input>
    </form>
  </div>
</nav>
<script src="./valide-filter.js"></script>