<!-- Open the modal using ID.showModal() method -->
<div class="mt-10 mb-5 ml-5">
    <button class="px-4 py-2 font-bold text-gray-500 bg-transparent border border-gray-500 rounded-full modal-open hover:border-indigo-500 hover:text-indigo-500" onclick="my_modal_1.showModal()">Importar Aliños</button>
</div>
    <dialog id="my_modal_1" class="rounded modal">
    <div class="px-10 py-10 modal-box">
        <h3 class="mb-3 text-lg font-bold">Importar aliños</h3>
        <div class="modal-action">
            <form action="{{ route('importar.dressing') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input id="import-inv" type="file" name="excel" required>
                <button type="submit" class="p-3 px-4 mt-4 text-white bg-blue-400 rounded modal-close hover:bg-blue-500">Importar Excel</button>
            </form>
            <form method="dialog">
                <!-- if there is a button in form, it will close the modal -->
                <button class="p-3 px-4 mt-4 text-white bg-orange-400 rounded modal-close hover:bg-orange-500">Cerrar</button>
            </form>
        </div>
    </div>
    </dialog>