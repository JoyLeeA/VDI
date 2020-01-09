<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/_include/head.php") ?>

  <div class="ui main text container">
    <h1 class="ui header">운영체제 리스트</h1>
    <p>본 페이지에서는 운영체제(OS)들을 관리합니다.</p>

	<div class="column">
    <table class="ui celled selectable center aligned table">
      <thead>
        <th>명칭</th>
        <th>image 파일 이름</th>
        <th>삭제</th>
      </thead>
      <tbody>
        <tr>
          <td>Windows 10 Education</td>
		  <td>Windows_10_Education.iso</td>
          <td><button class="red ui button">삭제</button></td>
        </tr>
        <tr>
          <td>Ubuntu 18.04 Desktop</td>
          <td>Ubuntu_18_04_Desktop.iso</td>
          <td><button class="red ui button">삭제</button></td>
        </tr>
      </tbody>
    </table>
  </div>

  </div>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/_include/foot.php") ?>