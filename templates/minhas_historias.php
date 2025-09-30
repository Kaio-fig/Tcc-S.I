<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Histórias - A Saga de Vorlak</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #6a1b9a;
            --secondary-color: #9c27b0;
            --dark-color: #2c2c2c;
            --light-color: #f5f5f5;
            --border-color: #e9ecef;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background-color: #f9f9f9; color: var(--dark-color); }
        .container { max-width: 1000px; margin: 30px auto; padding: 20px; }
        
        header { text-align: center; margin-bottom: 30px; }
        header h1 { font-size: 2.8rem; color: var(--primary-color); }
        header p { font-size: 1.1rem; color: #6c757d; }

        /* Estilo das Abas de Navegação */
        .tabs-nav {
            display: flex;
            border-bottom: 2px solid var(--border-color);
            margin-bottom: 30px;
        }
        .tab-button {
            padding: 15px 25px;
            cursor: pointer;
            border: none;
            background-color: transparent;
            font-size: 1.1rem;
            font-weight: 600;
            color: #6c757d;
            position: relative;
            transition: color 0.3s;
        }
        .tab-button.active {
            color: var(--primary-color);
        }
        .tab-button.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: var(--primary-color);
        }
        .tab-content { display: none; }
        .tab-content.active { display: block; }

        /* Estilo dos Blocos e Conteúdo */
        .bloco {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }
        .bloco h2 {
            font-size: 1.8rem;
            color: var(--dark-color);
            margin-bottom: 20px;
        }
        .bloco p, .bloco li {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #333;
        }
        
        /* Layout para Personagens */
        .personagens-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        /* Estilo do Acordeão (para Feitos e Ilhas) */
        .accordion-item {
            border-bottom: 1px solid var(--border-color);
        }
        .accordion-item:last-child {
            border-bottom: none;
        }
        .accordion-header {
            padding: 20px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.3rem;
            font-weight: 600;
        }
        .accordion-header::after {
            content: '\f078'; /* Ícone de seta para baixo (Font Awesome) */
            font-family: 'Font Awesome 6 Free';
            transition: transform 0.3s;
        }
        .accordion-item.active .accordion-header::after {
            transform: rotate(180deg);
        }
        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease-out, padding 0.4s ease-out;
        }
        .accordion-content div {
            padding: 0 20px 20px 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <header>
            <h1>A Saga de Vorlak</h1>
            <p>Uma crônica de Tormenta 20</p>
        </header>

        <nav class="tabs-nav">
            <button class="tab-button active" data-tab="personagens">Personagens</button>
            <button class="tab-button" data-tab="feitos">Feitos Lendários</button>
            <button class="tab-button" data-tab="ilhas">Exploração</button>
        </nav>

        <div id="personagens" class="tab-content active">
            <div class="personagens-grid">
                <div class="bloco">
                    <h2>Vorlak</h2>
                    <p>vlk-006 era um experimento de um laboratório clandestino. Vagas memórias de testes físicos e térmicos o assombram, junto da voz de um doutor que o acusava de ser uma falha por não se tornar "obediente". Com a ordem para sacrificá-lo, a cobaia sobreviveu e, descartado em meio a dejetos, sentiu medo pela primeira vez. Adotando o nome Vorlak, sobreviveu de pequenos delitos até ser salvo por Antônio Barbosa, capitão dos Piratas do Coração do Mar, encontrando um novo propósito em sua tripulação.</p>
                </div>
                <div class="bloco">
                    <h2>Jane Barbosa</h2>
                    <p>Abandonada na infância e resgatada por Antônio Barbosa, Jane foi criada entre piratas. Influenciada pelas lendas de sua avó adotiva, Magali, sobre o Kraken que matou seu avô Hector, ela cresceu com o mar em suas veias. O medo do Kraken e a responsabilidade com sua tripulação moldaram seu caráter, escondendo um grande coração sob uma fachada de pirata destemida. Foi ela quem acolheu Vorlak na tripulação, inicialmente como um simples pescador.</p>
                </div>
            </div>
             <div class="bloco">
                <h2>Lore Juntos</h2>
                <p>A parceria entre Jane e Vorlak se forjou quando, após ela ganhar sua primeira canhoneira, foram atacados de surpresa e lutaram lado a lado para defender o navio. Com o tempo, Vorlak tornou-se seu conselheiro. Em um naufrágio devastador, onde viu sua tripulação ser massacrada, Vorlak foi salvo por Jane das profundezas. Naquele momento, ele jurou devoção eterna e que nunca mais sentiria medo, passando a obedecer suas ordens inquestionavelmente e a focar em sua força para protegê-la e a sua nova família.</p>
            </div>
        </div>

        <div id="feitos" class="tab-content">
            <div class="bloco">
                <div class="accordion">
                    <div class="accordion-item">
                        <div class="accordion-header">O Tesouro do Homem Morto</div>
                        <div class="accordion-content">
                            <div><p>Em uma de suas primeiras aventuras, a tripulação encontrou um mapa para um tesouro amaldiçoado. Ao chegarem na caverna, a cobiça pelo ouro fez com que parte da tripulação ignorasse as ordens de Jane para recuar quando esqueletos amaldiçoados se levantaram. Vorlak e Jane lutaram para sair, enquanto aqueles que ficaram pelo tesouro se juntaram aos mortos, amaldiçoados pela eternidade.</p></div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div class="accordion-header">A Invasão ao Corvo</div>
                        <div class="accordion-content">
                            <div><p>Anos depois, para salvar os Piratas do Coração da escassez, Jane planejou um ataque ousado ao nobre Reino Corvo sob o disfarce de uma negociação comercial. A situação escalou, e ao ouvir o grito de Jane, Vorlak invadiu a mansão onde ela estava, salvando-a e iniciando um massacre. A ordem de Jane foi simples: "Mate-os, Vorlak". O resultado foi um nobre capturado, trocado por suprimentos que garantiram a prosperidade da tripulação por quase um ano.</p></div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <div class="accordion-header">O Megalodon</div>
                        <div class="accordion-content">
                            <div><p>Durante uma caça a uma cachalote, a tripulação se deparou com uma criatura mística: o Megalodon. Em uma batalha épica, o galeão foi quase destruído. Seguindo uma ordem audaciosa de Jane, Vorlak a arremessou para dentro da boca da criatura. De dentro para fora, Jane rasgou a garganta do monstro, finalizando-o. A cabeça do Megalodon agora adorna a proa do navio, um troféu e uma ameaça aos seus rivais.</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="ilhas" class="tab-content">
             <div class="bloco">
                <div class="accordion">
                    <div class="accordion-item">
                        <div class="accordion-header">A Ilha das Correntes e os Ossos Negros</div>
                        <div class="accordion-content">
                            <div><p>A jornada os levou primeiro à traiçoeira Ilha das Correntes, um cemitério de navios onde encontraram um mapa de pedra. Este os guiou até a Ilha dos Ossos Negros, um lugar macabro dominado pela Praga. Lá, entre torres de ossos e relíquias amaldiçoadas, descobriram que a ilha era um ponto de origem do próprio elemento da Praga, encontrando um mapa incompleto para outros locais misteriosos.</p></div>
                        </div>
                    </div>
                     <div class="accordion-item">
                        <div class="accordion-header">A Ilha das Estrelas</div>
                        <div class="accordion-content">
                            <div><p>Guiados por um mapa prateado, chegaram a um lugar onírico onde o mar e o céu eram um só. No coração da ilha, em cavernas submersas, encontraram uma piscina onde o conhecimento do cosmos se manifestava em luzes e padrões indecifráveis. Partiram sem respostas, mas marcados pela visão de algo maior que eles.</p></div>
                        </div>
                    </div>
                     <div class="accordion-item">
                        <div class="accordion-header">A Ilha do Ferro Morto</div>
                        <div class="accordion-content">
                            <div><p>Uma ilha que rejeitava o tempo e a podridão, repleta de navios naufragados perfeitamente preservados. No centro, um altar feito de um metal desconhecido pulsava com um calor brando. Saquearam relíquias que pareciam novas, mas pertenciam a eras esquecidas, partindo com a sensação de que a própria ilha os observava.</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Lógica para as Abas Principais
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));
                    button.classList.add('active');
                    document.getElementById(button.dataset.tab).classList.add('active');
                });
            });

            // Lógica para o Acordeão (Feitos e Ilhas)
            const accordionItems = document.querySelectorAll('.accordion-item');

            accordionItems.forEach(item => {
                const header = item.querySelector('.accordion-header');
                header.addEventListener('click', () => {
                    // Fecha todos os outros itens para manter apenas um aberto
                    accordionItems.forEach(otherItem => {
                        if (otherItem !== item) {
                            otherItem.classList.remove('active');
                            otherItem.querySelector('.accordion-content').style.maxHeight = null;
                        }
                    });

                    // Abre ou fecha o item clicado
                    item.classList.toggle('active');
                    const content = item.querySelector('.accordion-content');
                    if (item.classList.contains('active')) {
                        content.style.maxHeight = content.scrollHeight + "px";
                    } else {
                        content.style.maxHeight = null;
                    }
                });
            });
        });
    </script>
</body>
</html>