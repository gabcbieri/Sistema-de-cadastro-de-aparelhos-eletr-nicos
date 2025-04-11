<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Cadastro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Cadastro de Produto</h2>

        <form id="cadastroForm" action="cadastro.php" method="post" class="form-cadastro">
            <p>
                <input type="text" name="Aparelho" placeholder="Nome do Aparelho" required>
            </p>
            <p>
                <input type="number" name="Watts" placeholder="Consumo máximo Watts" step="0.01" min="0.01" required>
            </p>
            <p>
                <input type="number" name="Horas" placeholder="Horas por dia" step="0.01" min="0.01" required>
            </p>
            <p>
                <input type="number" name="Dias" placeholder="Dias por mês" step="1" min="1" required>
            </p>
            <p>
                <input type="number" name="Valor" placeholder="Valor do kWh (R$)" step="0.01" min="0.01" required>
            </p>
            <p>
                <button type="submit">Cadastrar Aparelho</button>
            </p>
        </form>
    </div>
</body>
</html>
