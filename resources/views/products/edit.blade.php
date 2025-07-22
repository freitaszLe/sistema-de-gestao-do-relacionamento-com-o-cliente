<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Produto: {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('products.update', $product) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium">Nome do Produto</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="mt-1 block w-full" required>
                            </div>
                            <div>
                                <label for="description" class="block text-sm font-medium">Descrição</label>
                                <textarea name="description" id="description" rows="4" class="mt-1 block w-full">{{ old('description', $product->description) }}</textarea>
                            </div>
                            <div>
                                <label for="price" class="block text-sm font-medium">Preço</label>
                                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" class="mt-1 block w-full" required>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center gap-4">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Atualizar Produto</button>
                            <a href="{{ route('products.index') }}" class="text-sm">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>