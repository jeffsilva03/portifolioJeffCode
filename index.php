
<?php
session_start();

// Capturar mensagens de sessão
$erros = $_SESSION['erros'] ?? [];
$sucesso = $_SESSION['sucesso'] ?? '';

// Limpar mensagens da sessão
unset($_SESSION['erros'], $_SESSION['sucesso']);
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfólio Digital</title>
    <!-- Bootstrap Icons -->
      <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts - Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" href="style.css">
    <style>
           .interface {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 4%;
        }

        /* SEÇÃO WORLDSKILLS */
        .worldskills {
            padding: 100px 0;
            background: linear-gradient(135deg, var(--dark-bg) 0%, var(--dark-bg-light) 100%);
            position: relative;
            overflow: hidden;
        }

        .worldskills::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="%23333" stroke-width="0.5" opacity="0.3"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.1;
            z-index: 1;
        }

        .worldskills .interface {
            position: relative;
            z-index: 2;
        }

        .worldskills-header {
            text-align: center;
            margin-bottom: 80px;
        }

        .worldskills-header h2 {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 20px;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .worldskills-header p {
            font-size: 18px;
            color: var(--text-dim);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .worldskills-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .worldskills-info {
            animation: slideInLeft 1s ease-out;
        }

        .worldskills-badge {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-color-light));
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 30px;
            box-shadow: 0 8px 32px rgba(148, 35, 236, 0.3);
        }

        .worldskills-badge i {
            font-size: 20px;
        }

        .worldskills-info h3 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 20px;
            color: var(--text-light);
        }

        .worldskills-info h3 span {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .worldskills-description {
            font-size: 18px;
            line-height: 1.7;
            color: var(--text-dim);
            margin-bottom: 30px;
        }

        .worldskills-stats {
            display: flex;
            gap: 40px;
            margin-bottom: 40px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 32px;
            font-weight: 800;
            color: var(--secondary-color);
            display: block;
        }

        .stat-label {
            font-size: 14px;
            color: var(--text-dim);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .worldskills-skills {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .skill-tag {
            background: rgba(148, 35, 236, 0.2);
            border: 1px solid var(--primary-color);
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 500;
            color: var(--text-light);
            transition: all 0.3s ease;
        }

        .skill-tag:hover {
            background: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(148, 35, 236, 0.4);
        }

        .worldskills-visual {
            position: relative;
            animation: slideInRight 1s ease-out;
        }

        .worldskills-medal {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            position: relative;
            box-shadow: 
                0 0 0 20px rgba(148, 35, 236, 0.1),
                0 0 0 40px rgba(148, 35, 236, 0.05),
                0 20px 60px rgba(148, 35, 236, 0.3);
            animation: float 3s ease-in-out infinite;
        }

        .worldskills-medal::before {
            content: '';
            position: absolute;
            width: 260px;
            height: 260px;
            background: var(--dark-bg-light);
            border-radius: 50%;
            z-index: 1;
        }

        .medal-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .medal-icon {
            font-size: 80px;
            color: var(--secondary-color);
            margin-bottom: 15px;
            display: block;
        }

        .medal-text {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .medal-year {
            font-size: 14px;
            color: var(--text-dim);
            margin-top: 5px;
        }

        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .floating-element {
            position: absolute;
            opacity: 0.6;
            animation: floatRandom 6s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }

        .floating-element:nth-child(3) {
            bottom: 30%;
            left: 20%;
            animation-delay: 4s;
        }

        /* ANIMAÇÕES */
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes floatRandom {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            33% {
                transform: translateY(-15px) rotate(120deg);
            }
            66% {
                transform: translateY(10px) rotate(240deg);
            }
        }

        /* RESPONSIVIDADE */
        @media screen and (max-width: 1024px) {
            .worldskills-content {
                grid-template-columns: 1fr;
                gap: 40px;
                text-align: center;
            }
            
            .worldskills-medal {
                width: 250px;
                height: 250px;
            }
            
            .worldskills-medal::before {
                width: 210px;
                height: 210px;
            }
            
            .medal-icon {
                font-size: 60px;
            }
        }

        @media screen and (max-width: 768px) {
            .worldskills {
                padding: 60px 0;
            }
            
            .worldskills-header h2 {
                font-size: 32px;
            }
            
            .worldskills-info h3 {
                font-size: 28px;
            }
            
            .worldskills-stats {
                justify-content: center;
                gap: 30px;
            }
            
            .worldskills-medal {
                width: 200px;
                height: 200px;
            }
            
            .worldskills-medal::before {
                width: 160px;
                height: 160px;
            }
            
            .medal-icon {
                font-size: 50px;
            }
            
            .medal-text {
                font-size: 14px;
            }
        }

        @media screen and (max-width: 480px) {
            .worldskills-stats {
                flex-direction: column;
                gap: 20px;
            }
            
            .worldskills-skills {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- CABEÇALHO -->
    <header>
        <div class="interface">
            <div class="logo">
            <img src="images/logo.png" alt="Logo">
            </div>

            <nav class="menu-desktop">
                <ul>
                    <li><a href="#inicio">Início</a></li>
                    <li><a href="#especialidades">Especialidades</a></li>
                    <li><a href="#sobre">Sobre</a></li>
                    <li><a href="#portfolio">Portfólio</a></li>
                </ul>
            </nav>

            <div class="btn-contato">
                <a href="#contato"><button>Contato</button></a>
            </div>

            <div class="btn-abrir-menu" id="btn-menu">
                <i class="bi bi-list"></i>
            </div>

            <div class="menu-mobile" id="menu-mobile">
                <div class="btn-fechar">
                    <i class="bi bi-x-lg"></i>
                </div>

                <nav>
                    <ul>
                        <li><a href="#inicio">Início</a></li>
                        <li><a href="#especialidades">Especialidades</a></li>
                        <li><a href="#sobre">Sobre</a></li>
                        <li><a href="#portfolio">Portfólio</a></li>
                        <li><a href="#contato">Contato</a></li>
                    </ul>
                </nav>
            </div>

            <div class="overlay-menu" id="overlay-menu"></div>
        </div>
    </header>

    <!-- TOPO DO SITE -->
    <section class="topo-do-site" id="inicio">
        <div class="interface">
            <div class="flex">
                <div class="txt-topo-site">
                    <h1>Transformando ideias em <span>experiências digitais</span> impactantes</h1>
                    
                    <div class="texto-animado">
                        <h3>Eu sou <span data-palavras="Desenvolvedor,Designer,Freelancer">Web Developer</span></h3>
                    </div>
                    
                    <p>Criar soluções digitais inovadoras que conectam marcas com seus públicos através de design e desenvolvimento de alta qualidade.</p>

                    <div class="btn-contato">
                        <a href="#contato"><button>Entre em contato</button></a>
                    </div>
                </div>

                <div class="img-topo-site">
                    <img src="images/pc.png" alt="Imagem Hero">
                </div>
            </div>
        </div>
    </section>

    <!-- ESPECIALIDADES -->
    <section class="especiliadades" id="especialidades">
        <div class="interface">
            <h2 class="titulo">Principais <span>Especialidades</span></h2>
            <div class="flex">
                <div class="especialidades-box">
                    <i class="bi bi-code-square"></i>
                    <h3>Sistemas Web</h3>
                    <p>Criação de sites responsivos, modernos e otimizados.</p>
                </div>

                <div class="especialidades-box">
                    <i class="bi bi-palette"></i>
                    <h3>Design UI/UX</h3>
                    <p>Design intuitivo e visualmente atraente .</p>
                </div>

                <div class="especialidades-box">
                    <i class="bi bi-phone"></i>
                    <h3>Sites Responsivos</h3>
                    <p>Desenvolvimento de interfaces que se adaptam perfeitamente.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SOBRE -->
    <section class="sobre" id="sobre">
        <div class="interface">
            <div class="flex">
                <div class="txt-sobre">
                    <h2>Muito prazer, <span>sou Designer & Desenvolvedor</span></h2>
                    <p>Com mais de 5 anos de experiência, me dedico a transformar ideias em projetos digitais de sucesso. Minha abordagem combina design criativo e código limpo para criar soluções que não apenas impressionam visualmente, mas também entregam resultados.</p>
                    <p>Trabalho com as tecnologias mais recentes e as melhores práticas do mercado para garantir que cada projeto seja único, funcional e alinhado com os objetivos do cliente.</p>

                    <div class="btn-social">
                        <a href="https://github.com/jeffsilva03"><button><i class="bi bi-instagram"></i></button></a>
                       <a href="https://www.linkedin.com/in/jefferson-silva-355620323/">  <button><i class="bi bi-linkedin"></i></button></a>
                       <a href="https://github.com/jeffsilva03"> <button><i class="bi bi-github"></i> </button></a>
                    </div>
                </div>

                <div class="img-sobre">
                    <img src="images/avatar.png" alt="Imagem Sobre">
                </div>
            </div>
        </div>

        <!-- CONTADOR -->
        <div class="contador">
            <div class="interface">
                <div class="flex">
                    <div class="contador-item">
                        <h3 class="numero">120</h3>
                        <h4>Projetos Concluídos</h4>
                    </div>

                    <div class="contador-item">
                        <h3 class="numero">85</h3>
                        <h4>Clientes Satisfeitos</h4>
                    </div>

                    <div class="contador-item">
                        <h3 class="numero">5</h3>
                        <h4>Anos de Experiência</h4>
                    </div>

                    <div class="contador-item">
                        <h3 class="numero">15</h3>
                        <h4>Prêmios Ganhos</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PORTFÓLIO -->
    <section class="portfolio" id="portfolio">
        <div class="interface">
            <h2 class="titulo">Meu <span>Portfólio</span></h2>

            <div class="flex">
                <div class="img-port" style="background-image: url('images/site1.png')">
                    <div class="overlay">
                        <h3>Projeto Website</h3>
                        <div class="tecnologias">
                            <span>HTML</span>
                            <span>CSS</span>
                            <span>JavaScript</span>
                        </div>
                        <div class="btn-ver">
                            <a href="https://sitetastyrestaurante.netlify.app/"><button>Ver Projeto</button></a>
                        </div>
                        <div class="btn-ver">
                            <a href="https://github.com/jeffsilva03/tastySalad"><button>GitHub</button></a>
                        </div>
                    </div>
                </div>

                <div class="img-port" style="background-image: url('/api/placeholder/360/460')">
                    <div class="overlay">
                        <h3>App Mobile</h3>
                        <div class="tecnologias">
                            <span>React Native</span>
                            <span>Node.js</span>
                            <span>Firebase</span>
                        </div>
                        <div class="btn-ver">
                            <button>Ver Projeto</button>
                        </div>
                        <div class="btn-ver">
                            <a href="https://github.com/jeffsilva03/augebitMOBILE"><button>GitHub</button></a>
                        </div>
                    </div>
                </div>

                <div class="img-port" style="background-image: url('/api/placeholder/360/460')">
                    <div class="overlay">
                        <h3>Site Institucional</h3>
                        <div class="tecnologias">
                            <span>PHP</span>
                            <span>CSS</span>
                            <span>MySQL</span>
                        </div>
                        <div class="btn-ver">
                            <button>Ver Projeto</button>
                        </div>
                        <div class="btn-ver">
                            <a href="https://github.com/jeffsilva03/augebitWeb"><button>GitHub</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- DEPOIMENTOS -->
    <section class="depoimentos" id="depoimentos">
        <div class="interface">
            <h2 class="titulo">O que meus <span>clientes</span> dizem</h2>

            <div class="flex">
                <div class="depoimento-item">
                    <p>"O trabalho entregue superou todas as minhas expectativas. O site ficou moderno, rápido e, principalmente, tem trazido resultados para meu negócio. Recomendo para todos!"</p>
                    <div class="depoimento-cliente">
                        <img src="images/homem.jpg" alt="Cliente 1">
                        <div class="info">
                            <h4>João Silva</h4>
                            <span>Empresário</span>
                        </div>
                    </div>
                    <div class="depoimento-stars">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                </div>

                <div class="depoimento-item">
                    <p>"Profissional extremamente dedicado e atencioso. Entendeu perfeitamente o que eu queria e entregou antes do prazo. O design ficou impecável e funciona perfeitamente em todos os dispositivos."</p>
                    <div class="depoimento-cliente">
                        <img src="images/mulher.jpg" alt="Cliente 2">
                        <div class="info">
                            <h4>Maria Oliveira</h4>
                            <span>Marketing Digital</span>
                        </div>
                    </div>
                    <div class="depoimento-stars">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                </div>

                <div class="depoimento-item">
                    <p>"A experiência de trabalhar neste projeto foi incrível! Comunicação clara, prazo respeitado e resultado final perfeito. Já estamos planejando novos projetos juntos."</p>
                    <div class="depoimento-cliente">
                        <img src="images/homem2.jpg" alt="Cliente 3">
                        <div class="info">
                            <h4>Carlos Santos</h4>
                            <span>E-commerce</span>
                        </div>
                    </div>
                    <div class="depoimento-stars">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

     <!-- SEÇÃO WORLDSKILLS -->
    <section class="worldskills" id="worldskills">
        <div class="interface">
            <div class="worldskills-header">
                <h2>Competidor WorldSkills</h2>
                <p>Representando o Brasil na maior competição mundial de habilidades profissionais, onde os melhores talentos se encontram</p>
            </div>

            <div class="worldskills-content">
                <div class="worldskills-info">
                    <div class="worldskills-badge">
                        <i class="bi bi-award-fill"></i>
                        Competidor Oficial
                    </div>
                    
                    <h3>Excelência em <span>Desenvolvimento Web</span></h3>
                    
                    <p class="worldskills-description">
                        Selecionado para representar o Brasil na WorldSkills, a maior competição de habilidades profissionais do mundo. 
                        Esta conquista representa anos de dedicação e aperfeiçoamento constante em desenvolvimento web e tecnologias digitais.
                    </p>

                    <div class="worldskills-stats">
                        <div class="stat-item">
                            <span class="stat-number">2025</span>
                            <span class="stat-label">Competição</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">70+</span>
                            <span class="stat-label">Países</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">1.500+</span>
                            <span class="stat-label">Competidores</span>
                        </div>
                    </div>

                    <div class="worldskills-skills">
                        <span class="skill-tag">Web Development</span>
                        <span class="skill-tag">Frontend</span>
                        <span class="skill-tag">Backend</span>
                        <span class="skill-tag">UI/UX Design</span>
                        <span class="skill-tag">JavaScript</span>
                        <span class="skill-tag">PHP</span>
                        <span class="skill-tag">React</span>
                        <span class="skill-tag">Node.js</span>
                    </div>
                </div>

                <div class="worldskills-visual">
                    <div class="floating-elements">
                        <i class="bi bi-code-slash floating-element" style="font-size: 24px; color: var(--primary-color);"></i>
                        <i class="bi bi-trophy floating-element" style="font-size: 20px; color: var(--secondary-color);"></i>
                        <i class="bi bi-globe floating-element" style="font-size: 22px; color: var(--primary-color-light);"></i>
                    </div>
                    
                    <div class="worldskills-medal">
                        <div class="medal-content">
                            <i class="bi bi-award medal-icon"></i>
                            <div class="medal-text">WorldSkills</div>
                            <div class="medal-year">China 2027</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- FORMULÁRIO DE CONTATO -->
    <section class="formulario" id="contato">
        <div class="floating-dots"></div>
        <div class="floating-dots"></div>
        <div class="floating-dots"></div>

        <div class="interface">
            <h2 class="titulo">Fale <span>Comigo</span></h2>

            <!-- Simulação de mensagens PHP para demonstração -->
            <!-- Exibir mensagens de erro -->
            <!-- 
            <?php if (!empty($erros)): ?>
                <div class="mensagem erro">
                    <ul style="margin: 0; padding-left: 20px;">
                        <?php foreach ($erros as $erro): ?>
                            <li><?php echo htmlspecialchars($erro); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            -->

            <!-- Demonstração de mensagem de erro -->
            <!-- <div class="mensagem erro">
                <ul style="margin: 0; padding-left: 20px;">
                    <li>Por favor, preencha o campo nome</li>
                    <li>E-mail inválido</li>
                </ul>
            </div> -->

            <!-- Exibir mensagem de sucesso -->
            <!-- 
            <?php if (!empty($sucesso)): ?>
                <div class="mensagem sucesso">
                    <?php echo htmlspecialchars($sucesso); ?>
                </div>
            <?php endif; ?>
            -->

            <!-- Demonstração de mensagem de sucesso -->
            <!-- <div class="mensagem sucesso">
                ✅ Mensagem enviada com sucesso! Entraremos em contato em breve.
            </div> -->

            <form action="processar_contato.php" method="POST" id="contactForm">
                <div class="form-group">
                    <input type="text" name="nome" placeholder="Seu nome completo" required
                           value="">
                           <!-- value="<?php echo htmlspecialchars($_POST['nome'] ?? ''); ?>"> -->
                </div>
                
                <div class="form-group">
                    <input type="email" name="email" placeholder="Seu melhor email" required
                           value="">
                           <!-- value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"> -->
                </div>
                
                <div class="form-group">
                    <input type="tel" name="telefone" placeholder="Seu telefone"
                           value="">
                           <!-- value="<?php echo htmlspecialchars($_POST['telefone'] ?? ''); ?>"> -->
                </div>
                
                <div class="form-group">
                    <textarea name="mensagem" placeholder="Sua mensagem..." required></textarea>
                    <!-- <?php echo htmlspecialchars($_POST['mensagem'] ?? ''); ?> -->
                </div>
                
                <div class="btn-enviar">
                    <input type="submit" value="ENVIAR MENSAGEM">
                </div>
            </form>
        </div>
    </section>

    <!-- RODAPÉ -->
   <footer>
        <div class="interface">
            <div class="line-footer">
                <div class="flex">
                    <div class="logo-footer">
                        <img src="images/logo.png" alt="Logo">
                    </div>
                    <p class="footer-description">Transformando ideias em experiências digitais memoráveis e inovadoras.</p>
                </div>
            </div>

            <div class="line-footer borda">
                <div class="contact-section">
                    <p>
                        <i class="bi bi-envelope-fill"></i>
                        <a href="mailto:contato@portfolio.com">contato@portfolio.com</a>
                    </p>
                </div>
            </div>

            <div class="line-footer borda">
                <div class="copyright-section">
                    <p>Criado por <a href="#">JeffCode</a> &copy; 2025 - Todos os direitos reservados</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
     <script>
        function debugSubmit(form) {
            console.log('🚀 Formulário sendo enviado...');
            console.log('Action:', form.action);
            console.log('Method:', form.method);
            
            // Capturar dados do formulário
            const formData = new FormData(form);
            console.log('📝 Dados do formulário:');
            for (let [key, value] of formData.entries()) {
                console.log(`  ${key}: ${value}`);
            }
            
            // Mostrar alerta de debug
            if (confirm('🔧 DEBUG: Enviar formulário?\n\nVerifique o console para detalhes.')) {
                console.log('✅ Usuário confirmou o envio');
                return true;
            } else {
                console.log('❌ Usuário cancelou o envio');
                return false;
            }
        }
        
        // Log quando a página carregar
        window.addEventListener('load', function() {
            console.log('📄 Página carregada');
            console.log('URL:', window.location.href);
            console.log('Hash:', window.location.hash);
            
            // Verificar se veio de redirecionamento
            const referrer = document.referrer;
            if (referrer) {
                console.log('🔄 Veio de:', referrer);
            }
        });
    </script>
    <script src="menu.js"></script>
</body>
</html>