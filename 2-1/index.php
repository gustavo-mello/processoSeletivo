<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de Números</title>
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
            padding: 20px 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            max-width: 400px;
            width: 100%;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-top: 0;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        select,
        input {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .resultado {
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
            font-size: 1.2em;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Conversor de Números</h1>
        <form id="converte-numeros">
            <label for="tipo">Escolha qual converção</label>
            <select name="tipo" id="tipo">
                <option value="1">Número Indo Arabico para Número Romano</option>
                <option value="2">Número Romano para Número Indo Arabico</option>
            </select>

            <label for="numero">Número para converter</label>
            <input type="text" name="numero" id="numero">

            <div id="resultado" class="resultado"></div>

            <button type="submit">Converter</button>
        </form>
       
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script>
        $("#converte-numeros").on("submit", function(e) {
            var tipo = $("#tipo").val();
            var numero = $("#numero").val();

            e.preventDefault();

            $.ajax({
                url: "ajax-conversor.php",
                type: "POST",
                dataType: "json",
                data: {
                    tipo: tipo,
                    numero: numero
                },
                success: function(response) {
                    $("#resultado").text(response);

                },
                error: function(jqXHR, status, error) {}
            });

        });
    </script>
</body>

</html>