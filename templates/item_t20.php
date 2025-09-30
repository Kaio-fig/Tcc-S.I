<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item: Coroa do Estrategista</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            /* Paleta de cores ajustada para o tema de Tormenta 20 */
            --cor-primaria: #8a0303; /* Vermelho escuro de T20 */
            --cor-fundo: #f2e9d8;    /* Cor de pergaminho */
            --cor-surface: #ffffff;
            --cor-texto-primario: #3a2d2d;
            --cor-texto-secundario: #6c757d;
            --cor-borda: #d1c7b8;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background-color: var(--cor-fundo); color: var(--cor-texto-primario); padding: 40px; }
        
        .item-container {
            max-width: 900px;
            margin: auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: grid;
            grid-template-columns: 300px 1fr;
        }

        /* --- Coluna da Esquerda (Imagem e Status) --- */
        .item-sidebar {
            background-color: #faf6f0; /* Um tom mais claro de pergaminho */
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-right: 1px solid var(--cor-borda);
        }
        .item-image {
            width: 200px;
            height: 200px;
            background-color: #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 80px;
            color: var(--cor-primaria);
            margin-bottom: 30px;
            border: 3px solid var(--cor-primaria);
            overflow: hidden;
        }
        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .item-stats {
            display: flex;
            gap: 20px;
            text-align: center;
            width: 100%;
            justify-content: space-around;
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
            color: var(--cor-texto-primario);
        }
        
        /* --- Coluna da Direita (Detalhes) --- */
        .item-main {
            padding: 40px;
            display: flex;
            flex-direction: column;
        }
        .item-main h1 {
            font-size: 2.5rem;
            color: var(--cor-primaria);
            line-height: 1.2;
            margin-bottom: 10px;
        }
        .item-type {
            display: inline-block;
            align-self: flex-start;
            background-color: var(--cor-primaria);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 30px;
        }
        .item-main h3 {
            font-size: 1.2rem;
            color: var(--cor-texto-primario);
            border-bottom: 2px solid var(--cor-borda);
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .item-main .description {
            font-size: 1rem;
            line-height: 1.7;
            color: #444;
            flex-grow: 1;
        }

        /* Rodapé com botões */
        .item-footer {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 1rem;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--cor-borda);
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
            background-color: var(--cor-primaria);
            color: white;
            border-color: var(--cor-primaria);
        }
        .btn-primary:disabled {
            background-color: #ccc;
            border-color: #ccc;
            color: #666;
            cursor: not-allowed;
        }
        .btn-secondary {
            background-color: transparent;
            color: var(--cor-texto-primario);
            border-color: var(--cor-borda);
        }
        .btn-secondary:hover {
            background-color: #f8f9fa;
            border-color: #c0c0c0;
        }
    </style>
</head>
<body>

    <div class="item-container">
        <aside class="item-sidebar">
            <div class="item-image">
                <i class="fas fa-crown"></i>
            </div>
            <div class="item-stats">
                <div class="stat-box">
                    <span>Preço</span>
                    <strong>15000</strong>
                </div>
                <div class="stat-box">
                    <span>Peso</span>
                    <strong>1</strong>
                </div>
            </div>
        </aside>

        <main class="item-main">
            <span class="item-type">Item Maravilhoso</span>
            <h1>Coroa do Estrategista</h1>
            
            <h3>Descrição</h3>
            <div class="description">
                <p>Esta coroa de prata, adornada com um único topázio na fronte, parece analisar o campo de batalha por conta própria. O usuário recebe +2 em testes de Iniciativa.</p>
                <p style="margin-top: 1rem;">Além disso, uma vez por rodada, como uma ação livre, o portador pode gastar 2 PM para conceder a um aliado em alcance curto um bônus de +2 em seu próximo teste de ataque até o início do próximo turno do portador.</p>
            </div>

            <footer class="item-footer">
                <a href="meus_itens.php" class="btn btn-secondary">Voltar</a>
                <button type="button" class="btn btn-primary" disabled>Salvar Item</button>
            </footer>
        </main>
    </div>

</body>
</html>