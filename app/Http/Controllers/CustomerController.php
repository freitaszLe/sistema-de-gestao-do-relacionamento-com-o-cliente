<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;

class CustomerController extends Controller
{

public function index()
{
    $user = auth()->user();

    // Carrega os clientes e a contagem de contatos de forma otimizada
    $customers = $user->customers()->withCount('contacts')->latest()->get();

    // Calcula as estatísticas
    $totalCustomers = $customers->count();
    $totalContacts = $customers->sum('contacts_count'); // Soma a contagem de contatos de cada cliente

    return view('customers.index', [
        'customers' => $customers,
        'totalCustomers' => $totalCustomers,
        'totalContacts' => $totalContacts,
    ]);
}


    public function create()
    {
        // Apenas retorna a view que contém o formulário de criação
        return view('customers.create');
    }

    public function store(Request $request)
    {
        // Valida os dados que vieram do formulário
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email', 
            'phone' => 'nullable|string',
        ]);

        // Cria o novo cliente associado diretamente ao usuário logado
        $request->user()->customers()->create($validated);

        // Redireciona o usuário de volta para a dashboard com uma mensagem de sucesso
        return redirect(route('dashboard'))->with('success', 'Cliente cadastrado com sucesso!');
    }



    public function show(Customer $customer)
    {
        // **SEGURANÇA**: Verifica se o cliente que está sendo acessado pertence ao usuário logado.
        // Se não pertencer, exibe um erro 403 (Acesso Proibido).
        if (Auth::id() !== $customer->user_id) {
            abort(403, 'Acesso não autorizado.');
        }
        
        // Se o acesso for autorizado, retorna a view de detalhes.
        // (Vamos precisar criar a view 'customers.show' em breve)
        return view('customers.show', ['customer' => $customer]);
    }



    public function edit(Customer $customer)
    {
        // **SEGURANÇA**: Mesma verificação do método show()
        if (Auth::id() !== $customer->user_id) {
            abort(403, 'Acesso não autorizado.');
        }
        
        $customer->load('contacts'); // Carrega os contatos associados ao cliente

        return view('customers.edit', ['customer' => $customer]);
    }


    public function update(Request $request, Customer $customer)
    {
        // **SEGURANÇA**: Mesma verificação do método show() e edit()
        if (Auth::id() !== $customer->user_id) {
            abort(403, 'Acesso não autorizado.');
        }

        // Valida os dados, com uma regra especial para o email:
        // O email deve ser único, a menos que seja o email do próprio cliente que estamos editando.
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string',
        ]);


        $customer->update($validated);

        // Redireciona de volta para a dashboard com uma mensagem de sucesso
        return redirect(route('dashboard'))->with('success', 'Cliente atualizado com sucesso!');
    }


    public function destroy(Customer $customer)
    {
        // **SEGURANÇA**: Mesma verificação dos outros métodos
        if (Auth::id() !== $customer->user_id) {
            abort(403, 'Acesso não autorizado.');
        }


        $customer->delete();

        // Redireciona de volta para a dashboard com uma mensagem de sucesso
        return redirect(route('dashboard'))->with('success', 'Cliente excluído com sucesso!');
    }
}