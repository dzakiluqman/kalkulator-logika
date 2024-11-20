<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Logika</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1D1B31;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .calculator {
            width: 360px; 
            background: #2A2B3C;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }
        .calculator .screen {
            width: 100%;
            height: 60px;
            border: none;
            background: #3A3B4F;
            color: #fff;
            font-size: 1.5em;
            text-align: right;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            box-sizing: border-box; 
        }
        .calculator .buttons {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }
        .calculator .expressions {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-top: 10px;
        }
        .calculator button {
            width: 100%;
            aspect-ratio: 1;
            padding: 15px;
            font-size: 1.2em;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-sizing: border-box; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
            transition: all 0.2s ease-in-out;
        }
        .calculator button.operand {
            background: #502753;
            color: #fff;
        }
        .calculator button.operator {
            background: #3A3B4F;
            color: #fff;
        }
        .calculator button.clear {
            background: #dc3545;
            color: #fff;
        }
        .calculator button.calculate {
            background: #502753;
            color: #fff;
        }
        .calculator button:hover {
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15); 
        }
        .result {
            margin-top: 20px;
            font-size: 1.2em;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="calculator">
        <form id="logicForm" action="{{ route('kalkulator.calculate') }}" method="POST">
            @csrf
            <!-- Display Screen -->
            <input type="text" id="screen" class="screen" name="expression" readonly>

            <!-- Buttons -->
            <div class="buttons">
                <!-- First Row: True and False -->
                <button type="button" class="operand" onclick="appendToScreen('1')">True</button>
                <button type="button" class="operand" onclick="appendToScreen('0')">False</button>
                <button type="button" class="operator" onclick="appendToScreen('(')">(</button>
                <button type="button" class="operator" onclick="appendToScreen(')')">)</button>
            </div>
            <div class="expressions">
                <!-- Second Row: Logical Expressions (Negation, Conjunction, Disjunction, Implication) -->
                <button type="button" class="operator" onclick="appendToScreen('¬')">¬</button>
                <button type="button" class="operator" onclick="appendToScreen('∧')">∧</button>
                <button type="button" class="operator" onclick="appendToScreen('∨')">∨</button>
                <button type="button" class="operator" onclick="appendToScreen('→')">→</button>

                <!-- Third Row: Bi-implication, XOR, C (Clear), = (Calculate) -->
                <button type="button" class="operator" onclick="appendToScreen('↔')">↔</button>
                <button type="button" class="operator" onclick="appendToScreen('⊕')">⊕</button>
                <button type="button" class="backspace" onclick="backspace()">←</button>
                <button type="button" class="calculate" onclick="submitForm()">=</button>
            </div>
        </form>

        <!-- Result -->
        @if(isset($result))
            <div class="result">
                <strong>Hasil:</strong> {{ $result ? 'true' : 'false' }}
            </div>
        @endif

        <!-- Errors -->
        @if($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <script>
        const screen = document.getElementById('screen');

        // Append input to the screen
        function appendToScreen(value) {
            screen.value += value + ' ';
        }

        // Clear the screen
        function clearScreen() {
            screen.value = '';
        }

        // Backspace functionality
        function backspace() {
            screen.value = screen.value.trim(); // Remove trailing spaces
            screen.value = screen.value.slice(0, -1).trim(); // Remove last character and trailing space
        }


        // Submit the form
        function submitForm() {
            const form = document.getElementById('logicForm');
            if (screen.value.trim() === '') {
                alert('Masukkan ekspresi logika terlebih dahulu!');
                return;
            }
            form.submit();
        }
    </script>
</body>
</html>
