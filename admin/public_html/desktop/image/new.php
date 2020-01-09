<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/_include/head.php") ?>

  <div class="ui main text container">
    <h1 class="ui header">운영체제 신규 등록</h1>
    <p>본 페이지에서는 운영체제(OS)들을 관리합니다.</p>

	<div class="column">
    <table class="ui celled selectable center aligned table">
      <tbody>
        <tr>
          <td>명칭</td>
		  <td><div class="ui input"><input type="text" name="name"></div></td>
        </tr>
        <tr>
          <td>OS image 파일 선택</td>
		  <td><div class="ui input"><input type="file" name="os_image"></div></td>
        </tr>
        <tr>
          <td colspan="2"><button class="green ui button">추가</button></td>
        </tr>
      </tbody>
    </table>
  </div>

  </div>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/_include/foot.php") ?>