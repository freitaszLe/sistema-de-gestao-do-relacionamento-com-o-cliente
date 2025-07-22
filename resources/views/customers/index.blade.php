<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Meus Clientes') }}
            </h2>
            <a href="{{ route('customers.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Adicionar Cliente
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Alerta de sucesso --}}
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                                        {{-- Cards de Estatísticas --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        {{-- Card Total de Clientes --}}
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-gray-500 text-sm font-semibold uppercase">Total de Clientes</h3>
                                <p class="text-3xl font-bold mt-2">{{ $totalCustomers }}</p>
                            </div>
                        </div>
                        {{-- Card Total de Contatos --}}
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-gray-500 text-sm font-semibold uppercase">Total de Contatos</h3>
                                <p class="text-3xl font-bold mt-2">{{ $totalContacts }}</p>
                            </div>
                        </div>
                        {{-- Card Exemplo --}}
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-gray-500 text-sm font-semibold uppercase">Vendas (Exemplo)</h3>
                                <p class="text-3xl font-bold mt-2">R$ 1,234.56</p>
                            </div>
                        </div>
                    </div>

                    {{-- Tabela de Clientes --}}

                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Nome
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Telefone
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($customers as $customer)
                                    <tr class="bg-white border-b">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $customer->name }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $customer->email }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $customer->phone }}
                                        </td>
                                        <td class="px-6 py-4 flex gap-2">
                                            <a href="{{ route('customers.edit', $customer) }}" class="font-medium text-blue-600 hover:underline">Editar</a>
                                            <form action="{{ route('customers.destroy', $customer) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este cliente?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="font-medium text-red-600 hover:underline">Excluir</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="bg-white border-b">
                                        <td colspan="4" class="px-6 py-4 text-center">
                                            Nenhum cliente cadastrado.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>