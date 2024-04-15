@extends('layouts.landingpage')

@section('content')
    <div class="container my-5">
        <h2 class="text-center fw-bold">Orders</h2>

        <div class="row">
            <div class="col-md-8">
                <div class="card p-3 shadow my-3">
                    <div class="col-md-2">
                        <button class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#addProduct">
                            Pilih Product
                        </button>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="dataProduct">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4 my-3">
                <div class="card p-3 shadow">
                    <form action="">
                        <div class="row d-flex">
                            <div class="col-md-6 mb-3">
                                <label for="" class="mb-2">Order Id</label>
                                <input type="text" value="HASDGH534" class="form-control" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="" class="mb-2">Nama Kasir</label>
                                <input type="text" value="Haikal" class="form-control" disabled>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="totalBelanja" class="mb-2">Total Belanja</label>
                                <input type="number" name="totalBelanja" class="form-control" id="totalBelanja" placeholder="0" disabled>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="diBayar" class="mb-2">Di Bayar</label>
                                <input type="number" name="diBayar" class="form-control" id="diBayar">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="kembalian" class="mb-2">Kembalian</label>
                                <input type="number" name="kembalian" class="form-control" placeholder="0" id="kembalian" disabled>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-primary" id="btnBayar">
                                Bayar
                            </button>
                            <button class="btn btn-danger">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Pilih Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card p-2">
                        <table class="table" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Jumlah</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->stock }}</td>
                                    <td>
                                        <input type="number" class="form-control quantity-input" value="1" min="1">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary addToCartBtn" data-product-id="{{ $item->id }}" data-product-name="{{ $item->name }}" data-product-price="{{ $item->price }}" data-product-stock="{{ $item->stock }}">Pilih</button>
                                    </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
    var i = 1;
    
    // Function to handle adding product to cart
    $('.addToCartBtn').click(function() {
        var button = $(this);
        
        // Menonaktifkan tombol "Pilih" setelah dipilih
        button.addClass('btn-disabled').prop('disabled', true).text('Selected');

        var productId = button.data('product-id');
        var productName = button.data('product-name');
        var productPrice = button.data('product-price');
        var productStock = button.data('product-stock');
        var quantity = $(this).closest('tr').find('.quantity-input').val();
        var total = productPrice * quantity;
        var totalBelanja = parseFloat($('#totalBelanja').val()) || 0;
        totalBelanja += total;

        var row = `<tr>
            <td>${$('#dataProduct tr').length + 1}</td>
            <td>${productName}</td>
            <td>${productPrice}</td>
            <td>${quantity}</td>
            <td>${total}</td>
            <td><button type="button" class="btn btn-danger">Hapus</button></td>
        </tr>`;

        $('#dataProduct').append(row);
        $('#totalBelanja').val(totalBelanja.toFixed(2)); 
    });

    $('#dataProduct').on('click', '.btn-danger', function() {
      var row = $(this).closest('tr');
      row.remove();
      

      updateTotalBelanja();
    });

    function updateTotalBelanja() {
    var totalBelanja = 0;
    $('#dataProduct tr').each(function() {
      var quantity = parseInt($(this).find('td:nth-child(4)').text());
      var price = parseFloat($(this).find('td:nth-child(3)').text());
      totalBelanja += quantity * price;
    });

    $('#totalBelanja').val(totalBelanja.toFixed(2));
  }
  
    // Function to handle payment
    $('#btnBayar').click(function() {
        $('#formBayar').submit();
    });

    $('#diBayar').keyup(function (e) { 
        var totalBelanja = parseFloat($('#totalBelanja').val());
        var diBayar = parseFloat($('#diBayar').val());
        var kembalian = diBayar - totalBelanja;
        $('#kembalian').val(kembalian);
    });
});

</script>
@endsection
