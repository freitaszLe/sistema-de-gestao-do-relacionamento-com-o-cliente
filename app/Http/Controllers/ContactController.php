<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Mostra o formulário para criar um novo contato para um cliente específico.
     */
    public function create(Customer $customer)
    {
        // Verifica se o usuário logado tem permissão para ver este cliente
        if ($customer->user_id !== Auth::id()) {
            abort(403, 'Ação não autorizada.');
        }
        return view('contacts.create', ['customer' => $customer]);
    }

    /**
     * Salva um novo contato no banco de dados.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:100',
            'customer_id' => 'required|exists:customers,id',
        ]);

        $customer = Customer::findOrFail($validated['customer_id']);

        if ($customer->user_id !== Auth::id()) {
            abort(403, 'Ação não autorizada.');
        }

        Contact::create($validated);

        return redirect()->route('customers.edit', $customer->id)
                         ->with('success', 'Contato adicionado com sucesso!');
    }

    /**
     * Remove um contato do banco de dados.
     */
    public function destroy(Contact $contact)
    {
        // Lógica para deletar virá depois
        return back()->with('success', 'Lógica de deletar ainda não implementada.');
    }
}