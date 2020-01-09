<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/_include/head.php") ?>
<?php
$temp = $_db->prepare("SELECT * FROM `os` WHERE os.delete_datetime='0000-00-00 00:00:00'");
$temp->execute();
$result = $temp->get_result();
?>

  <div class="ui main text container">
    <h1 class="ui header">고정 사양 신규 등록</h1>
    <p>본 페이지에서는 가상 데스크톱 환경에 알맞은 사양을 관리합니다.</p>

	<div class="column">
    <table class="ui celled selectable center aligned table">

      <tbody>

	  	<form id="submit_form" method="POST" action="/_module/specification">
		<input type="hidden" name="type" value="new" />
        <tr>
          <td>명칭</td>
		  <td><div class="ui input"><input type="text" name="name"></div></td>
        </tr>
        <tr>
          <td>CPU</td>
		  <td><div class="ui input"><input type="text" name="cpu"></div></td>
        </tr>
        <tr>
          <td>RAM</td>
		  <td><div class="ui input"><input type="text" name="ram"></div></td>
        </tr>
        <tr>
          <td>HDD</td>
		  <td><div class="ui input"><input type="text" name="hdd"></div></td>
        </tr>
        <tr>
          <td>OS</td>
		  <td>
			<select class="ui dropdown" name="os_idx">
			  <option value="">선택</option>
	  			<?php while($row = $result->fetch_object()){ ?>
			  <option value="<?=$row->idx?>"><?=$row->name?></option>
			  <?php } ?>
			</select>
		  </td>
        </tr>
		</form>

        <tr>
          <td colspan="2"><button class="green ui button" id="submit_button" name="submit_button">추가</button></td>
        </tr>
      </tbody>
    </table>
  </div>

  </div>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/_include/foot.php") ?>