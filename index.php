<html>
    <h3>Busca de usuário</h3>
    <form method = "get">
        <input type = "text" placeholder = "Usuário" name = "user"/>
        <input type = "submit" action = "http://localhost/apigit" />
        <input type = "text" placeholder = "Usuário" name = "userRepo" hidden/>
        <input type = "text" placeholder = "Repositório" name = "repo" hidden/>
    </form>
    <h3>Listar commits</h3>
    <form method = "get">
        <input type = "text" hidden name = "user" value = ""/>
        <input type = "text" placeholder = "Usuário" name = "userRepo"/>
        <input type = "text" placeholder = "Repositório" name = "repo" />
        <input type = "submit" action = "http://localhost/apigit" />
    </form>


<?php

    $ch = curl_init();

    $user = null;
    $userRepo = null;
    $repo = null;

    if($_GET['user'])
        $user = $_GET['user'];
    if($_GET['userRepo'])
        $userRepo = $_GET['userRepo'];
    if($_GET['repo'])
        $repo = $_GET['repo'];

    if($repo && $userRepo){
        curl_setopt($ch, CURLOPT_USERAGENT, "Pedro Reis");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_URL, "https://api.github.com/repos/".$userRepo."/".$repo."/commits");

        $resp = curl_exec($ch);
        $json = json_decode($resp, true);
        curl_close($ch);

        if($json){
            foreach($json as $value){
                echo "Hash do commit: " . $value['sha'] . "<br>";
                echo "Autor: " . $value['author'] . "<br>";
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

</html>