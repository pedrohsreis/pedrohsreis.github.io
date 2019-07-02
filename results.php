<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v2.1.14
* @link https://coreui.io
* Copyright (c) 2018 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->

<html lang="en">

<head>
  <base href="./">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
  <meta name="author" content="Łukasz Holeczek">
  <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
  <title>GitCollab</title>
  <!-- Icons-->
  <link rel="icon" type="image/ico" href="./img/favicon.ico" sizes="any" />
  <link href="node_modules/@coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
  <link href="node_modules/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
  <link href="node_modules/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="node_modules/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
  <!-- Main styles for this application-->
  <link href="css/style.css" rel="stylesheet">
  <link href="vendors/pace-progress/css/pace.min.css" rel="stylesheet">
  <!-- Global site tag (gtag.js) - Google Analytics-->
  <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());
    // Shared ID
    gtag('config', 'UA-118965717-3');
    // Bootstrap ID
    gtag('config', 'UA-118965717-5');
  </script>
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
  <header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">
      Git<b>Collab</b>
      <img class="navbar-brand-minimized" src="img/brand/sygnet.svg" width="30" height="30" alt="CoreUI Logo">
    </a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">

  </header>
  <div class="app-body">
    <div class="sidebar">
      <nav class="sidebar-nav">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="nav-icon icon-speedometer"></i> Página Inicial
            </a>
          </li>
        </ul>
      </nav>
      <button class="sidebar-minimizer brand-minimizer" type="button"></button>
    </div>
    <div style = "width: 600px; margin-left: 230px; margin-top: 20px">

<?php

    $ch = curl_init();

    $user = null;
    $userRepo = null;
    $repo = null;
    $content = null;

    $vetorCommits;
    $i = 0;

    if($_GET['user'])
        $user = $_GET['user'];
    if($_GET['userRepo'])
        $userRepo = $_GET['userRepo'];
    if($_GET['repo'])
        $repo = $_GET['repo'];
    if($_GET['contents'])
        $content = 1;

    if($repo && $userRepo && !$content){
        curl_setopt($ch, CURLOPT_USERAGENT, "Pedro Reis");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_URL, "https://api.github.com/repos/".$userRepo."/".$repo."/commits");

        $resp = curl_exec($ch);
        $json = json_decode($resp, true);
        curl_close($ch);


        if($json){
            foreach($json as $value){
                echo "Hash do commit: " . $value['sha'] . "<br>";
                echo "Mensagem: " . $value['commit']['message'] . "<br>";
                echo "Autor do commit: " . $value['commit']['author']['name'] . "<br>";
                echo "Email do committer: " . $value['commit']['author']['email'] . "<br>";
                echo "Data do commit: " . $value['commit']['author']['date'] . "<br>";
                echo "<br>";

                $vetorCommits[$i]['autor'] = $value['commit']['author']['name'];
                //echo "Autor no vetor: " .$vetorCommits[$i]['autor'];
                $vetorCommits[$i]['data'] = $value['commit']['author']['date'];
                $vetorCommits[$i]['mensagem'] = $value['commit']['message'];
                $i++;
            }
            $jsonCommits = json_encode($vetorCommits);
            
            echo "<a href = 'http://localhost/apigithub/results.json'><button style = 'margin-bottom: 20px' class='btn btn-sm btn-primary' style = 'text-align: center'>
            <i class='fa fa-dot-circle-o'></i> Baixar Json</button></a>";
            
            $fp = fopen('results.json', 'w');
            fwrite($fp, $jsonCommits);
            fclose($fp);

        }
    }

    if($repo && $userRepo && $content){
        curl_setopt($ch, CURLOPT_USERAGENT, "Pedro Reis");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_URL, "https://api.github.com/repos/".$userRepo."/".$repo."/contents");

        $resp = curl_exec($ch);
        $json = json_decode($resp, true);
        curl_close($ch);


        if($json){
            foreach($json as $value){
                echo "URL de download: " . $value['download_url'] . "<br>";
            }
            
        }
    }


    if($_GET['user']){

        curl_setopt($ch, CURLOPT_USERAGENT, "Pedro Reis");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_URL, "https://api.github.com/users/".$user);

        $resp = curl_exec($ch);
        $json = json_decode($resp, true);

        curl_close($ch);
        if($json){
            echo "<h1>Informações de Usuário - GitHub</h1><br><br>";
            echo "Nome de usuário: " . $json['login'] . "<br>";
            echo "Nº ID: " . $json['id']  . "<br>";
            echo "ID Node: " . $json['node_id'] . "<br>";
            echo "URL da image de avatar: " . $json['avatar_url'] . "<br>";
            echo "URL da requisição: " . $json['url'] . "<br>";
            echo "URL do Perfil do usuário: " . $json['html_url'] . "<br>";
            echo "Seguidores " . $json['followers_url'] . "<br>";
            echo "Seguindo: " . $json['following_url'] . "<br>";
            echo "Gists: " . $json['gists_url'] . "<br>";
            echo "Favoritos: " . $json['starred_url'] . "<br>";
            echo "Inscrições: " . $json['subscriptions_url'] . "<br>";
            echo "Organizações: " . $json['organizations_url'] . "<br>";
            echo "Repositórios (link): " . $json['repos_url'] . "<br>";
            echo "Eventos: " . $json['events_url'] . "<br>";
            echo "Eventos recebidos: " . $json['received_events_url'] . "<br>";
            echo "Tipo de usuário: " . $json['type'] . "<br>";
            echo "Empresa: " . $json['company'] . "<br>";
            echo "Localização: " . $json['location'] . "<br>";
            echo "Repositórios públicos: " . $json['public_repos'] . "<br>";
            echo "Primeiro acesso: " . $json['created_at'] . "<br>";
            echo "Última atualização: " . $json['updated_at'] . "<br>";

        }
        else {
            echo 'yep, its null';
        }
}

?>
</div>
</div>
 <footer class="app-footer">
    <div>
      <a href="https://coreui.io">CoreUI</a>
      <span>&copy; 2018 creativeLabs.</span>
    </div>
    <div class="ml-auto">
      <span>Powered by</span>
      <a href="https://coreui.io">CoreUI</a>
    </div>
  </footer>
  <!-- CoreUI and necessary plugins-->
  <script src="node_modules/jquery/dist/jquery.min.js"></script>
  <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
  <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="node_modules/pace-progress/pace.min.js"></script>
  <script src="node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
  <script src="node_modules/@coreui/coreui/dist/js/coreui.min.js"></script>
  <!-- Plugins and scripts required by this view-->
  <script src="node_modules/chart.js/dist/Chart.min.js"></script>
  <script src="node_modules/@coreui/coreui-plugin-chartjs-custom-tooltips/dist/js/custom-tooltips.min.js"></script>
  <script src="js/main.js"></script>
</body>

