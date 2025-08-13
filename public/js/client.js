import express from 'express';
import grpc from '@grpc/grpc-js';
import protoLoader from '@grpc/proto-loader';
import path from 'path';

const app = express();

// MIDDLEWARES ESSENCIAIS
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

const PROTO_PATHS = [
    path.resolve('./public/protos/sysele.proto'),
    path.resolve('./public/protos/cargo.proto'),
    path.resolve('./public/protos/eleicao.proto'),
    path.resolve('./public/protos/candidato.proto'),
];

const packageDefinition = protoLoader.loadSync(PROTO_PATHS);
const proto = grpc.loadPackageDefinition(packageDefinition);

// const client_cargo = new proto.cargo.CargoService(
//     '18.118.122.201:8000',
//     grpc.credentials.createInsecure()
// );

// const client_candidato = new proto.candidato.CandidatoService(
//     '18.118.122.201:8000',
//     grpc.credentials.createInsecure()
// );



app.post('/criar-eleicao', (req, res) => {
    const client_eleicao = new proto.eleicao.EleicaoService(
        '18.117.137.25:50051',
        grpc.credentials.createInsecure()
    );
    client_eleicao.CreateEleicao(req.body, (error, grpcResponse) => {
        if (error) {
            console.error('Erro gRPC:', error);
            return res.status(500).json({ error: error.message });
        }
        return res.json(grpcResponse);
    });
});

app.get('/buscar-pessoa-por-cpf', (req, res) => {
    const client_eleitor = new proto.sysele.SistemaVotacaoService(
        '18.118.122.201:8000',
        grpc.credentials.createInsecure()
    );

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
    const client_eleitor = new proto.sysele.SistemaVotacaoService(
        '18.118.122.201:8000',
        grpc.credentials.createInsecure()
    );
    let eleitorRaw = { ...req.body };
    console.log('Recebido do Laravel (raw):', eleitorRaw);

    // pega o objeto eleitor (aceita wrapper ou body direto)
    let eleitor = eleitorRaw.eleitor ? eleitorRaw.eleitor : eleitorRaw;

    // --- normaliza nomes possíveis (aceita data_nascimento ou dataNascimento vindo do Laravel)
    // Se veio em snake_case converte para camelCase (só por segurança).
    if (!eleitor.dataNascimento && eleitor.data_nascimento) {
        eleitor.dataNascimento = eleitor.data_nascimento;
        delete eleitor.data_nascimento;
    }

    // verifica presença básica
    if (!eleitor || !eleitor.dataNascimento) {
        return res.status(400).json({ error: 'Campo dataNascimento ausente' });
    }

    // garante formato DD-MM-YYYY no payload que queremos (você pediu dataNascimento = '12-12-1998')
    // se Laravel já enviou nesse formato, okay; senão, converte:
    const raw = String(eleitor.dataNascimento).trim();

    function toDDMMYYYY(s) {
        // já dd-mm-yyyy
        if (/^\d{2}-\d{2}-\d{4}$/.test(s)) return s;
        // dd/mm/yyyy -> dd-mm-yyyy
        if (/^\d{2}\/\d{2}\/\d{4}$/.test(s)) {
            const [dd, mm, yyyy] = s.split('/');
            return `${dd}-${mm}-${yyyy}`;
        }
        // yyyy-mm-dd -> dd-mm-yyyy
        if (/^\d{4}-\d{2}-\d{2}$/.test(s)) {
            const [yyyy, mm, dd] = s.split('-');
            return `${dd}-${mm}-${yyyy}`;
        }
        // yyyy/mm/dd -> dd-mm-yyyy
        if (/^\d{4}\/\d{2}\/\d{2}$/.test(s)) {
            const [yyyy, mm, dd] = s.split('/');
            return `${dd}-${mm}-${yyyy}`;
        }
        // ISO full -> extrai data
        if (/^\d{4}-\d{2}-\d{2}T/.test(s)) {
            const datePart = s.split('T')[0];
            const [yyyy, mm, dd] = datePart.split('-');
            return `${dd}-${mm}-${yyyy}`;
        }
        // tentativa com Date
        const d = new Date(s);
        if (!isNaN(d.getTime())) {
            const yyyy = d.getFullYear();
            const mm = String(d.getMonth() + 1).padStart(2, '0');
            const dd = String(d.getDate()).padStart(2, '0');
            return `${dd}-${mm}-${yyyy}`;
        }
        return null;
    }

    const ddmmyyyy = toDDMMYYYY(raw);
    if (!ddmmyyyy) {
        console.error('Formato de data não reconhecido:', raw);
        return res.status(400).json({ error: 'Formato de dataNascimento inválido: ' + raw });
    }

    eleitor.dataNascimento = ddmmyyyy; // garante DD-MM-YYYY (camelCase) como você pediu

    // --- mapear status string para enum numérico do proto (por segurança)
    const STATUS_MAP = { 'ATIVO': 0, 'INATIVO': 1, 'SUSPENSO': 2, 'ATivo': 0, 'Ativo': 0 };
    let statusValue = eleitor.status;
    if (typeof statusValue === 'string') {
        const key = statusValue.toUpperCase();
        statusValue = (STATUS_MAP[key] !== undefined) ? STATUS_MAP[key] : statusValue;
    }

    // monta o objeto que vamos enviar ao gRPC (mantendo camelCase para os campos)
    const grpcPayload = {
        eleitor: {
            id: eleitor.id,
            nome: eleitor.nome,
            email: eleitor.email,
            cpf: eleitor.cpf,
            dataNascimento: eleitor.dataNascimento, // camelCase e DD-MM-YYYY
            status: statusValue,
            vinculos: Array.isArray(eleitor.vinculos) ? eleitor.vinculos : []
        }
    };

    console.log('Pronto para gRPC (payload):', JSON.stringify(grpcPayload, null, 2));

    client_eleitor.SalvarEleitor(grpcPayload, (error, grpcResponse) => {
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
