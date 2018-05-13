<header class="site-header">
  <div class="inner">
    <h1 class="logo"><a href="/">ConnectAct</a></h1>
    <div class="global-navi">
      <ul>
        <li>
          <?php if (isset($_SESSION["user_id"])): ?>
            <a href="/logout.php">ログアウト</a>
          <?php else: ?>
            <a href="/signin.php">新規登録 / ログイン</a>
          <?php endif; ?>
        </li>
      </ul>
    </div>
  </div>
</header>
