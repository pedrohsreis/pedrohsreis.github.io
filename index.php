<html>

<?php

    $ch = curl_init();

    $user = $_GET['user'];

    curl_setopt($ch, CURLOPT_USERAGENT, "Pedro Reis");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_URL, "https://api.github.com/users/".$user);

    $resp = curl_exec($ch);
    $json = json_decode($resp, true);

    curl_close($ch);

    if($json){
        echo "<h'>Informações de Usuário - GitHub</h1><br><br>";
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

?>

</html>