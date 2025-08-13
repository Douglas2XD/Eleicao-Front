import express from 'express';
import grpc from '@grpc/grpc-js';
import protoLoader from '@grpc/proto-loader';
import path from 'path';

const app = express();

// MIDDLEWARES ESSENCIAIS
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

const PROTO_PATH = path.resolve('./public/protos/eleicao.proto');
const packageDefinition = protoLoader.loadSync(PROTO_PATH);
const proto = grpc.loadPackageDefinition(packageDefinition).sysele;

const client_eleitor = new proto.SistemaVotacaoService(
    '18.118.122.201:50051', 
    grpc.credentials.createInsecure()
);

app.get('/buscar-pessoa-por-cpf', (req, res) => {
    const cpf = req.query.cpf;
    
    if (!cpf) {
        return res.status(400).json({ error: 'CPF é obrigatório' });
    }

    client_eleitor.BuscarPessoaPorCpf({ cpf: cpf }, (error, grpcResponse) => {
        if (error) {
            console.error('Erro gRPC:', error);
            return res.status(500).json({ error: error.message });
        }
        return res.json(grpcResponse);
    });
});

app.post('/enviar-eleitor', (req, res) => {
    const eleitor = req.body;
    
    console.log('Dados recebidos:', eleitor);
    
    client_eleitor.EnviarEleitor(eleitor, (error, grpcResponse) => {
        if (error) {
            console.error('Erro gRPC:', error);
            return res.status(500).json({ error: error.message });
        }
        return res.json(grpcResponse);
    });
});

app.listen(3000, () => {
    console.log('Servidor Node.js rodando na porta 3000');
});