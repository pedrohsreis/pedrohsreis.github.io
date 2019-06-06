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
        <input hidden value = "" name = "contents" />
        <input type = "text" placeholder = "Usuário" name = "userRepo"/>
        <input type = "text" placeholder = "Repositório" name = "repo" />
        <input type = "submit" action = "http://localhost/apigit" />
    </form>


    <?php if($_GET['userRepo'] && $_GET['repo']) { ?>

        <h2>Fazer download de conteúdo</h2>
        <form method = "get">
            <input hidden value = "1" name = "contents" />
            <input type = "text" hidden name = "user" value = ""/>
            <input hidden value = <?php echo $_GET['userRepo']; ?> name = "userRepo" />
            <input hidden value = <?php echo $_GET['repo'] ?> name = "repo" />
            <input type = "submit" value = "Buscar conteúdo" action = "http://localhost/apigit" />
        </form>

    <?php } ?>

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
            
            echo $jsonCommits;
            
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

</html>