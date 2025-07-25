{{-- {{dd($avaliacao)}} --}}
<div style="display: flex; align-items: center; justify-content: center; gap: 20px; overflow: hidden; margin: 10px;">
    <div style="height: 80px; max-width: 100%;">
        <img src="{{ asset('assets/img/brasao_pcpb.png') }}" alt="Brasão PCPB"
            style="height: 80px; max-width: 100%; object-fit: contain;">
    </div>
    <div style="text-align: right;">
        <span style="font-family: Arial;">
            <nobr>Polícia Civil</nobr>
        </span><br>
        <strong style="font-family: Arial;">
            <nobr>Delegacia Geral</nobr>
        </strong><br>
        <span style="font-family: Arial;">
            <nobr>Recursos Humanos</nobr>
        </span>
    </div>
    <div style="height: 80px; max-width: 100%;">
        <img src="{{ asset('assets/img/logo_pb.png') }}" alt="Logomarca governo da Paraíba"
            style="height: 80px; max-width: 100%; object-fit: contain;">
    </div>
</div>

<div
    style="background-color: black; color: white; text-align: center; padding: 5px; font-family: Arial; font-weight: bold; font-size: 14px; margin: 0 10px;">
    FICHA DE AVALIAÇÃO DE DESEMPENHO INDIVIDUAL MENSAL
</div>

<table
    style="border-collapse: collapse; border: 1px solid black; font-family: Arial; margin: 10px 10px; font-size: 11px; width: calc(100% - 20px);">
    <tr>
        <td style="border: 1px solid black;" colspan="4"><strong>NOME DO AVALIADO:
            </strong>{{ $avaliacao->servidor_avaliacao_desempenho_servidor->nome }}</td>
    </tr>
    <tr>
        <td style="border: 1px solid black;" colspan="2"><strong>MATRICULA:</strong>
            {{ $avaliacao->servidor_avaliacao_desempenho_servidor->matricula }}</td>
        <td style="border: 1px solid black;" colspan="2"><strong>DATA DE NOMEAÇÃO:</strong>
            {{ date('d/m/Y', strtotime($avaliacao->servidor_avaliacao_desempenho_servidor->datanomeacao)) }}</td>
    </tr>
    <tr>
        <td style="border: 1px solid black;" colspan="2"><strong>CARGO:</strong>
            {{ $avaliacao->servidor_avaliacao_desempenho_servidor->cargo_nome->nome ?? '-' }}
        </td>
        <td style="border: 1px solid black;" colspan="2"><strong>CLASSE:</strong> {{ $avaliacao->servidor_avaliacao_desempenho_servidor->classe }}</td>
    </tr>
    <tr>
        <td style="border: 1px solid black;" colspan="4"><strong>UNIDADE\ÓRGÃO\ENTIDADE:</strong> {{ $avaliacao->servidor_avaliacao_desempenho_servidor->unidades->nome ?? '-' }}</td>
    </tr>
    <tr>
        <td style="border: 1px solid black;" colspan="4"><strong>AVALIAÇÃO REFERENTE AO MÊS DE:</strong> {{['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'][$avaliacao->mes - 1]}} de {{$avaliacao->ano}}</td>
    </tr>
    <tr>
        <th style="border: 1px solid black; text-align: center;">Nº</th>
        <th style="border: 1px solid black; text-align: center;" colspan="2">CRITÉRIOS – C</th>
        <th style="border: 1px solid black; text-align: center;">AVALIAÇÃO (0 a 10)</th>
    </tr>
    <tr>
        <th style="border: 1px solid black;">
            <nobr>C-1</nobr>
        </th>
        <th style="border: 1px solid black;">PRODUTIVIDADE NO DESEMPENHO DAS FUNÇÕES</th>
        <td style="border: 1px solid black;">
            - Postura orientada para a busca continua da satisfação das necessidades e superação das expectativas dos
            clientes internos e externos.
            - Capacidade de produzir mais com menor quantidade de recursos ou em menor espaço de tempo. Pode-se
            traduzir, também, na capacidade de atingir resultados em tempo mais curto.</td>
        <td style="border: 1px solid black; text-align: center;">{{ $avaliacao->c1 }}</td>
    </tr>
    <tr>
        <th style="border: 1px solid black;">
            <nobr>C-2</nobr>
        </th>
        <th style="border: 1px solid black;">CONHECIMENTO DE MÉTODOS E TÉCNICAS NECESSÁRIOS PARA O DESENVOLVIMENTO DAS
            ATIVIDADES REFERENTES AO CARGO EFETIVO NA UNIDADE DE EXERCÍCIO</th>
        <td style="border: 1px solid black;">
            - Executa corretamente as atividades pelas quais é responsável, demonstrando percepção do impacto do seu
            trabalho sobre as demais tarefas.
            - Apresenta domínio dos processos, ferramentas e habilidades necessárias ao desempenho das atividades no
            trabalho.
            - Compreende os problemas relativos às suas atividades e sabe como resolvê-los.
            - Percebe possíveis problemas em suas atividades, propõe alternativas de solução e comunica às pessoas
            responsáveis pela solução</td>
        <td style="border: 1px solid black; text-align: center;">{{ $avaliacao->c2 }}</td>
    </tr>
    <tr>
        <th style="border: 1px solid black;">
            <nobr>C-3</nobr>
        </th>
        <th style="border: 1px solid black;">VISÃO SISTÊMICA, TRABALHO EM EQUIPE E LIDERANÇA</th>
        <td style="border: 1px solid black;">
            - Executa corretamente as atividades pelas quais é responsável, demonstrando percepção do impacto do seu
            trabalho sobre as demais tarefas.
            - Apresenta domínio dos processos, ferramentas e habilidades necessárias ao desempenho das atividades no
            trabalho.
            - Compreende os problemas relativos às suas atividades e sabe como resolvê-los.
            - Percebe possíveis problemas em suas atividades, propõe alternativas de solução e comunica às pessoas
            responsáveis pela solução.</td>
        <td style="border: 1px solid black; text-align: center;">{{ $avaliacao->c3 }}</td>
    </tr>
    <tr>
        <th style="border: 1px solid black;">
            <nobr>C-4</nobr>
        </th>
        <th style="border: 1px solid black;">COMPROMETIMENTO COM O TRABALHO</th>
        <td style="border: 1px solid black;">
            - Executa suas atividades visando um resultado final.
            - Busca continuamente o alcance das metas e objetivos individuais, visando à obtenção de resultados para a
            instituição.
            - Busca a ampliação do conhecimento em sua área de atuação, mantendo-se atualizado por iniciativa própria
            ou aproveitando as oportunidades oferecidas pela instituição.</td>
        <td style="border: 1px solid black; text-align: center;">{{ $avaliacao->c4 }}</td>
    </tr>
    <tr>
        <th style="border: 1px solid black;">
            <nobr>C-5</nobr>
        </th>
        <th style="border: 1px solid black;">CUMPRIMENTO DAS NORMAS DE PROCEDIMENTOS E DE CONDUTA NO DESEMPENHO DAS
            ATRIBUIÇÕES DO CARGO</th>
        <td style="border: 1px solid black;">
            - Comparece com regularidade e prontidão ao local de trabalho, cumprindo o horário preestabelecido para
            sua jornada.
            - Conhece e cumpre as normas gerais de estrutura e funcionamento da instituição, bem como os regulamentos
            vigentes na área de atuação.
            - Aplica procedimentos adequados ao bom funcionamento da Unidade.</td>
        <td style="border: 1px solid black;text-align: center;">{{ $avaliacao->c5 }}</td>
    </tr>
    <tr>
        <th style="border: 1px solid black; text-align:right;" colspan="3">PONTUAÇÃO OBTIDA NO FORMULÁRIO</th>
        <th style="border: 1px solid black; text-align: center;">{{ $avaliacao->total }}</th>
    </tr>
</table>
