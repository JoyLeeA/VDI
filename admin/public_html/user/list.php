<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/_include/head.php") ?>
<?php
$temp = $_db->prepare("SELECT user.idx, user.name, user.username, spec.name AS spec_name, spec.cpu, spec.ram, spec.hdd FROM user JOIN specification AS spec ON user.specification_idx=spec.idx WHERE user.delete_datetime='0000-00-00 00:00:00'");
$temp->execute();
$result = $temp->get_result();
?>
  <div class="ui main text container">
    <h1 class="ui header">특수 사용자 리스트</h1>
    <p>본 페이지에서는 특수 사용자들을 관리합니다.</p>

	<div class="column">
    <table class="ui celled selectable center aligned table">
      <thead>
        <th>특수 사용자 이름</th>
        <th>아이디</th>
        <th>할당된 instance 이름</th>
        <th>고정 사양 이름</th>
        <th>권한 삭제</th>
      </thead>
      <tbody>
	  	<?php while($row = $result->fetch_object()){ ?>
        <tr>
          <td><?=$row->name?></td>
		  <td><?=$row->username?></td>
		  <td>instance-001(???)</td>
		  <td><?=$row->name?>(<?=$row->cpu?>Cores / RAM <?=$row->ram?>GB / HDD <?=$row->hdd?>GB)</td>
          <td><button class="red ui button" onclick="location.href='/_module/user?type=delete&idx=<?=$row->idx?>'">삭제</button></td>
        </tr>
		<?php } ?>
      </tbody>
    </table>
  </div>

  </div>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/_include/foot.php") ?>