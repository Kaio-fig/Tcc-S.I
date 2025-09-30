<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item: Cérebro em Cápsula</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #6a1b9a;
            --secondary-color: #9c27b0;
            --dark-color: #2c2c2c;
            --light-color: #f5f5f5;
            --danger-color: #f44336;
            --border-color: #dee2e6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background-color: #f9f9f9;
            color: var(--dark-color);
            padding: 40px;
        }

        .item-container {
            max-width: 900px;
            margin: auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: grid;
            grid-template-columns: 300px 1fr;
            /* Coluna da esquerda fixa, direita flexível */
        }

        /* --- Coluna da Esquerda (Imagem e Status) --- */
        .item-sidebar {
            background-color: #f8f9fa;
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-right: 1px solid var(--border-color);
        }

        /* ... (seu CSS existente) ... */

        .item-image {
            width: 200px;
            height: 200px;
            /* background-color: #e9ecef; (Pode remover, a imagem vai cobrir) */
            border-radius: 50%;
            display: flex;
            /* Mantém flex para centralizar a imagem */
            align-items: center;
            justify-content: center;
            /* font-size: 80px; (Remover, era do ícone) */
            /* color: var(--primary-color); (Remover, era do ícone) */
            margin-bottom: 30px;
            overflow: hidden;
            /* Garante que a imagem não saia do círculo */
            border: 3px solid var(--primary-color);
            /* Adiciona uma borda para destaque */
        }

        .item-image img {
            width: 100%;
            /* Faz a imagem preencher a largura do contêiner */
            height: 100%;
            /* Faz a imagem preencher a altura do contêiner */
            object-fit: cover;
            /* Recorta a imagem para cobrir o espaço sem distorcer */
            display: block;
            /* Remove espaços extras que alguns navegadores adicionam a imagens */
        }

        /* ... (restante do seu CSS) ... */
        .item-stats {
            display: flex;
            gap: 20px;
            text-align: center;
        }

        .stat-box span {
            font-size: 0.9rem;
            color: #666;
            text-transform: uppercase;
            display: block;
        }

        .stat-box strong {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-color);
        }

        /* --- Coluna da Direita (Detalhes) --- */
        .item-main {
            padding: 40px;
            display: flex;
            flex-direction: column;
        }

        .item-main h1 {
            font-size: 2.5rem;
            color: var(--primary-color);
            line-height: 1.2;
            margin-bottom: 10px;
        }

        .item-type {
            display: inline-block;
            align-self: flex-start;
            /* Faz o balão ter a largura do texto */
            background-color: var(--primary-color);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 30px;
        }

        .item-main h3 {
            font-size: 1.2rem;
            color: var(--dark-color);
            border-bottom: 2px solid var(--border-color);
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .item-main .description {
            font-size: 1rem;
            line-height: 1.7;
            color: #444;
            flex-grow: 1;
            /* Empurra o rodapé para o final */
        }

        /* Rodapé com botões */
        .item-footer {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 1rem;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 700;
            text-decoration: none;
            border: 2px solid transparent;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .btn-primary:disabled {
            background-color: #ccc;
            border-color: #ccc;
            color: #666;
            cursor: not-allowed;
        }

        .btn-secondary {
            background-color: transparent;
            color: var(--dark-color);
            border-color: var(--border-color);
        }

        .btn-secondary:hover {
            background-color: var(--light-color);
            border-color: #c0c0c0;
        }
    </style>
</head>

<body>

    <div class="item-container">
        <aside class="item-sidebar">
            <div class="item-image">
                <img src="../static/Cerebro.jpg" alt="">
            </div>
            <div class="item-stats">
                <div class="stat-box">
                    <span>Categoria</span>
                    <strong>IV</strong>
                </div>
                <div class="stat-box">
                    <span>Espaços</span>
                    <strong>1</strong>
                </div>
            </div>
        </aside>

        <main class="item-main">
            <span class="item-type">Item Paranormal</span>
            <h1>Cérebro em Cápsula</h1>

            <h3>Descrição</h3>
            <p class="description">
                Em interlúdios, pode-se gastar 1 ação e fazer um teste de Engenharia para adicionar 1 efeito paranormal ou 1 modificação comum em um equipamento a sua escolha. Este item pode aplicar efeitos até mesmo em equipamentos não modificáveis.
            </p>

            <footer class="item-footer">
                <a href="meus_itens.php" class="btn btn-secondary">Voltar</a>
                <button type="button" class="btn btn-primary" disabled>Salvar Item</button>
            </footer>
        </main>
    </div>

</body>

</html>