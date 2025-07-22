<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Adicionar Novo Contato para: {{ $customer->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('contacts.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label for="name" class="block text-sm font-medium">Nome do Contato</label>
                                <input type="text" name="name" id="name" class="mt-1 block w-full" required>
                            </div>
                            <div>
                                <label for="position" class="block text-sm font-medium">Cargo</label>
                                <input type="text" name="position" id="position" class="mt-1 block w-full">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium">Email</label>
                                <input type="email" name="email" id="email" class="mt-1 block w-full">
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium">Telefone</label>
                                <input type="text" name="phone" id="phone" class="mt-1 block w-full">
                            </div>
                        </div>
                        <div class="mt-6 flex items-center gap-4">
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Salvar Contato</button>
                            <a href="{{ route('customers.edit', $customer) }}" class="text-sm">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>