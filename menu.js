// Menu mobile
let btnMenu = document.getElementById('btn-menu');
let menu = document.getElementById('menu-mobile');
let overlay = document.getElementById('overlay-menu');

btnMenu.addEventListener('click', () => {
    menu.classList.add('abrir-menu');
});

menu.addEventListener('click', () => {
    menu.classList.remove('abrir-menu');
});

overlay.addEventListener('click', () => {
    menu.classList.remove('abrir-menu');
});

// Fechar menu ao clicar em um link
const menuLinks = document.querySelectorAll('.menu-mobile nav ul li a');
menuLinks.forEach(link => {
    link.addEventListener('click', () => {
        menu.classList.remove('abrir-menu');
    });
});

// Header fixo com efeito ao rolar a página
const header = document.querySelector('header');
window.addEventListener('scroll', () => {
    if (window.scrollY > 100) {
        header.classList.add('sticky');
    } else {
        header.classList.remove('sticky');
    }
});

// Animações ao scroll
const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animated');
        }
    });
}, {
    threshold: 0.1
});

// Elementos para animação
document.addEventListener('DOMContentLoaded', () => {
    const animatedElements = [
        ...document.querySelectorAll('.especialidades-box'),
        ...document.querySelectorAll('.img-port'),
        ...document.querySelectorAll('.contador-item'),
        ...document.querySelectorAll('.depoimento-item'),
        document.querySelector('.txt-sobre'),
        document.querySelector('.img-sobre'),
        document.querySelector('section.formulario .titulo'),
        document.querySelector('form')
    ];

    animatedElements.forEach(el => {
        if (el) {
            observer.observe(el);
        }
    });

    // Botão voltar ao topo
    const btnTopo = document.createElement('div');
    btnTopo.classList.add('btn-topo');
    btnTopo.innerHTML = '<i class="bi bi-arrow-up"></i>';
    document.body.appendChild(btnTopo);

    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            btnTopo.classList.add('active');
        } else {
            btnTopo.classList.remove('active');
        }
    });

    btnTopo.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    // Animação de carregamento da página
    const loader = document.createElement('div');
    loader.classList.add('loader');
    loader.innerHTML = '<div class="spinner"></div>';
    document.body.appendChild(loader);

    window.addEventListener('load', () => {
        setTimeout(() => {
            loader.classList.add('fade-out');
            
            setTimeout(() => {
                loader.remove();
            }, 800);
        }, 1000);
    });

    // Contador de números
    const contadorItems = document.querySelectorAll('.contador-item .numero');
    
    if (contadorItems.length > 0) {
        const contadorObserver = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = entry.target;
                    const countTo = parseInt(target.getAttribute('data-count'));
                    let count = 0;
                    const speed = Math.floor(2000 / countTo);
                    
                    const updateCount = () => {
                        if (count < countTo) {
                            count++;
                            target.textContent = count;
                            setTimeout(updateCount, speed);
                        } else {
                            target.textContent = countTo;
                        }
                    };
                    
                    updateCount();
                    contadorObserver.unobserve(target);
                }
            });
        }, {
            threshold: 0.5
        });
        
        contadorItems.forEach(item => {
            const value = item.textContent;
            item.setAttribute('data-count', value);
            item.textContent = '0';
            contadorObserver.observe(item);
        });
    }

    // Efeito de digitação para texto animado
    const textoAnimado = document.querySelectorAll('.texto-animado h3 span');
    
    if (textoAnimado.length > 0) {
        textoAnimado.forEach(texto => {
            const palavras = texto.getAttribute('data-palavras').split(',');
            let wordIndex = 0;
            let charIndex = 0;
            let isDeleting = false;
            
            const type = () => {
                const palavra = palavras[wordIndex];
                
                if (isDeleting) {
                    texto.textContent = palavra.substring(0, charIndex - 1);
                    charIndex--;
                } else {
                    texto.textContent = palavra.substring(0, charIndex + 1);
                    charIndex++;
                }
                
                if (!isDeleting && charIndex === palavra.length) {
                    isDeleting = true;
                    setTimeout(type, 1500);
                } else if (isDeleting && charIndex === 0) {
                    isDeleting = false;
                    wordIndex = (wordIndex + 1) % palavras.length;
                    setTimeout(type, 500);
                } else {
                    setTimeout(type, isDeleting ? 50 : 100);
                }
            };
            
            type();
        });
    }

    // Adicionar funcionalidade de smooth scroll para os links do menu
    const allLinks = document.querySelectorAll('header nav ul li a, .btn-contato a');
    allLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            if (href.startsWith('#') && href !== '#') {
                e.preventDefault();
                const targetSection = document.querySelector(href);
                
                if (targetSection) {
                    window.scrollTo({
                        top: targetSection.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
});


// Efeito de parallax para fundos
window.addEventListener('scroll', () => {
    const scrollPosition = window.pageYOffset;
    
    // Efeito parallax para seções específicas
    const sections = document.querySelectorAll('section.sobre, section.portfolio');
    sections.forEach(section => {
        const distance = section.getBoundingClientRect().top + scrollPosition;
        const offset = (scrollPosition - distance) * 0.1;
        
        if (scrollPosition > distance - window.innerHeight && 
            scrollPosition < distance + section.offsetHeight) {
            section.style.backgroundPositionY = `${offset}px`;
        }
    });
});