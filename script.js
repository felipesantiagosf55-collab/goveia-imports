document.addEventListener("DOMContentLoaded", function () {
    const numeroWhatsapp = "5543999301558";
    const botoesComprar = document.querySelectorAll(".btn-tech");
    botoesComprar.forEach(botao => {
        botao.addEventListener("click", function (event) {
            event.preventDefault();
            const card = botao.closest("#Reservar");
            const nome = document.getElementById("nome").value.trim();
            const telefone = document.getElementById("tel").value.trim();
            const escolha = document.getElementById("escolha").value;
            if (!nome || !telefone || !escolha) {
                alert("Por favor, verifique se todas as informações foram preenchida 👍​");
                return
            }
            const mensagem = `*NOVA RESERVA - GoveiaImports*\n\n` +
                     `👤 *Nome:* ${nome}\n` +
                     `📞 *WhatsApp:* ${telefone}\n` +
                     `📱 *Iphone escolhido:* ${escolha}\n` +
                     `Gostaria de confirmar a Reserva de um Iphone!`;
            const mensagemCodificada = encodeURIComponent(mensagem);
            const linkWhatsApp = `https://wa.me/${numeroWhatsapp}?text=${mensagemCodificada}`;
            window.open(linkWhatsApp, "_blank");
        });
    });
}); 
document.addEventListener("DOMContentLoaded", function () {
    const numeroWhatsapp = "5543999301558";
    const botoesComprar = document.querySelectorAll(".btn-comprar");
    botoesComprar.forEach(botao => {
        botao.addEventListener("click", function (event) {
            event.preventDefault();
            const card = botao.closest(".produto-card");
            const modelo = card.querySelector(".p-modelo") ? card.querySelector(".p-modelo").innerText.trim() : "modelo";
            const cor = card.querySelector(".p-armazenamento") ? card.querySelector(".p-armazenamento").innerText.trim() : "armazenamento";
            const preco = card.querySelector(".p-preco") ? card.querySelector(".p-preco").innerText.trim() : "preco";
            const detalhe = card.querySelector(".p-detalhes") ? card.querySelector(".p-detalhes").innerText.trim() : "detalhes";
            const mensagem = 
`🔥 *GoveiaImports - NOVO PEDIDO DO SITE*

👋 Olá, Mathues! Gostaria de garantir este Iphone:

📦 *PRODUTO:* ${modelo}
📏 *COR/GB:* ${cor}
🔋 *BATERIA* ${detalhe}%
💰 *VALOR:* ${preco}

_Aguardando confirmação da compra!`;
            const mensagemCodificada = encodeURIComponent(mensagem);
            const linkWhatsApp = `https://wa.me/${numeroWhatsapp}?text=${mensagemCodificada}`;
            window.open(linkWhatsApp, "_blank");
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {
    const header = document.querySelector('header');
    const vitrine = document.querySelector('.vitrine');
    if (!header || !vitrine) return;
    const cards = Array.from(vitrine.querySelectorAll(':scope > .produto-card'));
    if (cards.length === 0) return;
    const DESKTOP_BREAKPOINT = 992;
    function atualizarAlturaHeader() {
        document.documentElement.style.setProperty('--header-h', header.offsetHeight + 'px');
    }
    function limparEstilosCards() {
        cards.forEach((card) => {
            card.style.transform = '';
            card.style.opacity = '';
        });
    }
    function atualizarEmpilhamento() {
        if (window.innerWidth >= DESKTOP_BREAKPOINT) {
            limparEstilosCards();
            return;
        }
        const headerH = header.offsetHeight;
        for (let i = 0; i < cards.length - 1; i++) {
            const atual = cards[i];
            const proximo = cards[i + 1];
            const alturaAtual = atual.offsetHeight;
            const topoProximo = proximo.getBoundingClientRect().top;
            let progresso = (headerH + alturaAtual - topoProximo) / alturaAtual;
            progresso = Math.min(Math.max(progresso, 0), 1);
            const escala = 1 - progresso * 0.12;
            const opacidade = 1 - progresso * 0.55;
            atual.style.transform = `scale(${escala})`;
            atual.style.opacity = opacidade;
        }
        const ultimo = cards[cards.length - 1];
        ultimo.style.transform = '';
        ultimo.style.opacity = '';
    }
    let ticking = false;
    function onScrollOrResize() {
        if (!ticking) {
            requestAnimationFrame(() => {
                atualizarEmpilhamento();
                ticking = false;
            });
            ticking = true;
        }
    }
    atualizarAlturaHeader();
    atualizarEmpilhamento();
    window.addEventListener('scroll', onScrollOrResize, { passive: true });
    window.addEventListener('resize', () => {
        atualizarAlturaHeader();
        onScrollOrResize();
    });
});
const element = document.getElementById('tel');
const maskOptions = {
  mask: '(00) 0 0000-0000'
};
const mask = IMask(element, maskOptions);
document.querySelectorAll('.linha-produtos').forEach(linha => {
    const grid = linha.querySelector('.produtos-grid');
    const indicatorsContainer = linha.querySelector('.carrossel-indicators');
    if (!grid || !indicatorsContainer) return;

    const cards = grid.querySelectorAll('.produto-card');
    
    // 1. Cria dinamicamente uma bolinha para cada card encontrado
    cards.forEach((card, index) => {
        const dot = document.createElement('div');
        dot.classList.add('indicator-dot');
        if (index === 0) dot.classList.add('active'); // Primeira bolinha começa ativa
        indicatorsContainer.appendChild(dot);
    });

    const dots = indicatorsContainer.querySelectorAll('.indicator-dot');

    // 2. Atualiza a bolinha verde com base na rolagem lateral do carrossel
    grid.addEventListener('scroll', () => {
        const scrollLeft = grid.scrollLeft;
        const cardWidth = cards[0].offsetWidth + 18; // Largura do card + o gap (18px)
        
        // Calcula o índice do card que está mais visível no centro/esquerda
        const activeIndex = Math.round(scrollLeft / cardWidth);

        // Atualiza a classe active nas bolinhas
        dots.forEach((dot, index) => {
            if (index === activeIndex) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    });
});
