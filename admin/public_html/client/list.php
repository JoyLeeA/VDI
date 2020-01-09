<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/_include/head.php"); ?>
<?php
$temp = $_db->prepare("SELECT idx, name, status FROM `client` WHERE delete_datetime='0000-00-00 00:00:00'");
$temp->execute();
$result = $temp->get_result();
?>
  <div class="ui main text container">
    <h1 class="ui header">전체 실습실 장비 상황 확인</h1>
    <p>본 페이지에서는 실습실의 전체 장비 상황을 확인하실 수 있습니다.</p>

	<div class="column">
    <table class="ui celled selectable center aligned table">
      <thead>
        <th>장비이름</th>
        <th>전원 상태</th>
        <th>장비 권한 제거</th>
      </thead>
      <tbody>
<?php
$compute = $openstack->computeV2(['region' => '{region}']);

$servers = $compute->listServers(['imageId' => '{imageId}']);

foreach ($servers as $server) {
}
?>

	  	<?php while($row = $result->fetch_object()){ ?>
        <tr>
          <td><?=$row->status?></td>
          <td style="background-color: <?=$row->status == 'On' ? 'green' : 'red'?>"><?=$row->status?></td>
          <td><button class="red ui button" onclick="location.href='/_module/client?type=delete&idx=<?=$row->idx?>'">삭제</button></td>
        </tr>
		<?php } ?>
      </tbody>
    </table>
  </div>

  </div>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/_include/foot.php") ?>