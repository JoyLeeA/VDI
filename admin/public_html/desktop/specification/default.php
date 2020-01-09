<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/_include/head.php") ?>
<?php
$temp = $_db->prepare("SELECT * FROM `specification` WHERE delete_datetime='0000-00-00 00:00:00'");
$temp->execute();
$result = $temp->get_result();
?>

  <div class="ui main text container">
    <h1 class="ui header">실습실 기본 가상 환경 설정</h1>
    <p>본 페이지에서는 실습실의 기본 가상 환경을 설정합니다.</p>

	<div class="column">
    <table class="ui celled selectable center aligned table">

      <tbody>
	  
	  	<form id="submit_form" method="POST" action="/_module/specification">
		<input type="hidden" name="type" value="default" />

        <tr>
          <td>기본 환경</td>
		  <td>
			<select class="ui dropdown" name="idx">
		  <option value="">선택</option>
	  	<?php while($row = $result->fetch_object()){ ?>
		  <option value="<?=$row->idx?>"<?=$row->is_default == 'Y' ? " selected" : ""?>><?=$row->name?>(<?=$row->cpu?>Cores / RAM <?=$row->ram?>GB / HDD <?=$row->hdd?>GB)</option>
		  <?php } ?>
		</select>
		</td>
        </tr>

        <tr>
          <td colspan="2"><button class="green ui button" id="submit_button" name="submit_button">변경</button></td>
        </tr>

		</form>

      </tbody>
    </table>
  </div>

  </div>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/_include/foot.php") ?>