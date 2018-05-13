<?php
try {
  $sql = new PDO('mysql:host=localhost;dbname=connectact;charset=utf8mb4;unix_socket=/tmp/mysql.sock', 'root', 'sunburst1121');
} catch ( PDOException $e ) {
  print "接続エラー:{$e->getMessage()}";
  $sql = null;
}

$stmt = $sql->prepare('
  SELECT
    User.account as account,
    User.mail as mail,
    User.password as password,
    Profile.last_name as last_name,
    Profile.first_name as first_name,
    Profile.last_name_kana as last_name_kana,
    Profile.first_name_kana as first_name_kana,
    Profile.birth_year as birth_year,
    Profile.birth_month as birth_month,
    Profile.birth_date as birth_date,
    Profile.gender as gender,
    Profile.nickname as nickname,
    Profile.message as message
  FROM
    User
  JOIN
    Profile
  ON
    User.object_id = Profile.user_id
  WHERE
    mail=?');
$stmt->bindValue(1, "sat.sunburst@gmail.com");
$stmt->execute();

$userList = $stmt->fetchAll();
$user = $userList[0];
?>
<!DOCTYPE html>
<html>
  <?php require_once  '../_src/inc/head.php'; ?>
  <body>
    <?php require_once  '../_src/inc/header.php'; ?>
    <main>
      <section>
        <h2>基本情報</h2>
        <table>
          <tr>
            <th>アカウント名</th>
            <td><?php echo $user['account'] ?></td>
          </tr>
          <tr>
            <th>メールアドレス</th>
            <td><?php echo $user['mail'] ?></td>
          </tr>
          <tr>
            <th>パスワード</th>
            <td><?php echo $user['password'] ?></td>
          </tr>
        </table>
      </section>
      <section>
        <h2>プロフィール</h2>

        <table>
          <tr>
            <th>名前</th>
            <td><?php echo $user['last_name']." ".$user['first_name'] ?></td>
          </tr>
          <tr>
            <th>フリガナ</th>
            <td><?php echo $user['last_name_kana']." ".$user['first_name_kana'] ?></td>
          </tr>
          <tr>
            <th>生年月日</th>
            <td><?php echo $user['birth_year']."年".$user['birth_month']."月".$user['birth_date']."日" ?></td>
          </tr>
          <tr>
            <th>性別</th>
            <td><?php
            if ($user['gender'] == 1) {
              echo "男";
            } else if ($user['gender'] == 2) {
              echo "女";
            } else {
              echo "その他";
            }
          ?></td>
          </tr>
          <tr>
            <th>ニックネーム（芸名）</th>
            <td><?php echo $user['nickname'] ?></td>
          </tr>
          <tr>
            <th>ひと言</th>
            <td><?php echo $user['message'] ?></td>
          </tr>
        </table>
      </section>
    </main>
    <?php require_once  '../_src/inc/footer.php'; ?>
  </body>
</html>
