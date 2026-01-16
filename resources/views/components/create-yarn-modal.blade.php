@props(['projects'])

<div>
    <div class="modal fade" id="CreateYarnModal" tabindex="-1" aria-labelledby="CreateYarnModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="CreateYarnModalLabel">
                        Crea un nuovo filato
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="mb-5" action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-control mb-3 py-3 px-3 d-flex flex-column gap-4">
                            <div>
                                <label class="text-danger" for="new_yarn[name]">
                                    Nome
                                </label>
                                <input class="ms-2" type="text" name="new_yarn[name]" id="new_yarn[name]">
                            </div>
                            <div>
                                <label class="text-danger" for="new_yarn[brand]">
                                    Marca
                                </label>
                                <input class="ms-2" type="text" name="new_yarn[brand]" id="new_yarn[brand]">
                            </div>
                            <div class="d-flex align-items-center">
                                <label class="text-danger" for="weight">
                                    Peso
                                </label>
                                <input class="ms-2" type="text" name="weight" id="weight">
                                {{-- <select class="ms-2 w-50 form-select" name="category_id" id="category">
                                    <option selected>
                                        Seleziona la categoria
                                    </option>
                                    <x-category-options :categories="$categories" />
                                </select> --}}
                            </div>
                            <div class="d-flex align-items-center">
                                <label class="text-danger" for="category">
                                    Categoria
                                </label>
                                <input class="ms-2" type="text" name="category" id="category">
                            </div>
                            <div class="d-flex align-items-center">
                                <label class="text-danger" for="ply">
                                    Fili
                                </label>
                                <input class="ms-2" type="number" name="ply" id="ply">
                            </div>
                            <div class="d-flex align-items-center">
                                <label class="text-danger" for="unit_weight">
                                    Peso unitario
                                </label>
                                <input class="ms-2" type="number" name="unit_weight" id="unit_weight">
                            </div>
                            <div class="d-flex align-items-center">
                                <label class="text-danger" for="meterage">
                                    Metraggio
                                </label>
                                <input class="ms-2" type="number" name="meterage" id="meterage">
                            </div>
                            <div class="d-flex align-items-center">
                                <label class="text-danger" for="fiber_types_number">
                                    Tipologie di fibra
                                </label>
                                <input class="ms-2" type="number" name="fiber_types_number" id="fiber_types_number">
                            </div>
                            <div class="d-flex align-items-center">
                                <label class="text-danger" for="min_hook_size">
                                    Misura uncinetto minima
                                </label>
                                <input class="ms-2" type="number" name="min_hook_size" id="min_hook_size">
                            </div>
                            <div class="d-flex align-items-center">
                                <label class="text-danger" for="max_hook_size">
                                    Misura uncinetto massima
                                </label>
                                <input class="ms-2" type="number" name="max_hook_size" id="max_hook_size">
                            </div>
                            <div class="d-flex align-items-center">
                                <label class="text-danger" for="min_needle_size">
                                    Misura ferri minima
                                </label>
                                <input class="ms-2" type="number" name="min_needle_size" id="min_needle_size">
                            </div>
                            <div class="d-flex align-items-center">
                                <label class="text-danger" for="max_needle_size">
                                    Misura ferri massima
                                </label>
                                <input class="ms-2" type="number" name="max_needle_size" id="max_needle_size">
                            </div>
                            <div class="d-flex align-items-center">
                                <label class="text-danger" for="color_type">
                                    Tipologia colore
                                </label>
                                <input class="ms-2" type="number" name="color_type" id="color_type">
                            </div>
                            <div>
                                <label for="image_path">
                                    Immagine
                                </label>
                                <input class="ms-2" type="file" name="image_path" id="image_path">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                            Annulla
                        </button>
                        <button type="submit" class="btn btn-success">
                            Conferma
                        </button>   
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>