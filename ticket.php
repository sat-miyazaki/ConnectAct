<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <?php require_once  './_src/inc/head.php'; ?>
  <body class="ticket">
    <?php require_once  './_src/inc/header.php'; ?>
    <main>
      <div class="contents-area">
      </div>
    </main>
    <?php require_once  './_src/inc/footer.php'; ?>

    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="/_assets/libs/slick/slick.min.js"></script>

    <script type="text/javascript">
      $(document).ready(function(){
        $('.photo-list').slick({
          infinite: false,
          slidesToShow: 3,
          slidesToScroll: 1
        });
      });
    </script>
  </body>
</html>
