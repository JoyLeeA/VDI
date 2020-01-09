<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/_include/head.php") ?>
<?php
$temp = $_db->prepare("SELECT spec.idx, spec.name AS spec_name, spec.cpu, spec.ram, spec.hdd, os.name AS os_name FROM specification AS spec JOIN os ON spec.os_idx=os.idx WHERE spec.delete_datetime='0000-00-00 00:00:00'");
$temp->execute();
$result = $temp->get_result();
?>

  <div class="ui main text container">
    <h1 class="ui header">고정 사양 리스트</h1>
    <p>본 페이지에서는 가상 데스크톱 환경에 알맞은 사양을 관리합니다.</p>

	<div class="column">
    <table class="ui celled selectable center aligned table">
      <thead>
        <th>명칭</th>
        <th>CPU</th>
        <th>RAM</th>
        <th>HDD</th>
        <th>OS</th>
        <th>삭제</th>
      </thead>
      <tbody>
	  	<?php while($row = $result->fetch_object()){ ?>
		<?php
		$temp_os = $_db->prepare("SELECT * FROM `specification` WHERE delete_datetime='0000-00-00 00:00:00'");
		$temp->execute();
		$result_os = $temp->get_result();
		$result_os = $result_os->fetch_object();
		?>
        <tr>
          <td><?=$row->spec_name?></td>
		  <td><?=$row->cpu?>Core</td>
		  <td><?=$row->ram?>GB</td>
		  <td><?=$row->hdd?>GB</td>
		  <td><?=$row->os_name?></td>
          <td><button class="red ui button" onclick="location.href='/_module/specification?type=delete&idx=<?=$row->idx?>'">삭제</button></td>
        </tr>
		<?php } ?>
      </tbody>
    </table>
  </div>

  </div>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/_include/foot.php") ?>