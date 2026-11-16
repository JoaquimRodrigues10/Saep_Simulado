<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use App\Models\Cliente;
use Illuminate\Http\Request;

class VeiculoController extends Controller
{
    // LISTAR VEÍCULOS
    public function listar()
    {
        $veiculos = Veiculo::with('cliente')
            ->orderBy('placa')
            ->get();

        return view('veiculos.listar', compact('veiculos'));
    }

    // ABRIR FORMULÁRIO DE CADASTRO
    public function create()
    {
        $clientes = Cliente::orderBy('nome')->get();

        return view('veiculos.create', compact('clientes'));
    }

    // CADASTRAR VEÍCULO
    public function store(Request $request)
    {
        $validated = $request->validate([
            'placa' => [
                'required',
                'string',
                'max:10',
                Rule::unique((new Veiculo)->getTable(), 'placa'),
            ],
            'marca' => 'required|string|max:100',
            'modelo' => 'required|string|max:100',
            'cliente_id' => [
                'required',
                Rule::exists(
                    (new Cliente)->getTable(),
                    (new Cliente)->getKeyName()
                ),
            ],
        ], [
            'placa.required' => 'Informe a placa do veículo.',
            'placa.unique' => 'Essa placa já está cadastrada.',
            'marca.required' => 'Informe a marca do veículo.',
            'modelo.required' => 'Informe o modelo do veículo.',
            'cliente_id.required' => 'Selecione um cliente.',
            'cliente_id.exists' => 'O cliente selecionado não existe.',
        ]);

        Veiculo::create($validated);

        return redirect()->back()
            ->with('success', 'Veículo cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $veiculo = Veiculo::findOrFail($id);

        $clientes = Cliente::orderBy('nome')->get();

        return view('veiculos.edit', compact('veiculo', 'clientes'));
    }

    public function update(Request $request, $id)
    {
        $veiculo = Veiculo::findOrFail($id);

        $validated = $request->validate([
            'placa' => [
                'required',
                'string',
                'max:10',
                Rule::unique((new Veiculo)->getTable(), 'placa')
                    ->ignore($veiculo->getKey()),
            ],
            'marca' => 'required|string|max:100',
            'modelo' => 'required|string|max:100',
            'cliente_id' => [
                'required',
                Rule::exists(
                    (new Cliente)->getTable(),
                    (new Cliente)->getKeyName()
                ),
            ],
        ]);

        $veiculo->update($validated);

        return redirect()->back()
            ->with('success', 'Veículo atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $veiculo = Veiculo::findOrFail($id);

        $veiculo->delete();

        return redirect()->back()
            ->with('success', 'Veículo excluído com sucesso!');
    }
}
