@extends('product.layout')

@section('content')

    


    <div class="container">
        <div class="row">
            <div class="col-md-12">

                @session('status')
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endsession

                <div class="card">
                    <div class="card-header">
                        <h4>Ürünler Listesi</h4>
                        <div class="header-buttons">
                        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger float-end logout" style="margin-left: 10px;">Çıkış Yap</button>
                        <!-- <a href="" class="btn btn-danger float-end logout" style="margin-left: 10px;">Çıkış Yap</a>-->
                        </form>
                            <a href="{{ url('product/create') }}" class="btn btn-primary float-end add-product">Ürün ekle</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive d-none d-md-block">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>İsim</th>
                                        <th>Açıklama</th>
                                        <th>Fiyat</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                
                             
                                    @foreach ($products as $product)
                                    
                                    <tr>
                                        <td>{{ $product['id'] }}</td>
                                        <td>{{  $product['name'] }}</td>
                                        <td>
                                            @if (strlen( $product['description']) > 12)
                                                <span class="description-short">{{ substr($product['description'], 0, 12) }}...</span>
                                            @else
                                                <span class="description-full">{{ $product['description'] }}</span>
                                            @endif
                                        </td>
                                        <td>{{  $product['price'] }}</td>
                                        <td class="actions">
                                            <a href="{{ route('product.edit', $product['id']) }}" class="btn btn-success">Düzenle</a>
                                            <a href="{{ route('product.show', $product['id']) }}" class="btn btn-info">Göster</a>

                                            <form action="{{ route('product.destroy', $product['id']) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Sil</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                   
                               
                                </tbody>
                            </table>
                        </div>

                        <div class="row d-block d-md-none">
                        
                            @foreach ($products as $product)
                                <div class="col-md-12 product-item" style="border: 1px solid #ddd; margin-bottom: 10px; padding: 10px;">
                                    <div style="display: flex; justify-content: flex-start;">
                                        <strong>ID:</strong>
                                        <span style="margin-left: 10px; text-align: left;">{{ $product['id'] }}</span>
                                    </div>
                                    <div style="display: flex; justify-content: flex-start;">
                                        <strong>İsim:</strong>
                                        <span style="margin-left: 10px; text-align: left;">{{  $product['name'] }}</span>
                                    </div>
                                    <div style="display: flex; justify-content: flex-start;">
                                        <strong>Açıklama:</strong>
                                        <span style="margin-left: 10px; text-align: left;">
                                            @if (strlen($product['description']) > 12)
                                                <span class="description-short">{{ substr($product['description'], 0, 12) }}...</span>
                                            @else
                                                <span class="description-full">{{ $product['description'] }}</span>
                                            @endif
                                        </span>
                                    </div>
                                    <div style="display: flex; justify-content: flex-start;">
                                        <strong>Fiyat:</strong>
                                        <span style="margin-left: 10px; text-align: left;">{{ $product['price'] }}</span>
                                    </div>
                                    <div class="actions" style="margin-top: 10px; display: flex; flex-direction: row; justify-content: flex-start;">
                                        <div>
                                            <a href="{{ route('product.edit', $product['id']) }}" class="btn btn-success" style="margin-right: 5px;">Düzenle</a>
                                            <a href="{{ route('product.show', $product['id']) }}" class="btn btn-info" style="margin-right: 5px;">Göster</a>
                                            <form action="{{ route('product.destroy', $product['id']) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Sil</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                           
                           
                        </div>

                       @if ($products instanceof \Illuminate\Pagination\LengthAwarePaginator) 
                        {{ $products->links() }}
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 320px) {
            .description-short {
                display: inline;
            }

            .description-full {
                display: none;
            }
        }

        @media (min-width: 321px) {
            .description-short {
                display: inline;
            }

            .description-full {
                display: inline;
            }
        }

        .pagination {
    display: flex;
    justify-content: center;
    flex-wrap: wrap; /* Sayfalama öğelerinin taşmasını önler */
}

@media (max-width: 576px) {
    .pagination {
        width: 100%; /* Sayfalama genişliğini tam yap */
        justify-content: center; /* Ortaya hizala */
    }

    .pagination .page-item {
        margin: 0 5px; /* Sayfa numaraları arasında biraz boşluk bırak */
    }
}

@media (max-width: 400px) {
    .card-header {
        padding-bottom: 40px; /* Yalnızca 400px altında padding ekle */
}
}

@media (min-width: 401px) {
    .card-header {
        padding-bottom: 8px; /* 401px ve üzerindeki çözünürlüklerde padding'i sıfırla */
    }
}

.header-buttons {
    position: absolute !important; /* veya fixed kullanabilirsiniz */
    top: 10px !important; /* üstten mesafe */
    right: 10px !important; /* sağdan mesafe */
    display: flex !important; /* butonları yan yana dizmek için */
    gap: 10px !important; /* butonlar arasındaki mesafe */
}

.header-buttons .logout {
    background-color: #dc3545; /* Çıkış yap butonunun kırmızı arka plan rengi */
    color: white; /* Yazı rengi */
}

.header-buttons .add-product {
    background-color: #007bff; /* Ürün ekle butonunun mavi arka plan rengi */
    color: white; /* Yazı rengi */
}

.header-buttons .btn {
    padding: 8px 12px; /* Butonların içindeki boşluğu azalt */
    font-size: 14px; /* Yazı boyutunu küçült */
    border-radius: 4px; /* Kenarları biraz daha yuvarla */
}

.header-buttons .btn:hover {
    opacity: 0.9; /* Hover durumu için daha az opaklık */
}

@media (max-width: 400px) {
    .header-buttons {
        flex-direction: row; /* Butonları yan yana hizala */
        justify-content: center; /* Butonları ortala */
        margin-top: 30px; /* Başlık ile butonlar arasında boşluk artırıldı */
        padding: 0; /* Kartın içindeki alanı düzenle */
    }
    
    .header-buttons .btn {
        width: auto; /* Buton genişliğini otomatik ayarla */
        margin: 0 5px; /* Butonlar arasına yatay boşluk ekle */
        font-size: 14px; /* Buton boyutunu küçült */
    }
}


    </style>

@endsection








