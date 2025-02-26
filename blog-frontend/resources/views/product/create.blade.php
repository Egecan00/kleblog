@extends('product.layout')

@section('content')


    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Ürün ekleme
                            <a href="{{ url('product') }}" class="btn btn-danger float-end">Geri dön</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form id="productForm" action="{{ route('product.store') }}" method="POST" onsubmit="disableButton()">
                            @csrf

                            <div class="mb-3">
                                <label>İsim</label>
                                <input type="text" name="name" class="form-control" required />
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>Açıklama</label>
                                <textarea name="description" rows="3" class="form-control"></textarea>
                                @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label>Fiyat</label>
                                <input type="number" name="price" class="form-control" required />
                                @error('price') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <button id="submitButton" type="submit" class="btn btn-primary">Kaydet</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

<script>
    function disableButton() {
        const button = document.getElementById('submitButton');
        button.disabled = true;
        button.innerText = 'Kaydediliyor';
    }
</script>

