import client_eleitor from './client-eleitor.js';

// Receber os dados do eleitor via argumento CLI
const eleitorJson = process.argv[2];
const eleitor = JSON.parse(eleitorJson);

client_eleitor.SalvarEleitor(eleitor, (err, response) => {
    if (err) {
        console.error('Erro ao salvar eleitor:', err);
        process.exit(1);
    } else {
        console.log(JSON.stringify(response));
        process.exit(0);
    }
});
