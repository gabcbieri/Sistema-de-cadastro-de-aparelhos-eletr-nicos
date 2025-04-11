<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cálculo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
$arquivo = 'cadastros.json';
$cadastro_sucesso = false; // nao sei se o cadastro deu certo

function campoVazio($campo) {
    return !isset($_POST[$campo]) || trim($_POST[$campo]) === ''; // ve se o campo ta vazio
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $erros = [];

    foreach (['Aparelho', 'Watts', 'Horas', 'Dias', 'Valor'] as $campo) {
        if (campoVazio($campo)) {
            $erros[] = "O campo {$campo} é obrigatório.";
        }
    }

    if (!empty($erros)) {
        echo "<h3>Preencha todos os campos obrigatórios:</h3><ul>";
        foreach ($erros as $erro) {
            echo "<li>$erro</li>";
        }
        echo "</ul>";
        echo "<p><a href='form_cadastro.php'>Voltar</a></p>"; // link pra voltar pro formulario
    } else {
        $cadastro_sucesso = true;
        echo "<h1>Aparelho cadastrado</h1>";

        $aparelho = htmlspecialchars($_POST['Aparelho']); // chama as variáveis
        $watts = floatval($_POST['Watts']);
        $horas = floatval($_POST['Horas']);
        $dias = intval($_POST['Dias']);
        $valor = floatval($_POST['Valor']);

        // faz os cálculos necessários
        $kw = $watts / 1000;
        $consumo_diario = $kw * $horas;
        $consumo_mensal = $consumo_diario * $dias;
        $custo = $consumo_mensal * $valor;

        $categoria = ($custo <= 5) ? 'Baixo' : (($custo <= 10) ? 'Moderado' : 'Elevado'); // mostra o tipo da categoria

        $cadastro = [
            'aparelho' => $aparelho,
            'consumo_mensal' => $consumo_mensal,
            'custo' => $custo,
            'categoria' => $categoria
        ];

        $dados_anteriores = file_exists($arquivo) ? json_decode(file_get_contents($arquivo), true) : [];
        $dados_anteriores[] = $cadastro; // mostra os dados anteriores
        file_put_contents($arquivo, json_encode($dados_anteriores, JSON_PRETTY_PRINT));

        $consumo_formatado = number_format($consumo_mensal, 2, ',', '.'); // formatando os numeros
        $custo_formatado = number_format($custo, 2, ',', '.');

        echo "<h3>O aparelho <strong>$aparelho</strong> consome <strong>$consumo_formatado kWh</strong> por mês e custa <strong>R$$custo_formatado</strong>.</h3>";
        echo "<h4>Categoria de consumo: <strong>$categoria</strong></h4>";
    }
}

if ($cadastro_sucesso && file_exists($arquivo)) { // se o cadastro deu certo então o arquivo existe e é mostrado
    $cadastros = json_decode(file_get_contents($arquivo), true);

    echo "<hr>";
    echo "<h2>Todos os aparelhos cadastrados:</h2>";
    echo "<ul>";
    foreach ($cadastros as $item) { // percorre
        $c = number_format($item['custo'], 2, ',', '.'); // ($c custo em R$)
        $kwh = number_format($item['consumo_mensal'], 2, ',', '.');
        echo "<li><strong>{$item['aparelho']}</strong> - {$kwh} kWh/mês - R$$c - Categoria: {$item['categoria']}</li>"; // montando o html da lista
    }
    echo "</ul>";
}

echo "<p><a href='form_cadastro.php'>Cadastrar outro aparelho</a></p>";
echo "<p><a href='index.php'>Voltar ao início</a></p>";
?>

</body>
</html>