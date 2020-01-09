<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/_include/head.php") ?>
<?php
$temp = $_db->prepare("SELECT * FROM `specification` WHERE delete_datetime='0000-00-00 00:00:00'");
$temp->execute();
$result = $temp->get_result();
?>
  <div class="ui main text container">
    <h1 class="ui header">특수 사용자 신규 등록</h1>
    <p>본 페이지에서는 특수 사용자들을 관리합니다.</p>

	<div class="column">
    <table class="ui celled selectable center aligned table">

      <tbody>
	  
	  	<form id="submit_form" method="POST" action="/_module/user">
		<input type="hidden" name="type" value="new" />

        <tr>
          <td>특수 사용자 이름</td>
		  <td><div class="ui input"><input type="text" name="name"></div></td>
        </tr>
        <tr>
          <td>아이디</td>
		  <td><div class="ui input"><input type="text" name="username"></div></td>
        </tr>
        <tr>
          <td>비밀번호</td>
		  <td><div class="ui input"><input type="password" name="password"></div></td>
        </tr>
        <tr>
          <td>고정 사양 선택</td>
		  <td>
			<select class="ui dropdown" name="spec_idx">
		  <option value="">선택</option>
	  	<?php while($row = $result->fetch_object()){ ?>
		  <option value="<?=$row->idx?>"><?=$row->name?>(<?=$row->cpu?>Cores / RAM <?=$row->ram?>GB / HDD <?=$row->hdd?>GB)</option>
		  <?php } ?>
		</select>
		</td>
        </tr>
        <tr>
          <td colspan="2"><button class="green ui button" id="submit_button" name="submit_button">추가</button></td>
        </tr>

		</form>

      </tbody>
    </table>
  </div>

  </div>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/_include/foot.php") ?>