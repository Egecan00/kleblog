@extends('product.layout')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Ürünün detayları
                            <a href="{{ url('product') }}" class="btn btn-danger float-end">Geri dön</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label>İsim</label>
                            <p>
                                {{ $products['name'] }}
                            </p>
                        </div>
                        <div class="mb-3">
                            <label>Açıklama</label>
                            <p>
                                {!! $products['description'] !!}
                            </p>
                        </div>
                        <div class="mb-3">
                            <label>Fiyat</label>
                            <br/>
                            <p>
                                {{ $products['price']}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection