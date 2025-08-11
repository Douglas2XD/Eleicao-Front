import client_eleitor from './client-eleitor.js';

const cpfJson = process.argv[2];
const cpf = JSON.parse(cpfJson);

client_eleitor.BuscarPessoaPorCpf({cpf}, (err, response) => {
    if (err) {
        console.error('Erro ao buscar pessoa por CPF:', err);
    } else {
        console.log('Pessoa encontrada:', response);
    }
});
