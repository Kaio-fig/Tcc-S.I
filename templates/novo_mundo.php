<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor de Mundos - A Conquista da Coroa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #6a1b9a;
            --secondary-color: #3498db; /* Azul para eventos */
            --tertiary-color: #27ae60; /* Verde para itens */
            --dark-color: #2c2c2c;
            --light-color: #f5f5f5;
            --border-color: #dee2e6;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background-color: #f9f9f9; color: var(--dark-color); }
        .container { max-width: 1200px; margin: 20px auto; padding: 20px; }
        header { text-align: center; margin-bottom: 20px; }
        h1 { font-size: 2.5rem; color: var(--primary-color); }
        
        /* O Canvas do Mapa Mental */
        .mapa-container {
            width: 100%;
            height: 500px;
            background-color: #fff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            position: relative; /* Essencial para posicionar os nós */
            overflow: hidden;
            background-image: radial-gradient(#e0e0e0 1px, transparent 1px);
            background-size: 20px 20px;
        }
        
        /* Estilo dos Nós Arrastáveis */
        .mapa-no {
            position: absolute; /* Permite o posicionamento livre */
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border: 2px solid;
            background-color: white;
            cursor: move; /* Indica que o elemento é arrastável */
            text-align: center;
            min-width: 180px;
        }
        .mapa-no h4 { font-size: 1.1rem; margin-bottom: 5px; }
        .mapa-no p { font-size: 0.9rem; color: #555; }

        /* Cores diferentes para cada tipo de nó */
        .no-personagem { border-color: var(--primary-color); color: var(--primary-color); }
        .no-evento { border-color: var(--secondary-color); color: var(--secondary-color); }
        .no-item { border-color: var(--tertiary-color); color: var(--tertiary-color); }

        /* Linhas de Conexão (feitas com SVG) */
        .mapa-conectores {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            pointer-events: none; /* Permite clicar através do SVG */
        }
        .mapa-conectores line {
            stroke: #aaa;
            stroke-width: 2;
            stroke-dasharray: 5, 5; /* Linha tracejada */
        }

        /* Área de Ações Falsas */
        .mapa-acoes {
            margin-top: 30px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
        }
        .mapa-acoes h3 { margin-bottom: 15px; color: var(--primary-color); }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr auto; gap: 15px; }
        .form-grid input {
            width: 100%; padding: 10px; border: 1px solid var(--border-color);
            border-radius: 5px; font-size: 1rem;
        }
        .btn {
            padding: 10px 20px; border-radius: 5px; font-weight: 600;
            text-decoration: none; color: white; border: none; cursor: pointer;
        }
        .btn-primary { background-color: var(--primary-color); }
        .btn-primary:disabled { background-color: #ccc; cursor: not-allowed; }
    </style>
</head>
<body>

    <div class="container">
        <header>
            <h1>Mapa Mental: A Saga de Vorlak</h1>
        </header>
        
        <div class="mapa-container">
            <svg class="mapa-conectores">
                <line x1="28%" y1="50%" x2="50%" y2="25%" />
                <line x1="50%" y1="25%" x2="72%" y2="50%" />
            </svg>
            
            <div class="mapa-no no-personagem" style="top: 40%; left: 18%;">
                <h4>Personagem</h4>
                <p>Vorlak, o quebra queixos</p>
            </div>
            
            <div class="mapa-no no-evento" style="top: 15%; left: calc(50% - 90px);">
                <h4>Evento-Chave</h4>
                <p>Assassinato do Rei Theron</p>
            </div>
            
            <div class="mapa-no no-item" style="top: 40%; left: 68%;">
                <h4>Item Adquirido</h4>
                <p>Coroa do Estrategista</p>
            </div>
        </div>

        <div class="mapa-acoes">
            <h3>Adicionar Elementos ao Mapa</h3>
            <div class="form-grid">
                <input type="text" placeholder="Novo Personagem, Evento, Item...">
                <input type="text" placeholder="Descrição breve...">
                <button class="btn btn-primary" disabled>Adicionar Nó</button>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const nós = document.querySelectorAll('.mapa-no');
            
            nós.forEach(nó => {
                let isDragging = false;
                let offsetX, offsetY;

                nó.addEventListener('mousedown', (e) => {
                    isDragging = true;
                    // Calcula a diferença entre o clique do mouse e o canto superior esquerdo do nó
                    offsetX = e.clientX - nó.getBoundingClientRect().left;
                    offsetY = e.clientY - nó.getBoundingClientRect().top;
                    nó.style.zIndex = 1000; // Traz o nó para frente ao arrastar
                });

                document.addEventListener('mousemove', (e) => {
                    if (!isDragging) return;

                    // Posição do container pai
                    const containerRect = nó.parentElement.getBoundingClientRect();
                    
                    // Calcula a nova posição do nó
                    let newLeft = e.clientX - containerRect.left - offsetX;
                    let newTop = e.clientY - containerRect.top - offsetY;

                    // Limita o movimento para dentro do container
                    newLeft = Math.max(0, Math.min(newLeft, containerRect.width - nó.offsetWidth));
                    newTop = Math.max(0, Math.min(newTop, containerRect.height - nó.offsetHeight));

                    nó.style.left = `${newLeft}px`;
                    nó.style.top = `${newTop}px`;
                });

                document.addEventListener('mouseup', () => {
                    isDragging = false;
                    nó.style.zIndex = 1; // Devolve o nó à sua camada original
                });
            });
        });
    </script>
</body>
</html>