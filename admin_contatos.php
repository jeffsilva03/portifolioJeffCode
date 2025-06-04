<?php
require_once 'config.php';

try {
    $pdo = conectarBanco();
    $sql = "SELECT * FROM contatos ORDER BY data_envio DESC";
    $stmt = $pdo->query($sql);
    $contatos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar contatos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contatos Recebidos</title>
    <style>
        :root {
            --primary-color: #9423ec;
            --primary-color-light: #ac53ff;
            --secondary-color: #19b8ff;
            --dark-bg: #080808;
            --dark-bg-light: #121212;
            --card-bg: #1a1a1a;
            --text-light: #ffffff;
            --text-dim: #afafaf;
            --border-color: rgba(255, 255, 255, 0.1);
            --success-color: #22c55e;
            --warning-color: #f59e0b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, var(--dark-bg) 0%, var(--dark-bg-light) 100%);
            color: var(--text-light);
            min-height: 100vh;
            line-height: 1.6;
            position: relative;
            overflow-x: hidden;
        }

        /* EFEITOS DE FUNDO */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 20%, rgba(148, 35, 236, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(25, 184, 255, 0.08) 0%, transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        /* CONTAINER PRINCIPAL */
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 20px;
            position: relative;
            z-index: 1;
        }

        /* CABEÇALHO */
        .header {
            text-align: center;
            margin-bottom: 50px;
            opacity: 0;
            transform: translateY(30px);
            animation: slideUp 0.8s ease 0.2s forwards;
        }

        .header h1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 15px;
            position: relative;
        }

        .header h1::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 2px;
        }

        .stats-bar {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .stat-item {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 15px 25px;
            text-align: center;
            min-width: 120px;
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--secondary-color);
            display: block;
        }

        .stat-label {
            font-size: 0.85rem;
            color: var(--text-dim);
            margin-top: 5px;
        }

        /* FILTROS E BUSCA */
        .filters {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 40px;
            opacity: 0;
            transform: translateY(30px);
            animation: slideUp 0.8s ease 0.4s forwards;
        }

        .filters-grid {
            display: grid;
            grid-template-columns: 1fr auto auto;
            gap: 20px;
            align-items: center;
        }

        .search-box {
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 12px 45px 12px 20px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            color: var(--text-light);
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(148, 35, 236, 0.15);
        }

        .search-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-dim);
        }

        .filter-btn {
            padding: 12px 24px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            border-radius: 12px;
            color: var(--text-light);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(148, 35, 236, 0.4);
        }

        /* LISTA DE CONTATOS */
        .contacts-grid {
            display: grid;
            gap: 25px;
        }

        .contato {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 30px;
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0;
            transform: translateY(30px);
            animation: slideUp 0.6s ease forwards;
        }

        .contato:hover {
            transform: translateY(-5px);
            border-color: rgba(148, 35, 236, 0.3);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .contato::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 20px 20px 0 0;
        }

        .contact-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .contact-name {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text-light);
            margin: 0;
        }

        .contact-date {
            background: rgba(25, 184, 255, 0.15);
            color: var(--secondary-color);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            border: 1px solid rgba(25, 184, 255, 0.3);
        }

        .contact-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 0;
        }

        .info-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 0.8rem;
            color: var(--text-dim);
            margin-bottom: 2px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            color: var(--text-light);
            font-weight: 500;
        }

        .info-value a {
            color: var(--secondary-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .info-value a:hover {
            color: var(--primary-color-light);
        }

        .mensagem-container {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            padding: 20px;
            border-left: 4px solid var(--secondary-color);
            position: relative;
        }

        .mensagem-label {
            font-size: 0.8rem;
            color: var(--text-dim);
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .mensagem-texto {
            color: var(--text-light);
            line-height: 1.6;
            white-space: pre-line;
        }

        /* ESTADO VAZIO */
        .sem-contatos {
            text-align: center;
            padding: 80px 20px;
            opacity: 0;
            transform: translateY(30px);
            animation: slideUp 0.8s ease 0.6s forwards;
        }

        .empty-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            margin: 0 auto 25px;
            opacity: 0.7;
        }

        .sem-contatos p {
            font-size: 1.2rem;
            color: var(--text-dim);
            margin-bottom: 15px;
        }

        .sem-contatos .subtitle {
            font-size: 0.9rem;
            color: var(--text-dim);
            opacity: 0.7;
        }

        /* ANIMAÇÕES */
        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .contato:nth-child(1) { animation-delay: 0.1s; }
        .contato:nth-child(2) { animation-delay: 0.2s; }
        .contato:nth-child(3) { animation-delay: 0.3s; }
        .contato:nth-child(4) { animation-delay: 0.4s; }
        .contato:nth-child(5) { animation-delay: 0.5s; }

        /* RESPONSIVIDADE */
        @media (max-width: 768px) {
            .container {
                padding: 20px 15px;
            }

            .header h1 {
                font-size: 2.5rem;
            }

            .stats-bar {
                gap: 15px;
            }

            .stat-item {
                min-width: 100px;
                padding: 12px 20px;
            }

            .filters-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .contact-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .contact-info {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .contato {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .header h1 {
                font-size: 2rem;
            }

            .stats-bar {
                flex-direction: column;
                align-items: center;
            }

            .contato {
                padding: 15px;
            }
        }

        /* SCROLLBAR PERSONALIZADA */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--dark-bg);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--primary-color-light), var(--secondary-color));
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Contatos Recebidos</h1>
            <div class="stats-bar">
                <div class="stat-item">
                    <span class="stat-number" id="totalContacts">5</span>
                    <span class="stat-label">Total</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" id="todayContacts">2</span>
                    <span class="stat-label">Hoje</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" id="weekContacts">12</span>
                    <span class="stat-label">Esta Semana</span>
                </div>
            </div>
        </div>

        
        
      

        <!-- Estado vazio (comentado para mostrar com dados) -->
        <!-- 
        <div class="sem-contatos">
            <div class="empty-icon">📬</div>
            <p>Nenhum contato foi recebido ainda.</p>
            <p class="subtitle">Os contatos enviados pelo formulário aparecerão aqui.</p>
        </div>
        -->

        
        <?php if (empty($contatos)): ?>
            <div class="sem-contatos">
                <div class="empty-icon">📬</div>
                <p>Nenhum contato foi recebido ainda.</p>
                <p class="subtitle">Os contatos enviados pelo formulário aparecerão aqui.</p>
            </div>
        <?php else: ?>
            <?php foreach ($contatos as $contato): ?>
                <div class="contato">
                    <div class="contact-header">
                        <h3 class="contact-name"><?php echo htmlspecialchars($contato['nome']); ?></h3>
                        <span class="contact-date">
                            <?php echo date('d/m/Y H:i', strtotime($contato['data_envio'])); ?>
                        </span>
                    </div>
                    
                    <div class="contact-info">
                        <div class="info-item">
                            <div class="info-icon">📧</div>
                            <div class="info-content">
                                <div class="info-label">Email</div>
                                <div class="info-value">
                                    <a href="mailto:<?php echo htmlspecialchars($contato['email']); ?>">
                                        <?php echo htmlspecialchars($contato['email']); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <?php if (!empty($contato['telefone'])): ?>
                            <div class="info-item">
                                <div class="info-icon">📱</div>
                                <div class="info-content">
                                    <div class="info-label">Telefone</div>
                                    <div class="info-value">
                                        <a href="tel:<?php echo htmlspecialchars($contato['telefone']); ?>">
                                            <?php echo htmlspecialchars($contato['telefone']); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mensagem-container">
                        <div class="mensagem-label">Mensagem</div>
                        <div class="mensagem-texto">
                            <?php echo nl2br(htmlspecialchars($contato['mensagem'])); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        
    </div>

    <script>
        // Funcionalidade de busca
        const searchInput = document.querySelector('.search-input');
        const contatos = document.querySelectorAll('.contato');

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            contatos.forEach(contato => {
                const nome = contato.querySelector('.contact-name').textContent.toLowerCase();
                const email = contato.querySelector('.info-value a').textContent.toLowerCase();
                const mensagem = contato.querySelector('.mensagem-texto').textContent.toLowerCase();
                
                const match = nome.includes(searchTerm) || 
                             email.includes(searchTerm) || 
                             mensagem.includes(searchTerm);
                
                if (match) {
                    contato.style.display = 'block';
                    contato.style.animation = 'slideUp 0.3s ease forwards';
                } else {
                    contato.style.display = 'none';
                }
            });
        });

        // Animação de contador para estatísticas
        function animateCounter(element, target) {
            let current = 0;
            const increment = target / 30;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                element.textContent = Math.floor(current);
            }, 50);
        }

        // Iniciar animações dos contadores após carregamento
        window.addEventListener('load', () => {
            setTimeout(() => {
                animateCounter(document.getElementById('totalContacts'), 5);
                animateCounter(document.getElementById('todayContacts'), 2);
                animateCounter(document.getElementById('weekContacts'), 12);
            }, 800);
        });

        // Funcionalidade dos botões de filtro
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Adicionar funcionalidade específica aqui
                console.log('Botão clicado:', this.textContent);
            });
        });
    </script>
</body>
</html>