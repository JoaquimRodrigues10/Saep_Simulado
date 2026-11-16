<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function listar(Request $request)
    {
        $query = Cliente::query();

        if ($request->filled('nome')) {
            $query->where(
                'nome',
                'like',
                '%' . $request->nome . '%'
            );
        }

        $clientes = $query->orderBy('nome')->get();

        return view('clientes.listar', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:150',
            'cpf' => 'required|string|max:14',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:150',
        ], [
            'nome.required' => 'Informe o nome do cliente.',
            'cpf.required' => 'Informe o CPF do cliente.',
            'telefone.required' => 'Informe o telefone.',
            'email.required' => 'Informe o e-mail.',
            'email.email' => 'Informe um e-mail válido.',
        ]);

        Cliente::create($validated);

        return redirect()->back()
            ->with('success', 'Cliente cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);

        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $validated = $request->validate([
            'nome' => 'required|string|max:150',
            'cpf' => 'required|string|max:14',
            'telefone' => 'required|string|max:20',
            'email' => 'required|email|max:150',
        ], [
            'nome.required' => 'Informe o nome do cliente.',
            'cpf.required' => 'Informe o CPF do cliente.',
            'telefone.required' => 'Informe o telefone.',
            'email.required' => 'Informe o e-mail.',
            'email.email' => 'Informe um e-mail válido.',
        ]);

        $cliente->update($validated);

        return redirect()->back()
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);

        $cliente->delete();

        return redirect()->back()
            ->with('success', 'Cliente excluído com sucesso!');
    }
}
