<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gerenciar Cliente: {{ $customer->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                    <span class="font-medium">Sucesso!</span> {{ session('success') }}
                </div>
            @endif

            {{-- SEÇÃO 1: FORMULÁRIO PARA EDITAR A EMPRESA --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900">Dados da Empresa</h3>
                    <form action="{{ route('customers.update', $customer) }}" method="POST" class="mt-6 space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nome:</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $customer->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $customer->email) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Telefone:</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $customer->phone) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Atualizar Empresa</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- SEÇÃO 2: CONTATOS DA EMPRESA --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Contatos</h3>
                    <a href="{{ route('contacts.create', ['customer' => $customer->id]) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        + Adicionar Contato
                    </a>
                </div>
                <div>
                    @forelse ($customer->contacts as $contact)
                        <div class="flex justify-between items-center p-2 border-b">
                            <div>
                                <p class="font-semibold">{{ $contact->name }} - <span class="text-sm font-normal">{{ $contact->position }}</span></p>
                                <p class="text-sm text-gray-600">{{ $contact->email }} | {{ $contact->phone }}</p>
                            </div>
                            <form action="{{ route('contacts.destroy', $contact) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este contato?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-semibold">Excluir</button>
                            </form>
                        </div>
                    @empty
                        <p class="text-center text-gray-500">Nenhum contato cadastrado.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>