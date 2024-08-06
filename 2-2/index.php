<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TreeMap em PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 90%;
            height: 90%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .treemap {
            width: 100%;
            height: 100%;
            border: 1px solid #ccc;
            position: relative;
        }

        .div {
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #000;
            box-sizing: border-box;
            color: #fff;
            font-weight: bold;
            position: absolute;
            text-align: center;
            overflow: hidden;
            padding: 5px;
        }

        .div p {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>TreeMap Dinâmico</h1>
        <form id="tree-form">
            <label for="acao">Ação</label>
            <select name="acao" id="acao">
                <option value="inserir">Inserir</option>
                <!-- <option value="obter">Buscar</option> -->
                <option value="remover">Remover</option>
            </select>
            <label for="chave">Chave</label>
            <input type="text" name="chave" id="chave">
            <label for="valor" id="valor-label">Valor</label>
            <input type="text" name="valor" id="valor">
            <button type="submit">Executar</button>
        </form>
        <div id="resultado" class="treemap">
        </div>
    </div>

    <script src="jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#acao").change(function() {
                var acao = $(this).val();
                if (acao === "inserir") {
                    $("#valor-label").show();
                    $("#valor").show();
                } else {
                    $("#valor-label").hide();
                    $("#valor").hide();
                }
            }).change();

            $("#tree-form").on("submit", function(e) {
                e.preventDefault();
                var acao = $("#acao").val();
                var chave = $("#chave").val();
                var valor = $("#valor").val();

                $.ajax({
                    url: "ajax-TreeMap.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        acao: acao,
                        chave: chave,
                        valor: valor
                    },
                    success: function(response) {
                        const total = somaValoresNo(response);
                        const array = transformarEmArray(response);

                        const local = $("#resultado");

                        melhorLocal(local, array, 0, 0, local.width(), local.height(), total);


                    },
                    error: function(jqXHR, status, error) {
                        console.error(error);
                    }
                });
            });


            function somaValoresNo(no) {
                if (no === null) {
                    return 0;
                }

                const valor = parseFloat(no.valor) || 0;
                const somaEsquerda = somaValoresNo(no.noEsquerda);
                const somaDireita = somaValoresNo(no.noDireita);

                return valor + somaEsquerda + somaDireita;
            }

            function transformarEmArray(no) {
                const resultado = [];

                function percorrer(no) {
                    if (no === null) return;

                    resultado.push({
                        chave: no.chave,
                        valor: parseFloat(no.valor)
                    });

                    percorrer(no.noEsquerda);
                    percorrer(no.noDireita);
                }
                percorrer(no);

                return resultado;
            }

            function melhorLocal(local, array, x, y, largura, altura, total) {
                if (array.length === 0) return;

                let linha = [];
                let qtdArray = [...array];
                let proporcao = Infinity;

                var arrayMaior = [];

                let retorno = 0;

                while (qtdArray.length > 0) {
                    linha.push(qtdArray.shift());

                    const novaProporcao = calcularProporcao(linha, largura, altura, total);

                    console.log(novaProporcao);

                    if (novaProporcao <= proporcao) {
                        proporcao = novaProporcao;
                    } else {
                        qtdArray.unshift(linha.pop());
                        retorno = montarLinha(local, linha, x, y, largura, altura, total);

                        y += retorno;
                        linha = [];
                        proporcao = Infinity;
                    }


                }

                if (linha.length > 0) {
                    montarLinha(local, linha, x, y, largura, altura, total);
                }

            }

            function montarLinha(local, linha, x, y, largura, altura, total) {

                let totalLinha = linha.reduce((sum, item) => sum + item.valor, 0);
                let alturaLinha = (totalLinha / total) * altura;

                let atualX = x;

                linha.forEach(item => {
                    let larguraItem = (item.valor / totalLinha) * largura;

                    let $div = $('<div></div>', {
                        class: 'div',
                        css: {
                            left: `${atualX}px`,
                            top: `${y}px`,
                            width: `${larguraItem}px`,
                            height: `${alturaLinha}px`,
                            backgroundColor: corRandomica()
                        },
                        html: `<p>${item.chave} - Valor: ${item.valor}</p>`
                    });

                    $div.appendTo(local);
                    atualX += larguraItem;
                });

                return alturaLinha;
            }

            function calcularProporcao(linha, largura, altura, total) {

                const totalLinha = linha.reduce((sum, item) => sum + item.valor, 0);

                const area = (totalLinha / total) * (largura * altura);

                const larguraLinha = area / altura;

                const proporcao = Math.max(larguraLinha / altura, altura / larguraLinha);

                return proporcao;
            }

            function corRandomica() {
                const hexa = '0123456789ABCDEF';
                let color = '#';
                for (let i = 0; i < 6; i++) {
                    color += hexa[Math.floor(Math.random() * 16)];
                }
                return color;
            }
        });
    </script>
</body>

</html>