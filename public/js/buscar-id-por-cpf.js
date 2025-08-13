import client_eleitor from './client-eleitor.js';
import express from 'express';

import grpc from '@grpc/grpc-js';
import protoLoader from '@grpc/proto-loader';
import path from 'path';
import { fileURLToPath } from 'url';

// Resolver __dirname no ES Module
const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const PROTO_PATH_ELEITOR = path.join(__dirname, '..', 'protos', 'sysele.proto');

const packageDefinition = protoLoader.loadSync(PROTO_PATH_ELEITOR, {
    keepCase: true,
    longs: String,
    enums: String,
    defaults: true,
    oneofs: true
});

const protoEleitor = grpc.loadPackageDefinition(packageDefinition).sysele;

// Conectar ao servidor gRPC na EC2
client_eleitor = new protoEleitor.SistemaVotacaoService(
    '18.118.122.201:8000',
    grpc.credentials.createInsecure()
);

const app = express();
app.use(express.json());

app.get('/buscar-pessoa-por-cpf', (req, res) => {
    const cpf = req.query.cpf;

    client_eleitor.BuscarPessoaPorCpf({
        cpf
    }, (err, response) => {
        if (err) {
            console.error('Erro ao buscar pessoa por CPF:', err);
        } else {
            console.log('Pessoa encontrada:', response);
        }
    });
});

app.listen(3000, () => {
  console.log('Servidor rodando na porta 3000');
});
