@extends('template.template')

@section('content')
    <style>
        .candidate-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .candidate-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .candidate-card.selected {
            border: 2px solid #667eea;
            background-color: #f8f9ff;
        }
    </style>
    <div id="votarScreen" class="screen">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3><i class="fas fa-vote-yea me-2"></i>Eleição Presidencial 2024</h3>
                    <button class="btn btn-secondary" onclick="showScreen('menuScreen')">
                        <i class="fas fa-arrow-left me-2"></i>Voltar
                    </button>
                </div>

                <p class="text-muted mb-4">Selecione seu candidato:</p>

                <div class="row">
                    @foreach ($eleicao['candidatos'] as $candidato)
                        <div class="col-md-4 mb-3">
                            <div class="card candidate-card" onclick="selectCandidate(this)">
                                <div class="card-body text-center">
                                    <i class="fas fa-user-circle fa-4x text-primary mb-3"></i>
                                    <h5>{{ $candidato['nome'] }}</h5>
                                    <p class="text-muted">Número: {{ $candidato['numero'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-4">
                    <button class="btn btn-success btn-lg" onclick="confirmarVoto()">
                        <i class="fas fa-check me-2"></i>Confirmar Voto
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function selectCandidate(card) {
            // Remove selection from all cards
            document.querySelectorAll('.candidate-card').forEach(c => {
                c.classList.remove('selected');
            });

            // Add selection to clicked card
            card.classList.add('selected');
        }

        async function confirmarVoto() {
            const selectedCard = document.querySelector('.candidate-card.selected');
            if (!selectedCard) {
                alert('Por favor, selecione um candidato antes de confirmar o voto.');
                return;
            }

            // Pega os dados do candidato selecionado
            const nome = selectedCard.querySelector('h5').innerText;
            const numero = selectedCard.querySelector('p').innerText.replace('Número: ', '').trim();

            // Aqui você deve substituir esses valores pelos reais do seu sistema
            const id_eleicao = '{{ $eleicao['id'] }}'; // pegando id da eleição do backend blade
            const id_eleitor = {{session('eleitor')['id']}}; // exemplo fixo, substitua pelo ID do eleitor real
            const id_candidato = numero; // usando o número como id do candidato (ajuste se for diferente)

            const voto = {
                id_eleicao,
                id_eleitor,
                id_candidato
            };

            // console.log(JSON.stringify(voto));

            try {
                const response = await fetch('http://13.221.77.151:8000/votar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(voto)
                });

                if (!response.ok) {
                    const errorText = await response.json();
                    throw new Error(errorText.detail);
                }

                const result = await response.json();
                alert('Voto enviado com sucesso!');
                // Aqui pode redirecionar ou mudar a tela, ex:
                // showScreen('menuScreen');
            } catch (error) {
                alert('Erro ao enviar voto: ' + error.message);
                console.error(error);
            }
        }
    </script>
@endsection
