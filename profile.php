<?php include_once "includes/header.php" ?>

<div class="inner-page-contents">
  <div style="height: 100%; width: 100%; display: grid; grid-template-columns: 500px 1fr;">
    <div class="profile-column">
      <div class="profile-info-container">
        <div class="profile-info-header">
          <h1 style="font-size: 1.25em;">My Information</h1>
        </div>
        <div class="profile-info">
          <div class="profile-photo">
            <i class="far fa-user-circle"></i>
          </div>
          <div class="profile-contents">
            <h1 style="font-size: 2.5em; font-weight: 700; margin-top: 20px;">USERNAME</h1>
            <h2 style="font-size: 1.5em; font-weight: 700; margin-top: 10px;">(ID #000000)</h2>
            <p style="color: black; padding: 50px 75px; font-size: 1.25em;">This is my profile's description! My team is the best!</p>
          </div>
          <button class="profile-button"> <i class="fas fa-pencil-alt"></i> Edit Profile </button>
        </div>
      </div>
    </div>
    <div class="profile-column"></div>
  </div>
</div>

<?php include_once "includes/footer.php" ?>
