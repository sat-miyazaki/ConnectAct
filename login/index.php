<?php
require_once '../_src/database/database.php';

session_start();

if (!empty($_POST["mail"]) && !empty($_POST["password"])) {
  $db = getDB();
  $stmt = $db->prepare("SELECT object_id, mail, password FROM User WHERE mail=?");
  $stmt->bindValue(1, $_POST["mail"]);
  if ($stmt->execute()) {
    $rowCount = $stmt->rowCount();
    if ($rowCount == 1) {
      $userList = $stmt->fetchAll();
      $user = $userList[0];
      if(password_verify($_POST["password"], $user["password"])){
        $_SESSION["user_id"] = $user["object_id"];
        header('Location: ../');
      } else {
         $error = "パスワードが間違っています。";
      }
    } else {
      $error = "メールアドレスが存在しません。";
    }
  } else {
    $error = "クエリエラー";
  }
}
?>
<!DOCTYPE html>
<html>
  <?php require_once '../_src/inc/head.php'; ?>
  <body>
    <?php require_once '../_src/inc/header.php'; ?>
    <main>
      <section>
        <form class="" action="./" method="post">
          <table>
            <tr>
              <th>メールアドレス</th>
              <td><input type="mail" name="mail" /></td>
            </tr>
            <tr>
              <th>パスワード</th>
              <td><input type="password" name="password" /></td>
            </tr>
            <tr>
              <td colspan="2"><button type="submit">ログイン</button></td>
            </tr>
          </table>
        </form>
      </section>
    </main>
    <?php require_once '../_src/inc/footer.php'; ?>
  </body>
</html>
