<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogikaController extends Controller
{
    public function index()
    {
        return view('kalkulator-logika.index');
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'expression' => 'required|string',
        ]);

        $expression = $request->input('expression');

        // Preprocess the expression to match PHP syntax
        $parsedExpression = $this->convertToPHPLogic($expression);

        try {
            // Evaluate the parsed expression
            $result = eval("return {$parsedExpression};");
        } catch (\Throwable $e) {
            return back()->withErrors(['error' => 'Ekspresi logika tidak valid.'])->withInput();
        }

        return view('kalkulator-logika.index', [
            'result' => $result,
        ]);
    }

    /**
     * Convert a logic expression to PHP syntax
     */
    private function convertToPHPLogic($expression)
    {
        // Replace logical operators with PHP equivalents
        $replacements = [
            '¬' => '!',
            '∧' => '&&',
            '∨' => '||',
            '→' => '|| !', // Implication A → B ≡ !A ∨ B
            '↔' => '===',  // Bi-implication A ↔ B ≡ A === B
            '⊕' => '^',    // XOR A ⊕ B ≡ A XOR B
        ];

        // Replace operators in the expression
        foreach ($replacements as $symbol => $phpEquivalent) {
            $expression = str_replace($symbol, $phpEquivalent, $expression);
        }

        // Return the processed expression
        return $expression;

        // Tampilkan hasil
        return view('kalkulator-logika/index', ['result' => $result]);
    }
}
