<?php
  require "../includes/config.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $config['title']; ?></title>

  <!-- Bootstrap Grid -->
  <link rel="stylesheet" type="text/css" href="../media/assets/bootstrap-grid-only/css/grid12.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

  <!-- Custom -->
  <link rel="stylesheet" type="text/css" href="../media/css/style.css">
</head>
<body>

  <div id="wrapper">

  <?php include "../includes/header.php"; ?>
  <?php 
    $article = mysqli_query($connection, "SELECT * FROM `courses` WHERE `id` = ". (int)$_GET['id']);
    if( mysqli_num_rows($article) <= 0)
    {
  ?>
    <div id="content">
      <div class="container">
        <div class="row">
          <section class="content__left col-md-8">
            <div class="block">
              <h3><?php echo $art['title']; ?></h3>
              <div class="block__content">
                <img src="../media/images/post-image.jpg">
                <div class="full-text">
                  Такого курсу в нас немає!
               </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
    <?php
    } else {
      $art = mysqli_fetch_assoc($article);
      mysqli_query($connection,"UPDATE `courses` SET `views` = `views` + 1 WHERE `id` = ". (int) $art['id']);
    ?>
    <div id="content">
      <div class="container">
        <div class="row">
          <section class="content__left col-md-8">
            <div class="block">
              <a><?php echo $art['views']; ?> переглядів</a>
              <h3><?php echo $art['title']; ?></h3>
              <div class="block__content">
                <img src="<?php echo $art['image']; ?>" style="max-width: 100%">
                <div class="full-text">
                <?php echo $art['text']; ?>
                </div>
              </div>
            </div>

            <div class="block">
              <a href="#comment-add-form">Додати свій</a>
              <h3>Коментарі до курсу</h3>
              <div class="block__content">
                <div class="articles articles__vertical">
                <?php 
                $comments = mysqli_query($connection,"SELECT * FROM `comments` WHERE `articles_id` = " . (int) $art['id'] . " ORDER BY `id` DESC ");
                ?>
                <?php
                if(mysqli_num_rows($comments) <= 0){
                  echo "No comments";
                }else{
                while($comment = mysqli_fetch_assoc($comments)){
                ?>
                  <article class="article">
                    <div class="article__image" style="background-image: url(https://www.gravatar.com/avatar/<?php echo md5($comment['email']); ?>?s=125);"></div>
                    <div class="article__info">
                      <a href="./article.php?id=<?php echo $comment['id']; ?>"><?php echo $comment['nickname']; ?></a>
                      <div class="article__info__meta">
                      </div>
                      <div class="article__info__preview"><?php echo mb_substr($comment['text'], 0, 50, 'utf-8'); ?></div>
                    </div>
                  </article>
                <?php
                }}
                ?>

                </div>
              </div>
            </div>

            <div class="block" id="comment-add-form">
              <h3>Додати коментар</h3>
              <div class="block__content">
                <form class="form" method="POST" >
                  <?php 
                    if( isset($_POST['do_post'])){
                      $errors = array();
                      if( $_POST ['name'] == ''){
                        $errors[] = 'Input name!';
                      }
                      if( $_POST ['nickname'] == ''){
                        $errors[] = 'Input nickname!';
                      }
                      if( $_POST ['email'] == ''){
                        $errors[] = 'Input email!';
                      }
                      if( $_POST ['text'] == ''){
                        $errors[] = 'Input text!';
                      }
                      if(empty($errors)){
                        mysqli_query($connection,"INSERT INTO `comments` (`author`, `nickname`, `email`, `text`, `pubdate`, `articles_id`) 
                        VALUES ('".$_POST['name']."', '".$_POST['nickname']."', '".$_POST['email']."', '".$_POST['text']."', NOW(), '".$art['id']."')");
                      }else {
                        echo $errors[0];
                      }
                    }
                  ?>
                  <div class="form__group">
                    <div class="row">
                      <div class="col-md-6">
                        <input type="text" class="form__control"  name="name" placeholder="Ім'я" value="<?php echo $_POST['name']; ?>"> 
                      </div>
                      <div class="col-md-6">
                        <input type="text" class="form__control" required="" name="nickname" placeholder="Нік" value="<?php echo $_POST['nickname']; ?>">
                      </div>
                      <div class="col-md-6">
                        <input type="text" class="form__control" required="" name="email" placeholder="email" value="<?php echo $_POST['email']; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="form__group">
                    <textarea name="text" required="" class="form__control" placeholder="Текст коментаря ..."><?php echo $_POST['email']; ?></textarea>
                  </div>
                  <div class="form__group">
                    <input type="submit" class="form__control" name="do_post" value="Додати коментар" action="/article.php?id=<?php echo art['id']; ?>#comment-add-form">
                  </div>
                </form>
              </div>
            </div>
          </section>
          <section class="content__right col-md-4">
          <?php include "../includes/sidebar.php"; ?>
          </section>
        </div>
      </div>
    </div>
    <?php 
    }
    ?>
    <!-- <?php include "../includes/footer.php"; ?> -->

  </div>

</body>
</html>