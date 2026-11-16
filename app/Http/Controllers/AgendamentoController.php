<?php

namespace App\Http\Controllers;

use App\Models\Agendamento;
use App\Models\Cliente;
use App\Models\Veiculo;
use Illuminate\Http\Request;

class AgendamentoController extends Controller
{
    public function listar()
    {
        $agendamentos = Agendamento::with(['veiculo.cliente'])
            ->orderBy('data')
            ->orderBy('hora')
            ->get();

        return view('agendamento.listar', compact('agendamentos'));
    }
    public function create()
    {
        $clientes = Cliente::all();
        $veiculos = Veiculo::all();

        return view('agendamento.create', compact('clientes', 'veiculos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'data' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'descricao' => 'nullable|string|max:1000',
            'veiculo_id' => [
                'required',
                Rule::exists(
                    (new Veiculo)->getTable(),
                    (new Veiculo)->getKeyName()
                ),
            ],
        ], [
            'data.required' => 'Informe a data do agendamento.',
            'hora.required' => 'Informe o horário.',
            'veiculo_id.required' => 'Selecione um veículo.',
            'veiculo_id.exists' => 'O veículo selecionado não existe.',
        ]);

        Agendamento::create($validated);

        return redirect()->back()
            ->with('success', 'Agendamento cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $agendamento = Agendamento::findOrFail($id);

        $clientes = Cliente::all();
        $veiculos = Veiculo::all();

        return view('agendamento.edit', compact(
            'agendamento',
            'clientes',
            'veiculos'
        ));
    }

    public function update(Request $request, $id)
    {
        $agendamento = Agendamento::findOrFail($id);

        $validated = $request->validate([
            'data' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'descricao' => 'nullable|string|max:1000',
            'veiculo_id' => [
                'required',
                Rule::exists(
                    (new Veiculo)->getTable(),
                    (new Veiculo)->getKeyName()
                ),
            ],
        ]);

        $agendamento->update($validated);

        return redirect()->back()
            ->with('success', 'Agendamento atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $agendamento = Agendamento::findOrFail($id);

        $agendamento->delete();

        return redirect()->back()
            ->with('success', 'Agendamento excluído com sucesso!');
    }
}
