function mudarPersonagem(nomeDoArquivo) {
    document.getElementById('camada-personagem').src = '../IMG/Personagems/' + nomeDoArquivo;
}

function mudarBorda(nomeDoArquivo) {
    document.getElementById('camada-borda').src = '../IMG/Bordas/' + nomeDoArquivo;
}

function desenharComCover(ctx, img, targetWidth, targetHeight) {
    const imgRatio = img.naturalWidth / img.naturalHeight;
    const targetRatio = targetWidth / targetHeight;
    let sX = 0, sY = 0, sWidth = img.naturalWidth, sHeight = img.naturalHeight;

    if (imgRatio > targetRatio) {
        sWidth = img.naturalHeight * targetRatio;
        sX = (img.naturalWidth - sWidth) / 2;
    } else {
        sHeight = img.naturalWidth / targetRatio;
        sY = (img.naturalHeight - sHeight) / 2;
    }
    ctx.drawImage(img, sX, sY, sWidth, sHeight, 0, 0, targetWidth, targetHeight);
}

document.addEventListener('DOMContentLoaded', () => {
    const btnSalvar = document.querySelector('.btn-salvar');
    if (!btnSalvar) return;

    btnSalvar.addEventListener('click', async () => {
        const titulo = prompt("Digite um título para o seu cartaz:");
        if (!titulo || !titulo.trim()) return;

        const imgPersonagem = document.getElementById('camada-personagem');
        const imgBorda = document.getElementById('camada-borda');

        const aguardar = (img) => new Promise((res) => {
            if (img.complete && img.naturalWidth !== 0) res();
            else img.onload = () => res();
        });

        await Promise.all([aguardar(imgPersonagem), aguardar(imgBorda)]);

        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = 400;
        canvas.height = 560;

        desenharComCover(ctx, imgPersonagem, canvas.width, canvas.height);
        desenharComCover(ctx, imgBorda, canvas.width, canvas.height);

        const imagemBase64 = canvas.toDataURL('image/png');

        try {
            const resposta = await fetch('../PHP/salvar_cartaz.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ titulo: titulo.trim(), imagem: imagemBase64 })
            });
            const resultado = await resposta.json();
            alert(resultado.mensagem);
        } catch (erro) {
            alert("Erro ao comunicar com o servidor.");
        }
    });
});