<?php
require_once '../../_src/database/database.php';

$db = getDB();
if (!empty($_POST['mail']) && !empty($_POST['password'])) {
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

  $stmt = $db->prepare("INSERT INTO User (mail, password, updated_at) VALUES (?, ?, NOW())");
  $stmt->bindValue(1, $_POST["mail"]);
  $stmt->bindValue(2, $password);

  if($stmt->execute()) {
    $insertId = $db->lastInsertId('id');

    $stmt = $db->prepare("UPDATE User SET object_id=? WHERE id=?");
    $stmt->bindValue(1, "user-".$insertId);
    $stmt->bindValue(2, $insertId);
    if ($stmt->execute()) {
      header('Location: ../../login/');
    }
  } else {
    $status = "failed";
  }
}
?>
<!DOCTYPE html>
<html>
  <?php require_once '../../_src/inc/head.php'; ?>
  <body>
    <?php require_once '../../_src/inc/header.php'; ?>
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
              <th>パスワード（確認）</th>
              <td><input type="password" name="password_validate" /></td>
            </tr>
            <tr>
              <td colspan="2"><button type="submit">登録</button></td>
            </tr>
          </table>
        </form>
      </section>
    </main>
    <?php require_once '../../_src/inc/footer.php'; ?>
  </body>
</html>
