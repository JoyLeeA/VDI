<?php define('is_admin', true); ?>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/_include/init.php"); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <title>VDI System</title>

  <link rel="stylesheet" type="text/css" href="//semantic-ui.com/dist/components/reset.css">
  <link rel="stylesheet" type="text/css" href="//semantic-ui.com/dist/components/site.css">

  <link rel="stylesheet" type="text/css" href="//semantic-ui.com/dist/components/container.css">
  <link rel="stylesheet" type="text/css" href="//semantic-ui.com/dist/components/grid.css">
  <link rel="stylesheet" type="text/css" href="//semantic-ui.com/dist/components/header.css">
  <link rel="stylesheet" type="text/css" href="//semantic-ui.com/dist/components/image.css">
  <link rel="stylesheet" type="text/css" href="//semantic-ui.com/dist/components/menu.css">
  <link rel="stylesheet" type="text/css" href="//semantic-ui.com/dist/components/table.css">
  <link rel="stylesheet" type="text/css" href="//semantic-ui.com/dist/components/button.css">
  <link rel="stylesheet" type="text/css" href="//semantic-ui.com/dist/components/input.css">

  <link rel="stylesheet" type="text/css" href="//semantic-ui.com/dist/components/divider.css">
  <link rel="stylesheet" type="text/css" href="//semantic-ui.com/dist/components/list.css">
  <link rel="stylesheet" type="text/css" href="//semantic-ui.com/dist/components/segment.css">
  <link rel="stylesheet" type="text/css" href="//semantic-ui.com/dist/components/dropdown.css">
  <link rel="stylesheet" type="text/css" href="//semantic-ui.com/dist/components/icon.css">

  <link rel="stylesheet" type="text/css" href="/_assets/css/main.css">

</head>
<body>

  <div class="ui fixed inverted menu">
    <div class="ui container">
      <a href="/client/" class="header item">
        VDI System
      </a>

      <a class="item" href="/client/list"> 실습실 장비 관리</a>

      <div class="ui simple dropdown item"> 서버 장비 관리 <i class="dropdown icon"></i>
        <div class="menu">
		  <a class="item" href="/server/infra">Compute 서비스 관리</a>
		  <a class="item" href="/server/compute">Block Storage 서비스 관리</a>
		  <a class="item" href="/server/storage">네트워크 에이전트 관리</a>
		  <a class="item" href="https://vdi-openstack.nerd.kim/" target="_blank">OpenStack 관리자 페이지(새창)</a>
		  <a class="item" href="http://vdi-maas.nerd.kim/" target="_blank">MaaS 관리자 페이지(새창)</a>
        </div>
      </div>

      <div class="ui simple dropdown item"> 가상 데스크탑 환경 관리 <i class="dropdown icon"></i>
        <div class="menu">
          <a class="item" href="/desktop/specification/list">고정 사양 리스트</a>
          <a class="item" href="/desktop/specification/new">고정 사양 신규 등록</a>
          <a class="item" href="/desktop/specification/default">실습실 기본 가상 환경 설정</a>
          <a class="item" href="/desktop/image/list">운영체제 리스트</a>
		  <a class="item" href="/desktop/image/new">운영체제 신규 등록</a>
        </div>
      </div>

      <div class="ui simple dropdown item"> 특수 사용자 관리 <i class="dropdown icon"></i>
        <div class="menu">
          <a class="item" href="/user/list">특수 사용자 리스트</a>
		  <a class="item" href="/user/new">특수 사용자 신규 등록</a>
        </div>
      </div>

      <div class="ui simple dropdown item"> 기타 <i class="dropdown icon"></i>
        <div class="menu">
          <a class="item" href="/license/status">라이센스 상황 관리</a>
		  <a class="item" href="/_module/logout">로그아웃</a>
        </div>
      </div>

    </div>
  </div>
