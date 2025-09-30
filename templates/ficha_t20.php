<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/ficha_t20.css">
    <title>Ficha T20 - Vorlak</title>
</head>
<body>

<div class="ficha-container">

    <main class="coluna-principal">
        <nav class="abas-nav">
            <button type="button" class="tab-button active" data-tab="atributos">Atributos & Perícias</button>
            <button type="button" class="tab-button" data-tab="poderes">Poderes</button>
            <button type="button" class="tab-button" data-tab="equipamento">Equipamento</button>
        </nav>

        <div id="atributos" class="tab-content active">
            <div class="bloco">
                <h3>Atributos</h3>
                <div class="atributos-grid">
                    <div class="atributo"><label>FORÇA</label><div class="valor">4</div></div>
                    <div class="atributo"><label>DESTREZA</label><div class="valor">2</div></div>
                    <div class="atributo"><label>CONSTITUIÇÃO</label><div class="valor">4</div></div>
                    <div class="atributo"><label>INTELIGÊNCIA</label><div class="valor">0</div></div>
                    <div class="atributo"><label>SABEDORIA</label><div class="valor">1</div></div>
                    <div class="atributo"><label>CARISMA</label><div class="valor">-1</div></div>
                </div>
            </div>
            <div class="bloco">
                <h3>Perícias</h3>
                <div class="pericias-container">
                    <div class="pericia-item"><span>Acrobacia</span> <strong>+2</strong></div>
                    <div class="pericia-item"><span>Atletismo</span> <strong>+13</strong></div>
                    <div class="pericia-item"><span>Atuação</span> <strong>+4</strong></div>
                    <div class="pericia-item"><span>Cavalgar</span> <strong>+7</strong></div>
                    <div class="pericia-item"><span>Cura</span> <strong>+6</strong></div>
                    <div class="pericia-item"><span>Diplomacia</span> <strong>+4</strong></div>
                    <div class="pericia-item"><span>Enganação</span> <strong>+4</strong></div>
                    <div class="pericia-item"><span>Fortitude</span> <strong>+15</strong></div>
                    <div class="pericia-item"><span>Furtividade</span> <strong>+6</strong></div>
                    <div class="pericia-item"><span>Iniciativa</span> <strong>+13</strong></div>
                    <div class="pericia-item"><span>Intimidação</span> <strong>+9</strong></div>
                    <div class="pericia-item"><span>Intuição</span> <strong>+6</strong></div>
                    <div class="pericia-item"><span>Investigação</span> <strong>+5</strong></div>
                    <div class="pericia-item"><span>Luta</span> <strong>+15</strong></div>
                    <div class="pericia-item"><span>Ofício (pirata)</span> <strong>+10</strong></div>
                    <div class="pericia-item"><span>Percepção</span> <strong>+6</strong></div>
                    <div class="pericia-item"><span>Pontaria</span> <strong>+7</strong></div>
                    <div class="pericia-item"><span>Reflexos</span> <strong>+11</strong></div>
                    <div class="pericia-item"><span>Sobrevivência</span> <strong>+6</strong></div>
                    <div class="pericia-item"><span>Vontade</span> <strong>+6</strong></div>
                </div>
            </div>
        </div>

        <div id="poderes" class="tab-content">
            <div class="bloco">
                <h3>Poderes e Habilidades</h3>
                <div class="poder-item"><h4>Mordida Poderosa (Raça)</h4><p>Você possui uma arma natural de mordida (dano 1d6, crítico x2, perfuração), com a qual recebe +2 em testes de agarrar. Uma vez por rodada, quando usa a ação agredir para atacar com outra arma, pode gastar 1 PM para fazer um ataque corpo a corpo extra com a mordida.</p></div>
                <div class="poder-item"><h4>Predador Aquático (Raça)</h4><p>Você tem deslocamento de natação 6m e recebe +1 na Defesa e +2 em Furtividade.</p></div>
                <div class="poder-item"><h4>Surto Reptiliano (Raça)</h4><p>Uma vez por cena, você pode gastar 1 PM para realizar uma ação de movimento adicional em seu turno.</p></div>
                <div class="poder-item"><h4>Confissão (Origem)</h4><p>Você pode usar Intimidação para interrogar sem custo e em uma hora.</p></div>
                <div class="poder-item"><h4>Ataque Poderoso (Guerreiro)</h4><p>Sempre que faz um ataque corpo a corpo, você pode sofrer –2 no teste de ataque para receber +5 na rolagem de dano.</p></div>
                <div class="poder-item"><h4>Ambidestria (Combatente)</h4><p>Se estiver empunhando duas armas e fizer a ação agredir, você pode fazer dois ataques, um com cada arma. Se fizer isso, sofre –2 em todos os testes de ataque até o seu próximo turno.</p></div>
                <div class="poder-item"><h4>Durão (Guerreiro)</h4><p>A partir do 3º nível, sempre que sofre dano, você pode gastar 3 PM para reduzir esse dano à metade.</p></div>
                 <div class="poder-item"><h4>Ataque Extra (Guerreiro)</h4><p>A partir do 6º nível, quando usa a ação agredir, você pode gastar 2 PM para realizar um ataque adicional uma vez por rodada.</p></div>
                </div>
        </div>

        <div id="equipamento" class="tab-content">
            <div class="bloco">
                <h3>Ataques</h3>
                <table width="100%">
                    <thead><tr style="text-align: left;"><th>Arma</th><th>Teste</th><th>Dano</th><th>Crítico</th></tr></thead>
                    <tbody>
                        <tr><td>Machado de Guerra</td><td>+15</td><td>1d6+7</td><td>x4</td></tr>
                        <tr><td>Escudo Pesado</td><td>+15</td><td>1d6+5</td><td>x2</td></tr>
                        <tr><td>Mordida</td><td>+15</td><td>1d6+5</td><td>x2</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="bloco">
                <h3>Equipamento (17/18)</h3>
                <ul class="equipamento-lista">
                    <li>Machado de guerra x2 (Adamante, maciço)</li>
                    <li>Armadura pesada (Mitral, Espinhosa 1d4)</li>
                    <li>Escudo pesado (Selado, +1 em testes de resistência)</li>
                    <li>Poção de mana x4</li>
                    <li>Pedra de amolar do Trubat</li>
                    <li>Saco de dormir e Equipamento para viajem</li>
                </ul>
                <p style="text-align: right; margin-top: 1rem; font-weight: bold;">2319 Tibares</p>
            </div>
        </div>
    </main>

    <aside class="coluna-lateral">
        <div class="bloco bloco-personagem">
            <div class="personagem-imagem">
                <img src="../static/Vorlak_Icon.png" alt="">
                </div>
            <h1 class="personagem-nome">Vorlak</h1>
            <p class="personagem-info">Moreau Guerreiro 11</p>
        </div>
        <div class="bloco status-grid">
            <div class="status-box">
                <label>❤️ Pontos de Vida</label>
                <div class="valor">123</div>
            </div>
            <div class="status-box">
                <label>💧 Pontos de Mana</label>
                <div class="valor">33</div>
            </div>
        </div>
        <div class="bloco" style="text-align: center;">
            <label style="font-weight: 700; font-size: 0.8rem; text-transform: uppercase; color: var(--cor-texto-secundario);">🛡️ Defesa</label>
            <div style="font-size: 3rem; font-weight: 700; color: var(--cor-texto-primario);">29</div>
        </div>
    </aside>
</div>

<script>
    // JavaScript para funcionalidade das abas
    document.addEventListener('DOMContentLoaded', () => {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove a classe 'active' de todos
                tabButtons.forEach(btn => btn.classList.remove('active'));
                tabContents.forEach(content => content.classList.remove('active'));

                // Adiciona a classe 'active' ao clicado e ao seu conteúdo
                button.classList.add('active');
                const targetContent = document.getElementById(button.dataset.tab);
                if (targetContent) {
                    targetContent.classList.add('active');
                }
            });
        });
    });
</script>

</body>
</html>