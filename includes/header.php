<?php include "../includes/config.php" ?>
<header id="header">
      <!-- <div class="header__top">
        <div class="container">
          <div class="header__top__logo">
            <h1><?php 
              echo $config['title']; 
              ?></h1>
          </div>
          <nav class="header__top__menu">
            <ul>
              <li><a href="index.php">Главная</a></li>
              <li><a href="about_me.php">Обо мне</a></li>
              <li><a href="https://vk.com">Я Вконтакте</a></li>
            </ul>
          </nav>
        </div>
      </div> -->
        <?php 
        $categories = mysqli_query($connection,"SELECT * FROM `categories`");
        ?>
      <div class="header__bottom">
        <div class="container">
          <nav>
            <ul>
                <?php 
                while( $cat = mysqli_fetch_assoc($categories)){
                ?>
              <li><a href="articles.php?categorie=<?php echo $cat[id]; ?>"><?php echo $cat['title']; ?></a></li>
              <?php
                }
                ?>
            </ul>
          </nav>
        </div>
      </div>
    </header>