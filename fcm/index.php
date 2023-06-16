<!doctype html>
<html lang="ko">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <link href="./css/style.css" rel="stylesheet">

  <title>FCM Push Notification</title>
</head>

<body>
  <main class="form-fcm">
    <form action="push_notification.php" method="post">
      <div class="text-center mb-4"><img src="http://taejintech.co.kr/img/m_logo.png" width="180" alt="태진테크" title=""></div>
       <select name="role" id="role" class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" required>
        <option selected>대상앱 선택</option>
        <option value="ROLE_GUEST">사용자</option>
        <option value="ROLE_ADMIN" selected>관리자</option>
        <option value="ROLE_ALL">전체</option>
      </select>
      <div class="form-floating">
        <input type="text" name="title" class="form-control" id="title" placeholder="title" value="공지사항" required>
        <label for="title">title</label>
      </div>
      <div class="form-floating">
        <textarea name="message" rows="4" class="form-control" id="message" placeholder="message" required></textarea>
        <label for="message">message</label>
      </div>      
      <button class="w-100 btn btn-lg btn-danger" id="btn-send" type="submit">SEND</button>
    </form>    
    <p class="mt-2 mb-3 text-muted text-center">&copy; 2021</p>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>