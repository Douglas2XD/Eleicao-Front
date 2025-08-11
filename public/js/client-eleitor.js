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
const client_eleitor = new protoEleitor.SistemaVotacaoService(
    '18.118.122.201:8000',
    grpc.credentials.createInsecure()
);
