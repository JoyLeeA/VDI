<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/_include/login.head.php"); ?>

<div class="ui middle aligned center aligned grid">
  <div class="column">
    <h2 class="ui teal image header">
      <div class="content">
        VDI System
      </div>
    </h2>
    <form class="ui large form" action="/_module/login" method="POST">
      <div class="ui stacked segment">
        <div class="field">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input type="text" name="username" placeholder="관리자 아이디">
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input type="password" name="password" placeholder="관리자 비밀번호">
          </div>
        </div>
        <div class="ui fluid large teal submit button">로그인</div>
      </div>

      <div class="ui error message"></div>

    </form>

  </div>
</div>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/_include/login.foot.php") ?>
